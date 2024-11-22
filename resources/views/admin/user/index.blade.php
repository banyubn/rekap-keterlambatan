@extends('layouts.master')
@section('content')
<user-table
table-uri="{{ route('api.user.table') }}"
delete-uri="{{ route('api.user.destroy', '') }}"
edit-uri="{{ route('admin.user.edit', '') }}"
create-uri="{{ route('admin.user.create') }}"
>
</user-table>
@endsection