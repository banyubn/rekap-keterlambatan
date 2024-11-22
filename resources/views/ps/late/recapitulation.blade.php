@extends('layouts.master')
@section('content')
    <ps-late-recap-table 
        table-all-uri="{{ route('ps.late.index') }}"
        table-uri="{{ route('api.late.table') }}" 
        auth-id="{{ Auth::user()->id }}"
        rayon-uri="{{ route('api.rayon.all') }}"
        detail-uri="{{  route('ps.late.detail', '') }}"
        >
    </ps-late-recap-table>
@endsection
