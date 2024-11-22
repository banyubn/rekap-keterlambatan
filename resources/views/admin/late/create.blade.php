@extends('layouts.master')
@section('content')
<late-form
    form-uri={{ route('api.late.store') }}
    index-uri={{ route('admin.late.index') }}
    student-uri={{ route('api.student.all') }}
    >
</late-form>
@endsection