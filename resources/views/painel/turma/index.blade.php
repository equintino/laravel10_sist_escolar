@extends('painel.templates.template1')

@section('content')
<table class='table table-striped'>
    <thead>
        <tr>
            <th>Descrição</th>
        	<th>Turno</th>
		    <th>Sigla</th>
            <th width="100px">Ações</th>
        </tr>
    </thead>
    <tbosy>

    @foreach($turmas as $i)

    <tr>
        <td>{{ $i->descricao }}</td>
        <td>{{ $i->turno }}</td>
        <td>{{ $i->sigla }}</td>
        <td>
            <a href='{{ route( "turma.edit", ["id" => $i->id]) }}' style='text-decoration: none'>
                <i class='fa fa-pencil edit actions' ></i>
            </a>
            <a class='deleta' href='{{ route("turma.show", ["id" => $i->id]) }}'>
                <i class='fa fa-eye delete actions'></i>
            </a>
        </td>
    </tr>
    @endforeach

    </tbody>
</table>
@endsection
