<?php

namespace App\DataTables;

use App\Models\ContactEnquiry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContactEnquiryDataTable extends DataTable
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
            ->addColumn('action', function($model){
                return '<ul class="action">
                            <li class="delete">
                                <a href="javascript:;" onclick="destroy('.$model->id.')">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>
                          </ul>';
            })
            ->addColumn('date', function($model){
                return fetchRecDate($model->rec_date);
            })
            ->setRowId('id')->rawColumns(['action','date']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ContactEnquiry $model): QueryBuilder
    {
        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');

        $query = $model->newQuery()->orderByDesc('id');

        if(!empty($start_date) && !empty($end_date)){
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $query = $query->whereRaw('DATE(rec_date) BETWEEN ? AND ?',[$start_date,$end_date]);
        } else {
            $start_date = date('Y-m-d',strtotime('-2 days'));
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
                    ->setTableId('contactenquiry-table')
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
            Column::make('DT_RowIndex')->title('#')->width(5),
            Column::make('date')->title('Date')->width(10)->searchable(false),
            Column::make('fullname')->title('Full Name')->data('fullname'),
            Column::make('email')->data('email')->title('Email'),
            Column::make('mobile')->data('mobile')->title('Mobile'),
            Column::make('subject')->data('subject')->title('Subject'),
            Column::make('message')->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(5)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ContactEnquiry_' . date('YmdHis');
    }
}
