<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PainelController extends Controller
{

    public function index()
    {

        $title = 'Painel - Dashboard';
        $pg = 'Dashboard';

        return view('painel.index', compact('title','pg'));

    }

}
