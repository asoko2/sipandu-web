<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $nav;

    public function __construct()
    {
        $this->nav = 'dashboard';
    }

    public function index(){
        return view('verifikator.home.index', ['nav' => $this->nav]);
    }
}
