<?php

namespace App\DataTables;

use App\Models\MobileBanking;
use Yajra\DataTables\Services\DataTable;

class MobileBankingDataTable extends DataTable
{
    public function ajax()
    {
        $mobileBankings = $this->query();

        return datatables()
            ->of($mobileBankings)
            ->addColumn('image', function ($mobileBankings) {
                return '<img src="' . $mobileBankings->image_url . '" width="200" height="100">';
            })
            ->addColumn('action', function ($mobileBankings) {
                return '<a target="_blank" href="' . url('admin/settings/edit-mobile-banking/' . $mobileBankings->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;<a href="' . url('admin/settings/delete-mobile-banking/' . $mobileBankings->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="glyphicon glyphicon-trash"></i></a>';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function query()
    {
        $mobileBankings = MobileBanking::select();
        return $this->applyScopes($mobileBankings);
    }

    public function html()
    {
        return $this->builder()
            ->columns([
                'name',
                'mobile_no',
                'message',
                'image',
            ])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }
}
