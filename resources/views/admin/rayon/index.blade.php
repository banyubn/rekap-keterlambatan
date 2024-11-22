@extends('layouts.master')
@section('content')
<rayon-table
table-uri="{{ route('api.rayon.table') }}"
delete-uri="{{ route('api.rayon.destroy', '') }}"
edit-uri="{{ route('admin.rayon.edit', '') }}"
>
</rayon-table>
@endsection