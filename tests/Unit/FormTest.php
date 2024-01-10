<?php

namespace Tests\Unit;

use App\Http\Controllers\Painel\PainelTurmaController;
use App\Http\Requests\Painel\TurmaFormRequest;
use App\Models\Aluno;
use App\Models\Image;
use App\Models\Matricula;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\User;
use Database\Factories\UserFactory;
// use Illuminate\Foundation\Testing\TestCase;

use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    /** @test */
    public function only_user_logged_can_seen()
    {
        $factory = new UserFactory();
        // $factory->definition(User::class, function (Faker $faker) {
        //     return [
        //         'name' => $faker->name,
        //         'email'=> $faker->unique()->safeEmail,
        //         'password' => bcrypt('12345678')
        //     ];
        // });
        $factory->definition();

        dd(
            get_class_methods($factory),
            $this
        );
        $response = $this->get('/painel')
            ->assertRedirect('/login');
    }

    public function input_if_fill_require_is_validate()
    {
        // $user = new UserFactory();
        $user = new User();
        // $aluno = new Aluno();

        dd(
            // get_class_methods($aluno),
            // $aluno->matAluno()
            // $user->definition()
            $user->make([
                'email' => 'edmquintino@gmail.com',
                'password' => '12345678'
            ])
        );

        $turma = new Turma();
        $aluno = new Aluno();
        $professor = new Professor();
        $matricula = new Matricula();
        $image = new Image();

        $turma = new PainelTurmaController($turma, $aluno, $professor, $matricula, $image);

        $request = new TurmaFormRequest();
        dd(
            $user,
            $request,
            $turma->store($request)
        );
        $this->assertTrue(true);
    }
}
