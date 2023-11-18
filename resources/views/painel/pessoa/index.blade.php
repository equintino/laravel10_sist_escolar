@extends ('painel.templates.template1')

@section ('content')

    {{-- <a  href='{{route("$tipo.create")}}' ><button class="btn btn-info btn-sm mb-2"><i class="fa fa-plus-circle mr-2"></i>CADASTRAR</button></a> --}}
    <table class="table table-striped">
        <thead>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Endereço de Email</th>

            @if ($tipo !== 'professor' && $tipo !== 'funcionario')

            <th>Turma</th>

            @elseif ($tipo !== 'funcionario')

            <th>Turmas</th>

            @endif

            <th width="100px">Ações</th>
        </thead>
        <tbody>

        @foreach ($dados as $i)

            <tr>
                <td>{{ $i->nome }}</td>
                <td>{{ $i->telefone . (!empty($i->celular) ? ' / ' : '') . $i->celular }}</td>
                <td>{{ $i->email }}</td>

                @if ($tipo !== 'professor' && $tipo !== 'funcionario')

                <td> {{ $i->sigla }} </td>

                @elseif ($tipo !== 'funcionario')

                <td>

                @foreach ($turmas[$i->id] as $detalhe)

                {{ $detalhe->sigla ?? null }}

                @endforeach

                </td>

                @endif

                <td>
                    <a href="{{ route( $tipo.'.edit', ['id' => $i->id] ) }}" style="text-decoration: none">
                        <i class="fa fa-pencil edit actions" ></i>
                    </a>
                    <a class="deleta" href="{{ route( $tipo.'.show', ['id' => $i->id] )}}">
                        <i class="fa fa-eye delete actions"></i>
                    </a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {!! $dados->links() !!}

@endsection
