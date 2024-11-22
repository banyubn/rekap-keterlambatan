@extends('layouts.master')
@section('content')
<rayon-form
    form-uri={{ route('api.rayon.update', '') }}
    index-uri={{ route('admin.rayon.index') }}
    rayon-uri={{ route('api.rayon.show', $id) }}
    user-uri={{ route('api.user.all') }}
    >
</rayon-form>
@endsection