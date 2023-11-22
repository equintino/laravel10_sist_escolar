<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTurmaTest extends DuskTestCase
{
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
    public function register_if_turma_is_correct(): void
    {
        $this->browse(function (Browser $first, Browser $second) {
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
}
