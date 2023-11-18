<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- font de Ícones -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>

    <link rel="stylesheet" href="{{url('assets/all/css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/painel/css/style.css')}}"/>

    <!-- Mascara -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js" integrity="sha256-u7MY6EG5ass8JhTuxBek18r5YG6pllB9zLqE4vZyTn4=" crossorigin="anonymous"></script>

    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

    <script type='text/javascript'>
        /* variáveis */
        var pg;
        $(document).ready(function(){
            var tela=$('body').width();
            pg=$('#nome-pagina').text().toLowerCase();
            pag=pg.split(' ')[0];

            switch(pag){
                case 'dashboard':
                    $('.navbar li #dashboard').addClass('active');
                    break;
                case 'cadastro':
                    if(tela < 700){
                        $('#cad_pessoa input[name=nome]').attr('size',null);
                        $('#cad_pessoa input[name=pai]').attr('size',null);
                        $('#cad_pessoa input[name=mae]').attr('size',null);
                        $('#cad_pessoa input[name=email]').attr('size',null);
                        $('#cad_pessoa input[name=endereco]').attr('size',null);
                    }
                    $('.navbar li[menu=cadastro]').addClass('active');
                    $('body').css('background','#EFEFF7');
                    break;
                case 'edição': case 'editando':
                    $('body').css('background','rgb(234, 234, 143) none repeat scroll 0% 0%');
                    break;
                case 'listagem':
                    $('.navbar li[menu=listagem]').addClass('active');
		    break;
                case 'exibição':
                    $('.navbar li a#turma').addClass('active');
            }

            $('button#btn-cad').click(function(){
                var a = pg.split(' ');
                var tipo = a[a.length-1].toLowerCase();
                tipo=(tipo==='funcionários')?'funcionarios':tipo;

                $(location).attr('href','/painel/cadastro/'+tipo);
            });
        });
    </script>

    @stack('style')

    <title>{{ isset($title)? $title : 'Painel - Sistema Escolar' }}</title>


</head>
<body>
<div id="topo">
    <nav class='navbar navbar-expand-lg fixed-top navbar-dark bg-info'>
        <a class='navbar-brand' href='{{ url("painel/") }}'>SISTEMA ESCOLAR</a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#conteudoNavbarSuportado' aria-controls='conteudoNavbarSuportado' aia-expanded='false' aia-label='Alterna navegação'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='conteudoNavbarSuportado'>
            <ul class='navbar-nav ml-5' style="height: 40px">
                <li class='nav-item mr-2'>
                    <a class='nav-link' href='{{ url("painel/") }}' id="dashboard">Dashboard</a>
                </li>
                <li class='nav-link dropdown' menu="cadastro" style="margin-top: -8px">
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Cadastro</a>
                    <div class="dropdown-menu" aria-labelledby='navbarDropdown2'>
                        <a class='dropdown-item' href='{{ route("turma.create") }}'>Turmas</a>
                        <a class='dropdown-item' href='{{ route("aluno.create") }}'>Alunos</a>
                        <a class='dropdown-item' href='{{ route("professor.create") }}'>Professores</a>
                        <a class='dropdown-item' href='{{ route("funcionario.create") }}'>Funcionários</a>
                    </div>
                </li>
                <li class='nav-link dropdown' menu="listagem" style="margin-top: -8px">
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Listagem</a>
                    <div class="dropdown-menu" aria-labelledby='navbarDropdown2'>
                        <a class='dropdown-item' href='{{ route("turma.index") }}'>Turmas</a>
                        <a class='dropdown-item' href='{{ route("aluno.index") }}'>Alunos</a>
                        <a class='dropdown-item' href='{{ route("professor.index") }}'>Professores</a>
                        <a class='dropdown-item' href='{{ route("funcionario.index") }}'>Funcionários</a>
                    </div>
                </li>
            </ul>
        </div>
        <div  id="nome-pagina">{{ isset($pg)? $pg : null }}</div>
        <div>
            <ul class='navbar-nav'>
                <li class='nav-item'>
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                        {{ __('SAIR') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div class="container" style="margin-top: 60px">

    @if (!empty($pg) && $pg!=='Dashboard')
        <h3 class="titulo-pg">{{ isset($pg) ? $pg : null }}</h3>
    @endif

    @yield('content')

</div>

<script type='text/javascript' src='{{ url("assets/painel/js/script.js") }}'></script>
@stack('script')

</body>
</html>
