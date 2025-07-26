<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $organizations = [
            [
                'type' => 'bpd',
                'title' => 'Badan Permusyawaratan Desa (BPD)',
                'description' => '<h2>Badan Permusyawaratan Desa (BPD)</h2>
<p>BPD adalah lembaga yang melaksanakan fungsi pemerintahan yang anggotanya merupakan wakil dari penduduk desa berdasarkan keterwakilan wilayah dan ditetapkan secara demokratis.</p>

<h3>Fungsi BPD:</h3>
<ul>
    <li>Membahas dan menyepakati Rancangan Peraturan Desa bersama Kepala Desa</li>
    <li>Melaksanakan pengawasan terhadap kinerja Kepala Desa</li>
    <li>Melakukan evaluasi laporan keterangan penyelenggaraan Pemerintahan Desa</li>
    <li>Membentuk panitia pemilihan Kepala Desa</li>
    <li>Melakukan pengawasan dan evaluasi terhadap pelaksanaan Peraturan Desa dan Anggaran Pendapatan dan Belanja Desa</li>
</ul>

<h3>Peran BPD:</h3>
<ul>
    <li>Mengayomi adat istiadat</li>
    <li>Menampung dan menyalurkan aspirasi masyarakat</li>
    <li>Melakukan pengawasan terhadap penyelenggaraan Pemerintahan Desa</li>
</ul>',
            ],
            [
                'type' => 'pkk',
                'title' => 'Pemberdayaan Kesejahteraan Keluarga (PKK)',
                'description' => '<h2>Pemberdayaan Kesejahteraan Keluarga (PKK)</h2>
<p>PKK adalah organisasi kemasyarakatan yang memberdayakan wanita untuk turut berpartisipasi dalam pembangunan Indonesia.</p>

<h3>Program PKK:</h3>
<ul>
    <li>Pendidikan dan Keterampilan</li>
    <li>Pengembangan Kehidupan Berkoperasi</li>
    <li>Pangan</li>
    <li>Sandang</li>
    <li>Kesehatan</li>
    <li>Keluarga Berencana</li>
    <li>Perencanaan Sehat</li>
</ul>

<h3>Kegiatan PKK:</h3>
<ul>
    <li>Pemberdayaan ekonomi keluarga</li>
    <li>Peningkatan kualitas kesehatan keluarga</li>
    <li>Pendidikan dan pelatihan keterampilan</li>
    <li>Pengembangan koperasi</li>
    <li>Peningkatan kesejahteraan keluarga</li>
</ul>',
            ],
            [
                'type' => 'karang-taruna',
                'title' => 'Karang Taruna',
                'description' => '<h2>Karang Taruna</h2>
<p>Karang Taruna adalah organisasi kepemudaan di Indonesia yang dibentuk oleh masyarakat sebagai wadah generasi muda untuk mengembangkan diri, tumbuh, dan berkembang atas dasar kesadaran serta tanggung jawab sosial dari, oleh, dan untuk generasi muda.</p>

<h3>Fungsi Karang Taruna:</h3>
<ul>
    <li>Mencegah timbulnya masalah kesejahteraan sosial</li>
    <li>Menyelenggarakan berbagai kegiatan sosial</li>
    <li>Mengembangkan usaha-usaha produktif</li>
    <li>Mengembangkan kegiatan olahraga dan rekreasi</li>
    <li>Mengembangkan kegiatan pendidikan dan pelatihan</li>
</ul>

<h3>Program Karang Taruna:</h3>
<ul>
    <li>Pemberdayaan ekonomi pemuda</li>
    <li>Pengembangan olahraga dan seni</li>
    <li>Pendidikan dan pelatihan</li>
    <li>Kegiatan sosial kemasyarakatan</li>
    <li>Pengembangan kepemimpinan pemuda</li>
</ul>',
            ],
        ];

        foreach ($organizations as $organization) {
            Organization::create($organization);
        }
    }
}
