@extends('layouts.master')
@section('content')
<rombel-form
    form-uri={{ route('api.rombel.store') }}
    index-uri={{ route('admin.rombel.index') }}
>
</rombel-form>
@endsection