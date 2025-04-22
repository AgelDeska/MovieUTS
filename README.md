# Movie Application

Aplikasi web berbasis Laravel untuk mengelola informasi film.

## Overview

Aplikasi ini memungkinkan pengguna untuk menelusuri, menambahkan, mengedit, dan menghapus informasi film. Ini mencakup fitur-fitur seperti kategorisasi, informasi film terperinci, dan unggahan gambar untuk poster film.

## Features

- Menelusuri film dengan penomoran halaman
- Lihat informasi film terperinci
- Menambahkan film baru dengan unggahan gambar
- Mengedit informasi film yang ada
- Menghapus film
- Mengkategorikan film

## Refactoring Documentation

### Refactoring Areas

#### 1. Penggunaan Rute Standar

**Problem:** Definisi rute yang tidak konsisten di seluruh tampilan.
- Beberapa tampilan digunakan hardcode URLs: `<a href="/movie/{{ $movie['id'] }}">`
- Lainnya menggunakan nama routes: `route('movies.update', ['movie' => $movie->id])`

**Solution:** Standarisasi ke rute bernama jika memungkinkan dan memperbarui file rute untuk menyertakan nama rute yang tepat.

```php
// Before
<a href="/">Kembali</a>
<a href="/movie/{{ $movie['id'] }}">Lihat Selanjutnya</a>
<form action="/movies/store" method="POST">

// After
<a href="{{ route('homepage') }}">Kembali</a>
<a href="{{ route('movies.show', $movie->id) }}">Lihat Selanjutnya</a>
<form action="{{ route('movies.store') }}" method="POST">
```

#### 2. Pola Akses Data Standar

**Problem:** Sintaks akses data yang tidak konsisten.
- Beberapa file menggunakan array syntax: `$movie['judul']`
- Objek lain yang digunakan syntax: `$movie->category->nama_kategori`

**Solution:** Distandarisasi ke notasi objek untuk data model.

```php
// Before
<h2 class="card-title">{{ $movie['judul'] }}</h2>
<p class="card-text">{{ $movie['sinopsis'] }}</p>

// After
<h2 class="card-title">{{ $movie->judul }}</h2>
<p class="card-text">{{ $movie->sinopsis }}</p>
```

#### 3. Struktur HTML Duplikat yang Diekstrak

**Problem:** Tata letak kartu diulang di beberapa tampilan.

**Solution:** Mengekstrak tata letak kartu umum ke dalam tampilan parsial.

```php
// New file: resources/views/partials/movie-card.blade.php
<div class="card mb-3" style="max-width: 540px;">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="{{ asset('images/' . $movie->foto_sampul) }}" class="img-fluid rounded-start" alt="{{ $movie->judul }}">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">{{ $movie->judul }}</h5>
                <p class="card-text">{{ $movie->sinopsis }}</p>
                <a href="/movie/{{ $movie->id }}" class="btn btn-success">Lihat Selanjutnya</a>
            </div>
        </div>
    </div>
</div>

// Usage in homepage.blade.php
@foreach ($movies as $movie)
    <div class="col-lg-6">
        @include('partials.movie-card', ['movie' => $movie])
    </div>
@endforeach
```

#### 4. Added Validation Error Display

**Problem:** Formulir input tidak menampilkan kesalahan validasi.

**Solution:** Menambahkan penanganan kesalahan untuk bidang formulir.

```php
// Before
<input type="text" class="form-control" id="judul" name="judul" required="">

// After
<input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
@error('judul')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
```

#### 5. Digunakan Asset Helper untuk Jalur

**Problem:** Jalur hardcode untuk gambar.

**Solution:** Pembantu asset() yang digunakan untuk aset publik.

```php
// Before
<img src="/images/{{ $movie['foto_sampul'] }}" class="img-fluid rounded-start" alt="...">

// After
<img src="{{ asset('images/' . $movie->foto_sampul) }}" class="img-fluid rounded-start" alt="{{ $movie->judul }}">
```

### Manfaat Refactoring

1. **Pemeliharaan yang Ditingkatkan**: Pola yang konsisten membuat kode lebih mudah dipahami dan dipelihara
2. **Pengalaman Pengguna yang Lebih Baik**: Umpan balik validasi yang ditambahkan membantu pengguna memperbaiki kesalahan formulir
3. **Enhanced Reusability**: Komponen yang diekstraksi mengurangi duplikasi kode
4. **Ketahanan yang Ditingkatkan**: Pembantu aset memastikan resolusi jalur yang benar di lingkungan yang berbeda
5. **Organisasi Kode yang Lebih Baik**: Pendekatan standar membuat basis kode lebih kohesif

### Routes Update

File rute diperbarui untuk menyertakan rute bernama untuk semua titik akhir:

```php
Route::get('/', [MovieController::class, 'index'])->name('homepage');
Route::get('/movie/{id}', [MovieController::class, 'detail'])->name('movies.show');
Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
Route::post('/movies/store', [MovieController::class, 'store'])->name('movies.store');
Route::get('/movies/data', [MovieController::class, 'data'])->name('movies.index');
Route::get('/movies/edit/{id}', [MovieController::class, 'form_edit'])->name('movies.edit');
Route::post('movies/{movie}/update', [MovieController::class, 'update'])->name('movies.update');
Route::get('movies/delete/{id}', [MovieController::class, 'delete'])->name('movies.delete');
```

## Installation

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database
4. Run `php artisan key:generate`
5. Run `php artisan migrate --seed`
6. Run `php artisan serve`

## Requirements

- PHP 8.0+
- Laravel 9.0+
- MySQL 5.7+ or equivalent
