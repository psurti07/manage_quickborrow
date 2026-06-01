<?php

namespace App\DataTables;

use Carbon\Carbon;
use Modules\Career\App\Models\CareerEnquiry;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CareerEnquiryDataTable extends DataTable
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
                            <li class="delete" style="display:flex;align-items: center;justify-content: center">
                                <a href="javascript:;" onclick="destroy('.$row->id.')">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>
                          </ul>';
                return $action;
            })
            ->addColumn('resume',function($row){
                return '<ul class="action" style="display:block">
                                <li style="display:flex;align-items: center;justify-content: center">
                                    <a class="pdf" href="https://quikborrow.com/upload/resumes/'.$row->resume.'" target="_blank">
                                        <i class="icofont icofont-file-pdf"></i>
                                    </a>
                                </li>
                           </ul>';
            })
            ->editColumn('rec_date', function($row) {
                return Carbon::parse($row->rec_date)->format('d-m-Y h:i:s A');
            })
            ->setRowId('id')
            ->rawColumns(['action','resume','rec_date']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CareerEnquiry $model): QueryBuilder
    {
        return $model->newQuery()->where('career_enquiries.isDelete','0')
            ->join('careers', 'career_enquiries.applyfor', '=', 'careers.id')
            ->select('career_enquiries.*', 'careers.title as career_title');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('careerenquiry-table')
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
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false)->width(5),
            Column::make('rec_date')->title('Date')->searchable(false),
            Column::make('career_title')->data('career_title')->name('careers.title'),
            Column::make('firstname')->data('firstname')->title('First Name'),
            Column::make('lastname')->data('lastname')->title('Last Name'),
            Column::make('mobile')->data('mobile')->title('Mobile'),
            Column::make('email')->data('email')->title('Email'),
            Column::make('resume')->searchable(false),
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
        return 'CareerEnquiry_' . date('YmdHis');
    }
}
