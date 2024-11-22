@extends('layouts.master')
@section('content')
    <h1>Data Late</h1>
    <v-menu>
        <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                    elevation="3"
                    class="d-inline cursor-pointer"
                    >All
                    <v-icon
                        class="ml-1 text-h5"
                        icon="mdi-menu-down"
                    ></v-icon>
                </v-btn>
        </template>
        <v-list>
            <v-list-item
                href="{{ route('admin.late.recapitulation') }}"
                class="text-capitalize"
            >
            Recapitulation
            </v-list-item>
        </v-list>
    </v-menu>
    <br>
    <br>
    <late-all-table table-uri="{{ route('api.late.table') }}" delete-uri="{{ route('api.late.destroy', '') }}"
        edit-uri="{{ route('admin.late.edit', '') }}" create-uri="{{ route('admin.late.create') }}">
    </late-all-table>
@endsection
