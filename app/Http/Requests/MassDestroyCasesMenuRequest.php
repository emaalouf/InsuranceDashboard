<?php

namespace App\Http\Requests;

use App\Models\CasesMenu;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCasesMenuRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cases_menu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:cases_menus,id',
        ];
    }
}
