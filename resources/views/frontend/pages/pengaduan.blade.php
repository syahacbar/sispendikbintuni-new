@extends('frontend.layouts.app')
@section('content')
    <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="text-center mb-4">
                    <h3 class="text-success fw-bold">
                        Form Pengaduan
                    </h3>
                    <p class="text-muted">
                        Form Pengaduan Layanan Sistem Informasi Pendidikan Kabupaten Teluk Bintuni
                    </p>
                </div>
            </div>
            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row my-3">
                    <div class="col-md-12">
                        @if (session('success'))
                            <div class="alert alert-success d-flex flex-column gap-2">
                                <div><strong>{{ session('success') }}</strong></div>
                            </div>
                        @endif

                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="judul_laporan" class="form-label">Judul Aduan</label>
                            <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="nama_pelapor" class="form-label">Nama Pelapor</label>
                            <input type="text" class="form-control" id="nama_pelapor" name="nama_pelapor" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Aktif</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor HP/WA</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori Pengaduan</label>
                            <select class="form-control" id="kategori" name="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Fasilitas Sekolah">Fasilitas Sekolah</option>
                                <option value="Kurikulum & Pembelajaran">Kurikulum & Pembelajaran</option>
                                <option value="Guru & Tenaga Kependidikan">Guru & Tenaga Kependidikan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="dok_lampiran" class="form-label">Dokumen Lampiran</label>
                            <input type="file" class="form-control" id="dok_lampiran" name="dok_lampiran">
                            {{-- <small class="form-text text-muted">Lampiran bersifat opsional. Maks. 2MB, format: jpg, jpeg,
                                png, pdf, docx.</small> --}}

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Pengaduan</label>
                            <textarea class="form-control" id="isi" name="isi"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Kirim Pengaduan</button>
                        <button type="reset" class="btn btn-secondary d-none" id="reset-btn">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script src="https://cdn.tiny.cloud/1/2onuugfnc4zd46qg4zym8s946ezny033scq014mxt4usgs1q/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submit-btn');
            const resetBtn = document.getElementById('reset-btn');
            const requiredFields = ['nama_pelapor', 'judul_laporan', 'email', 'no_hp', 'kategori'];

            const checkForm = () => {
                const editor = tinymce.get('isi');
                const editorContent = editor ? editor.getContent({
                    format: 'text'
                }).trim() : '';
                const isEditorFilled = editorContent.length > 0;

                const areFieldsFilled = requiredFields.every(id => {
                    const el = document.getElementById(id);
                    return el && el.value.trim() !== '';
                });

                const isValid = isEditorFilled && areFieldsFilled;
                const isAnyFieldFilled = isEditorFilled || requiredFields.some(id => {
                    const el = document.getElementById(id);
                    return el && el.value.trim() !== '';
                });

                // Enable/disable tombol submit
                submitBtn.disabled = !isValid;

                // Show/hide tombol reset
                if (isAnyFieldFilled) {
                    resetBtn.classList.remove('d-none');
                } else {
                    resetBtn.classList.add('d-none');
                }
            };

            // Tambah event listener ke input biasa
            requiredFields.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', checkForm);
                }
            });

            // TinyMCE init
            tinymce.init({
                selector: '#isi',
                height: 250,
                menubar: false,
                plugins: 'lists preview', // HANYA plugin yang dibutuhkan
                toolbar: 'undo redo | bold italic underline | bullist numlist | preview', // tanpa link & image
                branding: false,
                forced_root_block: '', // opsional: untuk cegah <p> otomatis
                setup: function(editor) {
                    editor.on('drop', function(e) {
                        e.preventDefault(); // cegah drag-drop gambar
                    });
                    editor.on('input', checkForm);
                    editor.on('change', checkForm);
                }
            });

            // Reset
            form.addEventListener('reset', () => {
                setTimeout(() => {
                    submitBtn.disabled = true;
                    resetBtn.classList.add('d-none');
                    if (tinymce.get('isi')) {
                        tinymce.get('isi').setContent('');
                    }
                }, 100);
            });
        });
    </script>
@endsection
