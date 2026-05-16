<?php

namespace App\DataTables;

use App\Models\SourceEntry;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class UtmSourceDataTable extends DataTable
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
            ->addColumn('fullname', function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->addColumn('rdate', function($row){
                return date('d-m-Y', strtotime($row->rec_date));
            })
            /*->addColumn('action', 'utmsource.action')*/
            ->setRowId('id')
            ->rawColumns(['fullname', 'rdate']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SourceEntry $model): QueryBuilder
    {
        $start_date = $this->request()->get('start_date');
        $end_date = $this->request()->get('end_date');
        $source = $this->request()->get('utmsource');
        
        $source = strtolower(request()->get('utmsource'));

        switch ($source) {
            case 'meta':
                $whereIn = ['facebook', 'instagram', 'fb', 'ig', 'facebook_instagram', 'facebookads', 'instagramads', 'meta'];
                break;
        
            case 'google':
                $whereIn = ['google'];
                break;
        
            case 'taboola':
                $whereIn = ['taboola'];
                break;
        
            case 'web':
                $whereIn = ['web'];
                break;
        
            default:
                $whereIn = [];
                break;
        }

        
        $query = $model->newQuery()->join('user_registrations as u', 'source_entry.user_id', '=', 'u.id')
        ->select([
            'source_entry.id',
            'source_entry.utm_source',
            'source_entry.utm_medium',
            'source_entry.utm_campaign',
            'source_entry.source_id',
            'source_entry.rec_date',
            'u.first_name',
            'u.last_name',
            'u.mobile'
        ])->orderByDesc('source_entry.id');
        
        if (!empty($whereIn)) {
            $query->whereIn('source_entry.utm_source', $whereIn);
        }
        
        if(!empty($start_date) && !empty($end_date)){
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $query = $query->whereRaw('DATE(source_entry.rec_date) BETWEEN ? AND ?',[$start_date,$end_date]);
        } else {
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
            $query = $query->whereRaw('DATE(source_entry.rec_date) BETWEEN ? AND ?', [$start_date,$end_date]);
        }
        
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('utmsource-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->pageLength(100)
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
            Column::make('rdate')->title('Date')->searchable(false),
            Column::make('fullname')->title('Fullname')->data('fullname'),
            Column::make('mobile')->title('Mobile')->data('mobile'),
            Column::make('utm_source')->title('Source')->data('utm_source'),
            Column::make('utm_medium')->title('UTM Medium')->data('utm_medium'),
            Column::make('utm_campaign')->title('Campaign')->data('utm_campaign'),
            Column::make('source_id')->title('Source Id')->data('source_id')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UtmSource_' . date('YmdHis');
    }
}
