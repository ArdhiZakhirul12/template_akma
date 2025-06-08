<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class incomeController extends Controller
{
    public function incomeIndex()
    {
        return view('pages.income.index');
    }
}
