<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $nav;

    public function __construct()
    {
        $this->nav = 'dashboard';
    }

    public function index()
    {
        return view('operator.home.index', ['nav' => $this->nav]);
    }
}
