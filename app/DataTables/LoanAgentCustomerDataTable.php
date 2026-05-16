<?php

namespace App\DataTables;

use App\Models\UserRegistration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class LoanAgentCustomerDataTable extends DataTable
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
            $actionBtn = '<a class="" href="'.route('manage.loanagent.customer.details',['userId'=>$row->id]).'"><i class="icon-info-alt"></i></a>';
                return $actionBtn;
            })
            ->addColumn('date',function($row){
                return date('d-m-Y', strtotime($row->rec_date)).'<br/>'.date('h:i:s A', strtotime($row->rec_date));
            })
            ->addColumn('full_name', function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->setRowId('id')->rawColumns(['action','date','full_name']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserRegistration $model): QueryBuilder
    {
        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');
        $agent = $this->request()->get('agent');
        
        $query = $model->newQuery()
            ->where('acc_type', 2)
            ->when(Auth::user()->role == 2, function ($q) {
                return $q->where('staff_id', Auth::user()->id);
            })
            ->where('isUser', 2)
            ->where('isDelete', 0)
            ->orderByDesc('id');
            
        if($agent != ''){
            if($agent){
                $query = $query->whereNotNull('staff_id');   
            } else {
                $query = $query->whereNull('staff_id');
            }
        }
        if (!empty($start_date) && !empty($end_date)) {
            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');
            $query = $query->whereRaw('DATE(rec_date) BETWEEN ? AND ?', [$start_date, $end_date]);
        } else {
            $start_date = date('Y-m-d', strtotime('-2 days'));
            $end_date = date('Y-m-d');
            $query = $query->whereRaw('DATE(rec_date) BETWEEN ? AND ?', [$start_date, $end_date]);
        }
        
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('customer-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(100)
                    ->dom('Blfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->pageLength(50)
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
            Column::make('DT_RowIndex')->title('#')->width(5)->searchable(false)->orderable(false),
            Column::make('date')->title('Date')->searchable('false'), 
            Column::make('full_name')->title('Full Name')->data('full_name'),
            Column::make('mobile')->title('Mobile')->data('mobile'),
            Column::make('email')->title('Email')->data('email'),
            Column::make('city')->title('city')->data('city'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->searchable(false)
                ->orderable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'LoanAgentCustomer_' . date('YmdHis');
    }
}
