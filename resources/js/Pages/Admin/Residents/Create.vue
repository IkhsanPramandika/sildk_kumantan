<template>
    <AdminLayout title="Tambah Data Penduduk">
        <FormCard title="Tambah Data Penduduk Baru" :cancel-route="route('admin.residents.index')"
            submit-text="Simpan Data" :loading="form.processing" @submit="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <FormField id="nik" label="NIK" type="text" v-model="form.nik" placeholder="Masukkan NIK (16 digit)"
                    required :error="form.errors.nik" />

                <FormField id="family_card_number" label="Nomor Kartu Keluarga" type="text"
                    v-model="form.family_card_number" placeholder="Masukkan nomor KK (16 digit)" required
                    :error="form.errors.family_card_number" />

                <div class="md:col-span-2">
                    <FormField id="full_name" label="Nama Lengkap" type="text" v-model="form.full_name"
                        placeholder="Masukkan nama lengkap" required :error="form.errors.full_name" />
                </div>

                <FormField id="birth_place" label="Tempat Lahir" type="text" v-model="form.birth_place"
                    placeholder="Masukkan tempat lahir" required :error="form.errors.birth_place" />

                <FormField id="birth_date" label="Tanggal Lahir" type="date" v-model="form.birth_date" required
                    :error="form.errors.birth_date" />

                <FormField id="gender" label="Jenis Kelamin" type="select" v-model="form.gender"
                    placeholder="Pilih jenis kelamin" required :options="genderOptions" :error="form.errors.gender" />

                <FormField id="religion" label="Agama" type="select" v-model="form.religion" placeholder="Pilih agama"
                    required :options="religionOptions" :error="form.errors.religion" />

                <FormField id="marital_status" label="Status Perkawinan" type="select" v-model="form.marital_status"
                    placeholder="Pilih status perkawinan" required :options="maritalStatusOptions"
                    :error="form.errors.marital_status" />

                <FormField id="last_education" label="Pendidikan Terakhir" type="select" v-model="form.last_education"
                    placeholder="Pilih pendidikan terakhir" required :options="educationOptions"
                    :error="form.errors.last_education" />

                <FormField id="occupation" label="Pekerjaan" type="select" v-model="form.occupation"
                    placeholder="Pilih pekerjaan" required :options="occupationOptions" :error="form.errors.occupation" />

                <FormField id="blood_type" label="Golongan Darah" type="select" v-model="form.blood_type"
                    placeholder="Pilih golongan darah" required :options="bloodTypeOptions"
                    :error="form.errors.blood_type" />

                <div class="md:col-span-2">
                    <FormField id="address" label="Alamat" type="textarea" v-model="form.address"
                        placeholder="Masukkan alamat lengkap" required :error="form.errors.address" />
                </div>

                <FormField id="rt" label="RT" type="text" v-model="form.rt" placeholder="Masukkan RT" required
                    :error="form.errors.rt" />

                <FormField id="rw" label="RW" type="text" v-model="form.rw" placeholder="Masukkan RW" required
                    :error="form.errors.rw" />

                <FormField id="hamlet" label="Dusun" type="text" v-model="form.hamlet" placeholder="Masukkan nama dusun"
                    required :error="form.errors.hamlet" />

                <FormField id="citizenship" label="Kewarganegaraan" type="select" v-model="form.citizenship"
                    placeholder="Pilih kewarganegaraan" required :options="citizenshipOptions"
                    :error="form.errors.citizenship" />

                <FormField id="mother_name" label="Nama Ibu" type="text" v-model="form.mother_name"
                    placeholder="Masukkan nama ibu" required :error="form.errors.mother_name" />

                <FormField id="father_name" label="Nama Ayah" type="text" v-model="form.father_name"
                    placeholder="Masukkan nama ayah" required :error="form.errors.father_name" />

                <FormField id="family_relationship_status" label="Status Hubungan Keluarga" type="select"
                    v-model="form.family_relationship_status" placeholder="Pilih status hubungan keluarga" required
                    :options="familyRelationshipOptions" :error="form.errors.family_relationship_status" />

                <FormField id="life_status" label="Status Hidup" type="select" v-model="form.life_status"
                    placeholder="Pilih status hidup" required :options="lifeStatusOptions"
                    :error="form.errors.life_status" />

                <div class="md:col-span-2">
                    <FormField id="disability_type" label="Jenis Disabilitas" type="text" v-model="form.disability_type"
                        placeholder="Kosongkan jika tidak ada disabilitas" :error="form.errors.disability_type" />
                </div>
            </div>
        </FormCard>
    </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FormCard from '@/Components/Admin/FormCard.vue';
