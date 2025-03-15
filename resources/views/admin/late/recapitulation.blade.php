@extends('layouts.master')
@section('content')
    <h1>Data Late</h1>
    <v-menu>
        <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                    class="d-inline cursor-pointer"
                    elevation="3"
                    >Recapitulation
                    <v-icon
                        class="ml-1 text-h5"
                        icon="mdi-menu-down"
                    ></v-icon>
                </v-btn>
        </template>
        <v-list>
            <v-list-item
                href="{{ route('admin.late.index') }}"
                class="text-capitalize"
            >
            All
            </v-list-item>
        </v-list>
    </v-menu>
    <br>
    <br>
    <late-recap-table 
        table-uri="{{ route('api.late.table') }}" 
        delete-uri="{{ route('api.late.destroy', '') }}"
        edit-uri="{{ route('admin.late.edit', '') }}" 
        create-uri="{{ route('admin.late.create') }}"
        detail-uri="{{  route('admin.late.detail', '') }}"
        print-uri="{{ route('admin.late.print', '') }}"
        >
    </late-recap-table>
@endsection
