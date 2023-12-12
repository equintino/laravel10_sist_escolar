<style>
    div.botao {
        float: right;
        margin-bottom: 60px;
    }

    form [type="date"] {
        color: #6d6969;
    }

    form input {
        text-transform: uppercase;
    }

    .email {
        text-transform: lowercase;
    }

    .upload_botao_envia {
        width:80px;
        height:30px;
        color:#fff;
        font: 11px Verdana;
        background:#2A4889;
        border-radius:7px;
    }

    label {
        font-size: .8em;
        color: #6d6969;
        /* text-transform: uppercase; */
        font-weight: 700;
        margin-bottom: -1px;
    }

    .dados {
        font-size: 12px;
        margin-bottom: -10px;
    }

    fieldset {
	    margin-bottom: 10px;
    }

    fieldset legend {
        text-transform: uppercase;
        font-size: 14px;
        padding: 0 10px;
    }

    .thumb-image {
	    margin-right: 12px;
    }
</style>

<!-- <a href='#' onclick='goBack(-1)' class="fa fa-arrow-left" style="font-size: 20px; margin-top: -20px; text-decoration: none"></a> -->

@if( isset($errors) && count($errors) > 0 )
<div class="alert alert-danger">
    @foreach( $errors->all() as $error )
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if (isset($dados))

    <form method="POST" action="{{ route($tipo.'.update' , ['id' => $dados->id]) }}" id="cad-pessoa" enctype="multipart/form-data" />
    @method ('PUT')

@else

    <form id="cad-pessoa" action="{{ url('painel/'.$tipo.'.store') }}" method="POST" enctype="multipart/form-data" />

