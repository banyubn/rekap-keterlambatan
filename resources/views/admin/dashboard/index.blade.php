@extends('layouts.master')
@section('content')
    <admin-dashboard
        student-uri={{ route('api.student.all') }}
        rombel-uri={{ route('api.rombel.all') }}
        rayon-uri={{ route('api.rayon.all') }}
        late-uri={{ route('api.late.all') }}
        user-uri={{ route('api.user.all') }}
    ></admin-dashboard>
@endsection