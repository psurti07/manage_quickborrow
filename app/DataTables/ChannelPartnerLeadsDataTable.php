<?php

namespace App\DataTables;

use Modules\ChannelPartner\App\Models\ChannelPartner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ChannelPartnerLeadsDataTable extends DataTable
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
                $action = '<ul class="action" style="display:block">
                            <li class="text-primary" style="display:block;align-items: center">
                                <a href="javascript:;" onclick="showDetailsModal('.$row->id.')">
                                    <i class="icon-info-alt"></i>
                                </a>
                            </li>
                          </ul>';
                return $action;
            })
            ->addColumn('fullname', function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ChannelPartner $model): QueryBuilder
    {
        return $model->newQuery()->where('isDelete',0)->where('isActive',0);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('channelpartnerleads-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
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
            Column::make('DT_RowIndex')->title('#')->width(5),
            Column::make('fullname')->data('fullname')->title('Full Name'),
            Column::make('mobile')->data('mobile')->title('Mobile'),
            Column::make('email')->data('email')->title('Email'),
            Column::make('company_code')->title('company_code')->searchable(false),
            Column::make('company_name')->title('company_name')->searchable(false),
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
        return 'ChannelPartnerLeads_' . date('YmdHis');
    }
}
