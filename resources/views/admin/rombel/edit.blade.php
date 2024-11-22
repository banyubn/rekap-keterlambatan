@extends('layouts.master')
@section('content')
<rombel-form
    form-uri={{ route('api.rombel.update', '') }}
    index-uri={{ route('admin.rombel.index') }}
    rombel-uri={{ route('api.rombel.show', $id) }}
    >
</rombel-form>
@endsection