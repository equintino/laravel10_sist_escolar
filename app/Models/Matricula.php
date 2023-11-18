<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $guarded = [];

    public function matAluno()
    {
        return $this->hasOne(Aluno::class);
    }
}
