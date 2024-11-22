@extends('layouts.master')
@section('content')
<student-form
    form-uri={{ route('api.student.update', '') }}
    index-uri={{ route('admin.student.index') }}
    student-uri={{ route('api.student.show', $id) }}
    rombel-uri={{ route('api.rombel.all') }}
    rayon-uri={{ route('api.rayon.all') }}
    >
</student-form>
@endsection