<?php

namespace Tests\Browser;

// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTurmaTest extends DuskTestCase
{
    private $turmaId;

    /** @test */
    public function login_if_logged_is_successful(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('public/login')
                    ->assertUrlIs('http://localhost/laravel10_sist_escolar/public/login')
                    ->assertSee('Acesso Restrito')
                    ->type('email', 'edmquintino@gmail.com')
                    ->type('password', '12345678')
                    ->press('Entrar')
                    ->assertUrlIs('http://localhost/laravel10_sist_escolar/public/home');
        });
    }

    /** @test */
    public function register_twice__turma_if_can_is_correctly(): void
    {
        $this->browse(function (Browser $first, Browser $second) {
            if (!DB::select('select * from turmas where descricao = "test turma"')) {
                /** Register turma */
                $first->visit('public/painel/turma.create')
                        ->assertUrlIs('http://localhost/laravel10_sist_escolar/public/painel/turma.create')
                        ->assertSee('CADASTRO DAS TURMAS')
                        ->type('descricao', 'test turma')
                        ->radio('turno', 'M')
                        ->press('SALVAR')
                        ->waitForDialog(10)
                        ->assertDialogOpened('Cadastro realizado com sucesso!!!')
                        ->driver->switchTo()->alert()->accept();
            }

            /** Try register turma agin */
            $second->visit('public/painel/turma.create')
                    ->assertUrlIs('http://localhost/laravel10_sist_escolar/public/painel/turma.create')
                    ->assertSee('CADASTRO DAS TURMAS')
                    ->type('descricao', 'test turma')
                    ->radio('turno', 'M')
                    ->press('SALVAR')
                    ->waitForDialog(10)
                    ->assertDialogOpened('Provavelmente a sigla já foi cadastrada');
        });
    }

    /** @test */
    public function redirect_after_delete_turma_if_yes_is_correct(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('public/painel/turma')
                    ->with('table', function ($table) {
                        $turma = DB::select('select * from turmas where descricao="test turma"')[0];
                        if (!empty($turma)) {
                            $this->turmaId = $turma->id;
                            $table->script(
                                "(delTurma = () => {
                                    setTimeout(() => {
                                        const rows = document.querySelectorAll('table tbody tr')
                                        for (let x = 0; x < rows.length; x++) {
                                            let content = rows[x].textContent
                                            if (content.indexOf('test turma') !== -1) {
                                                let view = rows[x].querySelector('.delete').parentElement
                                                view.onclick = (e) => {
                                                    e.preventDefault()
                                                    window.location.assign(url='turma.show/" . $this->turmaId . "')
                                                }
                                                view.dispatchEvent(new Event('click'))
                                            }
                                        }
                                    }, 0)
                                })()"
                            );
                            $table->assertPathIs("/laravel10_sist_escolar/public/painel/turma.show/{$this->turmaId}");
                        }
            });
        });
    }

    /** @test */
    public function check_if_turma_has_any_registred_yes(): void
    {
        $this->browse(function (Browser $browser) {
            $alunos = DB::select('select id from alunos');
            $turmas = DB::select('select id from turmas where descricao="test turma"');
            if ($alunos && $turmas) {
                DB::insert(
                    "insert into matriculas (aluno_id, turma_id, ativo) values ({$alunos[0]->id}, {$turmas[0]->id}, 1)"
                );
                $matricula = DB::table('matriculas')->orderBy('id', 'DESC')->first();
            }
            $browser->visit("public/painel/turma.show/{$matricula->turma_id}")
                    ->assertPathIs("/laravel10_sist_escolar/public/painel/turma.show/{$matricula->turma_id}")
                    ->press('EXCLUIR')
                    ->waitForDialog(10)
                    ->assertDialogOpened('Existem alunos matriculados nesta turma');

            // DB::delete("delete from matriculas where id={$matricula->id}");
        });
    }

    /** @test */
    public function delete_if_can_abort_deletion_turma_ok(): void
    {
        $this->turmaId = DB::select('select id from turmas where descricao="test turma"')[0]->id ?? null;

        if (!empty($this->turmaId)) {
            $matriculaRemovida = DB::select("select * from matriculas where turma_id = {$this->turmaId}") ?? null;

            if (
                !empty($matriculaRemovida) && DB::delete("delete from matriculas where id ={$matriculaRemovida[0]->id}")
            ) {
                $this->browse(function (Browser $browser) {
                    $browser->visit("public/painel/turma.show/{$this->turmaId}")
                            ->assertPathIs("/laravel10_sist_escolar/public/painel/turma.show/{$this->turmaId}")
                            ->press('EXCLUIR')
                            ->waitForDialog(10)
                            ->assertDialogOpened('Deseja realmente excluir esta turma?')
                            ->dismissDialog();
                });
            }
        }
    }

    /** @test */
    public function delete_if_can_delete_turma_ok(): void
    {
        $this->turmaId = DB::select('select id from turmas where descricao="test turma"')[0]->id ?? null;

        if (!empty($this->turmaId)) {
            $matriculaRemovida = DB::select("select * from matriculas where turma_id = {$this->turmaId}");

            if (!empty($matriculaRemovida)) {
                DB::delete("delete from matriculas where id = {$matriculaRemovida[0]->id}");
            }
            $this->browse(function (Browser $browser) {
                $browser->visit("public/painel/turma.show/{$this->turmaId}")
                    ->assertPathIs("/laravel10_sist_escolar/public/painel/turma.show/{$this->turmaId}")
                    ->press('EXCLUIR')
                    ->waitForDialog(10)
                    ->assertDialogOpened('Deseja realmente excluir esta turma?')
                    ->acceptDialog();
            });
        }
    }
}
