<?php

namespace App\DataTables;

use App\Models\UserRegistration;
use Modules\Auth\App\Models\Administrations;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ApplicationsDataTable extends DataTable
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
            $actionBtn = '<a class="" href="'.route('manage.selfapply.loan.application.details',['applicationId'=>$row->loanid]).'"><i class="icon-info-alt"></i></a>';
                return $actionBtn;
            })
            ->addColumn('date', function($row) {
                return Carbon::parse($row->rec_date)->format('d-m-Y')."<br/>".Carbon::parse($row->rec_date)->format('h:i:s A');
            })
            ->addColumn('full_name', function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->addColumn('staff', function($row) {
                return optional(Administrations::find($row->staff_id))->fullname ?? 'N/A';
            })
            ->setRowId('id')->rawColumns(['action','date','full_name','staff']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserRegistration $model): QueryBuilder
    {
        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');
        $agent = $this->request()->get('agent') == null ? '' : $this->request()->get('agent');
        
        $processSteps = $this->processSteps;
        /*Log::info('datatable process step - ' . $processSteps);*/
        $query = $model->newQuery()
            ->select(
                'user_registrations.staff_id',
                'user_registrations.rec_date',
                'user_registrations.first_name',
                'user_registrations.last_name',
                'user_registrations.mobile',
                'user_registrations.email',
                'user_registrations.city',
                'user_registrations.state',
                'user_registrations.id as userid',
                'loan_applications.id as loanid'
            )
            ->join('loan_applications', 'user_registrations.id', '=', 'loan_applications.userid')
            ->when(Auth::user()->role == 2, function ($q) {
                $q->where('user_registrations.staff_id', Auth::user()->id);
            })
            ->where('user_registrations.acc_type', 2)
            ->where('user_registrations.isDelete', 0)
            ->whereIn('user_registrations.process_step', $processSteps==5 ? [4,(int)$processSteps] : [(int)$processSteps])  
            ->where('user_registrations.isUser', 2)
            ->orderByDesc('user_registrations.id');
            
        if($agent > 0){
            $query = $query->where('staff_id', $agent);
        } elseif($agent == 0) {
            $query = $query->where('staff_id', NULL);
        }
        if(!empty($start_date) && !empty($end_date)){
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $query = $query->whereRaw('DATE(user_registrations.rec_date) BETWEEN ? AND ?',[$start_date,$end_date]);
        } else {
            $start_date = date('Y-m-d',strtotime('-2 days'));
            $end_date = date('Y-m-d');
            $query = $query->whereRaw('DATE(user_registrations.rec_date) BETWEEN ? AND ?', [$start_date,$end_date]);
        }
        /*Log::info($query->toSql());
        Log::info($query->getBindings());*/
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('applications-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
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
            Column::make('date')->searchable(false)->orderable(false), 
            Column::make('staff')->data('staff')->title('Staff'),
            Column::make('full_name')->data('full_name')->title('Full Name'),
            Column::make('mobile')->data('mobile')->title('Mobile'),
            Column::make('email')->data('email')->title('Email'),
            Column::make('city')->data('city')->title('City'),
            Column::make('state')->data('state')->title('State'),
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
        return 'Applications_' . date('YmdHis');
    }
}
