<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $guarded = [
        
    ];

    public function matAluno()
    {
        return $this->hasOne(Matricula::class);
    }
}
