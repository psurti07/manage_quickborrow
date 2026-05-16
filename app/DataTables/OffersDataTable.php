<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Cardoffer as Offer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OffersDataTable extends DataTable
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
            ->addColumn('action', function($model){
                $btnName = $model->isCustomer==0 ?'Lead':'Customer';
                $btnClass = $model->isCustomer==0 ?'warning':'success';
                $msg = $model->isCustomer==0 ? "Are you sure you want to convert this lead into customer." : "Are you sure you want to convert this customer into lead.";
                $msg = addslashes($msg);
                return '<a href="javascript:;" id="btn-'.$model->id.'" class="btn btn-'.$btnClass.'" onclick="convert('.$model->id.', \''.$msg.'\','.$model->isCustomer.')">'.$btnName.'</a>';
            })
            ->addColumn('registrationDate', function ($model){
                return displayDate($model->registration_date);
            })
            ->addColumn('fullname',function($model){
                return $model->first_name.' '.$model->last_name;
            })
            ->filterColumn('fullname', function ($query, $keyword) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"]);
            })
            ->addColumn('amount', function($query){
                return formatePriceIndia($query->amount);
            })
            ->addColumn('expiryDate', function($model){
                return displayDate($model->expiry_date);
            })
            ->setRowId('id')
            ->rawColumns(['action','registrationDate','amount','expiryDate','fullname']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Offer $model): QueryBuilder
    {
       
        $offerName = $this->offerName;
        switch($offerName){
            case 'Great_Deal_Offer':
                $offerPage = 1;
                break;
            case 'Elite_Offer':
                $offerPage = 2;
                break;
            case 'Ultra_Saver_Offer':
                $offerPage = 3;
                break;
            case 'Big_Offer':
                $offerPage = 8;
                break;
            case 'Big_Benefit_Offer':
                $offerPage = 10;
                break;
            case 'Prime_Offer':
                $offerPage = 4;
                break;
            case 'Mega_Offer':
                $offerPage = 5;
                break;
            case 'Premium_Offer':
                $offerPage = 6;
                break;
            case 'Star_Offer':
                $offerPage = 7;
                break;
            case 'Great_Offer':
                $offerPage = 9;
                break;
            case 'Standard_Offer':
                $offerPage = 31;
                break;
            case 'Silver_Offer':
                $offerPage = 32;
                break;
            default:
                $offerPage = 1;
                break;
        }
        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');

        $query = $model->newQuery()
            ->where('offerpage',$offerPage)
            ->where('isActive', 1)
            ->where('isDelete', 0)
            ->orderByDesc('id');

        if(!empty($start_date) && !empty($end_date)){
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $query = $query->whereRaw('DATE(registration_date) BETWEEN ? AND ?',[$start_date,$end_date]);
        } else {
            $start_date = date('Y-m-d',strtotime('-2 days'));
            $end_date = date('Y-m-d');
            $query = $query->whereBetween('registration_date',[$start_date,$end_date]);
        }
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('offers-table')
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
            Column::make('fullname')->title('Fullname')->data('fullname'),
            Column::make('mobile')->title('Mobile')->data('mobile'),
            Column::make('emailid')->title('Email')->data('emailid'),
            Column::make('card_number')->title('Card Number')->data('card_number'),
            Column::make('registrationDate')->title('Registration')->searchable(false),
            Column::make('expiryDate')->title('Expiry Date')->searchable(false),
            Column::make('amount')->title('Amount')->data('amount'),
            Column::make('paymentid')->title('Payment Id')->data('paymentid'),
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
        return 'Offers_' . date('YmdHis');
    }
}