import FormField from '@/Components/FormField.vue';

const form = useForm({
    nik: '',
    family_card_number: '',
    full_name: '',
    address: '',
    rt: '',
    rw: '',
    hamlet: '',
    birth_place: '',
    birth_date: '',
    gender: '',
    religion: '',
    marital_status: '',
    occupation: '',
    last_education: '',
    blood_type: '',
    citizenship: 'wni',
    life_status: 'alive',
    mother_name: '',
    father_name: '',
    family_relationship_status: '',
    disability_type: ''
});

const genderOptions = [
    { value: 'male', label: 'Laki-laki' },
    { value: 'female', label: 'Perempuan' }
];

const religionOptions = [
    { value: 'islam', label: 'Islam' },
    { value: 'christian', label: 'Kristen' },
    { value: 'catholic', label: 'Katolik' },
    { value: 'hindu', label: 'Hindu' },
    { value: 'buddhist', label: 'Buddha' },
    { value: 'confucian', label: 'Konghucu' },
    { value: 'other', label: 'Lainnya' }
];

const maritalStatusOptions = [
    { value: 'single', label: 'Belum Kawin' },
    { value: 'married', label: 'Kawin' },
    { value: 'divorced', label: 'Cerai Hidup' },
    { value: 'widowed', label: 'Cerai Mati' }
];

const educationOptions = [
    { value: 'none', label: 'Tidak Sekolah' },
    { value: 'elementary', label: 'SD' },
    { value: 'junior_high', label: 'SMP' },
    { value: 'senior_high', label: 'SMA' },
    { value: 'd1', label: 'D1' },
    { value: 'd2', label: 'D2' },
    { value: 'd3', label: 'D3' },
    { value: 's1', label: 'S1' },
    { value: 's2', label: 'S2' },
    { value: 's3', label: 'S3' }
];

const bloodTypeOptions = [
    { value: 'A', label: 'A' },
    { value: 'B', label: 'B' },
    { value: 'AB', label: 'AB' },
    { value: 'O', label: 'O' },
    { value: 'unknown', label: 'Tidak Diketahui' }
];

const citizenshipOptions = [
    { value: 'wni', label: 'WNI' },
    { value: 'wna', label: 'WNA' }
];

const lifeStatusOptions = [
    { value: 'alive', label: 'Hidup' },
    { value: 'deceased', label: 'Meninggal' }
];

const familyRelationshipOptions = [
    { value: 'head', label: 'Kepala Keluarga' },
    { value: 'wife', label: 'Istri' },
    { value: 'child', label: 'Anak' },
    { value: 'other', label: 'Lainnya' }
];

const occupationOptions = [
    { value: 'Pelajar/Mahasiswa', label: 'Pelajar/Mahasiswa' },
    { value: 'Belum/Tidak Bekerja', label: 'Belum/Tidak Bekerja' },
    { value: 'Mengurus Rumah Tangga', label: 'Mengurus Rumah Tangga' },
    { value: 'Karyawan Swasta', label: 'Karyawan Swasta' },
    { value: 'Nelayan/Perikanan', label: 'Nelayan/Perikanan' },
    { value: 'Petani/Pekebun', label: 'Petani/Pekebun' }
];

const submit = () => {
    form.post(route('admin.residents.store'));
};
</script>
