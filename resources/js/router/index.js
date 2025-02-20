import { createRouter, createWebHistory } from 'vue-router'
import Timeline from '../components/Timeline.vue'
import BuatPengaduan from '../components/BuatPengaduan.vue'
import CekPengaduan from '../components/CekPengaduan.vue'
import AdminLogin from '../components/admin/Login.vue'
import AdminDashboard from '../components/admin/Dashboard.vue'

const routes = [
    {
        path: '/',
        name: 'timeline',
        component: Timeline
    },
    {
        path: '/buat-pengaduan',
        name: 'buat-pengaduan',
        component: BuatPengaduan
    },
    {
        path: '/cek-pengaduan',
        name: 'cek-pengaduan',
        component: CekPengaduan
    },
    {
        path: '/admin/login',
        name: 'admin-login',
        component: AdminLogin
    },
    {
        path: '/admin/dashboard',
        name: 'admin-dashboard',
        component: AdminDashboard,
        meta: { requiresAuth: true }
    }
    // Other routes will be added later
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

// Navigation guard
router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {
        try {
            const response = await axios.get('/api/user')
            if (response.data.is_admin) {
                next()
            } else {
                next('/admin/login')
            }
        } catch (error) {
            next('/admin/login')
        }
    } else {
        next()
    }
})

export default router 