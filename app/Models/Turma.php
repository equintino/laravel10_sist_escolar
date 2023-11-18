<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $table = 'turmas';
    protected $guarded = [];

    public function listaTurmas()
    {
        for($x=1;$x <= count($this->all());$x++)
        {
            $dados[] = $this->find($x);
        }
        return $dados;
    }
}
