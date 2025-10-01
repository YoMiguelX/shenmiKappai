<?php
namespace App\Controllers;

class Paginas extends BaseController
{
    public function index()
    {
        return view('paginas/home');
    }
}
