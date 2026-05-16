<?php

namespace App\DataTables;

use App\Models\UserRegistration as OpenAccount;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OpenAccountsDataTable extends DataTable
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
                $url = (($row->acc_type == 1) ? route('manage.selfapply.customer.details',['userId'=>$row->id]) : route('manage.loanagent.customer.details',['userId'=>$row->id]));
                $actionBtn = '<a class="" href="'.$url.'"><i class="icon-info-alt"></i></a>';
                return $actionBtn;
            })
            ->addColumn('date', function($row){
                return date('d-m-Y H:i:s', strtotime($row->rec_date));
            })
            ->addColumn('fullname', function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->setRowId('id')
            ->rawColumns(['action','fullname','date']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(OpenAccount $model): QueryBuilder
    {
        $days = $this->request()->get('days');
        if(empty($days)){
            $days = $this->days;
        }
        $accType = $this->acc_type;
        $processStep = $this->processStep;
        
        $query = $model->newQuery()
            ->where(['isUser'=>2,'acc_type'=>$accType])
            ->where('process_step','!=',$processStep)
            ->where('isDelete',0)
            ->whereRaw('DATE(rec_date) <= ?', [Carbon::now()->subDays((int)$days)->format('Y-m-d')])
            ->orderBy('rec_date');
        //Log::info($query->toSql());
        //Log::info($query->getBindings());
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('openaccounts-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
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
                        'pageLength' => 100
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('date')->data('date')->title('Date Time')->searchable(false)->orderable(true),
            Column::make('fullname')->data('fullname')->title('Full Name'),
            Column::make('email')->data('email')->title('Email'),
            Column::make('mobile')->data('mobile')->title('Mobile'),
            Column::make('city')->data('city')->title('City'),
            Column::make('state')->data('state')->title('State'),
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
        return 'OpenAccounts_' . date('YmdHis');
    }
}
