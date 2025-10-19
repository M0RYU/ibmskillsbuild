# Hero Selector MLBB - Sistem Rekomendasi Hero Mobile Legends dengan Metode MOORA

<p align="center">
<img src="Banner.webp" width="400" alt="Logo Aplikasi">
</p>

## Tentang Aplikasi

**Hero Selector MLBB** adalah aplikasi web modern berbasis metode MOORA (Multi-Objective Optimization by Ratio Analysis) yang dibangun menggunakan framework Laravel untuk membantu pemain **Mobile Legends: Bang Bang** dalam memilih hero terbaik berdasarkan kriteria tertentu. 

### Kasus Penggunaan

Aplikasi ini dirancang khusus untuk memudahkan pemilihan hero Mobile Legends dalam berbagai skenario, seperti:

- 🛡️ **Tank dengan Mobilitas Terbaik** - Menemukan tank yang gesit dan mudah melakukan engage/disengage
- 🏹 **Marksman dengan Poke Damage Tinggi** - Memilih MM yang efektif untuk harass musuh dari jarak jauh
- ⚔️ **Fighter dengan Sustain Terbaik** - Fighter yang tahan banting dan sulit untuk di-kill
- 🔮 **Mage dengan Burst Damage Tertinggi** - Mage yang bisa menghancurkan musuh dalam sekejap
- 🗡️ **Assassin dengan Mobility Tinggi** - Assassin yang cepat masuk dan keluar dari teamfight
- 🛡️ **Support dengan Crowd Control Terbaik** - Support yang efektif mengontrol pergerakan musuh

Dengan metode MOORA (Multi-Objective Optimization by Ratio Analysis), aplikasi ini mengevaluasi hero berdasarkan berbagai kriteria seperti damage, durability, mobility, crowd control, dan aspek lainnya untuk memberikan rekomendasi hero terbaik sesuai kebutuhan tim dan strategi permainan.

### Fitur Utama

- **Manajemen Kriteria Hero**: Mengelola kriteria evaluasi hero seperti damage, durability, mobility, CC, dll dengan status aktif/non-aktif dan tipe input yang fleksibel
- **Manajemen Bobot Dinamis**: Sistem pembobotan kriteria yang dapat disesuaikan berdasarkan prioritas strategi tim (contoh: prioritas mobilitas 40%, damage 30%, durability 30%)
- **Database Hero**: Mengelola data hero Mobile Legends yang akan dievaluasi dengan statistik lengkap
- **Sistem Penilaian Fleksibel**: Mendukung input berupa nilai numerik (1-10) atau pilihan kategori (Low, Medium, High, Very High)
- **Perhitungan MOORA**: Implementasi lengkap algoritma MOORA dengan normalisasi matriks dan optimasi untuk ranking hero
- **Riwayat Ranking**: Menyimpan dan mengelola hasil ranking hero untuk berbagai skenario (push rank, tournament, casual, dll)
- **Dashboard Admin**: Panel administrasi untuk mengelola data hero dan kriteria evaluasi
- **Interface Klien**: Antarmuka yang mudah digunakan untuk membuat ranking dan melihat rekomendasi hero
- **Multi-Scenario Support**: Mendukung pembuatan ranking untuk berbagai kebutuhan (laning phase, teamfight, split push, dll)


## Teknologi yang Digunakan

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Frontend**: Blade Templates, Tailwind CSS 4.0, JavaScript
- **Database**: MySQL
- **Build Tool**: Vite 6.2+ dengan @tailwindcss/vite plugin
- **Package Manager**: Composer 2.x, NPM
- **Dependency Management**: Axios 1.8+, Laravel Vite Plugin
- **UI Framework**: Tailwind CSS 4.0 dengan konfigurasi modern

## Penggunaan AI dalam Pengembangan

Aplikasi ini dikembangkan dengan memanfaatkan **Artificial Intelligence (AI)** sebagai alat bantu yang signifikan dalam proses pengembangan. Berikut adalah cara AI digunakan dan dampaknya terhadap hasil aplikasi:

### Metodologi Pengembangan dengan AI

