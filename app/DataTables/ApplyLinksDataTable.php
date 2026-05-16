<?php

namespace App\DataTables;

use Modules\ApplyLinks\App\Models\ApplyLink;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ApplyLinksDataTable extends DataTable
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
            //->make(true)
            ->addColumn('action', function($model){
                $action = '<ul class="action">
                            <li class="edit"> <a href="javascript:;" onclick="openEditModal('.$model->id.')"><i class="icon-pencil-alt"></i></a></li>
                            <li class="delete">
                                <a href="javascript:;" onclick="destroy('.$model->id.')">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>
                          </ul>';
                return $action;
            })
            ->addColumn('tenures',function($model){
                return $model->tenures.' Months';
            })
            ->addColumn('bank',function($model){ return '<img src="'.url('upload/banks/'.$model->bank_image).'" height="50" width="100">'; })
            ->addColumn('bank_name',function($model){ return $model->bank_name; })
            ->addColumn('url',function($model){ return $model->applyurl; })
            ->setRowId('id')->rawColumns(['action','bank','bank_name','url']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ApplyLink $model): QueryBuilder
    {
        return $model->newQuery()
            ->select('bankapplylink.*','banks.bank_image','banks.bank_name')
            ->join('banks', 'bankapplylink.bankid', '=', 'banks.id')
            ->where(['bankapplylink.isDelete'=>0]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('applylinks-table')
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
            Column::make('DT_RowIndex')->title('#')->width(5)->orderable(false)->searchable(false),
            Column::make('bank')->width(5)->searchable(false),
            Column::make('bank_name')->width(5)->data('bank_name'),
            Column::make('roi')->width(5)->title('ROI')->searchable(false),
            Column::make('tenures')->width(5)->title('Tenure')->data('tenures'),
            Column::make('title')->width(70)->data('title'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(2),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ApplyLinks_' . date('YmdHis');
    }
}
