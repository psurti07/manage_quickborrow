<?php

namespace App\DataTables;

use Carbon\Carbon;
use Modules\Career\App\Models\Careers;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CareersDataTable extends DataTable
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
            ->addColumn('action', function($row){
                $action = '<ul class="action">
                            <li class="edit"> <a href="javascript:;" onclick="openEditModal('.$row->id.')"><i class="icon-pencil-alt"></i></a></li>
                            <li class="delete">
                                <a href="javascript:;" onclick="destroy('.$row->id.')">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>
                          </ul>';
                return $action;
            })
            ->addColumn('status',function($row){
                if($row->isActive) {
                    $statusBtn = '<a href="javascript:;" onclick="changeStatus('.$row->id.','.$row->isActive.')">
                                        <span class="btn btn-xs btn-outline-success">Active</span>
                                    </a>';
                } else {
                    $statusBtn = '<a href="javascript:;"  onclick="changeStatus('.$row->id.','.$row->isActive.')">
                                        <span class="btn btn-xs btn-outline-danger">Inactive</span>
                                      </a>';
                }
                return $statusBtn;
            })
                ->editColumn('rec_date', function($row) {
                    return Carbon::parse($row->rec_date)->format('d-m-Y');
                })
            ->setRowId('id')
            ->rawColumns(['action','status','rec_date']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Careers $model): QueryBuilder
    {
        return $model->newQuery()->where('isDelete',0);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('careers-table')
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
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false)->width(5),
            Column::make('title')->data('title')->title('Title'),
            // Column::make('descriptions'),
            Column::make('rec_date')->title('Date')->searchable(false),
            Column::make('status')->searchable(false),
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
        return 'Careers_' . date('YmdHis');
    }
}
