<?php

namespace App\DataTables;

use Modules\Auth\App\Models\Administrations;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StaffAccountDataTable extends DataTable
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
            ->filterColumn('rolename', function($query, $keyword) {
                $roleMap = [
                    'admin' => 0,
                    'office staff' => 1,
                    'loan agent staff' => 2,
                    'it staff' => 3,
                    'accounting' => 4,
                    'self apply staff' => 5
                ];
    
                $keywordLower = strtolower($keyword);
    
                if (isset($roleMap[$keywordLower])) {
                    $query->where('role', $roleMap[$keywordLower]);
                } else {
                    // No results for unmatched search term in role
                    $query->whereRaw('0=1');
                }
            })
            ->addColumn('action', function($row){
                $action = '<ul class="action" style="display:block">
                            <li class="text-primary" style="display:block;align-items: center">
                                <a href="'.route('manage.staff.account.details',['staffId'=>$row->id]).'">
                                    <i class="icon-info-alt"></i>
                                </a>
                            </li>
                          </ul>';
                return $action;
            })
            ->addColumn('status',function($row){
                if($row->isActive) {
                    $statusBtn = '<a href="javascript:;" onclick="changeStatus('.$row->id.','.$row->isActive.')">
                                        <span class="btn btn-xs btn-outline-success">Active</span>
                                    </a>';
                } else {
                    $statusBtn = '<a href="javascript:;"  onclick="changeStatus('.$row->id.','.$row->isActive.')">
                                        <span class="btn btn-xs btn-outline-danger">Inactive</span>
                                      </a>';
                }
                return $statusBtn;
            })
            ->addColumn('rolename',function($row){
                switch($row->role){
                    case 0:
                        $role = 'Admin';
                        break;
                    case 1:
                        $role = 'Office Staff';
                        break;
                    case 2:
                        $role = 'Loan Agent Staff';
                        break;
                    case 3:
                        $role = 'IT Staff';
                        break;
                    case 4:
                        $role = 'Accounting';
                        break;
                    case 5:
                        $role = 'Self Apply Staff';
                        break;
                    default:
                        $role = 'N/A';
                        break;
                }
                return $role;
            })
            ->setRowId('id')->rawColumns(['action','rolename','status']);
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(Administrations $model): QueryBuilder
    {
        return $model->newQuery()->where(['isDelete'=>0,['role','!=',6]])->orderByDesc('id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('staffaccount-table')
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
            Column::make('DT_RowIndex')->title('#')->width(5)->searchable(false)->exportable(false),
            Column::make('fullname')->title('Staff Name')->data('fullname'),
            Column::make('staff_code')->title('Staff Code')->data('staff_code'),
            Column::make('mobile')->title('Mobile')->data('mobile'),
            Column::make('emailid')->title('Email')->data('emailid'),
            Column::make('rolename')->title('Role')->data('rolename'),
            Column::make('status')->searchable(false),
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
        return 'StaffAccount_' . date('YmdHis');
    }
}
