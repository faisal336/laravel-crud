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
use Illuminate\Http\RedirectResponse;

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
     * @return JsonResponse
     * @throws Exception MemberService $memberService
     */
    public function list(): JsonResponse
    {
        return $this->memberService->allDTPaginated();
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Factory
     */
    public function index()
    {
        return view('resource.members.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|Factory
     */
    public function create()
    {
        $formAction = route('members.store');

        return view('resource.members.form', ['member' => new Member(), 'formAction' => $formAction]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MemberCreateRequest $request
     * @return RedirectResponse
     */
    public function store(MemberCreateRequest $request): RedirectResponse
    {
        $member = Member::create($request->validated());

        return redirect()->route('members.show', $member->id)->with('success', 'Member Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Member $member
     * @return View|Factory
     */
    public function show(Member $member)
    {
        return view('resource.members.show', ['member' => $member]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Member $member
     * @return View|Factory
     */
    public function edit(Member $member)
    {
        $formAction = route('members.update', $member->id);

        return view('resource.members.form', ['member' => $member, 'formAction' => $formAction]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MemberEditRequest $request
     * @param Member $member
     * @return RedirectResponse
     */
    public function update(MemberEditRequest $request, Member $member): RedirectResponse
    {
        $member->update($request->validated());

        return back()->with('success', 'Member Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Member $member
     * @return RedirectResponse
     */
    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return back()->with('success', 'Member Deleted!');
    }
}
