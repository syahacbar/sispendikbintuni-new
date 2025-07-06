@extends('frontend.layouts.app')

@section('content')
    <section class="identity-section mb-4 mt-5">
        <div class="container">
            <div class="identity-content">
                <h1 class="text-white fw-bold" data-aos="fade-up">Informasi Sekolah</h1>
                <p class="text-warning mb-4" data-aos="fade-up">Data Sekolah Kabupaten Teluk Bintuni</p>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="text-center mb-4">
                    <h3 class="text-success fw-bold">
                        Data Sekolah
                    </h3>
                    <p class="text-muted">
                        Tabel Informasi Sekolah Se-Kabupaten Teluk Bintuni
                    </p>
                </div>
            </div>
            <div class="row my-3">
                <div class="container">
                    <h3>Data Sekolah</h3>

                    <div class="mb-3">
                        <label>Kecamatan:</label>
                        <select id="kecamatanSelect" class="form-control">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ($kecamatans as $kec)
                                <option value="{{ $kec }}">{{ $kec }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Kelurahan:</label>
                        <select id="kelurahanSelect" class="form-control" disabled></select>
                    </div>

                    <div class="mb-3">
                        <label>Sekolah:</label>
                        <ul id="sekolahList" class="list-group"></ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.getElementById('kecamatanSelect').addEventListener('change', function() {
            const kecamatan = this.value;
            const kelurahanSelect = document.getElementById('kelurahanSelect');
            const sekolahList = document.getElementById('sekolahList');

            kelurahanSelect.innerHTML = '';
            sekolahList.innerHTML = '';

            if (kecamatan) {
                fetch(`/data-pendidikan/${kecamatan}/kelurahans`)
                    .then(res => res.json())
                    .then(data => {
                        kelurahanSelect.disabled = false;
                        kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
                        data.forEach(kel => {
                            kelurahanSelect.innerHTML += `<option value="${kel}">${kel}</option>`;
                        });
                    });
            } else {
                kelurahanSelect.disabled = true;
            }
        });

        document.getElementById('kelurahanSelect').addEventListener('change', function() {
            const kecamatan = document.getElementById('kecamatanSelect').value;
            const kelurahan = this.value;
            const sekolahList = document.getElementById('sekolahList');

            sekolahList.innerHTML = '';

            if (kelurahan) {
                fetch(`/data-pendidikan/${kecamatan}/${kelurahan}/sekolahs`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(sekolah => {
                            sekolahList.innerHTML += `
                            <li class="list-group-item">
                                <a href="/data-pendidikan/sekolah/${sekolah.slug}">
                                    ${sekolah.nama}
                                </a>
                            </li>
                        `;
                        });
                    });
            }
        });
    </script>
@endpush
