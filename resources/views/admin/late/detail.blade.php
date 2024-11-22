@extends('layouts.master')
@section('content')
    <h1>Detail Data Late</h1>
    <late-detail
        late-uri={{ route('api.late.detail', $id) }}
        student-uri={{ route('api.student.show', $id) }}
        recap-uri={{ route('admin.late.recapitulation') }}
        banner-src={{ asset('assets/img/banner.png') }}
        >
    </late-detail>
@endsection