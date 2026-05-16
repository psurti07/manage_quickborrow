<?php

namespace App\DataTables;

use App\Models\UserTree;
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

class ReferralCustomerDataTable extends DataTable
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
            ->addColumn('action', function($data){
                $type = (($data->acc_type == 1) ? 'selfapply' : 'loanagent');
                $lc = (($data->isUser == 1) ? 'leads' : (($data->acc_type == 1) ? 'users-details' : 'customer-details'));
                if($data->isUser == 1){
                    return '<a class="" href="javascript:;"><i class="icon-info-alt"></i></a>';
                } else {
                    return '<a class="" href="'.url($type.'/'.$lc.'/'.$data->subuserid).'"><i class="icon-info-alt"></i></a>';
                }
            })
            ->addColumn('fullname', function($data){
                return $data->first_name.' '.$data->last_name;
            })
            ->addColumn('date', function($data){
                return date('d-m-Y H:i:s', strtotime($data->rec_date));
            })
            ->setRowId('id')->rawColumns(['action','fullname','date']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserTree $model): QueryBuilder
    {
        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');
        
        $query = $model->newQuery()
            ->select('user_tree.*','user_registrations.first_name','user_registrations.last_name','user_registrations.city','user_registrations.state','user_registrations.mobile','user_registrations.email','user_registrations.acc_type','user_registrations.isUser')
            ->join('user_registrations', 'user_registrations.id', '=', 'user_tree.subuserid')
            ->orderByDesc('user_tree.id');
        
        if(!empty($start_date) && !empty($end_date)){
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $query = $query->whereRaw('DATE(user_tree.rec_date) BETWEEN ? AND ?',[$start_date,$end_date]);
        } else {
            $start_date = date('Y-m-d',strtotime('-2 days'));
            $end_date = date('Y-m-d');
            $query = $query->whereRaw('DATE(user_tree.rec_date) BETWEEN ? AND ?', [$start_date,$end_date]);
        }
        
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('referralcustomer-table')
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
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('date')->title('Date')->searchable(false),
            Column::make('fullname')->title('Full Name')->data('fullname'),
            Column::make('mobile')->title('Mobile')->data('mobile'),
            Column::make('email')->title('Email')->data('email'),
            Column::make('city')->title('City')->data('city'),
            Column::make('state')->title('State')->data('state'),
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
        return 'ReferralCustomer_' . date('YmdHis');
    }
}
