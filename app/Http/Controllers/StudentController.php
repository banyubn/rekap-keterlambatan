<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        switch (Auth::user()->role) {
            case 'admin':
                return view('admin.student.index');
            case 'ps':
                return view('ps.student.index');
        }
    }

    public function create()
    {
        return view('admin.student.create');
    }

    public function edit($id)
    {
        return view('admin.student.edit', compact('id'));
    }
}
