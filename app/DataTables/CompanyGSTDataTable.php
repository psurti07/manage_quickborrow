<?php

namespace App\DataTables;

use App\Models\UserRegistration;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CompanyGSTDataTable extends DataTable
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
            ->addColumn('fullname', function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->setRowId('id')
            ->rawColumns(['fullname']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserRegistration $model): QueryBuilder
    {
        return $model->newQuery()->whereNotNull('company_name')->whereNotNull('company_gst');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('companygst-table')
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
            Column::make('DT_RowIndex')->title('#')->width(5)->orderable(false)->searchable(false),
            Column::make('fullname')->title('FullName')->data('fullname'),
            Column::make('mobile')->title('Mobile')->data('mobile'),
            Column::make('email')->title('Email')->data('email'),
            Column::make('city')->title('City')->data('city'),
            Column::make('state')->title('State')->data('state'),
            Column::make('company_name')->title('Company Name')->searchable(false),
            Column::make('company_gst')->title('Company GST')->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CompanyGST_' . date('YmdHis');
    }
}
