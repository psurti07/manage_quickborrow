<?php

namespace App\DataTables;

use App\Models\SmsList;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SmsTemplateDataTable extends DataTable
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
                return $row->isActive == 1 ? '<i class="fa fa-check-circle-o text-success"></i>' : '<i class="fa fa-times-circle-o text-danger"></i>';
            })
            ->setRowId('id')
            ->rawColumns(['status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SmsList $model): QueryBuilder
    {
        return $model->newQuery()->orderByDesc('id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('smstemplate-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(100)
                    ->dom('Blfrtip')
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
            Column::make('title')->title('Title')->data('title'),
            Column::make('message')->title('Message')->data('message'),
            Column::make('status')->title('Working')->data('status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SmsTemplate_' . date('YmdHis');
    }
}
