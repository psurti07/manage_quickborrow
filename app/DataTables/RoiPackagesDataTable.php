<?php

namespace App\DataTables;

use Modules\RoiPackages\App\Models\RoiPackage;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoiPackagesDataTable extends DataTable
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
            ->addColumn('bank',function($model){ return '<img src="'.url('upload/banks/'.$model->bank_image).'" height="50" width="100">'; })
            ->addColumn('bank_name',function($model){ return $model->bank_name; })
            ->addColumn('ROI',function($model){ return $model->roi; })
            ->addColumn('terms_years',function($model){ return $model->termsyears; })
            ->addColumn('terms_months',function($model){ return $model->termsmonths; })
            ->setRowId('id')->rawColumns(['action','ROI','terms_years','terms_months','bank']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(RoiPackage $model): QueryBuilder
    {
        return $model->newQuery()->join('banks', 'roipackages.bankid', '=', 'banks.id')->where(['roipackages.isDelete'=>0]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('roipackages-table')
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
            Column::make('bank')->title('Bank')->searchable(false),
            Column::make('bank_name')->title('Bank Name')->data('bank_name'),
            Column::make('ROI')->title('ROI')->data('ROI'),
            Column::make('terms_years')->title('Terms Years')->data('terms_years'),
            Column::make('terms_months')->title('Terms Months')->data('terms_months'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'RoiPackages_' . date('YmdHis');
    }
}