#### 1. **Pembuatan Base/Foundation Aplikasi**
AI digunakan untuk membuat struktur dasar aplikasi dengan cara:
- Memberikan **prompt yang jelas dan terstruktur** berdasarkan rancangan yang telah disiapkan
- Menyertakan **Entity Relationship Diagram (ERD)** lengkap yang menggambarkan relasi antar tabel database
- Menjelaskan **alur kerja aplikasi** secara detail, termasuk:
  - Flow pembuatan ranking multi-step
  - Implementasi metode MOORA
  - Sistem manajemen kriteria dan bobot dinamis
  - Relasi user, ranking, alternative, criteria, dan assessment

**Dampak**: AI mampu menghasilkan struktur MVC (Model-View-Controller) yang terorganisir dengan baik, migrations database yang sesuai ERD, dan routing yang lengkap dalam waktu singkat. Hal ini mempercepat proses setup awal dari yang biasanya memakan waktu berhari-hari menjadi beberapa jam saja.

#### 2. **Pengembangan dan Kustomisasi**
Setelah base aplikasi selesai, pengembangan dilanjutkan secara manual dengan:
- Menambahkan fitur-fitur spesifik untuk kasus penggunaan Mobile Legends
- Mengimplementasikan validasi dan business logic yang kompleks
- Menyesuaikan UI/UX sesuai kebutuhan pengguna
- Mengoptimalkan query database dan performa aplikasi

**Dampak**: Dengan base yang solid dari AI, fokus pengembangan dapat dialihkan ke fitur-fitur inti dan optimasi, bukan pada setup infrastruktur dasar.

#### 3. **Debugging dan Troubleshooting**
AI digunakan sebagai asisten debugging ketika menemui error yang sulit dideteksi:
- **Complex Error Analysis**: Error yang melibatkan multiple layer (database, eloquent relationship, validation)
- **Logic Error**: Bug dalam implementasi algoritma MOORA atau kalkulasi bobot
- **Integration Issues**: Masalah integrasi antara backend Laravel dan frontend Vite
- **Performance Bottleneck**: Identifikasi query N+1 problem dan optimasi

**Dampak**: Waktu debugging berkurang drastis. Error yang sebelumnya bisa memakan waktu berjam-jam untuk diidentifikasi, kini dapat diselesaikan dalam hitungan menit dengan bantuan AI untuk menganalisis stack trace dan menyarankan solusi.

#### 4. **Desain dan Pemilihan Tampilan**
AI membantu dalam aspek visual dan user experience:
- **Layout Suggestions**: Rekomendasi layout yang optimal untuk wizard multi-step
- **Color Scheme**: Pemilihan skema warna yang sesuai dengan tema Mobile Legends
- **Component Design**: Desain komponen UI seperti card hero, tabel ranking, form assessment
- **Responsive Design**: Saran implementasi Tailwind CSS untuk berbagai ukuran layar
- **UX Flow**: Optimasi user flow untuk mengurangi friction dalam proses pembuatan ranking

**Dampak**: Interface aplikasi menjadi lebih intuitif dan user-friendly. Feedback dari pengguna menunjukkan bahwa wizard multi-step mudah dipahami dan proses pembuatan ranking tidak membingungkan.

### Dampak Nyata Penggunaan AI

1. **Efisiensi Waktu Pengembangan**: Pengembangan yang normalnya membutuhkan 3-4 minggu dapat diselesaikan dalam 1-2 minggu dengan kualitas kode yang tetap terjaga.

2. **Kualitas Kode yang Konsisten**: AI membantu menghasilkan kode yang mengikuti best practices Laravel dan standar PSR, membuat codebase lebih maintainable.

3. **Dokumentasi yang Lebih Baik**: AI membantu dalam pembuatan comment dan documentation yang jelas pada fungsi-fungsi kompleks seperti implementasi MOORA.

4. **Learning Accelerator**: Proses development dengan AI juga menjadi pembelajaran, di mana setiap solusi yang diberikan AI dapat dipelajari dan dipahami untuk meningkatkan skill programming.

