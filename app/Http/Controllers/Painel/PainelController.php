<?php

namespace App\Http\Controllers\Painel;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class PainelController extends Controller
{

    public function index(): View
    {
        $title = 'Painel - Dashboard';
        $pg = 'Dashboard';
        return view('painel.index', compact('title','pg'));
    }

}
