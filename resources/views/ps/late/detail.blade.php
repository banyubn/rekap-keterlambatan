@extends('layouts.master')
@section('content')
    <h1>Detail Data Keterlambatan</h1>
    <ps-late-detail
        late-uri={{ route('api.late.detail', $id) }}
        student-uri={{ route('api.student.show', $id) }}
        recap-uri={{ route('ps.late.recapitulation') }}
        banner-src={{ asset('assets/img/banner.png') }}
        >
    </ps-late-detail>
@endsection