@endif
@csrf

    <input type="hidden" value="{{ !empty($dados) ? $dados->id : null }}" />
    <div class='formulario'>

    @if (!empty($origem) && $origem !== 'turma')
    <fieldset style='border: 1px solid gray;border-radius: 5px' class='pl-4 pr-4 pb-3'>
	    <legend>Dados Pessoais
            <span style="font-size: 12px;color:red;margin-left: 10px">* campos obrigatórios.</span>

	        @if ($tipo=='aluno')

            <span style='float: right'>Matrícula Nº {{ $mat !== '00000' ? $mat : 'Sem Matrícula' }}</span>

	        @endif

	    </legend>

        <div class="form-row">
            <div class='col'>
                <div class="row">
                    <div class='form-group col'>
                        <input type="text" name="nome" value="{{ !empty($dados) ? $dados->nome : old('nome') }}" class="form-control-sm dados" id="nome" placeholder="Nome completo" size="58%" />
                    </div>
                    <div class='form-group col-3'>
                        <label>Data de Nascimento: *</label>
                        <input type="date" name="nascimento" class="form-control-sm dados" value="{{ $dados->nascimento ?? null }}"/>
                    </div>
                    <div class='form-group col-4'>
                        <label class="mr-3">Sexo: *</label>
                        <label>( Masculino </label>
                        <input type="radio" name="sexo" value="M" <?= !empty($dados) && $dados->sexo === 'M' ? 'checked' : null  ?> />
                        <label class="ml-2">Feminino </label>
                        <input type="radio" name="sexo" value="F" <?= !empty($dados) && $dados->sexo === 'F' ? 'checked' : null  ?> /> )
                    </div>
                </div>

                @if ($tipo === 'aluno')

                <div class='row'>
                    <div class='col'>
                        <div class="form-group">
                            <input type="text" name="pai" value="{{ $dados->pai ?? null }}" placeholder="nome do pai" class="form-control-sm dados" size="58%" />
                        </div>
                    </div>
                    <div class='col'>
                        <div class='form-group'>
                            <input type="text" name="mae" value="{{ $dados->mae ?? null }}" placeholder="nome do mãe" class="form-control-sm dados" size="58%" />
                        </div>
                    </div>
                </div>

                @endif

                <div class='row mt-2'>
                    <div class='col'>
                        <div class='form-group'>
                            <input type="email" name="email" value="{{ $dados->email ?? old('email') }}" class="form-control-sm dados" placeholder="endereço eletrônico" size="58%" />
                        </div>
                    </div>
                    <div class='col-3'>
                        <div class='form-group'>
                            <input type="text" name="telefone" value="{{ !empty($dados) ? $dados->telefone : old('telefone') }}" class="form-control-sm tel dados" placeholder="Tel (XX)XXXX-XXXX" maxlength="13" />
                        </div>
                    </div>
                    <div class='col-3'>
                        <div class='form-group'>
                            <input type="text" name="celular" value="{{ !empty($dados) ? $dados->celular : old('celular') }}" placeholder="cel (XX)9XXXX-XXXX" maxlength="14" />
                        </div>
                    </div>
		        </div>
                <div class='row'>

                    @if ($tipo !== 'aluno')

                    <div class='form-group col'>
                        <input type="text" name="cpf" value="{{ !empty($dados) ? $dados->cpf : old('cpf') }}" class="form-control-sm dados" placeholder="CPF: XXX.XXX.XXX-XX" maxlength="14" size="14px" />
                    </div>
                    <div class='form-group col'>
                        <input type="text" name="rg" value="{{ !empty($dados) ? $dados->rg : old('rg') }}" class="form-control-sm dados" placeholder="número de RG" />
                    </div>
                    <div class='form-group col'>
                        <input type="text" name="rg" value="{{ !empty($dados) ? $dados->rg : old('rg') }}" class="form-control-sm dados" placeholder="órgão expedidor" />
                    </div>
                    <div class='form-group col'>
                        <input type="text" name="rg_uf" value="{{ !empty($dados) ? $dados->rg_uf : old('rg_uf') }}" placeholder="UF: XX" maxlength="2" />
                    </div>
                    <div class='form-group col'>
                        <label>Data de Expedição: </label>
                        <input type="date" name="rg_data" value="{{ !empty($dados) ? $dados->rg_data : old('rg_data') }}" class="form-control-sm dados" />
                    </div>

		            @endif

                </div>
	        </div>

	        <div class="col-2" style="border-left: 1px solid gray; text-align: center;">
		        <div class='localFoto ml-4' id='fileUpload'>
                    <span id="image-holder" style='position: absolute; right: 4px'>

                        @if (isset($dados))

                        <img class="thumb-image" src='{{ url("painel/imagem/".$dados->image_id) }}' alt=" " height="140px" />

                        @endif
                    </span>
		            <div class="input-group pr-2 pl-2" >
                        <div class="custom-file" id='inserirFoto' style="border: 1px solid gray; height: 140px; margin-left: -5px; ">
                            <input type="file" class="custom-file-input" id="inputGroupFile01" name='pic' aria-describedby="inputGroupFileAddon01" >
                            <label class="btn btn-sm btn-dark mr-3" for="inputGroupFile01" style='width: 900px;margin-top: 180px; height: 20px; padding-bottom: 20px; text-transform: capitalize'>Foto</label>
                        </div>
		            </div>
		        </div>
	        </div>
	    </div><!-- form-row -->
    </fieldset>

    @endif

    @if (!empty($origem) && $origem !== 'turma')

    <fieldset style='border: 1px solid gray;border-radius: 5px' class='pl-4 pr-4 pb-4 '>
	    <legend>Endereço</legend>
        <div class="form-group">
            <input type="text" name="cep" value="{{ !empty($dados) ? $dados->cep : old('cep') }}" class="form-control-sm dados" id="cep" placeholder="CEP: XXXXX-XXX" maxlength="9" />
        </div>
	    <div class='row'>
            <div class='form-group col'>
                <input type="text" name="endereco" value="{{ !empty($dados) ? $dados->endereco : old('endereco') }}" class="form-control-sm dados" placeholder="digite o endereço" size="70%" id="rua" />
            </div>
            <div class='form-group col-2'>
                <input type="number" name="numero" value="{{ !empty($dados) ? $dados->numero : old('numero') }}" class="form-control-sm dados" placeholder="número" id="numero" />
            </div>
            <div class='form-group col-4'>
                <input type="text" name="complemento" value="{{ !empty($dados) ? $dados->complemento : old('complemento') }}" class="form-control-sm dados" placeholder="complemento" />
            </div>
	    </div>
	    <div class='row mt-2'>
            <div class='form-group col-2'>
                <input type="text" name="bairro" value="{{ !empty($dados) ? $dados->bairro : old('bairro') }}" class="form-control-sm dados" placeholder="bairro" id="bairro" />
            </div>
            <div class='form-group col-2'>
                <input type="text" name="uf" value="{{ !empty($dados) ? $dados->uf : old('uf') }}" class="form-control-sm dados" placeholder="uf: XX" maxlength="2"
                id="uf" />
            </div>
            <div class='form-group col'>
                <input type="text" name="municipio" value="{{ !empty($dados) ? $dados->municipio : old('municipio') }}" placeholder="município" id="cidade" />
            </div>
	    </div>
    </fieldset>

    @endif

    @if ( $tipo == 'aluno' )

    <fieldset id="dado-escolar" style='border: 1px solid gray;border-radius: 5px;margin: 0 auto' class='pl-4 pr-4 pb-4'>
        <legend>Dados Escolares</legend>

        @if (!empty($origem) && $origem !== 'turma')

        <div class="row">
            <div class="form-group col-3">
                <label>Procedência Escolar: </label><br>
                <select name="procedencia" class="form-control-sm" placeholder="procedência escolar">
                    <option></option>
                    <option value="particular" <?= !empty($dados) && $dados->procedencia === 'particular' ? 'selected' : null ?>>Particular</option>
                    <option value="publica" <?= !empty($dados) && $dados->procedencia === 'publica' ? 'selected' : null ?>>Pública</option>
                </select>
            </div>
            <div class='form-group col' style="margin-top: 22px">
                <!-- <label>Instituição: </label> -->
                <input type="text" name="instituicao" value="{{ !empty($dados) ? $dados->instituicao : old('instituicao') }}" class="form-control-sm dados" placeholder="nome da instituição" size="70%" />
            </div>
        </div>

        @endif

        <div class='row'>
            <div class='form-group col'>
                <label>Turma Sigla: *</label>
                <select name="turma_id">
                    <option></option>

                    @foreach ($turmas as $turma)

                    <option value="{{ $turma->id }}" <?= !empty($matricula) && $turma->id === $matricula->turma_id ? 'selected' : null ?> > {{ $turma->sigla }} </option>

                    @endforeach
                </select>
            </div>
        </div>
    </fieldset>

    @elseif ($tipo === 'funcionario')

    <fieldset id="departamento" style='border: 1px solid gray;border-radius: 5px;margin: 0 auto' class='pl-4 pr-4 pb-4'>
        <legend>Departamento</legend>
	    <div class='row'>
            <div class="form-group col-2">
                <label> .</label>
                <input type='text' name='setor' value='{{ !empty($dados) ? $dados->setor : old("setor") }}' class='form-control-sm dados' placeholder='setor de trabalho' />
            </div>
            <div class='form-group col-2'>
                <label> .</label>
                <input type="text" name="funcao" value="{{ !empty($dados) ? $dados->funcao : old('funcao') }}" class="form-control-sm dados" placeholder="função que ocupa" />
            </div>
            <div class='form-group col-2'>
                <label>Admissão: *</label>
                <input type="date" name="admissao" value="{{ !empty($dados) ? $dados->admissao : old('admissao') }}" class="form-control-sm dados" />
            </div>
	        <div class='form-group col-2'>
                <label>Demissão: </label>
                <input type="date" name="demissao" value="{{ !empty($dados) ? $dados->demissao : old('demissao') }}" class="form-control-sm dados" />
	        </div>
	    </div>
	    <div class='row'>
	        <div class='form-group col-2'>
                <label>Expediente: *</label>
	        </div>
            <div class='form-group col-1'>
                <label>Entrada </label>
                <input type="time" name="entrada" value="{{ !empty($dados) ? $dados->entrada : old('entrada') }}" class="form-control-sm dados" />
            </div>
            <div class='form-group col'>
                <label>Saída </label><br>
                <input type="time" name="saida" value="{{ !empty($dados) ? $dados->saida : old('saida') }}" class="form-control-sm dados" />
            </div>
	    </div>
    </fieldset>

    @elseif ($tipo == 'professor')

        <fieldset id="disciplina" style='border: 1px solid gray;border-radius: 5px;margin: 0 auto' class='pl-4 pr-4 pb-4'>
        <legend>Turmas</legend>

        @foreach ($turmas as $key => $turma)

        <span class="form-group" >
            <input type="checkbox" name="<?= 'turma.' . $key ?>" value="{{ $turma->id }}" <?= !empty($dados) && in_array($turma->id, $turmaProf) ? 'checked' : false ?> class="ml-2" />
            <label>{{ $turma->sigla }}</label>
        </span>

        @if($cont++ > 2)

            @php $cont=0 @endphp<br>

        @endif

        @endforeach

        </fieldset>

    @endif

    <div class="botao">
        <button class="btn btn-sm btn-success">SALVAR</button>
    </div>

</div><!-- formulario -->

@push('script')

    <script type='text/javascript' src='{{url("assets/painel/js/pessoa.js")}}'></script>
    <script>
        $(document).ready(function() {
            $("[name=telefone]").mask("(#0)0000-0000");
            $("[name=celular").mask("(#0)90000-0000");
            $("[name=cpf]").mask("#00.000.000-00");
            $("[name=cep]").mask("#0000-000");
        });
    </script>

@endpush
