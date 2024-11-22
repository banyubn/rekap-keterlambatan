@extends('layouts.master')
@section('content')
    <ps-late-all-table auth-id="{{ Auth::user()->id }}" table-uri="{{ route('api.late.table') }}"
        rayon-uri="{{ route('api.rayon.all') }}" table-recap-uri="{{ route('ps.late.recapitulation') }}">
    </ps-late-all-table>
@endsection
