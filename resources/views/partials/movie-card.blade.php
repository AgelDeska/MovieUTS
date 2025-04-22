<!-- REFACTOR #3: Extracted reusable card component -->
<div class="card mb-3" style="max-width: 540px;">
    <div class="row g-0">
        <div class="col-md-4">
            <!-- REFACTOR #5: Using asset() helper for image paths -->
            <img src="{{ asset('images/' . $movie->foto_sampul) }}" class="img-fluid rounded-start" alt="{{ $movie->judul }}">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <!-- REFACTOR #2: Standardized to object notation -->
                <h5 class="card-title">{{ $movie->judul }}</h5>
                <p class="card-text">{{ $movie->sinopsis }}</p>
                <!-- REFACTOR #1: Using existing route pattern instead of named route -->
                <a href="/movie/{{ $movie->id }}" class="btn btn-success">Lihat Selanjutnya</a>
            </div>
        </div>
    </div>
</div>
