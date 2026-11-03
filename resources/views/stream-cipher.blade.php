@extends('layouts.app')
@section('title', 'Stream Cipher')

@section('content')
<style>
    .panel { background:#0d2142; border:1px solid #16315c; border-radius:12px; padding:20px; }
    .panel label { font-weight:600; margin-bottom:6px; }
    .form-control, .form-select { background:#081a38; border:1px solid #16315c; color:#e6edf7; }
    .form-control:focus, .form-select:focus { background:#081a38; color:#fff; border-color:#2f7bff; box-shadow:none; }
    .form-control::placeholder { color:#6f86ab; }
    .btn-enc { background:#1f6bff; border:1px solid #1f6bff; color:#fff; }
    .btn-dec { background:transparent; border:1px solid #2f7bff; color:#e6edf7; }
    .info-title { color:#e6edf7; font-weight:600; }
    .info-text { color:#9fb2d1; font-size:.9rem; }
    .back-btn { display:inline-block; background:#0d2142; border:1px solid #16315c; color:#e6edf7;
                padding:3px 12px; border-radius:6px; text-decoration:none; font-size:.85rem; margin-bottom:14px; }
</style>

<a href="/" class="back-btn"><i class="bi bi-arrow-left"></i> Kembali</a>

<div class="d-flex align-items-center gap-3 mb-4">
    <i class="bi bi-shuffle" style="font-size:2.6rem;color:#2f7bff"></i>
    <div>
        <h2 class="fw-bold mb-0">Stream Cipher</h2>
        <div class="info-text">Metode kriptografi yang mengenkripsi data secara bertahap menggunakan aliran kunci (keystream).</div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="panel">
            <div class="row g-3">
                <div class="col-12">
                    <label>Pilih Algoritma</label>
                    <select class="form-select" id="algo">
                        <option value="chacha20">ChaCha20</option>
                        <option value="rc4">RC4</option>
                    </select>
                </div>
                <div class="col-12">
                    <label>Pesan</label>
                    <textarea class="form-control" id="pesan" rows="4" placeholder="Masukkan pesan..."></textarea>
                </div>
                <div class="col-12">
                    <label>Kunci</label>
                    <input type="text" class="form-control" id="kunci" placeholder="Masukkan kunci...">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-enc" id="btnEnkripsi"><i class="bi bi-play-fill"></i> Enkripsi</button>
                    <button class="btn btn-dec" id="btnDekripsi"><i class="bi bi-arrow-repeat"></i> Dekripsi</button>
                </div>
            </div>
        </div>

        <div class="panel mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="mb-0"><i class="bi bi-check-circle"></i> Hasil</label>
                <button class="btn btn-sm btn-dec" id="btnSalin">Salin</button>
            </div>
            <div class="info-text mt-2" id="hasil">Hasil akan muncul di sini...</div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel">
            <div class="info-title mb-2"><i class="bi bi-info-circle-fill" style="color:#2f7bff"></i> Informasi</div>
            <div class="info-title">ChaCha20</div>
            <div class="info-text mb-3">adalah stream cipher modern yang cepat dan aman.</div>
            <div class="info-title">Kelebihan:</div>
            <div class="info-text">- Performa tinggi<br>- Keamanan kuat</div>
        </div>
    </div>
</div>

<script>
    const kirim = async (aksi) => {
        const hasil = document.getElementById('hasil');
        const res = await fetch('/stream-cipher/proses', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                aksi: aksi,
                algo: document.getElementById('algo').value,
                pesan: document.getElementById('pesan').value,
                kunci: document.getElementById('kunci').value
            })
        });
        const data = await res.json();
        hasil.style.color = data.error ? '#ff7b7b' : '#e6edf7';
        hasil.style.wordBreak = 'break-all';
        hasil.textContent = data.error ?? data.hasil ?? data.message ?? JSON.stringify(data);
    };

    document.getElementById('btnEnkripsi').onclick = () => kirim('enkripsi');
    document.getElementById('btnDekripsi').onclick = () => kirim('dekripsi');
    document.getElementById('btnSalin').onclick = () => {
        navigator.clipboard.writeText(document.getElementById('hasil').textContent);
    };
</script>
@endsection