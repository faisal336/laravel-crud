<?php

namespace App\Http\Requests;

use App\Models\Member;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed member
 */
class MemberEditRequest extends FormRequest
{
    private $table;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->table = app(Member::class)->getTable();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => [
                'required',
                'email',
                // 'unique:App\Models\Member,email',
                // 'unique:members,email',
                Rule::unique($this->table)->ignore($this->member->id),
            ],
            'info' => 'nullable|string'
        ];
    }
}
