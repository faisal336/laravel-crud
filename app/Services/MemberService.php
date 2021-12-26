<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Support\Facades\DB;

class MemberService
{
    /**
     * @return array
     */
    public function paginate(): array
    {
        $request = request();

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
            ->offset($request->input('start', 0))
            ->limit($request->input('length', 10))
            ->get();

        $response = [];
        $response['draw'] = $request->input('draw', 1);
        $response['data'] = $members;
        $response['recordsTotal'] = $recordsTotal;
        $response['recordsFiltered'] = $recordsTotal;

        return $response;
    }
}
