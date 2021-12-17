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
            'is_active',
            'created_at'
        )
            ->offset(request('start', 0))
            ->limit(request('length', 10))
            ->get();

        foreach($members as $key => $member) {
            $member->action = '
                <a href="' . route('members.show', ['member' => $member->id]) . '" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a> |
                <a href="' . route('members.edit', ['member' => $member->id]) . '" class="edit btn btn-success btn-sm"><i class="fa fa-edit"></i></a> |
                <button type="button" class="destroy btn btn-danger btn-sm" id="deleteRecord" onclick="deleteRecord(' . $member->id . ')"><i class="fa fa-trash"></i></button>

            ';
        }

        $response = [];
        $response['draw'] = request('draw', 1);
        $response['data'] = $members;
        $response['recordsTotal'] = $recordsTotal;
        $response['recordsFiltered'] = $recordsTotal;

        return $response;
    }
}
