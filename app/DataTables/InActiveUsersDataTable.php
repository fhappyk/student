<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\InActiveUser;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class InActiveUsersDataTable extends DataTable
{
    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('status', function ($data) {
                return '
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown' . $data->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                            ' . $data->status . '
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="statusDropdown' . $data->id . '">
                             <li><a class="dropdown-item change-status" href="' . route("admin.change.status", [$data->id, 'active']) . '" data-id="' . $data->id . '" data-status="active">Active</a></li>
                        </ul>
                    </div>
                ';
            })
            ->addColumn('action', function ($data) {
                return view('admin.partials.actions', compact('data'));
            })
            ->rawColumns(['status', 'action']);
    }

    public function query(User $model): QueryBuilder
    {
         $query = $model->newQuery()->where('role', 'student')->where('status', 'inactive');
        Log::info('DataTable Query:', ['query' => $query->toSql()]);
        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('inactive-student-table')
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
        return 'InActiveUsers_' . date('YmdHis');
    }
}
