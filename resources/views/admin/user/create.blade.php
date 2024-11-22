@extends('layouts.master')
@section('content')
<user-form
    form-uri={{ route('api.user.store') }}
    index-uri={{ route('admin.user.index') }}
    >
</user-form>
@endsection