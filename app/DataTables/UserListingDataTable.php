<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\UserListing;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class UserListingDataTable extends DataTable
{
    public function dataTable($query) {
        return datatables()
            ->eloquent($query);
    }
    public function query(User $model): QueryBuilder
    {
        $query = $model->newQuery()->with('studentinfo')->where('role', 'student')->where('status', 'active');
        Log::info('home DataTable Query:', ['query' => $query->getQuery()->toSql(), 'bindings' => $query->getBindings()]);
        return $query;
    }
    
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-listing-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                                'tr' .
                                        <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
                    ->orderBy(4)
                    ->buttons(
                        Button::make('excel')
                            ->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                        Button::make('print')
                            ->text('<i class="bi bi-printer-fill"></i> Print'),
                        Button::make('reset')
                            ->text('<i class="bi bi-x-circle"></i> Reset'),
                        Button::make('reload')
                            ->text('<i class="bi bi-arrow-repeat"></i> Reload')
                    );
    }
 
    public function getColumns(): array
    {
        return [
            Column::make('id')->className('text-center align-middle'),
            Column::make('first_name')->className('text-center align-middle'),
            Column::make('last_name')->className('text-center align-middle'),
            Column::make('user_name')->className('text-center align-middle'),
            Column::make('email')->className('text-center align-middle'),  
            Column::make('professional_email')
            ->className('text-center align-middle')
            ->render(function($item) {
                return $item->studentinfo->professional_email ?? 'N/A'; // Fallback if not available
            }),

            
             
        ];
    }
 
    protected function filename(): string
    {
        return 'UserListing_' . date('YmdHis');
    }
}
