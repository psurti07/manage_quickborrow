<?php

namespace App\DataTables;

use App\Models\SupportRequest;
use App\Models\SupportRequests;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SupportRequestDataTable extends DataTable
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
            ->addColumn('action', function ($model) {
                 return '<ul class="action">
                             <li class="info">
                                 <a href="javascript:;" onclick="details(' . $model->id . ')">
                                     <i class="icon-info-alt"></i>
                                 </a>
                             </li>
                           </ul>';
             })
            ->addColumn('date', function($model){
                return date('d-m-Y h:i', strtotime($model->rec_date));
            })
            ->addColumn('name', function ($model) {
                return $model->firstname . ' ' . $model->lastname;
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$keyword}%"]);
            })
            ->addColumn('status', function($model){
                switch($model->status){
                    case 1:
                        $status = '<span class="text-info">Open</span>';
                        break;
                    case 2:
                        $status = '<span class="text-danger">Processing</span>';
                        break;
                    case 3:
                        $status = '<span class="text-warning">Closed – No Response</span>';
                        break;
                    case 4:
                        $status = '<span class="text-success">Solved</span>';
                        break;
                    default:
                        $status = "-";
                        break;
                }
                return $status;
            })
            ->addColumn('usertype',function($model){
                switch($model->usertype){
                    case 1:
                        $usertype = "Self Apply";
                        break;
                    case 2:
                        $usertype = "Guest User";
                        break;
                    case 3:
                        $usertype = "Loan Agent";
                        break;
                    default:
                        $usertype = "-";
                        break;
                }
                return $usertype;
            })
            ->setRowId('id')
            ->rawColumns(['date','name','status','usertype','action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SupportRequests $model): QueryBuilder
    {
        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');
        $usertype = $this->request()->get('usertype');
        $issueType = $this->request()->get('issueType');
        
        $query = $model->newQuery()->orderByDesc('id');
        
        if (!empty($usertype)) {
            $query->where('usertype', $usertype);
        }
        
        if (!empty($issueType)) {
            $query->where('issuetype', $issueType);
        }
        
        if(!empty($start_date) && !empty($end_date)){
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $query = $query->whereRaw('DATE(rec_date) BETWEEN ? AND ?',[$start_date,$end_date]);
        } else {
            $start_date = date('Y-m-d',strtotime('-2 days'));
            $end_date = date('Y-m-d');
            $query = $query->whereRaw('DATE(rec_date) BETWEEN ? AND ?',[$start_date,$end_date]);
        }
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('supportrequest-table')
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
            Column::make('DT_RowIndex')->title('#')->orderable(false)->searchable(false)->width(5),
            Column::make('date')->title('Date')->searchable(false),
            Column::make('ticketno')->title('Ticket No')->data('ticketno'),
            Column::make('status')->title('Status')->data('status'),
            Column::make('issuetype')->title('Issue Type')->data('issuetype'),
            Column::make('usertype')->title('User Type')->data('usertype'),
            Column::make('name')->title('Full Name')->data('name'),
            Column::make('mobile')->title('Mobile')->data('mobile'),
            Column::make('email')->title('Email')->data('email'),
             Column::computed('action')->searchable(false)
                 ->exportable(false)
                 ->printable(false)
                 ->title('Details')
                 ->width(5)
                 ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SupportRequest_' . date('YmdHis');
    }
}
