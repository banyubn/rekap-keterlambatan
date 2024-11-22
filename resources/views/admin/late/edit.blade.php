@extends('layouts.master')
@section('content')
<late-form
    form-uri={{ route('api.late.update', $id) }}
    index-uri={{ route('admin.late.index') }}
    late-uri={{ route('api.late.show', $id) }}
    student-uri={{ route('api.student.all') }}
    >
</late-form>
@endsection