5. **Fokus pada Problem Solving**: Dengan AI menangani boilerplate code dan struktur dasar, developer dapat lebih fokus pada logika bisnis dan implementasi algoritma MOORA yang merupakan inti dari aplikasi.


## Instalasi

### Persyaratan Sistem

- PHP >= 8.2 (dengan ekstensi: mbstring, xml, curl, zip, pdo, sqlite/mysql)
- Composer 2.x atau lebih baru
- Node.js >= 18.x & NPM >= 9.x
- Database: MySQL 5.7+
- Git (untuk clone repository)
- Web Server: Apache/Nginx (optional, bisa gunakan `php artisan serve`)

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/M0RYU/ibmskillsbuild.git
cd ibmskillsbuild
```

2. **Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

3. **Konfigurasi Environment**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

4. **Konfigurasi Database**
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=moora_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Setup Database**
```bash
# Run migrations
php artisan migrate

# Seed sample data (termasuk user admin dan kriteria)
php artisan db:seed
```

**Default Admin Credentials** (setelah seeding):
- Email: `anharphelia@weabo.com`
- Password: `anharphelia`


6. **Build Frontend Assets**
```bash
# Build for production
npm run build

# Or run in development mode
npm run dev
```

7. **Jalankan Aplikasi**
```bash
# Start the development server
php artisan serve

# Aplikasi akan berjalan di http://localhost:8000
```

Aplikasi akan berjalan di `http://localhost:8000`

### Konfigurasi Opsional

#### Storage Link (Untuk file upload di masa depan)
```bash
php artisan storage:link
```

