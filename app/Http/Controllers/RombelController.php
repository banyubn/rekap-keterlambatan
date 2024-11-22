<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RombelController extends Controller
{
    public function index()
    {
        return view('admin.rombel.index');
    }

    public function create()
    {
        return view('admin.rombel.create');
    }

    public function edit($id)
    {
        return view('admin.rombel.edit', compact('id'));
    }}
