<?php

namespace App\DataTables;

use App\Models\UserRegistration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DndListDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $action = '<ul class="action">
                        <li class="delete">
                            <a href="javascript:;" onclick="destroy(' . $row->id . ')">
                                <i class="icon-trash"></i>
                            </a>
                        </li>
                      </ul>';
                return $action;
            })
            ->addColumn('fullname',function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->setRowId('id')
            ->rawColumns(['action','fullname']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserRegistration $model): QueryBuilder
    {
        $type = (($this->type == 'selfapply') ? 1 : (($this->type == 'loanagent') ? 2 : 3));

        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');

        $query = $model->newQuery()->select('id', 'first_name', 'last_name', 'mobile')->where(['isDnd'=>1,'acc_type'=>$type,'isActive'=>1, 'isDelete'=>0])->orderBy('id');

        if(!empty($start_date) && !empty($end_date)){
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $query = $query->whereBetween('rec_date',[$start_date,$end_date]);
        } else {
            $start_date = date('Y-m-d',strtotime('-2 days'));
            $end_date = date('Y-m-d');
            $query = $query->whereBetween('rec_date',[$start_date,$end_date]);
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('dndlist-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->pageLength(100)
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
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('fullname')->data('fullname')->title('Full Name'),
            Column::make('mobile')->data('mobile')->title('Mobile'),
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
        return 'DndList_' . date('YmdHis');
    }
}
