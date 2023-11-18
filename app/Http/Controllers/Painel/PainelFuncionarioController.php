<?php

namespace App\Http\Controllers\Painel;

use App\Http\Requests\Painel\FuncionarioFormRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use App\Models\Image;

class PainelFuncionarioController extends Controller
{

    private $funcionario;
    private $tipo;
    private $totalPage = 5;
    private $image;

    public function __construct(Funcionario $funcionario, Image $image)
    {
        $this->funcionario = $funcionario;
        $this->tipo = 'funcionario';
	    $this->image = $image;
    }

    public function index()
    {
        $dados = $this->funcionario->paginate($this->totalPage);
        $tipo = $this->tipo;
        $pg = 'Listagem de Funcionários';

        return view('painel.pessoa.index', compact('dados','tipo','pg'));
    }

    public function edit(Request $request)
    {
        $origem = 'funcionario';
        $dados = $this->funcionario->find($request->id);
        $tipo = $this->tipo;
        $pg = 'Edição dos Dados do Funcionário';
        $dImagem = $this->image->find($dados->image_id);

        return view('painel.pessoa.cadastro', compact('dados','tipo','pg','dImagem', 'origem'));
    }

    public function create()
    {
        $tipo = $this->tipo;
        $origem = 'funcionario';
        $pg = 'Cadastro de Funcionários';

        return view('painel.pessoa.cadastro', compact('tipo','pg','origem'));
    }

    public function store(FuncionarioFormRequest $request)
    {
        $dados = array_filter($request->except('_token'));
        $cadastro = $this->funcionario;
        $image = $this->image;

	    /* foto */
        $_FILES['pic']['descricao'] = 'foto do funcionário';
        $_FILES['pic']['relacao'] = 'funcionario';


        $_FILES['pic']['conteudo'] = $image->binario();
        unset($dados['pic']);

        $insertImg = $image->create($_FILES['pic']);
	    $dados['image_id'] = $insertImg->id;

        try {
            $cadastro->create($dados);
            return redirect()->route('funcionario.index');
        } catch  ( \Exception $e ) {
            echo $e->getMessage();
            $html = '<h2 style="background: lightpink; padding: 70px 0 20px 20px">Erro ao GRAVAR no banco.</h2><button style="background: lightpink;font-weight: bolder;padding: 10px" onclick="history.go(-1)">VOLTAR</button>';

            return $html;
        }

    }

    public function update(Request $request)
    {
        $dados = $request->except('_token','_method');
        $update = $this->funcionario;
	    $image_id = $update->find($request->id)->image_id;

	    unset($dados['pic']);

	    if($_FILES['pic']['name']!=='') {
            $_FILES['pic']['conteudo'] = $this->image->binario();
            unset($_FILES['pic']['tmp_name'],$_FILES['pic']['error']);

            $grava = $this->image
                 ->where('id',$image_id)
                 ->update($_FILES['pic']);
        }

        try {
            $update
                ->where('id', $request->id)
                ->update($dados);

            return redirect()->route('funcionario.index');
        } catch  ( \Exception $e ) {
            $html = '<h2 style="background: lightpink; padding: 70px 0 20px 20px">Erro ao GRAVAR no banco.</h2><button style="background: lightpink;font-weight: bolder;padding: 10px" onclick="history.go(-1)">VOLTAR</button>';

            return $html;
        }

    }

    public function show(Request $request)
    {
        $dados = $this->funcionario->find($request->id);
        $tipo = $this->tipo;
        $pg = 'Exibindo Dados do Funcionário';

        return view('painel.pessoa.exibe', compact('dados', 'tipo', 'pg'));
    }

    public function destroy($id)
    {
        $funcionario = $this->funcionario->find($id);
        $delete = $funcionario
            ->delete();

        if($delete) {
	    $this->image
            ->find($funcionario->image_id)
            ->delete();
            return redirect()->route('funcionario.index');
        } else {
            return 'Erro ao excluir dados.';
        }
    }

}
