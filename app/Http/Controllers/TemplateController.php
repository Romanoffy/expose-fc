<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    
    public function index()
    {
        return view ('client.index');
    }
    public function main()
    {
        return view ('layouts.navigation');
    }
}