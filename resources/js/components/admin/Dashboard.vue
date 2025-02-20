<template>
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Dashboard Admin</h2>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-yellow-100 rounded-md p-3">
                                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ stats.pending }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-blue-100 rounded-md p-3">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Diproses</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ stats.processing }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-green-100 rounded-md p-3">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ stats.approved }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-red-100 rounded-md p-3">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Ditolak</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ stats.rejected }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengaduan List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    <li v-for="pengaduan in pengaduanList" :key="pengaduan.id">
                        <div class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <p class="text-sm font-medium text-blue-600 truncate">{{ pengaduan.judul }}</p>
                                        <span 
                                            class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                            :class="getStatusClass(pengaduan.status)"
                                        >
                                            {{ formatStatus(pengaduan.status) }}
                                        </span>
                                    </div>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <button 
                                            @click="viewDetail(pengaduan)"
                                            class="px-3 py-1 text-sm text-blue-600 hover:text-blue-900"
                                        >
                                            Detail
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500">
                                            {{ pengaduan.nama }}
                                        </p>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                        <p>
                                            {{ formatDate(pengaduan.created_at) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Detail Modal -->
        <div v-if="selectedPengaduan" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Detail Pengaduan
                            </h3>
                            <div class="mt-4 text-left">
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1">
                                            <span 
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                :class="getStatusClass(selectedPengaduan.status)"
                                            >
                                                {{ formatStatus(selectedPengaduan.status) }}
                                            </span>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Judul</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ selectedPengaduan.judul }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ selectedPengaduan.deskripsi }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Bukti</dt>
                                        <dd class="mt-1">
                                            <a 
                                                :href="`/storage/bukti/${selectedPengaduan.bukti_file}`" 
                                                target="_blank"
                                                class="text-blue-600 hover:text-blue-900"
                                            >
                                                Lihat Bukti
                                            </a>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Data Pelapor</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            <p>Nama: {{ selectedPengaduan.nama }}</p>
                                            <p>NIK: {{ selectedPengaduan.nik }}</p>
                                            <p>Email: {{ selectedPengaduan.email }}</p>
                                            <p>No. HP: {{ selectedPengaduan.no_hp }}</p>
                                            <p>Alamat: {{ selectedPengaduan.alamat }}</p>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-5 sm:mt-6 space-y-2">
                        <div v-if="selectedPengaduan.status === 'pending'" class="flex gap-2">
                            <button 
                                @click="showResponseForm('approved')"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm"
                            >
                                Terima
                            </button>
                            <button 
                                @click="showResponseForm('rejected')"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm"
                            >
                                Tolak
                            </button>
                        </div>
                        <button 
                            @click="closeModal"
                            class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm"
                        >
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Response Form Modal -->
        <div v-if="showingResponseForm" class="fixed z-20 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ responseType === 'approved' ? 'Terima Pengaduan' : 'Tolak Pengaduan' }}
                        </h3>
                        <div class="mt-4">
                            <label for="response" class="block text-sm font-medium text-gray-700">
                                {{ responseType === 'approved' ? 'Tanggapan' : 'Alasan Penolakan' }}
                            </label>
                            <textarea
                                id="response"
                                v-model="responseText"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :placeholder="responseType === 'approved' ? 'Masukkan tanggapan Anda...' : 'Masukkan alasan penolakan...'"
                            ></textarea>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6 flex gap-2">
                        <button 
                            @click="submitResponse"
                            :disabled="isSubmitting"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm disabled:opacity-50"
                        >
                            {{ isSubmitting ? 'Menyimpan...' : 'Simpan' }}
                        </button>
                        <button 
                            @click="closeResponseForm"
                            class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm"
                        >
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AdminDashboard',
    data() {
        return {
            stats: {
                pending: 0,
                processing: 0,
                approved: 0,
                rejected: 0
            },
            pengaduanList: [],
            selectedPengaduan: null,
            showingResponseForm: false,
            responseType: null,
            responseText: '',
            isSubmitting: false
        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        async fetchData() {
            try {
                const response = await axios.get('/api/admin/pengaduan')
                this.pengaduanList = response.data.pengaduan
                this.stats = response.data.stats
            } catch (error) {
                console.error('Error fetching data:', error)
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
                'processing': 'Diproses',
                'approved': 'Disetujui',
                'rejected': 'Ditolak'
            }
            return statusMap[status] || status
        },
        getStatusClass(status) {
            const statusClasses = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'processing': 'bg-blue-100 text-blue-800',
                'approved': 'bg-green-100 text-green-800',
                'rejected': 'bg-red-100 text-red-800'
            }
            return statusClasses[status] || 'bg-gray-100 text-gray-800'
        },
        viewDetail(pengaduan) {
            this.selectedPengaduan = pengaduan
        },
        closeModal() {
            this.selectedPengaduan = null
        },
        showResponseForm(type) {
            this.responseType = type
            this.showingResponseForm = true
            this.responseText = ''
        },
        closeResponseForm() {
            this.showingResponseForm = false
            this.responseType = null
            this.responseText = ''
        },
        async submitResponse() {
            if (!this.responseText.trim()) {
                alert('Mohon isi tanggapan terlebih dahulu')
                return
            }

            this.isSubmitting = true

            try {
                await axios.post(`/api/admin/pengaduan/${this.selectedPengaduan.id}/respond`, {
                    status: this.responseType,
                    tanggapan: this.responseText
                })

                this.closeResponseForm()
                this.closeModal()
                this.fetchData()

            } catch (error) {
                console.error('Error submitting response:', error)
                alert('Terjadi kesalahan saat menyimpan tanggapan')
            } finally {
                this.isSubmitting = false
            }
        }
    }
}
</script> 