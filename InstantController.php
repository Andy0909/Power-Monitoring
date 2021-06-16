<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class SmartmeterController extends Controller
{
    public function index()
    {
        $v = DB :: table('data')->orderBy('ID', 'desc')->pluck('v')->take(25);
        $i = DB :: table('data')->orderBy('ID', 'desc')->pluck('i')->take(25);
        return view('instant');
    }  
}
