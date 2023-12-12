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
<script>
// (delTurma = () => {
//                                     setTimeout(() => {
//                                         const rows = document.querySelectorAll('table tbody tr')
//                                         for (let x = 0; x < rows.length; x++) {
//                                             let content = rows[x].textContent
//                                             if (content.indexOf('test turma') !== -1) {
//                                                 let view = rows[x].querySelector('.delete').parentElement
//                                                 view.onclick = (e) => {
//                                                     e.preventDefault()
//                                                     window.location.assign(url="<?= route('turma.show', ['id' =>   170]) ?>")
//                                                 }
//                                                 view.dispatchEvent(new Event('click'))
//                                             }
//                                         }
//                                     }, 100)
//                                 })()
</script>
