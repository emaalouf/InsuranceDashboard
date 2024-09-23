<?php

namespace App\Http\Requests;

use App\Models\CasesMenu;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCasesMenuRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cases_menu_create');
    }

    public function rules()
    {
        return [
            'case_name' => [
                'string',
                'nullable',
            ],
            'car_make' => [
                'string',
                'required',
            ],
            'car_year' => [
                'string',
                'required',
            ],
            'case_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'parts' => [
                'string',
                'required',
            ],
            'parts_price' => [
                'string',
                'required',
            ],
        ];
    }
}
