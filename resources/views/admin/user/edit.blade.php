@extends('layouts.master')
@section('content')
<user-form
    form-uri={{ route('api.user.update', $id) }}
    user-uri={{ route('api.user.show', $id) }}
    index-uri={{ route('admin.user.index') }}
    >
</user-form>
@endsection