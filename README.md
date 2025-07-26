
# Website Desa Kumantan

Website resmi Desa Kumantan yang menyediakan informasi dan layanan digital untuk masyarakat desa.

## Fitur

- 🏠 **Profil Desa**
  - Sejarah Desa
  - Visi & Misi
  - Struktur Organisasi
  - Peta Desa

- 📰 **Informasi Desa**
  - Berita Desa
  - Pengumuman
  - Agenda Kegiatan
  - Galeri Foto

- 💼 **Potensi Desa**
  - Sumber Daya Alam
  - Infrastruktur
  - UMKM & Produk Lokal
  - Wisata Desa

- 👥 **Layanan Publik**
  - Pengaduan Masyarakat
  - Status Pengaduan
  - Formulir Administrasi
  - Kontak Darurat

- 📱 **Fitur Tambahan**
  - Pencarian Terpadu
  - Responsive Design
  - Dark/Light Mode
  - Multi-bahasa

## Teknologi

- **Frontend**
  - Vue.js 3
  - Inertia.js
  - Tailwind CSS
  - Heroicons

- **Backend**
  - PHP 8.2
  - Laravel 10
  - MySQL
  - Redis (Cache)

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js >= 16
- MySQL >= 8.0
- Redis (Opsional)

## Instalasi

1. Clone repository
```bash
git clone https://github.com/username/desa-kumantan.git
cd desa-kumantan
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=desa_kumantan
DB_USERNAME=root
DB_PASSWORD=
```

5. Jalankan migrasi dan seeder
```bash
php artisan migrate --seed
```

6. Build assets
```bash
npm run build
```

7. Jalankan server development
```bash
php artisan serve
npm run dev
```

## Struktur Folder

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── js/
│   │   ├── Components/
│   │   ├── Layouts/
│   │   └── Pages/
│   └── views/
├── routes/
│   ├── web.php
│   └── api.php
└── storage/
    └── app/
        └── public/
```

## Deployment

1. Build production assets
```bash
npm run build
```

2. Optimize Laravel
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Setup web server (Nginx/Apache)
4. Setup SSL certificate
5. Setup cron jobs
6. Setup backup system

## Kontak

- Website: [desakumantan.id](https://desakumantan.id)
- Email: admin@desakumantan.id
- Alamat: Desa Kumantan, Kecamatan Kumantan, Kabupaten Bengkalis, Riau
=======
# sildk_kumantan
>>>>>>> 501d5d0f5b2f2479e5c70a7b7556bd0580f10736
