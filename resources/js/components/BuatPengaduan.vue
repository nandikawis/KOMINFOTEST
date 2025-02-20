<template>
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Buat Pengaduan Baru</h2>

            <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-6">
                <!-- Personal Information Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Data Diri</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input 
                                type="text" 
                                id="nik" 
                                v-model="form.nik"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': errors.nik }"
                                required
                            >
                            <p v-if="errors.nik" class="mt-1 text-sm text-red-600">{{ errors.nik[0] }}</p>
                        </div>

                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input 
                                type="text" 
                                id="nama" 
                                v-model="form.nama"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': errors.nama }"
                                required
                            >
                            <p v-if="errors.nama" class="mt-1 text-sm text-red-600">{{ errors.nama[0] }}</p>
                        </div>

                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                            <input 
                                type="tel" 
                                id="no_hp" 
                                v-model="form.no_hp"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': errors.no_hp }"
                                required
                            >
                            <p v-if="errors.no_hp" class="mt-1 text-sm text-red-600">{{ errors.no_hp[0] }}</p>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                v-model="form.email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': errors.email }"
                                required
                            >
                            <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email[0] }}</p>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea 
                                id="alamat" 
                                v-model="form.alamat"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': errors.alamat }"
                                required
                            ></textarea>
                            <p v-if="errors.alamat" class="mt-1 text-sm text-red-600">{{ errors.alamat[0] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Complaint Information Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pengaduan</h3>
                    <div class="space-y-6">
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Pengaduan</label>
                            <input 
                                type="text" 
                                id="judul" 
                                v-model="form.judul"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': errors.judul }"
                                required
                            >
                            <p v-if="errors.judul" class="mt-1 text-sm text-red-600">{{ errors.judul[0] }}</p>
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Pengaduan</label>
                            <textarea 
                                id="deskripsi" 
                                v-model="form.deskripsi"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': errors.deskripsi }"
                                required
                            ></textarea>
                            <p v-if="errors.deskripsi" class="mt-1 text-sm text-red-600">{{ errors.deskripsi[0] }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bukti Pendukung</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                 :class="{ 'border-red-500': errors.bukti_file }">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="bukti_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload file</span>
                                            <input 
                                                id="bukti_file" 
                                                type="file" 
                                                class="sr-only"
                                                @change="handleFileUpload"
                                                accept=".jpg,.jpeg,.png,.pdf"
                                                ref="fileInput"
                                            >
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, PDF up to 2MB
                                    </p>
                                    <p v-if="selectedFile" class="text-sm text-gray-600">
                                        Selected: {{ selectedFile.name }}
                                    </p>
                                </div>
                            </div>
                            <p v-if="errors.bukti_file" class="mt-1 text-sm text-red-600">{{ errors.bukti_file[0] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button 
                        type="submit"
                        :disabled="isSubmitting"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                    >
                        <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ isSubmitting ? 'Mengirim...' : 'Kirim Pengaduan' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Success Modal -->
        <div v-if="showSuccessModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                    <div>
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Pengaduan Berhasil Dikirim
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Silakan simpan token berikut untuk mengecek status pengaduan Anda:
                                </p>
                                <p class="mt-2 text-lg font-mono bg-gray-100 p-2 rounded">
                                    {{ submissionToken }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button 
                            type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm"
                            @click="handleModalClose"
                        >
                            Kembali ke Beranda
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BuatPengaduan',
    data() {
        return {
            form: {
                nik: '',
                nama: '',
                no_hp: '',
                email: '',
                alamat: '',
                judul: '',
                deskripsi: '',
                bukti_file: null
            },
            selectedFile: null,
            errors: {},
            isSubmitting: false,
            showSuccessModal: false,
            submissionToken: ''
        }
    },
    methods: {
        handleFileUpload(event) {
            const file = event.target.files[0]
            if (file) {
                if (file.size > 2 * 1024 * 1024) { // 2MB limit
                    alert('File terlalu besar. Maksimal 2MB')
                    event.target.value = ''
                    return
                }
                this.selectedFile = file
                this.form.bukti_file = file
            }
        },
        async submitForm() {
            this.isSubmitting = true
            this.errors = {}

            const formData = new FormData()
            for (const key in this.form) {
                formData.append(key, this.form[key])
            }

            try {
                const response = await axios.post('/api/pengaduan', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                
                this.submissionToken = response.data.token
                this.showSuccessModal = true
            } catch (error) {
                if (error.response?.data?.errors) {
                    this.errors = error.response.data.errors
                    const errorMessages = Object.values(error.response.data.errors).flat()
                    alert('Validasi gagal:\n' + errorMessages.join('\n'))
                } else {
                    alert('Terjadi kesalahan. Silakan coba lagi.')
                }
                console.error('Error:', error.response?.data)
            } finally {
                this.isSubmitting = false
            }
        },
        handleModalClose() {
            this.showSuccessModal = false
            this.$router.push('/')
        }
    }
}
</script> 