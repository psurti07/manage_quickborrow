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

class SmsMessageDataTable extends DataTable
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
                            <li class="edit" style="display:flex;align-items: center;justify-content: center">
                                <a href="javascript:;" onclick="editModal('.$row->id.')">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                            </li>
                          </ul>';
                return $action;
            })
            ->addColumn('type', function($row){
                switch($row->type){
                    case 1:
                        $type = 'Self Apply';
                        break;
                    case 2:
                        $type = 'Loan Agent';
                        break;
                    case 3:
                        $type = 'Common';
                        break;
                    default:
                        $type = 'N/A';
                        break;
                }
                return $type;
            })
            ->setRowId('id')
            ->rawColumns(['action','type']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SmsList $model): QueryBuilder
    {
        $products = $this->request()->get('products');
        $query =  $model->newQuery()->where('isActive', 1);

        if($products){
            $query->where('type', $products);
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('smsmessage-table')
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
            Column::make('rec_date')->title('Update Date'),
            Column::make('type')->title('Plan Type')->data('type'),
            Column::make('title')->title('SMS Title')->data('title'),
            Column::make('message')->title('SMS'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(10)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SmsMessage_' . date('YmdHis');
    }
}
