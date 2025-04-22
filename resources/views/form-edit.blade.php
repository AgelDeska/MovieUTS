@extends('layout.template')
@section('title', 'Edit Data Movie')
@section('content')
		<h2 class="mb-4">Edit Movie</h2>
        <form action="{{ route('movies.update', ['movie' => $movie->id]) }}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			<!-- REFACTOR #4: Added validation error display -->
			<div class="mb-3">
				<label for="id" class="form-label">ID Film:</label>
				<input type="text" class="form-control" id="id" name="id" value="{{ $movie->id }}" disabled>
			</div>
			<div class="mb-3">
				<label for="judul" class="form-label">Judul:</label>
				<input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $movie->judul) }}" required>
				@error('judul')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="mb-3">
				<label for="category_id" class="form-label">Kategori:</label>
				<select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
					<option value="">Pilih Kategori</option>
					@foreach ($categories as $category)
						<option value="{{ $category->id }}" {{ old('category_id', $movie->category_id) == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
					@endforeach
				</select>
				@error('category_id')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="mb-3">
				<label for="sinopsis" class="form-label">Sinopsis:</label>
				<textarea class="form-control @error('sinopsis') is-invalid @enderror" id="sinopsis" name="sinopsis" rows="4" required>{{ old('sinopsis', $movie->sinopsis) }}</textarea>
				@error('sinopsis')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="mb-3">
				<label for="tahun" class="form-label">Tahun:</label>
				<input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', $movie->tahun) }}" required>
				@error('tahun')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="mb-3">
				<label for="pemain" class="form-label">Pemain:</label>
				<input type="text" class="form-control @error('pemain') is-invalid @enderror" id="pemain" name="pemain" value="{{ old('pemain', $movie->pemain) }}" required>
				@error('pemain')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Sebelumnya:</label>
                <!-- REFACTOR #5: Using asset() helper for image paths -->
                <img src="{{ asset('images/' . $movie->foto_sampul) }}" class="img-thumbnail"
                alt="{{ $movie->judul }}" width="100px">
            </div>
			<div class="mb-3">
				<label for="foto_sampul" class="form-label">Foto Sampul:</label>
				<input type="file" class="form-control @error('foto_sampul') is-invalid @enderror" id="foto_sampul" name="foto_sampul">
				@error('foto_sampul')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="mb-3">
				<button type="submit" class="btn btn-primary">Simpan</button>
				<!-- REFACTOR #1: Using named routes -->
				<a href="{{ route('movies.index') }}" class="btn btn-secondary">Batal</a>
			</div>
		</form>
@endsection
