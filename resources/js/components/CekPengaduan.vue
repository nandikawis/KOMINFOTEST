<template>
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Cek Status Pengaduan</h2>

            <!-- Search Form -->
            <div class="max-w-xl mx-auto mb-8">
                <form @submit.prevent="checkStatus" class="space-y-4">
                    <div>
                        <label for="token" class="block text-sm font-medium text-gray-700">Token Pengaduan</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input 
                                type="text" 
                                id="token"
                                v-model="token"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Masukkan token pengaduan Anda"
                                required
                            >
                        </div>
                    </div>
                    <div>
                        <button 
                            type="submit"
                            :disabled="isLoading"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                        >
                            <svg v-if="isLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ isLoading ? 'Mencari...' : 'Cek Status' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Result Section -->
            <div v-if="pengaduan" class="bg-gray-50 rounded-lg p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ pengaduan.judul }}</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ formatDate(pengaduan.created_at) }}
                            </p>
                        </div>
                        <span 
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            :class="getStatusClass(pengaduan.status)"
                        >
                            {{ formatStatus(pengaduan.status) }}
                        </span>
                    </div>
                    
                    <div class="prose prose-sm max-w-none text-gray-500">
                        <p>{{ pengaduan.deskripsi }}</p>
                    </div>

                    <!-- Tanggapan Section -->
                    <div v-if="pengaduan.tanggapan && pengaduan.tanggapan.length > 0" class="mt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Tanggapan:</h4>
                        <div class="space-y-4">
                            <div v-for="tanggapan in pengaduan.tanggapan" :key="tanggapan.id" 
                                 class="bg-white p-4 rounded-lg border border-gray-200">
                                <p class="text-sm text-gray-600">{{ tanggapan.isi }}</p>
                                <p class="mt-2 text-xs text-gray-500">{{ formatDate(tanggapan.created_at) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Message -->
            <div v-if="error" class="mt-4 bg-red-50 border border-red-200 rounded-md p-4">
                <p class="text-sm text-red-600">{{ error }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CekPengaduan',
    data() {
        return {
            token: '',
            pengaduan: null,
            error: null,
            isLoading: false
        }
    },
    methods: {
        async checkStatus() {
            this.isLoading = true;
            this.error = null;
            this.pengaduan = null;

            try {
                const response = await axios.get(`/api/pengaduan/check/${this.token}`);
                this.pengaduan = response.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Terjadi kesalahan saat mencari pengaduan';
            } finally {
                this.isLoading = false;
            }
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        formatStatus(status) {
            const statusMap = {
                'pending': 'Menunggu',
                'processing': 'Diproses',
                'approved': 'Disetujui',
                'rejected': 'Ditolak',
                'closed': 'Selesai'
            };
            return statusMap[status] || status;
        },
        getStatusClass(status) {
            const statusClasses = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'processing': 'bg-blue-100 text-blue-800',
                'approved': 'bg-green-100 text-green-800',
                'rejected': 'bg-red-100 text-red-800',
                'closed': 'bg-gray-100 text-gray-800'
            };
            return statusClasses[status] || 'bg-gray-100 text-gray-800';
        }
    }
}
</script> 