<?php

namespace App\Http\Controllers\Painel;

use App\Http\Requests\Painel\ProfessorFormRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\Image;

class PainelProfessorController extends Controller
{
    private $professor;
    private $tipo;
    private $turma;
    private $image;
    private $totalPage = 5;

    public function __construct(Professor $professor, Turma $turma, Image $image)
    {
        $this->professor = $professor;
        $this->tipo = 'professor';
        $this->turma = $turma;
	    $this->image = $image;
    }

    public function index(Professor $professor)
    {
        $dados = $professor->paginate($this->totalPage);
        $tipo = $this->tipo;
        $turmas = [];
        $pg = 'Listagem de Professores';
        foreach ($dados->all() as $dado) {
            $idTurmas = json_decode($dado->turmas);
            foreach ($idTurmas as $id) {
                $_turmas[] = $this->turma->where('id', $id)->first();
            }
            $turmas[$dado->id] = $_turmas;
        }

        return view('painel.pessoa.index', compact('dados','tipo','pg', 'turmas'));
    }

    public function create()
    {
        $cont = 0;
        $origem = 'professor';
        $tipo = $this->tipo;
        $pg = 'Cadastro de Professores';
        $turmas = $this->turma->all();

        return view('painel.pessoa.cadastro', compact('tipo', 'pg', 'turmas','origem', 'cont'));
    }

    public function edit(Request $request)
    {
        $cont = 0;
        $origem = 'professor';
        $dados = $this->professor->find($request->id);
        $tipo = $this->tipo;
        $pg = 'Edição dos Dados do Professor';
        $turmas = $this->turma->all();
        $turmaProf = !empty($dados->turmas) ? json_decode($dados->turmas) : array();
        $dImagem = $this->image->find($dados->image_id);

        return view('painel.pessoa.cadastro', compact('dados','tipo','pg','turmas','turmaProf','dImagem', 'origem', 'cont'));
    }

    public function store(ProfessorFormRequest $request)
    {
        $dados = array_filter($request->except('_token'));
        $cadastro = $this->professor;
	    $image = $this->image;

        foreach ($dados as $key => $value) {
            if (preg_match('/^turma/', $key)) {
                $turmas[] = $value;
                unset($dados[$key]);
            }
        }
        $dados['turmas'] = json_encode($turmas);

	    /* foto */
        $_FILES['pic']['descricao'] = 'foto do professor';
        $_FILES['pic']['relacao'] = 'professor';


        $_FILES['pic']['conteudo'] = $image->binario();
        unset($dados['pic']);

        $insertImg = $image->create($_FILES['pic']);
	    $dados['image_id'] = $insertImg->id;

        try {
            $cadastro->create($dados);
            return redirect()->route('professor.index');
        } catch  ( \Exception $e ) {
            return $e->getMessage();
            $html = '<h2 style="background: lightpink; padding: 70px 0 20px 20px">Erro ao GRAVAR no banco.</h2><button style="background: lightpink;font-weight: bolder;padding: 10px" onclick="history.go(-1)">VOLTAR</button>';

            return $html;
        }

    }

    public function update(ProfessorFormRequest $request)
    {
        $except = [];
        array_push($except,"_token","_method","pic");

        $dados = array_filter($request->except($except));

        foreach ($dados as $key => $dado) {
            if (preg_match('/^turma/', $key)) {
                $idTurmas[] = $dado;
                unset($dados[$key]);
            }
        }
        $dados['turmas'] = json_encode($idTurmas);
        $update = $this->professor;
	    $image_id = $update->find($request->id)->image_id;


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

            return redirect()->route('professor.index');
        } catch  ( \Exception $e ) {
            $html = '<h2 style="background: lightpink; padding: 70px 0 20px 20px">Erro ao GRAVAR no banco.</h2><button style="background: lightpink;font-weight: bolder;padding: 10px" onclick="history.go(-1)">VOLTAR</button>';

            return $html;
        }

    }

    public function show(Request $request)
    {
        $dados = $this->professor->find($request->id);
        $turmas = $this->turma->all();

        $tipo = $this->tipo;
        $pg = 'Exibindo Dados do Professor';

        $turmaProf = isset($dados->turmas) ? json_decode($dados->turmas) : array();
        asort($turmaProf);

        return view('painel.pessoa.exibe', compact('dados', 'tipo', 'pg','turmas','turmaProf'));

    }

    public function destroy($id)
    {
        $professor = $this->professor->find($id);
        $delete = $professor
            ->delete();

        if($delete) {
	    $this->image
            ->find($professor->image_id)
            ->delete();
            return redirect()->route('professor.index');
        } else {
            return 'Erro ao excluir dados.';
        }
    }

}
