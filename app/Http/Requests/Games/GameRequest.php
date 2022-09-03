<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'played_at' => [
                'required',
                'date',
            ],
            'score_blue' => [
                'required',
                'integer',
                'min:0',
                'max:10',
            ],
            'score_red' => [
                'required',
                'integer',
                'min:0',
                'max:10',
            ],
            'players' => [
                'required',
                'array',
            ],
            'players.*.id' => [
                'required',
                'distinct',
                'integer',
                'exists:users,id',
            ],
            'players.*.team' => [
                'required',
                'string',
                'in:blue,red',
            ],
            'players.*.position' => [
                'required',
                'string',
                'in:offense,defense',
            ],
        ];
    }
}
