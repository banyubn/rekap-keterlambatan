@extends('layouts.master')
@section('content')
<student-table
table-uri="{{ route('api.student.table') }}"
delete-uri="{{ route('api.student.destroy', '') }}"
edit-uri="{{ route('admin.student.edit', '') }}"
>
</student-table>
@endsection