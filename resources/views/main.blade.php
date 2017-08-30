@extends('layouts.app')

@section('content')
<div class="container login-form">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <form class="form-horizontal ajax-form" role="form" method="POST" action="{{ url('') }}">
                {!! csrf_field() !!}

                <div class="form-group req">
                    <label class="col-md-4 control-label">ФИО</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="fio" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Услуги</label>

                    <div class="col-md-6">
                        @foreach($services as $k => $s)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="services[]" value="{{ $s->id }}"> {{ $s->caption }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group req">
                    <label class="col-md-4 control-label">День рождения</label>

                    <div class="col-md-4">
                        <input type="text" class="form-control datepicker" name="birthday" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Телефон</label>

                    <div class="col-md-4">
                        <input type="text" class="form-control form-phone" name="phone" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Пол</label>

                    <div class="col-md-6">
                        @foreach(['female' => 'Женский', 'male' => 'Мужской'] as $k => $v)
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" value="{{ $k }}"> {{ $v }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-success">Рассчитать</button>
                        <button type="reset" class="btn btn-danger">Сброс</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
