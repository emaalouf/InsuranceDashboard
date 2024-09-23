@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.casesMenu.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cases-menus.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="case_name">{{ trans('cruds.casesMenu.fields.case_name') }}</label>
                <input class="form-control {{ $errors->has('case_name') ? 'is-invalid' : '' }}" type="text" name="case_name" id="case_name" value="{{ old('case_name', '') }}">
                @if($errors->has('case_name'))
                    <span class="text-danger">{{ $errors->first('case_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.casesMenu.fields.case_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="car_make">{{ trans('cruds.casesMenu.fields.car_make') }}</label>
                <input class="form-control {{ $errors->has('car_make') ? 'is-invalid' : '' }}" type="text" name="car_make" id="car_make" value="{{ old('car_make', '') }}" required>
                @if($errors->has('car_make'))
                    <span class="text-danger">{{ $errors->first('car_make') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.casesMenu.fields.car_make_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="car_year">{{ trans('cruds.casesMenu.fields.car_year') }}</label>
                <input class="form-control {{ $errors->has('car_year') ? 'is-invalid' : '' }}" type="text" name="car_year" id="car_year" value="{{ old('car_year', '') }}" required>
                @if($errors->has('car_year'))
                    <span class="text-danger">{{ $errors->first('car_year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.casesMenu.fields.car_year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="case_date">{{ trans('cruds.casesMenu.fields.case_date') }}</label>
                <input class="form-control date {{ $errors->has('case_date') ? 'is-invalid' : '' }}" type="text" name="case_date" id="case_date" value="{{ old('case_date') }}">
                @if($errors->has('case_date'))
                    <span class="text-danger">{{ $errors->first('case_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.casesMenu.fields.case_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="parts">{{ trans('cruds.casesMenu.fields.parts') }}</label>
                <input class="form-control {{ $errors->has('parts') ? 'is-invalid' : '' }}" type="text" name="parts" id="parts" value="{{ old('parts', '') }}" required>
                @if($errors->has('parts'))
                    <span class="text-danger">{{ $errors->first('parts') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.casesMenu.fields.parts_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="parts_price">{{ trans('cruds.casesMenu.fields.parts_price') }}</label>
                <input class="form-control {{ $errors->has('parts_price') ? 'is-invalid' : '' }}" type="text" name="parts_price" id="parts_price" value="{{ old('parts_price', '') }}" required>
                @if($errors->has('parts_price'))
                    <span class="text-danger">{{ $errors->first('parts_price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.casesMenu.fields.parts_price_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection