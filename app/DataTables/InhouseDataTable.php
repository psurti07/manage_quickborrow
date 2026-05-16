<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Inhouse\App\Models\StaffTask;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InhouseDataTable extends DataTable
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
            ->addColumn('action',function($model){
                $action = '<ul class="action">
                            <li class="details"> <a href="javascript:;" onclick="details('.$model->id.')"><i class="icon-info-alt"></i></a></li>
                          </ul>';
                return $action;
            })
            ->addColumn('start_date',function($model){
                return date('d-m-Y H:i:s',strtotime($model->rec_date));
            })
            ->addColumn('task_status',function($model){
                return taskStatus($model->task_status,$model->id);
            })
            ->addColumn('priority',function($model){
                return taskPriority($model->priority);
            })
            ->setRowId('id')->rawColumns(['task_status','priority','action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(StaffTask $model): QueryBuilder
    {
        return $model->newQuery()->where('isDelete',0);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('inhouse-table')
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
            Column::make('DT_RowIndex')->title('#')->searchable(false),
            Column::make('start_date')->title('Start Date')->searchable(false),
            Column::make('projects')->title('Project')->data('projects'),
            Column::make('task_title')->title('Title')->data('task_title'),
            Column::make('priority')->searchable(false),
            Column::make('task_status')->title('Status')->searchable(false),
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
        return 'Inhouse_' . date('YmdHis');
    }
}
