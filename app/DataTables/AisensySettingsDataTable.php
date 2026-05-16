<?php

namespace App\DataTables;

use App\Models\AisensyModel as AisensySetting;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AisensySettingsDataTable extends DataTable
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
            ->addColumn('product', function($row){
                return (($row->product == 'LA') ? 'Loan Agent' : 'Self Apply');
            })
            ->addColumn('action', function($row){
                return '
                    <ul class="action">
                            <li class="info"> <a href="javascript:;" onclick="openAiSensySettingsModal('.$row->id.')"><i class="icon-info-alt"></i></a></li>
                          </ul>
                ';
            })
            ->setRowId('id')->rawColumns(['product', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AisensySetting $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('aisensysettings-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print')
                    ])->parameters([
                        'responsive' => true
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false),
            Column::make('product')->data('product')->title('Product'),
            Column::make('type')->data('type')->title('Type'),
            Column::make('campaign_name')->data('campaign_name')->title('Campaign Name'),
            Column::make('media_filename')->data('media_filename')->title('Media Filename'),
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
        return 'AisensySettings_' . date('YmdHis');
    }
}
