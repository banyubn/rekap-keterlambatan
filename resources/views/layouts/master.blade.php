<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rekap Keterlambatan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap');

        body {
            font-family: 'Source Sans 3', sans-serif;
        }
    </style>
    @vite('resources/js/app.js')
</head>

<body>
    <div id="app">
        <v-app>
            <v-main>
                <v-navigation-drawer v-model="drawer" elevation="5" rail permanent app expand-on-hover color="primary">
                    <v-list>
                        <v-list-item class="mb-2"
                            prepend-avatar="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQx_DVDju34ygSyxCFLiCiat_DQoyUusJHXdw&s"
                            subtitle="{{ Auth::user()->email }}" title="{{ Auth::user()->name }}"></v-list-item>

                        <v-divider></v-divider>
                        <v-list-item {{ Route::is('admin.dashboard') || Route::is('ps.dashboard') ? 'active' : '' }}
                            link prepend-icon="mdi-view-dashboard" title="Dashboard"
                            href="@if (Auth::user()->role == 'admin') {{ route('admin.dashboard') }} @else {{ route('ps.dashboard') }} @endif">

                        </v-list-item>
                        @if (Auth::user()->role == 'admin')
                            <v-list-group value="open">
                                <template v-slot:activator="{ props }">
                                    <v-list-item v-bind="props" prepend-icon="mdi-server"
                                        title="Data Master"></v-list-item>
                                </template>

                                <!-- Student List Item -->
                                <v-list-item {{ Route::is('admin.student.*') ? 'active' : '' }} link
                                    prepend-icon="mdi-account-group" title="Data Student"
                                    href="{{ route('admin.student.index') }}">
                                </v-list-item>

                                <!-- Rombel List Item -->
                                <v-list-item {{ Route::is('admin.rombel.*') ? 'active' : '' }} link
                                    prepend-icon="mdi-account-group" title="Data Rombel"
                                    href="{{ route('admin.rombel.index') }}">
                                </v-list-item>

                                <!-- Rayon List Item -->
                                <v-list-item {{ Route::is('admin.rayon.*') ? 'active' : '' }} link
                                    prepend-icon="mdi-account-group" title="Data Rayon"
                                    href="{{ route('admin.rayon.index') }}">
                                </v-list-item>

                                <!-- User List Item -->
                                <v-list-item {{ Route::is('admin.user.*') ? 'active' : '' }} link
                                    prepend-icon="mdi-account-group" title="Data User"
                                    href="{{ route('admin.user.index') }}">
                                </v-list-item>
                            </v-list-group>
                        @endif

                        @if (Auth::user()->role == 'ps')
                            <!-- Student List Item -->
                            <v-list-item {{ Route::is('ps.student.*') ? 'active' : '' }} link
                                prepend-icon="mdi-account-group" title="Data Siswa"
                                href="{{ route('ps.student.index') }}">
                            </v-list-item>
                        @endif

                        <!-- Late List Item -->
                        <v-list-item {{ Route::is('admin.late.*') || Route::is('ps.late.*') ? 'active' : '' }} link
                            prepend-icon="mdi-table" title="Data Keterlambatan"
                            href="@if (Auth::user()->role == 'admin') {{ route('admin.late.index') }} @else {{ route('ps.late.index') }} @endif">
                        </v-list-item>

                        <v-divider></v-divider>

                        <!-- Logout List Item -->
                        <v-list-item link prepend-icon="mdi-logout" title="Logout" href="{{ route('logout') }}">
                        </v-list-item>
                    </v-list>
                </v-navigation-drawer>

                <v-container style="padding: 3em">
                    @yield('content')
                </v-container>
            </v-main>
        </v-app>
    </div>
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    @stack('script')
</body>

</html>
