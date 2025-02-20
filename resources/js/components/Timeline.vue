<template>
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Timeline Pengaduan Masyarakat</h2>
            
            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="text-center py-8">
                <p class="text-red-600">{{ error }}</p>
                <button @click="fetchPengaduan" class="mt-4 text-blue-600 hover:underline">
                    Coba lagi
                </button>
            </div>

            <!-- Timeline Content -->
            <div v-else class="space-y-8">
                <div v-for="pengaduan in pengaduanList" :key="pengaduan.id" 
                     class="bg-gray-50 rounded-lg p-6">
                    <div class="flex justify-between items-start">
                        <div class="flex-grow">
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ pengaduan.judul }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ formatDate(pengaduan.created_at) }}
                            </p>
                        </div>
                        <span :class="getStatusClass(pengaduan.status)" 
                              class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                            {{ formatStatus(pengaduan.status) }}
                        </span>
                    </div>
                    
                    <p class="mt-4 text-gray-700">{{ pengaduan.deskripsi }}</p>
                    
                    <!-- Tanggapan section if any -->
                    <div v-if="pengaduan.tanggapan && pengaduan.tanggapan.length > 0" 
                         class="mt-4 border-t border-gray-200 pt-4">
                        <h4 class="text-sm font-medium text-gray-900">Tanggapan Terakhir:</h4>
                        <p class="mt-2 text-sm text-gray-600">
                            {{ pengaduan.tanggapan[pengaduan.tanggapan.length - 1].isi }}
                        </p>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="pengaduanList.length === 0" class="text-center py-8">
                    <p class="text-gray-500">Belum ada pengaduan yang diverifikasi</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Timeline',
    data() {
        return {
            pengaduanList: [],
            loading: true,
            error: null
        }
    },
    mounted() {
        this.fetchPengaduan()
    },
    methods: {
        async fetchPengaduan() {
            this.loading = true
            this.error = null
            try {
                const response = await axios.get('/api/pengaduan/public')
                this.pengaduanList = response.data
            } catch (err) {
                this.error = 'Terjadi kesalahan saat memuat data'
                console.error('Error fetching pengaduan:', err)
            } finally {
                this.loading = false
            }
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            })
        },
        formatStatus(status) {
            const statusMap = {
                'pending': 'Menunggu',
                'approved': 'Disetujui',
                'rejected': 'Ditolak',
                'closed': 'Selesai'
            }
            return statusMap[status] || status
        },
        getStatusClass(status) {
            const statusClasses = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'approved': 'bg-green-100 text-green-800',
                'rejected': 'bg-red-100 text-red-800',
                'closed': 'bg-gray-100 text-gray-800'
            }
            return statusClasses[status] || 'bg-gray-100 text-gray-800'
        }
    }
}
</script> 