<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="{{url('assets/all/css/style.css')}}"/>
    <link rel="stylesheet" href="{{url('assets/site/css/style.css')}}"/>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .seletor-para-algum-widget {
            box-sizing: content-box;
        }
        #nome-pagina{
            margin-right: 50px;
            color: white;
            text-transform: uppercase;
        }
    </style>

    <script type='text/javascript'>
        /* variáveis */
        var pg;
        $(document).ready(function(){
            var tela=$('body').width();
            pag=pg.split(' ')[0];
            switch(pag){
                case 'home':
                    $('.navbar li #home').addClass('active');
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
                case 'lista':
                    $('.navbar li[menu=lista]').addClass('active');
            }

            $('#nome-pagina').html(pg+'<span style="font-size: 12px;text-transform: lowercase;position:relative;top: -3px;left: 5px"> (Página Ativa)</span>');
        });
    </script>

    @stack('script')
    @stack('style')

    <title>{{isset($title)?$title:'Sistema Escolar'}}</title>
</head>
<body>
<div id="topo">
    <nav class='navbar navbar-expand-lg navbar-dark bg-info'>
        {{--<a class='navbar-brand' href='{{ route("index") }}''>SISTEMA ESCOLAR</a>--}}
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#conteudoNavbarSuportado' aria-controls='conteudoNavbarSuportado' aia-expanded='false' aia-label='Alterna navegação'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='conteudoNavbarSuportado'>
            <ul class='navbar-nav ml-5'>
            {{--<li class='nav-item'>
			    <a class='nav-link' href='{{route('index')}}' id="home" >Home </a>
			</li>--}}
            </ul>
        </div>
        <div>
            <ul class='navbar-nav' style="float: right">
                <li class='nav-item'>
                    <a class='nav-link' href='{{url('painel')}}'>Entrar</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div class="container">

    @yield('content')

</div>
</body>
</html>
