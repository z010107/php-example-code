@extends('layouts.app')

@section('content')
<div class="container login-form">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('discount/save') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{ $obj->id }}" />

                <div class="form-group">
                    <label class="col-md-4 control-label">Услуги</label>

                    <div class="col-md-6">
                        @foreach($services as $k => $s)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ $s->id }}" {{ !empty(old('services.' . $k)) && old('services.' . $k) == $s->id ? 'checked' : (in_array($s->id, $links) ? 'checked' : '') }}> {{ $s->caption }}
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
                                <input type="checkbox" name="{{ $k }}" value="1" {{ !empty(old($k)) && old($k) == 1 ? 'checked' : ($obj->$k == 1 ? 'checked' : '') }}> {{ $v }}
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
                                <input type="checkbox" name="exist_phone" value="1" {{ !empty(old('exist_phone')) && old('exist_phone') == 1 ? 'checked' : ($obj->exist_phone == 1 ? 'checked' : '') }}>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Последние 4 цифры номера телефона</label>

                    <div class="col-md-2">
                        <input type="text" class="form-control only-chars" name="phone_last_digit" value="{{ !empty(old('phone_last_digit')) ? old('phone_last_digit') : $obj->phone_last_digit }}" maxlength="4">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Пол</label>

                    <div class="col-md-6">
                        @foreach(['female' => 'Женский', 'male' => 'Мужской'] as $k => $v)
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" value="{{ $k }}" {{ !empty(old('gender')) && old('gender') == $k ? 'checked' : ($obj->gender == $k ? 'checked' : '') }}> {{ $v }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Период действия условия</label>

                    <div class="col-md-2 {{ $errors->has('start_on') ? ' has-error' : '' }}">
                        <input type="text" class="form-control datepicker" name="start_on" value="{{ !empty(old('start_on')) ? old('start_on') : (!empty($obj->start_on) ? date("d.m.Y", strtotime($obj->start_on)) : '') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control datepicker" name="end_on" value="{{ !empty(old('end_on')) ? old('end_on') : (!empty($obj->end_on) ? date("d.m.Y", strtotime($obj->end_on)) : '') }}">
                    </div>
                </div>

                <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Скидка</label>

                    <div class="col-md-2">
                        <input type="number" class="form-control" name="discount" value="{{ !empty(old('discount')) ? old('discount') : $obj->discount }}">
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
