<?php

namespace App\DataTables;

use App\Models\SmsLog;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RemarketingLogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $totalMsgCount = (clone $query)->sum('msgcount');
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $action = '<ul class="action" style="display:block">
                            <li class="primary">
                                <a href="javascript:;" onclick="openRemarketingModal('.$row->id.')">
                                    <i class="icon-info-alt"></i>
                                </a>
                            </li>
                          </ul>';
                return $action;
            })
            ->addColumn('rec_date', function($row){
                return date('d-m-Y H:i:s', strtotime($row->rec_date));
            })
            ->with(['totalMsgCount' => $totalMsgCount])
            ->setRowId('id')
            ->rawColumns(['action','rec_date']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SmsLog $model): QueryBuilder
    {
        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');
        $parentId = $this->request()->get('sms');
        $parentParts = explode('-', $parentId);
        if (count($parentParts) === 3 && !empty($parentParts[0]) && !empty($parentParts[1]) && !empty($parentParts[2])) {
            $query = $model->newQuery()
                ->where('parentid', $parentParts[0])
                ->where('cronname', 'LIKE', '%' . $parentParts[1] . '%')
                ->where('crontype', 'LIKE', '%' . $parentParts[2] . '%');
        } else {
            $query = $model->newQuery()->orderByDesc('id');
        }

        
        if(!empty($start_date) && !empty($end_date)){
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $query = $query->whereRaw('DATE(rec_date) BETWEEN ? AND ?',[$start_date,$end_date]);
        } else {
            $start_date = date('Y-m-d',strtotime('-1 days'));
            $end_date = date('Y-m-d');
            $query = $query->whereRaw('DATE(rec_date) BETWEEN ? AND ?',[$start_date,$end_date]);
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('remarketinglog-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(100)
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print')
                    ])->parameters([
                        'responsive' => true,
                        'lengthMenu' => [[100, 250, 500, -1], [100, 250, 500, 'All']],
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->searchable(false)->title('#'),
            Column::make('rec_date')->searchable(false)->title('Date'),
            Column::make('crontype')->data('crontype')->title('Msg For'),
            Column::make('cronname')->data('cronname')->title('Job Name'),
            Column::make('msgcount')->data('msgcount')->title('Messages'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'RemarketingLog_' . date('YmdHis');
    }
}
