<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RayonController extends Controller
{
    public function index()
    {
        return view('admin.rayon.index');
    }

    public function create()
    {
        return view('admin.rayon.create');
    }

    public function edit($id)
    {
        return view('admin.rayon.edit', compact('id'));
    }
}
