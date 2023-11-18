@extends('painel.templates.template1')

@section('content')

	<!-- <a  href='{{route("turma.create")}}' ><button class="btn btn-info btn-sm mb-2"><i class="fa fa-plus-circle mr-2"></i>CADASTRAR</button></a> -->
    <table id="table" class="display">
		<thead>
			<tr>
				<th>NOME</th>
				<th>TURMA</th>
				<th>TURNO</th>
			</tr>
		</thead>
    <tbody>

	@foreach($alunos as $i)

		<tr>
		    <td>{{ $i->descrcao }}</td>
		    <td>{{ $i->turma }}</td>
		    <td>{{ $i->turno }}</td>
		</tr>

	@endforeach

    </tbody>

</table>

@endsection
