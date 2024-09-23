<?php

namespace App\Http\Requests;

use App\Models\ImagesMenu;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreImagesMenuRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('images_menu_create');
    }

    public function rules()
    {
        return [
            'images' => [
                'array',
            ],
        ];
    }
}
