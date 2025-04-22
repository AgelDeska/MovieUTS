@extends('layout.template')

@section('title', $movie->judul)

@section('content')

<div class="card mb-3">
    <div class="row g-0">
      <div class="col-md-3">
        <!-- REFACTOR #5: Using asset() helper for image paths -->
        <img src="{{ asset('images/' . $movie->foto_sampul) }}" class="img-fluid rounded-start" alt="{{ $movie->judul }}">
      </div>
      <div class="col-md-9">
        <div class="card-body">
          <!-- REFACTOR #2: Standardized to object notation -->
          <h2 class="card-title">{{ $movie->judul }}</h2>
          <p class="card-text">{{ $movie->sinopsis }}</p>
          <p class="card-text">Kategori : {{ $movie->category->nama_kategori }}</p>
          <p class="card-text">Tahun : {{ $movie->tahun }}</p>
          <p class="card-text">Pemain : {{ $movie->pemain }}</p>
          <!-- REFACTOR #1: Using named routes -->
          <a href="{{ route('homepage') }}" class="btn btn-success">Kembali</a>
        </div>
      </div>
    </div>
  </div>
    
@endsection
