@extends('layouts.master')
@section('content')
<student-form
    form-uri={{ route('api.student.store') }}
    index-uri={{ route('admin.student.index') }}
    rombel-uri={{ route('api.rombel.all') }}
    rayon-uri={{ route('api.rayon.all') }}
    >
</student-form>
@endsection