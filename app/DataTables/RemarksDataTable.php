<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Remarks\App\Models\Remark;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RemarksDataTable extends DataTable
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
            ->filterColumn('status', function ($query, $keyword) {
                $query->where('loanstatus.statusname', 'like', "%{$keyword}%");
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
            ->addColumn('type', function ($row) {
                return in_array($row->statusid, [6,11]) ? 'Self Apply' : 'Loan Agent';
            })
            ->setRowId('id')
            ->rawColumns(['action','type']);
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(Remark $model): QueryBuilder
    {
        $products = $this->request()->get('products');
        $query =  $model->newQuery()
        ->where('loanstatus_remarks.isDelete', 0)
        ->join('loanstatus', 'loanstatus_remarks.statusid', '=', 'loanstatus.id')
        ->select('loanstatus_remarks.*', 'loanstatus.statusname as status');
        
        if(!empty($products)){
            if($products == 'self-apply'){
                $query = $query->whereIn('statusid',array(6,11));
            } 
            else if($products == 'hire-agent'){
                $query = $query->whereIn('statusid',array(7,8,9,10));
            }
        }
        
        return $query;
        
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('remarks-table')
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
                Button::make('print'),
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
            Column::make('DT_RowIndex')->title('#')->width(5)->searchable(false),
            Column::make('type')->title('Type')->searchable(true),
            Column::make('status')->title('Status')->searchable(true),
            Column::make('title')->title('Title')->searchable(true),
            Column::make('remarks')->searchable(false),
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
        return 'Remarks_' . date('YmdHis');
    }
}
