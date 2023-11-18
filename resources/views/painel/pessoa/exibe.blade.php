<style>
    label {
        text-transform: uppercase;
        color: dimgray;
    }

    .info {
        font-weight: 700;
        margin-left: 5px;
        text-transform: uppercase;
    }

    label {
        font-size: 14px;
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

    <a href='{{ route("$tipo.index") }}' class="fa fa-arrow-left"
    style="font-size: 20px; margin-top: -20px; text-decoration: none"></a>
    <fieldset style="border: 1px solid gray; border-radius: 8px" class="pl-3 pb-2 pt-3 pr-3 ">
        <legend>Identificação

        @if($tipo=='aluno')

            <span style='float: right'>Matrícula Nº {{ isset($matId) ? $matId : '0000' }}</span>

        @endif

        </legend>
        <div class="row">
            <div style="margin: -20px 0 0 10px;border: 1px solid #ccc;border-radius: 9px;overflow: hidden; height: 140px">

                @if ($dados->image_id)

                    <img src='{{ route("imagem", ["id" => $dados->image_id]) }}' alt="photo" height="140" />

                @endif

            </div>
            <div class="col">
                <div class="row">

                    @if ($dados->nome)

                    <div class="col-1" align="right"><label>Nome: </label></div>
                    <div class="col-4 info" >{{ $dados->nome }}</div>

                    @endif

                    @if ($dados->nascimento)

                    <div class="col-2" align="right"><label>Dta de Nasc.: </label></div>
                    <div class="col-1 info" style="float: left">{{ $dados->nascimento }}</div>

                    @endif

                    @if ($dados->sexo)

                    <div class="col-3" align="right"><label>Sexo: </label><span class="col-1 info">{{ $dados->sexo=='F' ? 'Feminino' : 'Masculino' }}</span></div>

                    @endif

                </div>
                <div class="row">

                    @if ($dados->pai)

                    <div class="col-1" align="right"><label>Pai: </label></div>
                    <div class="col info">{{ $dados->pai }}</div>

                    @endif

                    @if($dados->mae)

                    <div class="col-1" align="right"><label>Mãe: </label></div>
                    <div class="col info">{{ $dados->mae }}</div>

                    @endif

                </div>
                <div class="row">

                    @if ($dados->email)

                    <div class="col-1" align="right"><label>E-mail: </label></div>
                    <div class="col-4 info" style="text-transform: lowercase" >{{ $dados->email }}</div>

                    @endif

                    @if ($dados->telefone)

                    <div class="col-1" align="right"><label>Telefone: </label></div>
                    <div class="col info">{{ $dados->telefone }}</div>

                    @endif

                    @if ($dados->celular)

                    <div class="col-1" align="right"><label>Celular: </label></div>
                    <div class="col info">{{ $dados->celular }}</div>

                    @endif

                    @if($dados->bolsista)

                    <div class="col"><label>Bolsista: </label><span class="col info">{{ $dados->bolsista==1?'SIM':'NÃO' }}</span></div>

                    @endif

                </div>
		        <div class="row">

		            @if ($dados->rg)

		            <div class="col-1" align="right"><label>RG: </label></div>
		            <div class="col info">{{$dados->rg}}</div>

		            @endif

                    @if ($dados->rg_orgao)

                    <div class="col-2" align="right"><label>Órgão Expedidor: </label></div>
                    <div class="col info">{{ $dados->rg_orgao }}</div>

                    @endif

                    @if ($dados->rg_uf)

                    <div class="col-1" align="right"><label>UF: </label></div>
                    <div class="col info">{{$dados->rg_uf}}</div>

                    @endif

                    @if ($dados->rg_data)

                    <div class="col-1" align="right"><label>Expedido: </label></div>
                    <div class="col info">{{$dados->rg_data}}</div>

                    @endif
	            </div>
            </div>
	    </div>
    </fieldset>

    @if ($dados->endereco)

    <fieldset style="border: 1px solid gray; border-radius: 8px" class="pl-3 pb-4 pr-3">
        <legend>Endereço</legend>
        <div class="row">
	        <div class="col-2"></div>
	        <div class="col info">
                @if ($dados->endereco) {{ $dados->endereco }} @endif
                @if ($dados->numero), {{ $dados->numero }} @endif
                @if ($dados->complemento) - {{ $dados->complemento }} @endif
            </div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div class="col info">
                @if ($dados->bairro) {{ $dados->bairro }} @endif
                @if ($dados->municipio) - {{ $dados->municipio }} @endif
                @if ($dados->uf)/{{ $dados->uf }} @endif
                @if ($dados->cep)- {{ $dados->cep }} @endif
            </div>
        </div>
    </fieldset>

    @endif

    @if ($tipo === 'aluno')

        @if ($dados->procedencia || $dados->instituicao)

        <fieldset style="border: 1px solid gray; border-radius: 8px" class="pb-3 pl-3 pr-3">
            <legend>Origem</legend>
            <div class="row">
                <div class="col-2" align="right"><label>Procedência: </label></div>
                <div class="col-2 info">{{ $dados->procedencia }}</div>

                <div class="col-2" align="right"><label>Instituição: </label></div>
                <div class="col info">{{ $dados->instituicao }}</div>
            </div>
        </fieldset>

        @endif

        <fieldset style="border: 1px solid gray; border-radius: 8px;" class="pl-3 pb-3 pr-3">
            <legend>Turma</legend>
            <div class="row">
                <div class="col">
                    <label>Sigla: </label>
                    <span class="info">{{ $turma->sigla ?? null }}</span>
                </div>

                @if ($dados->turno)

                <div class="col-2"><label>Turno: </label><span class="col info">{{ $dados->turno }}</span></div>

                @endif

                @if ($dados->ensino)

                <div class="col-3"><label>Ensino: </label><span class="col info">{{ $dados->ensino }}</span></div>

                @endif

                @if ($dados->ano)

                <div class="col"><label>Ano: </label><span class="col info">{{ $dados->ano }}º</span></div>

                @endif

            </div>
        </fieldset>

    @endif

    @if ($tipo === 'professor')

    <fieldset style="border: 1px solid gray; border-radius: 8px;" class="p-3">
        <legend>Turmas</legend>

        @foreach ($turmas as $turma)

        <div class="row">
            <div class="col-2" align="right">
                 <span class="info">{{ $turma->descricao . ' - ' .$turma->sigla }}</span>
            </div>
        </div>

        @endforeach

    </fieldset>

    @endif

    @if ($tipo === 'funcionario' && $dados->admissao)

    <fieldset style="border: 1px solid gray; border-radius: 8px;" class="p-3">
        <legend>Área de Trabalho</legend>
        <div class="row">

            @if ($dados->setor)

            <div class="col-2" align="right"><label>Setor: </label></div>
            <div class="col-1 info">{{ $dados->setor }}</div>

            @endif

            @if ($dados->funcao)

            <div class="col-2" align="right"><label>Função: </label></div>
            <div class="col-1 info">{{ $dados->funcao }}</div>
            @endif

            @if ($dados->admissao && !$dados->demissao)

            <div class="col-2" align="right"><label>Admissão: </label></div>
            <div class="col-1 info">{{ $dados->admissao }}</div>

            @endif

            @if ($dados->demissao)

            <div class="col-2" align="right"><label>Demissão: </label></div>
            <div class="col-1 info">{{ $dados->demissao }}</div>

            @endif

        </div>
        <div class="row">

            @if ($dados->entrada)

            <div class="col-2" align="right"><label>Entrada: </label></div>
		    <div class="col-1 info">{{ substr($dados->entrada, 0,5) }}</div>

            @endif

            @if ($dados->saida)

            <div class="col-2" align="right"><label>Saída: </label></div>
		    <div class="col info">{{ substr($dados->saida,0,5) }}</div>

            @endif
        </div>
    </fieldset>

    @endif

    <form method="GET" action="{{ route($tipo.'.destroy', ['id' => $dados->id]) }}" id="pessoa" />
        <button class="btn btn-sm btn-danger mb-5" style="float:right" value="delete">Exclui Dados</button>
    </form>

@endsection

<script>
    setTimeout(() => {
        const form = document.querySelector('form#pessoa')
        form.onsubmit = (e) => {
            e.preventDefault()
            // if (!form.querySelector('[data]')) return alert('Existe alunos matriculados nesta turma')
            const conf = confirm('Deseja realmente excluir este <?= $tipo ?>?')
            if (conf) form.submit()
        }
    }, 100)
</script>
