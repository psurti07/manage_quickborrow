<?php

namespace App\DataTables;

use App\Models\Adscontent;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdvertisementsDataTable extends DataTable
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
                            <li class="delete">
                                <a href="javascript:;" onclick="destroy('.$row->id.')">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>
                          </ul>';
                return $action;
            })
            ->addColumn('date',function($row){
                return date('d-m-Y', strtotime($row->rec_date));
            })
            ->addColumn('content',function($row){
                if($row->ad_type == 1){
                    return htmlspecialchars($row->ad_content);
                } else {
                    return '<img src="'.asset('upload/ads/'.$row->ad_content).'" width="50" height="50">';
                }

            })
            ->setRowId('id')
            ->rawColumns(['action','content','date']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Adscontent $model): QueryBuilder
    {
        $type = $this->type == 'text' ? 1 : 2;
        return $model->newQuery()->where('ad_type',$type)->where('isDelete',0)->orderByDesc('id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('advertisements-table')
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
            Column::make('DT_RowIndex')->title('#')->searchable(false),
            Column::make('date')->title('Date')->searchable(false),
            Column::make('content')->title('Content')->data('content'),
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
        return 'Advertisements_' . date('YmdHis');
    }
}
