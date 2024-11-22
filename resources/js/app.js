import { createApp, defineAsyncComponent } from 'vue';
import vuetify from "./vuetify";

const app = createApp({});


// Admin
// Siswa
app.component('student-table', defineAsyncComponent(() => import('./components/admin/Student/StudentTable.vue')));
app.component('student-form', defineAsyncComponent(() => import('./components/admin/Student/StudentForm.vue')));

// Rombel   
app.component('rombel-table', defineAsyncComponent(() => import('./components/admin/Rombel/RombelTable.vue')));
app.component('rombel-form', defineAsyncComponent(() => import('./components/admin/Rombel/RombelForm.vue')));

// Rayon
app.component('rayon-table', defineAsyncComponent(() => import('./components/admin/Rayon/RayonTable.vue')));
app.component('rayon-form', defineAsyncComponent(() => import('./components/admin/Rayon/RayonForm.vue')));

// User
app.component('user-table', defineAsyncComponent(() => import('./components/admin/User/UserTable.vue')));
app.component('user-form', defineAsyncComponent(() => import('./components/admin/User/UserForm.vue')));

// Late
app.component('late-all-table', defineAsyncComponent(() => import('./components/admin/Late/LateAllTable.vue')));
app.component('late-form', defineAsyncComponent(() => import('./components/admin/Late/LateForm.vue')));
app.component('late-recap-table', defineAsyncComponent(() => import('./components/admin/Late/LateRecapTable.vue')))
app.component('late-detail', defineAsyncComponent(() => import('./components/admin/Late/LateDetail.vue')))


// PS
// Student
app.component('ps-student-table', defineAsyncComponent(() => import('./components/ps/Student/StudentTable.vue')));

// Late
app.component('ps-late-all-table', defineAsyncComponent(() => import('./components/ps/Late/LateAllTable.vue')));
app.component('ps-late-recap-table', defineAsyncComponent(() => import('./components/ps/Late/LateRecapTable.vue')))
app.component('ps-late-detail', defineAsyncComponent(() => import('./components/ps/Late/LateDetail.vue')))

// Master
app.component('ps-dashboard', defineAsyncComponent(() => import('./components/ps/Master/PsDashboard.vue')));
app.component('admin-dashboard', defineAsyncComponent(() => import('./components/admin/Master/AdminDashboard.vue')));

app.component('snackbar', defineAsyncComponent(() => import('./components/Snackbar.vue')));
app.component('login-form', defineAsyncComponent(() => import('./components/LoginForm.vue')));

app.use(vuetify);
app.mount("#app");
