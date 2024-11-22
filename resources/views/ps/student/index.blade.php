@extends('layouts.master')
@section('content')
<ps-student-table
table-uri="{{ route('api.student.table') }}"
delete-uri="{{ route('api.student.destroy', '') }}"
rayon-uri="{{ route('api.rayon.all') }}"
auth-id="{{ Auth::user()->id }}"
>
</ps-student-table>
@endsection