@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h3>Условия предоставления скидки
                <a class="btn btn-primary" href="{{ url('discount/add') }}" role="button"><i class="glyphicon glyphicon-plus-sign"></i> Добавить новое</a>
            </h3>

            @if (!empty($objs))
            <table class="table table-hover">
                <tr>
                    <th>Скидка</th>
                    <th>Услуги</th>
                    <th>Дата рождения <br/>(неделя до)</th>
                    <th>Дата рождения <br/>(неделя после)</th>
                    <th>Поле "телефон"</th>
                    <th>4 цифры телефона</th>
                    <th>Пол</th>
                    <th>Период действия</th>
                    <th></th>
                </tr>
                @foreach ($objs as $o)
                <tr>
                    <td>{{ number_format($o->discount, 0, '.', ' ') }}%</td>
                    <td>
                        @if (!empty($o->links))
                        @foreach($o->links as $l)
                        {{ $l->service->caption }} <br/>
                        @endforeach
                        @else
                        Не заданы
                        @endif
                    </td>
                    <td>
                        @if (!empty($o->bd_week_before))
                        Задан
                        @else
                        Не задан
                        @endif
                    </td>
                    <td>
                        @if (!empty($o->bd_week_after))
                        Задан
                        @else
                        Не задан
                        @endif
                    </td>
                    <td>
                        @if (!empty($o->exist_phone))
                        Задан
                        @else
                        Не задан
                        @endif
                    </td>
                    <td>
                        @if (!empty($o->phone_last_digit))
                        {{ $o->phone_last_digit }}
                        @else
                        Не задан
                        @endif
                    </td>
                    <td>{{ trans('crud.gender_' . $o->gender) }}</td>
                    <td>
                        @if (!empty($o->start_on))
                        {{ date("d.m.Y", strtotime($o->start_on)) }}
                        @else
                        Не задан
                        @endif -<br/>
                        @if (!empty($o->end_on))
                        {{ date("d.m.Y", strtotime($o->end_on)) }}
                        @else
                        Не задан
                        @endif
                    </td>

                    <td width="100" class="text-center">
                        <a class="btn btn-info btn-sm" href="{{ url('discount/edit/' . $o->id) }}" role="button" title="Изменить"><i class="glyphicon glyphicon-pencil"></i></a>

                        <a class="btn btn-danger btn-sm confirm-delete" href="{{ url('discount/delete/' . $o->id) }}" role="button" title="Удалить" data-info="{{ $o->discount }}"><i class="glyphicon glyphicon-remove-sign"></i></a>
                    </td>
                </tr>
                @endforeach
            </table>
            @endif

        </div>
    </div>
</div>
@endsection
