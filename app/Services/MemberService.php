<?php

namespace App\Services;

use App\Models\Member;
use Yajra\DataTables\Facades\DataTables;

class MemberService
{
    /**
     * @throws \Exception
     */
    public function allDTPaginated()
    {
        $model = Member::query();
        $model->select('id', 'first_name', 'last_name', 'email', 'info', 'is_active', 'created_at');

        return Datatables::of($model)
            ->addIndexColumn()
            ->addColumn('action', function ($member) {
                return
                    '
                        <a href="' . route('members.show', ['member' => $member->id]) . '" class="show btn btn-primary btn-sm"><i class="fa fa-eye"></i></a> |
                        <a href="' . route('members.edit', ['member' => $member->id]) . '" class="edit btn btn-success btn-sm"><i class="fa fa-edit"></i></a> |
                        <form action="' . route('members.destroy', ['member' => $member->id]) . '" method="post">
                          <input type="hidden" name="_method" value="DELETE">
                          <input type="hidden" name="_token" value="' . csrf_token() . '">
                          <button type="submit" class="destroy btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    ';
            })
            ->rawColumns(['action'])
            ->only(['id', 'first_name', 'last_name', 'email', 'info', 'is_active', 'created_at', 'action'])
            ->make(true);
    }
}
