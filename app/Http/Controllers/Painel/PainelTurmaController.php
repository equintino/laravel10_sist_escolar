<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Requests\Painel\TurmaFormRequest;
use App\Http\Controllers\Controller;
use App\Models\Turma;
use App\Models\Aluno;
use App\Models\Professor;
use App\Models\Matricula;
use App\Models\Image;

class PainelTurmaController extends Controller
{
    private $turma;
    private $aluno;
    private $professor;
    private $matricula;
    private $image;

    /**
     * @turma Models\Turma
     * @aluno Models\Aluno
     * @professor Models\Professor
     * @matricula Models\Matricula
     * @image Models\Image
     */
    public function __construct(Turma $turma, Aluno $aluno, Professor $professor, Matricula $matricula, Image $image)
    {
        $this->turma = $turma;
        $this->aluno = $aluno;
        $this->professor = $professor;
        $this->matricula = $matricula;
        $this->image = $image;
    }

    public function index()
    {
        $alunos = $this->aluno->all();
        $turmas = $this->turma->all();
        $pg='Listagem das Turmas';

        foreach($alunos as $i) {
            $sigla    = $i->turma;
            $dTurma   = $this->turma->where('sigla',$sigla)->first();

            if(!empty($dTurma)) {
                $i->turma = $dTurma->descricao;
                $i->turno = $dTurma->turno;
                $i->sigla = $sigla;
            }
        }
        return view('painel.turma.index', compact('pg','alunos', 'turmas'));
    }

    public function find(Request $request)
    {
        return print json_encode('Retorno de processo');
    }

    public function edit(Request $request)
    {
        $origem = filter_input(INPUT_GET, 'origem', FILTER_SANITIZE_STRIPPED);
        $dados = $this->turma->find($request->id);
        $type = 'edit';

        /** listar turnos via ajax */
        echo "<script>let url='" . url('painel/turma/descricao') . "'</script>";

        $pg = "Editando a turma de {$dados->descricao}";
        foreach($this->turma->all() as $i) {
            if(!empty($i->descricao)) {
                $turmas[substr($i->sigla,0,strlen($i->sigla)-1)] = $i->descricao;
                if(!empty($i->turno)) {
                    $turnos[$i->descricao][substr($i->turno,0,1)] = $i->turno;
                }
            }
        }
        $turma = $this->turma->where('sigla',$dados->turma)->first();
        if(!empty($turma)) {
            $descricao = $turma->descricao;
            $turnos = $turnos[$descricao];
        }

        return view('painel.turma.cadastro', compact('dados','type','pg', 'turmas', 'turnos', 'origem'));
    }

    public function show(Request $request)
    {
        $pg = 'Detalhes da Turma';
        $alunos = [];
        $turma = $this->turma->where('id', $request->id)->first();
        $matriculas = $this->matricula->where('turma_id', $request->id)->get();
        foreach ($matriculas as $matricula) {
            $mat = $matricula->id;
            while (strlen($mat) < 5) {
                $mat = 0 . $mat;
            }
            $alunos[$mat] = $this->aluno->where('id', $matricula->aluno_id)->first();
        }
        return view('painel.turma.exibe', compact('turma', 'alunos',  'pg'));
    }

    public function create()
    {
        $origem = 'turma';
        $pg='Cadastro das Turmas';
        $type = 'create';

        return view('painel.turma.cadastro', compact('pg','origem','type'));
    }

    /**
     * @request Requests\Painel\TurmaFormRequest
     */
    public function store(TurmaFormRequest $request)
    {
        $dados = array_filter($request->except('_token'));
        $cadastro = $this->turma;

        try {
            $insert = $cadastro->create($dados);
            return redirect()->route('turma.index');
        } catch  ( \Exception $e ) {
            $html = '<h2 style="background: lightpink; padding: 70px 0 20px 20px">Erro ao GRAVAR no banco.</h2><button style="background: lightpink;font-weight: bolder;padding: 10px" onclick="history.go(-1)">VOLTAR</button>';

            return $e['message'];
        }

    }

    public function update(Request $request)
    {
        $dados = $request->except('_token','_method');
        $update = $this->turma;
        try {
            $update
                ->where('id', $request->id)
                ->update($dados);

            return redirect()->route('turma.index');
        } catch  ( \Exception $e ) {
            // return $e->getMessage();
            $html = '<h2 style="background: lightpink; padding: 70px 0 20px 20px">Possivelmente já foi cadastrada esta sigla ou houve um erro ao gravar no banco</h2><button style="background: lightpink;font-weight: bolder;padding: 10px" onclick="history.go(-1)">VOLTAR</button>';

            return $html;
        }
    }

    public function destroy(Request $request)
    {
        if ($this->turma->where('id', $request->id)->delete()) {
            return redirect()->route('turma.index');
        }
    }
}
