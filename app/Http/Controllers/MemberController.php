<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberCreateRequest;
use App\Http\Requests\MemberEditRequest;
use App\Models\Member;
use App\Services\MemberService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class MemberController extends Controller
{
    /**
     * @var MemberService
     */
    private $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * Returns a listing of the members in paginated DataTable json format.
     *
     * @return array
     * @throws Exception MemberService $memberService
     */
    public function list(): array
    {
        return $this->memberService->paginate();
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
            return $this->list();
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
        $data['formAction'] = route('members.store');

        return view('members.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MemberCreateRequest $request
     * @return JsonResponse
     */
    public function store(MemberCreateRequest $request): JsonResponse
    {
        try {
            $member = Member::create($request->validated());
        } catch (QueryException $e) {
            $errorMessage = json_encode($e->errorInfo);

            if ($e->errorInfo[1] === 1062) {
                $errorMessage = explode(" for ", $e->errorInfo[2])[0];
            }

            return $this->sendError($errorMessage);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            return $this->sendError($errorMessage, [], 500);
        }

        return $this->sendResponse("User created successfully", $member);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Member $member
     * @return JsonResponse|View|Factory
     */
    public function show(Request $request, Member $member)
    {
        if ($request->expectsJson()) {
            return $this->sendResponse("", $member);
        }

        $data['member'] = $member;

        return view('members.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Member $member
     * @return JsonResponse|View|Factory
     */
    public function edit(Member $member)
    {
        $data['member'] = $member;
        $data['formAction'] = route('members.update', $member->id);

        return view('members.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MemberEditRequest $request
     * @param Member $member
     * @return JsonResponse
     */
    public function update(MemberEditRequest $request, Member $member): JsonResponse
    {
        try {
            $member->update($request->validated());
        } catch (QueryException $e) {
            $errorMessage = json_encode($e->errorInfo);

            if ($e->errorInfo[1] === 1062) {
                $errorMessage = explode(" for ", $e->errorInfo[2])[0];
            }

            return $this->sendError($errorMessage);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            return $this->sendError($errorMessage, null, 500);
        }

        return $this->sendResponse("User Updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Member $member
     * @return JsonResponse
     */
    public function destroy(Member $member): JsonResponse
    {
        try {
            $member->delete();
        } catch (QueryException $e) {
            $errorMessage = json_encode($e->errorInfo);

            if ($e->errorInfo[1] === 1062) {
                $errorMessage = explode(" for ", $e->errorInfo[2])[0];
            }

            return $this->sendError($errorMessage);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            return $this->sendError($errorMessage, null, 500);
        }

        return $this->sendResponse("User Deleted successfully");
    }
}
