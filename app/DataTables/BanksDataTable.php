<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Banks\App\Models\Banks;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BanksDataTable extends DataTable
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
                                    <i class="icon-share-alt"></i>
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
            ->addColumn('bank', function($model){
                $pic1 = $model->bank_image;
                $path = 'upload/banks/';
                $pic2 = asset($path.$pic1);
                return '<img src="'.$pic2.'" class="img-100 me-2">';
            })
            ->setRowId('id')
            ->rawColumns(['action','status','bank']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Banks $model): QueryBuilder
    {
        return $model->newQuery()->where('isDelete',0);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('banks-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->pageLength(100)
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
            Column::make('DT_RowIndex')->title('#')->width(5)->searchable(false)->orderable(false),
            Column::make('bank')->title('Bank')->searchable(false),
            Column::make('bank_name')->data('bank_name')->title('Bank Name'),
            Column::make('order_no')->searchable(false),
            Column::make('status')->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->searchable(false)->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Banks_' . date('YmdHis');
    }
}
