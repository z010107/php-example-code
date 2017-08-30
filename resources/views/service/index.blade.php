@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Услугие
                <a class="btn btn-primary" href="{{ url('service/add') }}" role="button"><i class="glyphicon glyphicon-plus-sign"></i> Добавить новую</a>
            </h3>

            @if (!empty($objs))
            <table class="table table-hover">
                @foreach ($objs as $o)
                <tr>
                    <td>
                        {{ $o->caption }}
                    </td>
                    <td width="100" class="text-center">
                        <a class="btn btn-info btn-sm" href="{{ url('service/edit/' . $o->id) }}" role="button" title="Изменить"><i class="glyphicon glyphicon-pencil"></i></a>

                        <a class="btn btn-danger btn-sm confirm-delete" href="{{ url('service/delete/' . $o->id) }}" role="button" title="Удалить" data-info="{{ $o->caption }}"><i class="glyphicon glyphicon-remove-sign"></i></a>
                    </td>
                </tr>
                @endforeach
            </table>
            @endif


        </div>
    </div>
</div>
@endsection
