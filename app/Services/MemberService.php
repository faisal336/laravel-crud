<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MemberService
{
    /**
     * @throws \Exception
     */
    public function paginate()
    {
        $recordsTotal = Member::select(DB::raw('count(*) count'))->value('count');

        $members = Member::query()->select(
            'id',
            'first_name',
            'last_name',
            'email',
            'info',
            'image_path',
            'is_active',
            'created_at'
        )
            ->offset(request('start', 0))
            ->limit(request('length', 10))
            ->get();

        $response = [];
        $response['draw'] = request('draw', 1);
        $response['data'] = $members;
        $response['recordsTotal'] = $recordsTotal;
        $response['recordsFiltered'] = $recordsTotal;

        return $response;
    }
}
