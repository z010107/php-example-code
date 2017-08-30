@extends('layouts.app')

@section('content')
<div class="container login-form">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('service/save') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{ $obj->id }}" />

                <div class="form-group{{ $errors->has('caption') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Название</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="caption" value="{{ !empty(old('caption')) ? old('caption') : $obj->caption }}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Сохранить
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
