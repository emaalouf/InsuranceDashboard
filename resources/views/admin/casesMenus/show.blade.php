@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.casesMenu.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cases-menus.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.casesMenu.fields.id') }}
                        </th>
                        <td>
                            {{ $casesMenu->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.casesMenu.fields.case_name') }}
                        </th>
                        <td>
                            {{ $casesMenu->case_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.casesMenu.fields.car_make') }}
                        </th>
                        <td>
                            {{ $casesMenu->car_make }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.casesMenu.fields.car_year') }}
                        </th>
                        <td>
                            {{ $casesMenu->car_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.casesMenu.fields.case_date') }}
                        </th>
                        <td>
                            {{ $casesMenu->case_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.casesMenu.fields.parts') }}
                        </th>
                        <td>
                            {{ $casesMenu->parts }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.casesMenu.fields.parts_price') }}
                        </th>
                        <td>
                            {{ $casesMenu->parts_price }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cases-menus.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection