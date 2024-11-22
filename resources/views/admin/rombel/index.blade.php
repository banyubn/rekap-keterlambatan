@extends('layouts.master')
@section('content')
<rombel-table
table-uri="{{ route('api.rombel.table') }}"
edit-uri="{{ route('admin.rombel.edit', '') }}"
create-uri="{{ route('admin.rombel.create') }}"
delete-uri="{{ route('api.rombel.destroy', '') }}"
>
</rombel-table>
@endsection