<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LateController extends Controller
{
    public function index()
    {
        switch (Auth::user()->role) {
            case 'admin':
                return view('admin.late.index');
            case 'ps':
                return view('ps.late.index');
        }
    }

    public function create()
    {
        return view('admin.late.create');
    }

    public function recapitulation()
    {
        switch (Auth::user()->role) {
            case 'admin':
                return view('admin.late.recapitulation');
            case 'ps':
                return view('ps.late.recapitulation');
        }
    }

    public function edit($id)
    {
        return view('admin.late.edit', compact('id'));
    }

    public function detail($id)
    {
        switch (Auth::user()->role) {
            case 'admin':
                return view('admin.late.detail', compact('id'));
            case 'ps':
                return view('ps.late.detail', compact('id'));
        }
    }
}
