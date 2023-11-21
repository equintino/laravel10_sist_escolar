<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\Painel\AlunoFormRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Matricula;
use App\Models\Image;


use Illuminate\Support\Facades\Input;


class PainelAlunoController extends Controller {

    private $tipo;
    private $aluno;
    private $turma;
    private $matricula;
    private $image;
    private $totalPage = 5;

    public function __construct(Aluno $aluno, Turma $turma, Matricula $matricula, Image $image)
    {
        $this->aluno = $aluno;
        $this->tipo = 'aluno';
        $this->turma = $turma;
        $this->matricula = $matricula;
        $this->image = $image;
    }

    public function index()
    {
        $dados = DB::table('matriculas')
            ->rightJoin('alunos', 'alunos.id', '=', 'matriculas.aluno_id')
            ->leftJoin('turmas', 'turmas.id', '=', 'matriculas.turma_id')
            ->select('matriculas.id as matricula_id', 'alunos.id as id', 'turma_id', 'sigla', 'descricao', 'turno', 'alunos.nome', 'alunos.telefone', 'alunos.celular', 'alunos.email', 'alunos.image_id')
            ->paginate($this->totalPage);
        $tipo = $this->tipo;
        $pg = 'Listagem de Alunos';

        return view('painel.pessoa.index', compact('dados', 'tipo', 'pg'));
    }

    public function create()
    {
        $dados = null;
        $turmas = $this->turma->orderBy('turno')->get();
        $origem = 'aluno';
        $tipo = $this->tipo;
        $pg = 'Cadastro de Alunos';
        echo '<script>let url="' . url('painel/turma/descricao') . '"</script>';

        return view('painel.pessoa.cadastro', compact('dados','tipo', 'pg', 'turmas','origem'));
    }

    public function edit(Request $request)
    {
        $origem = 'aluno';
        $dados = $this->aluno->find($request->input('id'));
        $tipo = $this->tipo;
        $matricula = $this->matricula->where('aluno_id',$request->input('id'))->get()->first();
        $dImagem = $this->image->find($dados->image_id);
        echo '<script>let url="' . url('painel/turma/descricao') . '"</script>';

        /* adicionar zeros a esquerda */
        $mat = $matricula->id ?? 0;
        while(strlen($mat) < 5) {
            $mat = '0'. $mat;
        }

        $pg = 'Edição dos Dados do Aluno';
        $turmas = $this->turma->all();
        foreach($turmas as $i) {
            $turmas_[substr($i->sigla,0,strlen($i->sigla)-1)] = $i->descricao;
            $turnos[$i->descricao][substr($i->turno,0,1)] = $i->turno;
        }
        if (!empty($dados->turma)) {
            $turma = $this->turma->where('sigla',$dados->turma)->first();
            if (!empty($turma)) {
                $descricao = $turma->descricao;
                $turnos = $turnos[$descricao];
            } else {
                $turnos = [];
            }
        }

        return view('painel.pessoa.cadastro', compact('dados','tipo','pg', 'turmas', 'turnos','matricula','dImagem','origem','mat'));
    }

    public function store(AlunoFormRequest $request)
    {
        $dados = array_filter($request->except('_token'));
        $cadastro = $this->aluno;
        $matricula = $this->matricula;
        $image = $this->image;

	    /* foto */
        $_FILES['pic']['descricao'] = 'foto do aluno';
        $_FILES['pic']['relacao'] = 'aluno';


        $_FILES['pic']['conteudo'] = $image->binario();
        unset($dados['pic']);

        /** Saving photo */
        try {
            $insertImg = $image->create($_FILES['pic']);
	        $dados['image_id'] = $insertImg->id;
        } catch (\Exception $e) {
            return print $e->getMessage();
        }

        try {
            $turma_id = $dados['turma_id'];
            unset($dados['turma_id']);
            $insert = $cadastro->create($dados);
            $matricula->create( [
                'aluno_id'  =>  $insert->id,
                'turma_id'  =>  $turma_id,
                'ativo'     =>  true
            ] );

            return redirect()->route('aluno.index');
        } catch  ( \Exception $e ) {
            $html = '<h2 style="background: lightpink; padding: 70px 0 20px 20px">Erro ao GRAVAR no banco.</h2><button style="background: lightpink;font-weight: bolder;padding: 10px" onclick="history.go(-1)">VOLTAR</button>';

            return print $e->getMessage();
            // return $e->message;
        }

    }

    public function update(Request $request)
    {
        $dados = $request->except('_token','_method');
        $matricula = $this->matricula->where('aluno_id', $dados['id'])->get()->first();
        if (!empty($matricula)) {
            $matricula->turma_id = $dados['turma_id'];
            $matricula->update();
        } else {
            $this->matricula->create( [
                'aluno_id'  =>  $dados['id'],
                'turma_id'  =>  $dados['turma_id'],
                'ativo'     =>  true
            ] );
        }
        unset($dados['pic'], $dados['turma_id']);

        $update = $this->aluno;
        $image_id = $update->find($request->id)->image_id;

        if(!empty($_FILES) && $_FILES['pic']['name']!=='') {
            $_FILES['pic']['conteudo'] = $this->image->binario();
            unset($_FILES['pic']['tmp_name'],$_FILES['pic']['error'],$_FILES['pic']['full_path']);

            $image = $this->image->where('id',$image_id);
            $grava = $image->update($_FILES['pic']);
        }

        try {
            $update->where('id', $request->id)->update($dados);
            return redirect()->route('aluno.index');
        } catch  ( \Exception $e ) {
            return $e->getMessage();
            $html = '<h2 style="background: lightpink; padding: 70px 0 20px 20px">Erro ao GRAVAR no banco.</h2><button style="background: lightpink;font-weight: bolder;padding: 10px" onclick="history.go(-1)">VOLTAR</button>';

            return $html;
        }

    }

    public function show(Request $request)
    {
        $dados = $this->aluno->find($request->input('id'));
        $tipo = $this->tipo;
        $pg = 'Exibindo Dados do Aluno';
        $matricula = ($this->matricula->where('aluno_id', $request->input('id'))->get()->first());
        $turma = !empty($matricula->turma_id) ? $this->turma->where('id', $matricula->turma_id)->get()->first() : null;
        $matId = $matricula->id ?? 0;

        /* adicionar zeros a esquerda */
        while(strlen($matId) < 5)
        {
            $matId = '0'.$matId;
        }

        return view('painel.pessoa.exibe', compact('dados', 'tipo', 'pg','turma','matricula', 'matId'));

    }

    public function destroy($id)
    {
        $aluno = $this->aluno->find($id);
        $delete  = $aluno->delete();

        if($delete) {
            $this->image->find($aluno->image_id)->delete();
            return redirect()->route('aluno.index');
        } else {
            return 'Erro ao excluir dados.';
        }
    }

    public function turma($find)
    {
        dd($find);
    }
}
