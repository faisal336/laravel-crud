<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberCreateRequest;
use App\Http\Requests\MemberEditRequest;
use App\Models\Member;
use App\Services\MemberService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class MemberController extends Controller
{
    /**
     * @var MemberService
     */
    private $memberService;

    public function __construct()
    {
        $this->memberService = new MemberService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->memberService->paginate();
        }

        return view('members.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|Factory
     */
    public function create()
    {
        $data['member'] = new Member;

        return view('members.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MemberCreateRequest $request
     * @return Response
     */
    public function store(MemberCreateRequest $request): Response
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('member_image')) {
                $validatedData['image_path'] = $request->member_image->store('public/members');
                $validatedData['image_path'] = str_replace('public/members/', 'storage/members/', $validatedData['image_path']);
            }

            $member = Member::create($validatedData);

            $message = $member->id;
            $statusCode = 200;
        } catch (QueryException $e) {
            try {
                $message = json_encode($e->errorInfo, JSON_THROW_ON_ERROR);
                $statusCode = 500;

                if ($e->errorInfo[1] === 1062) {
                    $message = explode(" for ", $e->errorInfo[2])[0];
                    $statusCode = 409;
                }
            } catch (\JsonException $e) {
                $message = $e->getMessage();
                $statusCode = 500;
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $statusCode = 500;
        }

        return response($message, $statusCode);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Member $member
     * @return Response|View|Factory
     */
    public function show(Request $request, Member $member)
    {
        if ($request->expectsJson()) {
            return response($member);
        }

        $data['member'] = $member;

        return view('members.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Member $member
     * @return View|Factory
     */
    public function edit(Member $member)
    {
        $data['member'] = $member;

        return view('members.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MemberEditRequest $request
     * @param Member $member
     * @return Response
     */
    public function update(MemberEditRequest $request, Member $member): Response
    {
        try {
            $member->update($request->validated());

            $message = 'User Updated successfully';
            $statusCode = 200;
        } catch (QueryException $e) {
            try {
                $message = json_encode($e->errorInfo, JSON_THROW_ON_ERROR);
                $statusCode = 500;

                if ($e->errorInfo[1] === 1062) {
                    $message = explode(" for ", $e->errorInfo[2])[0];
                    $statusCode = 409;
                }
            } catch (\JsonException $e) {
                $message = $e->getMessage();
                $statusCode = 500;
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $statusCode = 500;
        }

        return response($message, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Member $member
     * @return Response
     */
    public function destroy(Member $member): Response
    {
        try {
            $member->delete();

            $message = 'User Deleted successfully';
            $statusCode = 200;
        } catch (QueryException $e) {
            try {
                $message = json_encode($e->errorInfo, JSON_THROW_ON_ERROR);
                $statusCode = 500;
            } catch (\JsonException $e) {
                $message = $e->getMessage();
                $statusCode = 500;
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $statusCode = 500;
        }

        return response($message, $statusCode);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function showTable(Request $request): Response
    {
        $id = $request->input('id', 0);
        $table = "
            <table class='table table-striped'>
            <tr>
                <td>something: $id</td>
                <td>something</td>
                <td>something</td>
                <td>something</td>
            </tr>
            </table>
        ";

        return response($table);
    }
}
