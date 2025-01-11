<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\TrashedUser;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class TrashedUsersDataTable extends DataTable
{
    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                return view('admin.partials.trashAction', compact('data'));
            });
    }

    public function query(User $model): QueryBuilder
    {
         $query = $model->onlyTrashed();
        // Log::info('DataTable Query:', ['query' => $query->toSql()]);
        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('trahsed-users-table')
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
            Column::make('uuid')->className('text-center align-middle'),
            Column::make('name')->className('text-center align-middle'),
            Column::make('email')->className('text-center align-middle'),
            Column::make('status')->className('text-center align-middle'),


            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->className('text-center align-middle'),
        ];
    }


    protected function filename(): string
    {
        return 'TrashedUsers_' . date('YmdHis');
    }
}
