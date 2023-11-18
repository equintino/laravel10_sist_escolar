<!-- <a href='#' onclick='goBack(-1)' class="fa fa-arrow-left" style="font-size: 20px; margin-top: -20px; text-decoration: none"></a> -->

@if( isset($errors) && count($errors) > 0 )

    <div class="alert alert-danger">

        @foreach( $errors->all() as $error )
            <p>{{$error}}</p>
        @endforeach

    </div>

@endif

@if(!empty($dados))

    <form method="POST" action="{{ route('turma.update', ['id' => $dados->id]) }}" id="edit-turma" />
    @method('PUT')

@else

    <form method="POST" action="{{ route('turma.store') }}" id="cad-turma" />

@endif
@csrf

<input type="hidden" name="id" value="{{ $dados->id ?? null }}" />

<fieldset style='border: 1px solid gray;border-radius: 5px' class='pl-4 pr-4 pb-3'>
    <legend>TURMAS</legend>

    @if($type === 'create' || $type === 'edit')
    <div class='row'>
        <div class='form-group col'>
            <label>Descrição: </label>
            <input type="text" name="descricao" value="{{ $dados->descricao ?? old('descricao') }}" class="form-control-sm dados" placeholder="Descrição da Turma" size="58%" required/>
        </div>

        <div class='form-group col'>
            <label>Turno: </label><br>
            <label>Manhã</label>
            <input type="radio" name="turno" <?= !empty($dados) && $dados->turno === 'M' ? 'checked' : '' ?>  value="M" required/>
            <label class="ml-2">Tarde </label>
            <input type="radio" name="turno" <?= !empty($dados) && $dados->turno === 'T' ? 'checked' : '' ?> value="T" required/>
            <label class="ml-2">Noite </label>
            <input type="radio" name="turno" <?= !empty($dados) && $dados->turno === 'N' ? 'checked' : '' ?> value="N" required/>
        </div>

        <div class='form-group col-1'>
            <label>Sigla</label>
            <input type="text" name="sigla" value="{{ $dados->sigla ?? old('sigla') }}" class="form-control-sm dados" size="3" />
        </div>
    </div>

    @else
    <div class='row'>
        <div class='form-group col-3'>
            <label>Turma: *</label>
            <select name="turma">
                <option></option>
            </select>
        </div>
        <div class='form-group col'>
        </div>
    </div>
    @endif

</fieldset>

<div class="botao" style='float: right'>
    <button class="btn btn-sm btn-success" value="save" >SALVAR</button>
</div>

@push('script')

    <script>
        $(function() {
            $("[name=descricao], [name=turno]").on("change keyup", function() {
                let descricao = $("[name=descricao]").val().split(" ");
                let turno = $("[name=turno]:checked").val();
                let sigla = "";
                for(let i in descricao) {
                    sigla += descricao[i].substr(0,1).toUpperCase();
                }
                if(typeof(turno) !== 'undefined') {
                    sigla += turno.substr(0,1).toUpperCase();
                }
                $("[name=sigla]").val(sigla);
            });

            const formEdit = document.querySelector('#edit-turma')
            if (formEdit !== null) {
                formEdit.onsubmit = (e) => {
                    e.preventDefault()
                }
                formEdit.onclick = (e) => {
                    const btnName = e.target.value
                    if (btnName === 'save') {
                        return formEdit.submit()
                    }
                }
            }

            $("form#cad-turma").on("submit", function(e) {
                e.preventDefault();
                let data = $(this).serialize();
                $.ajax({
                    url: "{{ route('turma.store') }}",
                    type: 'POST',
                    data: data,
                    beforeSend: function() {

                    },
                    success: function(response) {
                        if (response) {
                            alert('Cadastro realizado com sucesso!!!')
                            document.querySelector('form#cad-turma').reset()
                        }
                    },
                    error: function(error) {
                        alert('Provavelmente a sigla já foi cadastrada');
                    },
                    complete: function() {

                    }
                });
            });
        });
    </script>

@endpush
