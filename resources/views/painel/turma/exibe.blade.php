<style>
    label {
        text-transform: uppercase;
        color: dimgray;
        font-size: 14px;
    }

    .info {
        font-weight: 700;
        margin-left: 5px;
        text-transform: uppercase;
    }

    fieldset {
	    margin-bottom: 10px;
    }

    fieldset legend {
        text-transform: uppercase;
        font-size: 14px;
        padding: 0 15px;
    }
</style>

@extends('painel.templates.template1')

@section('content')
    <form method="GET" action="{{ route('turma.destroy', ['id' => $turma->id]) }}" id="cad-turma">
    <a href='{{ route("turma.index") }}' class="fa fa-arrow-left" style="font-size: 20px; margin-top: -20px; text-decoration: none"></a>
    <fieldset style="border: 1px solid gray; border-radius: 8px" class="pl-3 pb-2 pt-3 pr-5 ">
        <legend>{{ $turma->descricao ?? null }}</legend>
        <div class="row">

            <label class="col-1">Turno: </label>
            <input type="text" value="{{ $turma->turno }}" class="form-control-sm col-1" disabled/>

            <label class="col-1">Sigla: </label>
            <input type="text" value="{{ $turma->sigla }}" class="form-control-sm col-1" disabled/>

	    </div>

    </fieldset>

    <fieldset style="border: 1px solid gray; border-radius: 8px" class="mt-2 pl-3 pb-4 pr-3">
        <legend>Alunos</legend>
        <div class="row">

        @if (empty($alunos))

            <label class="col" data="no">Nenhum aluno nesta turma</lebel>

        @endif

        @foreach ($alunos as $key => $aluno)

            <label class="col-1 pb-3">Nome: </label>
            <input type="text" class="form-control-sm col-3" value="{{ $aluno->nome }}" disabled />
            <label class="col-1">Tel/Cel: </label>
            <input type="text" class="form-control-sm col-3" value="{{ $aluno->telefone . ' / ' . $aluno->celular }}" disabled/>
            <label class="col-1">Matrícula: </label>
            <label class="col-3">{{ $key }}</label>

        @endforeach

        </div>
    </fieldset>
    <div class="botao" style='float: right'>
        <button class="btn btn-sm btn-danger" value="delete" >EXCLUIR</button>
    </div>
    </form>

@endsection

<script>
    let readyPage = setInterval(() => {
        if (document.readyState === 'complete') {
            clearInterval(readyPage)
            const form = document.querySelector('form#cad-turma')
            form.onsubmit = (e) => {
                e.preventDefault()
                if (!form.querySelector('[data]')) {
                    return alert('Existem alunos matriculados nesta turma')
                } else {
                    const conf = confirm('Deseja realmente excluir esta turma?')
                    if (conf) form.submit()
                }
            }
        }
    }, 10)
</script>
