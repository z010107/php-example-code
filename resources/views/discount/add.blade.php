@extends('layouts.app')

@section('content')
<div class="container login-form">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('discount/save') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="0" />

                <div class="form-group{{ $errors->has('services') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Услуги</label>

                    <div class="col-md-6">
                        @foreach($services as $k => $s)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ $s->id }}" {{ old('services.' . $k) == $s->id ? 'checked' : '' }}> {{ $s->caption }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Дата рождения</label>

                    <div class="col-md-6">
                        @foreach(['bd_week_before' => 'Неделя до', 'bd_week_after' => 'Неделя после'] as $k => $v)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="{{ $k }}" value="1" {{ old($k) == 1 ? 'checked' : '' }}> {{ $v }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Заполнено ли поле "Телефон"</label>

                    <div class="col-md-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="exist_phone" value="1" {{ old('exist_phone') == 1 ? 'checked' : '' }}>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Последние 4 цифры номера телефона</label>

                    <div class="col-md-2">
                        <input type="text" class="form-control only-chars" name="phone_last_digit" value="{{ old('phone_last_digit') }}" maxlength="4">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Пол</label>

                    <div class="col-md-6">
                        @foreach(['female' => 'Женский', 'male' => 'Мужской'] as $k => $v)
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" value="{{ $k }}" {{ old('gender') == $k ? 'checked' : '' }}> {{ $v }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Период действия условия</label>

                    <div class="col-md-2 {{ $errors->has('start_on') ? ' has-error' : '' }}">
                        <input type="text" class="form-control datepicker" name="start_on" value="{{ old('start_on') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control datepicker" name="end_on" value="{{ old('end_on') }}">
                    </div>
                </div>

                <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Скидка</label>

                    <div class="col-md-2">
                        <input type="number" class="form-control" name="discount" value="{{ old('discount') }}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Создать
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
