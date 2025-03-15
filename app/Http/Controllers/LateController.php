<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function print($id) 
    {
        $student = Student::with('rombel', 'rayon')->find($id)->toArray();

        $pdf = Pdf::loadView('admin.late.print', ['student' => $student]);
        return $pdf->download('Keterlambatan ' . $student['nis'] . ' ' . $student['name'] . ' ' . \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') . '.pdf');
    }
}
