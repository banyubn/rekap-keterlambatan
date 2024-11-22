@extends('layouts.master')
@section('content')
<rayon-form
    form-uri={{ route('api.rayon.store') }}
    index-uri={{ route('admin.rayon.index') }}
    user-uri={{ route('api.user.all') }}
>
</rayon-form>
@endsection