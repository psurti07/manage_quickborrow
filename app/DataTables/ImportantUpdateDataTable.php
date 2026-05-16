<?php

namespace App\DataTables;

use App\Models\ImportantUpdate;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ImportantUpdateDataTable extends DataTable
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
            ->addColumn('action', function ($row) {
                $action = '<ul class="action">
                        <li class="edit"> <a href="javascript:;" onclick="openEditModal(' . $row->id . ')"><i class="icon-pencil-alt"></i></a></li>
                        <li class="delete">
                            <a href="javascript:;" onclick="destroy(' . $row->id . ')">
                                <i class="icon-trash"></i>
                            </a>
                        </li>
                      </ul>';
                return $action;
            })
            ->addColumn('rec_date',function($row){
                return date('d-m-Y H:i:s', strtotime($row->rec_date));
            })
            ->setRowId('id')
            ->rawColumns(['action','rec_date','status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ImportantUpdate $model): QueryBuilder
    {
        return $model->newQuery()->where('isDelete',0);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('importantupdate-table')
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
            Column::make('rec_date')->data('rec_date')->title('Date')->searchable(false),
            Column::make('tags')->data('tags')->title('Tag'),
            Column::make('descriptions')->data('descriptions')->title('Descriptions'),
            Column::make('status')->data('status')->title('Status')->searchable(false),
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
        return 'ImportantUpdate_' . date('YmdHis');
    }
}
