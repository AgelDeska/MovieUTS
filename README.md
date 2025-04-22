# Movie Application

A Laravel-based web application for managing movie information.

## Overview

This application allows users to browse, add, edit, and delete movie information. It includes features like categorization, detailed movie information, and image uploads for movie posters.

## Features

- Browse movies with pagination
- View detailed movie information
- Add new movies with image uploads
- Edit existing movie information
- Delete movies
- Categorize movies

## Refactoring Documentation

### Refactoring Areas

#### 1. Standardized Route Usage

**Problem:** Inconsistent route definition across views.
- Some views used hardcoded URLs: `<a href="/movie/{{ $movie['id'] }}">`
- Others used named routes: `route('movies.update', ['movie' => $movie->id])`

**Solution:** Standardized to named routes where possible and updated the routes file to include proper route names.

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

#### 2. Standardized Data Access Patterns

**Problem:** Inconsistent data access syntax.
- Some files used array syntax: `$movie['judul']`
- Others used object syntax: `$movie->category->nama_kategori`

**Solution:** Standardized to object notation for model data.

```php
// Before
<h2 class="card-title">{{ $movie['judul'] }}</h2>
<p class="card-text">{{ $movie['sinopsis'] }}</p>

// After
<h2 class="card-title">{{ $movie->judul }}</h2>
<p class="card-text">{{ $movie->sinopsis }}</p>
```

#### 3. Extracted Duplicate HTML Structure

**Problem:** Card layout was repeated across multiple views.

**Solution:** Extracted common card layouts into a partial view.

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

**Problem:** Input forms didn't display validation errors.

**Solution:** Added error handling for form fields.

```php
// Before
<input type="text" class="form-control" id="judul" name="judul" required="">

// After
<input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
@error('judul')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
```

#### 5. Used Asset Helper for Paths

**Problem:** Hardcoded paths for images.

**Solution:** Used asset() helper for public assets.

```php
// Before
<img src="/images/{{ $movie['foto_sampul'] }}" class="img-fluid rounded-start" alt="...">

// After
<img src="{{ asset('images/' . $movie->foto_sampul) }}" class="img-fluid rounded-start" alt="{{ $movie->judul }}">
```

### Benefits of Refactoring

1. **Improved Maintainability**: Consistent patterns make code easier to understand and maintain
2. **Better User Experience**: Added validation feedback helps users correct form errors
3. **Enhanced Reusability**: Extracted components reduce code duplication
4. **Improved Robustness**: Asset helpers ensure correct path resolution in different environments
5. **Better Code Organization**: Standardized approaches make the codebase more cohesive

### Routes Update

The routes file was updated to include named routes for all endpoints:

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
