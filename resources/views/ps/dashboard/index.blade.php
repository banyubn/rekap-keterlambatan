@extends('layouts.master')
@section('content')
    <ps-dashboard
    student-uri={{ route('api.student.all') }}
    rombel-uri={{ route('api.rombel.all') }}
    rayon-uri={{ route('api.rayon.all') }}
    late-uri={{ route('api.late.all') }}
    user-uri={{ route('api.user.all') }}
    auth-id="{{ Auth::user()->id }}"    
    ></ps-dashboard>
@endsection