#### Optimasi Performa
```bash
# Cache konfigurasi untuk performa lebih baik
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Arsitektur Database

### Struktur Kontroler

Aplikasi ini menggunakan arsitektur MVC (Model-View-Controller) dengan kontroler-kontroler berikut:

- **AuthController**: Menangani autentikasi login dan logout
- **AdminController**: Dashboard dan manajemen admin
- **ClientController**: Halaman publik dan tampilan ranking untuk pengguna umum
- **CriteriaController**: CRUD dan manajemen status kriteria
- **NewRankingController**: Multi-step wizard untuk pembuatan ranking baru
- **AlternativeController**: Manajemen alternatif dalam ranking

### Routing & Middleware

#### Public Routes:
- `/` - Halaman utama client
- `/login` - Halaman login
- `/ranking/{id}` - Detail ranking (public view)
- `/rankings/*` - Wizard pembuatan ranking

#### Protected Routes (Admin):
- `/admin` - Dashboard admin
- `/admin/criterias` - Manajemen kriteria (CRUD)
- Dilindungi dengan middleware `auth`

### Service Layer

**MooraService**: Service khusus untuk implementasi algoritma MOORA
- `calculateRanking()` - Menghitung ranking menggunakan metode MOORA
- `normalizeMatrix()` - Normalisasi matriks keputusan
- `calculateWeightedMatrix()` - Perhitungan matriks terbobot
- `calculateOptimizationValues()` - Kalkulasi nilai optimasi
- `rankAlternatives()` - Penentuan peringkat final

### Models & Eloquent Relationships

**User Model**
- `hasMany(Ranking)` - Satu user bisa membuat banyak ranking

**Ranking Model**
- `belongsTo(User)` - Ranking dibuat oleh satu user
- `hasMany(Alternative)` - Satu ranking punya banyak alternatif
- `hasMany(RankingCriteria)` - Satu ranking punya banyak kriteria dengan bobot
- `hasMany(RankingAlternative)` - Satu ranking punya banyak hasil ranking

**Criteria Model**
- `hasMany(CriteriaOption)` - Satu kriteria bisa punya banyak opsi
- `hasMany(Assessment)` - Satu kriteria digunakan di banyak assessment
- `hasMany(RankingCriteria)` - Satu kriteria bisa digunakan di banyak ranking

**Alternative Model**
- `belongsTo(Ranking)` - Alternatif milik satu ranking
- `hasMany(Assessment)` - Satu alternatif punya banyak assessment
- `hasOne(RankingAlternative)` - Satu alternatif punya satu hasil ranking

**Assessment Model**
- `belongsTo(Alternative)` - Assessment untuk satu alternatif
- `belongsTo(Criteria)` - Assessment untuk satu kriteria
- `belongsTo(CriteriaOption)` - Assessment bisa merujuk ke satu opsi (jika tipe options)

### Tabel Utama

- **users**: Data pengguna sistem dengan autentikasi
- **criterias**: Master data kriteria evaluasi hero (damage, mobility, durability, dll) dengan status aktif/non-aktif dan tipe input
- **criteria_options**: Opsi nilai untuk kriteria dengan tipe input "options" (contoh: Low, Medium, High, Very High)
- **alternatives**: Data hero Mobile Legends yang akan dievaluasi per ranking
- **rankings**: Data ranking/sesi evaluasi hero dengan metadata dan status temporary (contoh: "Best Tank for Pushing", "Best MM for Poke")
- **ranking_criteria**: Bobot kriteria yang dikustomisasi per ranking session
- **ranking_alternatives**: Hasil ranking hero dengan nilai optimasi dan peringkat
- **assessments**: Data penilaian detail untuk setiap hero berdasarkan kriteria
- **cache**: Cache sistem untuk performa optimal
- **jobs**: Queue jobs untuk proses background (jika diperlukan)


## Metode MOORA

MOORA (Multi-Objective Optimization by Ratio Analysis) adalah metode pengambilan keputusan multi-kriteria yang menggunakan pendekatan rasio untuk mengoptimalkan beberapa atribut secara bersamaan. Metode ini memiliki keunggulan dalam hal kesederhanaan perhitungan dan efektivitas hasil.

### Keunggulan Metode MOORA

1. **Sederhana dan Mudah Dipahami**: Proses perhitungan yang straightforward
2. **Fleksibel**: Dapat menangani berbagai jenis kriteria (benefit/cost)
3. **Akurat**: Menggunakan normalisasi yang tepat untuk menghindari bias
4. **Efisien**: Waktu komputasi yang relatif cepat

### Implementasi dalam Sistem

#### Langkah-langkah Perhitungan:

1. **Normalisasi Matriks Keputusan**
   - Menghitung akar kuadrat dari jumlah kuadrat setiap kolom
   - Membagi setiap elemen dengan nilai tersebut

2. **Penerapan Bobot Kriteria**
   - Mengalikan matriks ternormalisasi dengan bobot masing-masing kriteria
   - Bobot dapat dikustomisasi per ranking session

3. **Kalkulasi Nilai Optimasi**
   - Menjumlahkan nilai beneficial criteria
   - Mengurangkan nilai cost criteria
   - Formula: Yi = Σ(xij × wj)benefit - Σ(xij × wj)cost

4. **Penentuan Ranking**
   - Mengurutkan alternatif berdasarkan nilai optimasi tertinggi
   - Alternatif dengan nilai Yi terbesar mendapat rank 1

#### Tipe Kriteria yang Didukung:

- **Benefit**: Semakin besar nilainya semakin baik  
  Contoh untuk hero: *Damage Output, Mobility, Crowd Control, Sustain/Regen*
- **Cost**: Semakin kecil nilainya semakin baik  
  Contoh untuk hero: *Cooldown Skills, Mana Consumption, Difficulty Level*

#### Tipe Input Kriteria:

- **Number**: Input berupa angka langsung (contoh: 1-10, damage 500-2000)
- **Options**: Input berupa pilihan dengan nilai yang telah ditentukan (contoh: Low=2, Medium=5, High=8, Very High=10)

## Penggunaan Aplikasi

### Admin

1. **Login dan Dashboard**
   - Akses dashboard admin melalui interface web
   - Monitor statistik hero dan aktivitas sistem

2. **Manajemen Kriteria Hero**
   - Tambah, edit, atau hapus kriteria evaluasi hero (damage, mobility, durability, CC, sustain, dll)
   - Atur tipe kriteria (benefit/cost) dan input type (number/options)
   - Aktifkan/nonaktifkan kriteria sesuai kebutuhan

3. **Manajemen Opsi Kriteria**
   - Definisikan opsi untuk kriteria dengan tipe input "options"
   - Atur nilai numerik untuk setiap opsi (contoh: Low=2, Medium=5, High=8, Very High=10)

4. **Lihat Riwayat Ranking**
   - Akses semua ranking hero yang pernah dibuat
   - Lihat detail hasil dan data penilaian hero

### Pengguna/Klien

#### Flow Pembuatan Ranking Hero (Multi-Step Wizard):

1. **Membuat Ranking Baru**
   - Akses `/rankings/create`
   - Tentukan judul ranking (contoh: "Tank dengan Mobilitas Terbaik", "MM dengan Poke Damage Tinggi")
   - Berikan deskripsi skenario penggunaan
   - Sistem akan membuat ranking dengan status temporary

2. **Pilih Kriteria Evaluasi**
   - Pilih kriteria yang relevan untuk evaluasi (hanya kriteria aktif yang ditampilkan)
   - Contoh kriteria: Damage, Mobility, Durability, Crowd Control, Sustain, dll
   - Minimal 1 kriteria harus dipilih
   - Bisa kembali ke langkah sebelumnya jika diperlukan

3. **Atur Bobot Kriteria**
   - Atur bobot prioritas untuk setiap kriteria yang dipilih
   - Total bobot harus 100% (validasi real-time)
   - Contoh: Mobility 40%, Damage 30%, Durability 30%

4. **Input Hero**
   - Tambahkan hero Mobile Legends yang akan dibandingkan
   - Berikan nama hero dan role/kategori
   - Minimal 2 hero untuk perhitungan yang bermakna
   - Contoh: Khufra, Grock, Atlas, Fredrinn (untuk ranking tank)

5. **Proses Assessment Hero**
   - Berikan penilaian untuk setiap hero berdasarkan kriteria yang dipilih
   - Input dapat berupa:
     - Angka (contoh: Damage 1-10)
     - Pilihan opsi (contoh: Mobility - Low/Medium/High/Very High)
   - Sistem akan validasi kelengkapan data

6. **Melihat Hasil Ranking**
   - Klik tombol "Hitung Ranking"
   - Sistem otomatis menghitung ranking menggunakan metode MOORA
   - Hasil ditampilkan dalam tabel dengan:
     - Rank (peringkat) - Hero terbaik di posisi #1
     - Nama hero
     - Nilai optimasi
     - Detail penilaian per kriteria
   - Ranking akan diubah dari temporary menjadi permanent
   - Simpan untuk referensi draft pick atau strategi tim

### Fitur Tambahan

- **Multi-step Hero Ranking**: Proses pembuatan ranking hero dengan wizard multi-langkah
- **Temporary Rankings**: Draft ranking yang bisa dikembalikan atau dibatalkan
- **Dynamic Weight Validation**: Validasi real-time untuk total bobot 100%
- **Riwayat Ranking Hero**: Akses kembali hasil ranking untuk berbagai skenario (push rank, tournament, dll)
- **Responsive Design**: Akses melalui desktop, tablet, atau mobile device
- **Real-time Calculation**: Perhitungan otomatis saat data hero lengkap
- **User Authentication**: Sistem login untuk admin dengan middleware protection

## Development & Deployment

### Production Deployment

```bash
# Optimize for production
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --filter=MooraTest

# Run tests with coverage
php artisan test --coverage
```

### Troubleshooting

#### Common Issues:

1. **Permission Errors (Windows)**
   ```powershell
   # Jalankan sebagai Administrator jika diperlukan
   icacls storage /grant Users:F /T
   icacls bootstrap\cache /grant Users:F /T
   ```

2. **Database Connection**
   - Periksa konfigurasi `.env`
   - Pastikan database service berjalan
   - Cek kredensial database

3. **Asset Building Issues**
   ```powershell
   # Clear cache dan reinstall
   npm cache clean --force
   Remove-Item -Recurse -Force node_modules
   Remove-Item package-lock.json
   npm install
   ```

4. **Vite Connection Issues**
   - Pastikan port 5173 tidak digunakan aplikasi lain
   - Restart `npm run dev` jika hot reload tidak berfungsi
   - Clear browser cache jika CSS tidak update

5. **Laravel Cache Issues**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

