<template>
    <AdminLayout title="Detail Penduduk">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Detail Data Penduduk</h3>
                <div class="flex space-x-2">
                    <Link :href="route('admin.residents.edit', resident.id)"
                        class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 flex items-center">
                        <PencilIcon class="w-5 h-5 mr-2" />
                        Edit
                    </Link>
                    <Link :href="route('admin.residents.index')"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                        Kembali
                    </Link>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Identitas Dasar -->
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Identitas Dasar</h4>
                            <div class="space-y-3">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">NIK</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ resident.nik || '-' }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Nomor Kartu Keluarga</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ resident.family_card_number || '-' }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Nama Lengkap</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ resident.full_name || '-' }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Tempat, Tanggal Lahir</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ resident.birth_place || '-' }}, {{ formatDate(resident.birth_date) }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Jenis Kelamin</h4>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        :class="resident.gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800'">
                                        {{ getGenderText(resident.gender) }}
                                    </span>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Agama</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ getReligionText(resident.religion) }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Status Perkawinan</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ getMaritalStatusText(resident.marital_status) }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Keluarga</h4>
                            <div class="space-y-3">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Nama Ibu</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ resident.mother_name || '-' }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Nama Ayah</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ resident.father_name || '-' }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Status Hubungan Keluarga</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ getFamilyRelationshipText(resident.family_relationship_status) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Alamat</h4>
                            <div class="space-y-3">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Alamat Lengkap</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ resident.address || '-' }}</p>
                                </div>

                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">RT</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ resident.rt || '-' }}</p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">RW</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ resident.rw || '-' }}</p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Dusun</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ resident.hamlet || '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Lainnya</h4>
                            <div class="space-y-3">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Pekerjaan</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ getOccupationText(resident.occupation) }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Pendidikan Terakhir</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ getEducationText(resident.last_education) }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Golongan Darah</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ resident.blood_type || '-' }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Kewarganegaraan</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ getCitizenshipText(resident.citizenship) }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Status Hidup</h4>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        :class="resident.life_status === 'alive' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                        {{ getLifeStatusText(resident.life_status) }}
                                    </span>
                                </div>

                                <div v-if="resident.disability_type">
                                    <h4 class="text-sm font-medium text-gray-700">Jenis Disabilitas</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ resident.disability_type }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PencilIcon } from '@heroicons/vue/24/outline';

defineProps({
    resident: {
        type: Object,
        required: true
    }
});

const formatDate = (date) => {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const getGenderText = (gender) => {
    const texts = {
        male: 'Laki-laki',
        female: 'Perempuan'
    };
    return texts[gender] || '-';
};

const getReligionText = (religion) => {
    const texts = {
        islam: 'Islam',
        christian: 'Kristen',
        catholic: 'Katolik',
        hindu: 'Hindu',
        buddhist: 'Buddha',
        confucian: 'Konghucu',
        other: 'Lainnya'
    };
    return texts[religion] || '-';
};

const getMaritalStatusText = (status) => {
    const texts = {
        single: 'Belum Kawin',
        married: 'Kawin',
        divorced: 'Cerai Hidup',
        widowed: 'Cerai Mati'
    };
    return texts[status] || '-';
};

const getEducationText = (education) => {
    const texts = {
        none: 'Tidak Sekolah',
        elementary: 'SD',
        junior_high: 'SMP',
        senior_high: 'SMA',
        d1: 'D1',
        d2: 'D2',
        d3: 'D3',
        s1: 'S1',
        s2: 'S2',
        s3: 'S3'
    };
    return texts[education] || '-';
};

const getCitizenshipText = (citizenship) => {
    const texts = {
        wni: 'WNI',
        wna: 'WNA'
    };
    return texts[citizenship] || '-';
};

const getLifeStatusText = (status) => {
    const texts = {
        alive: 'Hidup',
        deceased: 'Meninggal'
    };
    return texts[status] || '-';
};

const getFamilyRelationshipText = (status) => {
    const texts = {
        head: 'Kepala Keluarga',
        wife: 'Istri',
        child: 'Anak',
        other: 'Lainnya',
        parent: 'Lainnya (Orang Tua)', // Handle legacy data
        sibling: 'Lainnya (Saudara)'  // Handle legacy data
    };
    return texts[status] || '-';
};

const getOccupationText = (occupation) => {
    const texts = {
        'Pelajar/Mahasiswa': 'Pelajar/Mahasiswa',
        'Belum/Tidak Bekerja': 'Belum/Tidak Bekerja',
        'Mengurus Rumah Tangga': 'Mengurus Rumah Tangga',
        'Karyawan Swasta': 'Karyawan Swasta',
        'Nelayan/Perikanan': 'Nelayan/Perikanan',
        'Petani/Pekebun': 'Petani/Pekebun'
    };
    return texts[occupation] || occupation || '-';
};
</script>
