<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut ini berisi aturan standar pesan kesalahan yang digunakan oleh
    | kelas validasi. Beberapa aturan mempunyai banyak versi seperti aturan 'size'.
    | Jangan ragu untuk mengoptimalkan setiap pesan yang ada di sini.
    |
    */

    'accepted' => 'Isian :attribute harus diterima.',
    'accepted_if' => 'Isian :attribute harus diterima ketika :other adalah :value.',
    'active_url' => 'Isian :attribute bukan URL yang valid.',
    'after' => 'Isian :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Isian :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Isian :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Isian :attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num' => 'Isian :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Isian :attribute harus berupa sebuah array.',
    'ascii' => 'Isian :attribute hanya boleh berisi karakter alfanumerik single-byte dan simbol.',
    'before' => 'Isian :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Isian :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => 'Isian :attribute harus mempunyai :min sampai :max anggota.',
        'file' => 'Isian :attribute harus berukuran antara :min sampai :max kilobita.',
        'numeric' => 'Isian :attribute harus bernilai antara :min sampai :max.',
        'string' => 'Isian :attribute harus berisi antara :min sampai :max karakter.',
    ],
    'boolean' => 'Isian :attribute harus bernilai true atau false.',
    'can' => 'Bidang :attribute berisi nilai yang tidak sah.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'current_password' => 'Kata sandi salah.',
    'date' => 'Isian :attribute bukan tanggal yang valid.',
    'date_equals' => 'Isian :attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => 'Isian :attribute tidak cocok dengan format :format.',
    'decimal' => 'Isian :attribute harus memiliki :decimal tempat desimal.',
    'declined' => 'Isian :attribute harus ditolak.',
    'declined_if' => 'Isian :attribute harus ditolak ketika :other adalah :value.',
    'different' => 'Isian :attribute dan :other harus berbeda.',
    'digits' => 'Isian :attribute harus berupa angka :digits.',
    'digits_between' => 'Isian :attribute harus antara angka :min dan :max.',
    'dimensions' => 'Bidang :attribute tidak memiliki dimensi gambar yang valid.',
    'distinct' => 'Bidang :attribute memiliki nilai yang duplikat.',
    'doesnt_end_with' => 'Isian :attribute tidak boleh diakhiri dengan salah satu dari berikut ini: :values.',
    'doesnt_start_with' => 'Isian :attribute tidak boleh diawali dengan salah satu dari berikut ini: :values.',
    'email' => 'Isian :attribute harus berupa alamat surel yang valid.',
    'ends_with' => 'Isian :attribute harus diakhiri salah satu dari berikut: :values',
    'enum' => 'Isian :attribute yang dipilih tidak valid.',
    'exists' => 'Isian :attribute yang dipilih tidak valid.',
    'extensions' => 'Bidang :attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file' => 'Bidang :attribute harus berupa sebuah berkas.',
    'filled' => 'Isian :attribute harus memiliki nilai.',
    'gt' => [
        'array' => 'Isian :attribute harus memiliki lebih dari :value anggota.',
        'file' => 'Isian :attribute harus berukuran lebih besar dari :value kilobita.',
        'numeric' => 'Isian :attribute harus bernilai lebih besar dari :value.',
        'string' => 'Isian :attribute harus berisi lebih besar dari :value karakter.',
    ],
    'gte' => [
        'array' => 'Isian :attribute harus memiliki :value anggota atau lebih.',
        'file' => 'Isian :attribute harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'numeric' => 'Isian :attribute harus bernilai lebih besar dari atau sama dengan :value.',
        'string' => 'Isian :attribute harus berisi lebih besar dari atau sama dengan :value karakter.',
    ],
    'hex_color' => 'Bidang :attribute harus berupa warna heksadesimal yang valid.',
    'image' => 'Isian :attribute harus berupa gambar.',
    'in' => 'Isian :attribute yang dipilih tidak valid.',
    'in_array' => 'Bidang :attribute tidak ada di dalam :other.',
    'integer' => 'Isian :attribute harus berupa bilangan bulat.',
    'ip' => 'Isian :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Isian :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Isian :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Isian :attribute harus berupa JSON string yang valid.',
    'lowercase' => 'Isian :attribute harus berupa huruf kecil.',
    'lt' => [
        'array' => 'Isian :attribute harus memiliki kurang dari :value anggota.',
        'file' => 'Isian :attribute harus berukuran kurang dari :value kilobita.',
        'numeric' => 'Isian :attribute harus bernilai kurang dari :value.',
        'string' => 'Isian :attribute harus berisi kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => 'Isian :attribute harus tidak lebih dari :value anggota.',
        'file' => 'Isian :attribute harus berukuran kurang dari atau sama dengan :value kilobita.',
        'numeric' => 'Isian :attribute harus bernilai kurang dari atau sama dengan :value.',
        'string' => 'Isian :attribute harus berisi kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => 'Isian :attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => 'Isian :attribute tidak boleh lebih dari :max anggota.',
        'file' => 'Isian :attribute tidak boleh lebih dari :max kilobita.',
        'numeric' => 'Isian :attribute tidak boleh lebih dari :max.',
        'string' => 'Isian :attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits' => 'Bidang :attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes' => 'Isian :attribute harus berupa berkas berjenis: :values.',
    'mimetypes' => 'Isian :attribute harus berupa berkas berjenis: :values.',
    'min' => [
        'array' => 'Isian :attribute harus memiliki minimal :min anggota.',
        'file' => 'Isian :attribute harus berukuran minimal :min kilobita.',
        'numeric' => 'Isian :attribute harus bernilai minimal :min.',
        'string' => 'Isian :attribute harus berisi minimal :min karakter.',
    ],
    'min_digits' => 'Bidang :attribute harus memiliki setidaknya :min digit.',
    'missing' => 'Bidang :attribute harus hilang.',
    'missing_if' => 'Bidang :attribute harus hilang ketika :other adalah :value.',
    'missing_unless' => 'Bidang :attribute harus hilang kecuali :other adalah :value.',
    'missing_with' => 'Bidang :attribute harus hilang ketika :values hadir.',
    'missing_with_all' => 'Bidang :attribute harus hilang ketika :values hadir.',
    'multiple_of' => 'Isian :attribute harus merupakan kelipatan dari :value',
    'not_in' => 'Isian :attribute yang dipilih tidak valid.',
    'not_regex' => 'Format isian :attribute tidak valid.',
    'numeric' => 'Isian :attribute harus berupa angka.',
    'password' => [
        'letters' => 'Isian :attribute harus mengandung setidaknya satu huruf.',
        'mixed' => 'Isian :attribute harus mengandung setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers' => 'Isian :attribute harus mengandung setidaknya satu angka.',
        'symbols' => 'Isian :attribute harus mengandung setidaknya satu simbol.',
        'uncompromised' => 'Isian :attribute yang diberikan telah muncul dalam kebocoran data. Silakan pilih :attribute yang berbeda.',
    ],
    'present' => 'Bidang :attribute wajib ada.',
    'present_if' => 'Bidang :attribute wajib ada ketika :other adalah :value.',
    'present_unless' => 'Bidang :attribute wajib ada kecuali :other adalah :value.',
    'present_with' => 'Bidang :attribute wajib ada ketika :values hadir.',
    'present_with_all' => 'Bidang :attribute wajib ada ketika :values hadir.',
    'prohibited' => 'Isian :attribute dilarang.',
    'prohibited_if' => 'Isian :attribute dilarang ketika :other adalah :value.',
    'prohibited_unless' => 'Isian :attribute dilarang kecuali :other adalah :values.',
    'prohibits' => 'Isian :attribute melarang isian :other untuk muncul.',
    'regex' => 'Format isian :attribute tidak valid.',
    'required' => 'Bidang :attribute wajib diisi.',
    'required_array_keys' => 'Isian :attribute harus berisi entri untuk: :values.',
    'required_if' => 'Bidang :attribute wajib diisi bila :other adalah :value.',
    'required_if_accepted' => 'Isian :attribute wajib diisi bila :other diterima.',
    'required_unless' => 'Bidang :attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with' => 'Bidang :attribute wajib diisi bila terdapat :values.',
    'required_with_all' => 'Bidang :attribute wajib diisi bila terdapat :values.',
    'required_without' => 'Bidang :attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Bidang :attribute wajib diisi bila sama sekali tidak terdapat :values.',
    'same' => 'Isian :attribute dan :other harus sama.',
    'size' => [
        'array' => 'Isian :attribute harus mengandung :size anggota.',
        'file' => 'Isian :attribute harus berukuran :size kilobita.',
        'numeric' => 'Isian :attribute harus berukuran :size.',
        'string' => 'Isian :attribute harus berukuran :size karakter.',
    ],
    'starts_with' => 'Isian :attribute harus diawali salah satu dari berikut: :values',
    'string' => 'Isian :attribute harus berupa string.',
    'timezone' => 'Isian :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Isian :attribute sudah ada sebelumnya.',
    'uploaded' => 'Isian :attribute gagal diunggah.',
    'uppercase' => 'Isian :attribute harus berupa huruf besar.',
    'url' => 'Format isian :attribute tidak valid.',
    'ulid' => 'Isian :attribute harus berupa ULID yang valid.',
    'uuid' => 'Isian :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi kustom untuk atribut dengan menggunakan
    | konvensi "attribute.rule" untuk menamai barisnya. Hal ini mempercepat dalam
    | menentukan baris bahasa kustom yang spesifik untuk aturan atribut yang diberikan.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Kustom Atribut Validasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar 'placeholder' atribut dengan sesuatu
    | yang lebih mudah dimengerti oleh pembaca seperti "Alamat Surel" daripada "email".
    | Hal ini membantu kita dalam membuat pesan menjadi lebih ekspresif.
    |
    */

    'attributes' => [
        'alamat_email' => 'Alamat Email',
        'email' => 'Alamat Email',
        'password' => 'Kata Sandi',
        'username' => 'Nama Pengguna',
        'name' => 'Nama',
        'address' => 'Alamat',
        'phone' => 'Nomor Telepon',
        'mobile' => 'Nomor Seluler',
        'age' => 'Usia',
        'sex' => 'Jenis Kelamin',
        'gender' => 'Jenis Kelamin',
        'day' => 'Hari',
        'month' => 'Bulan',
        'year' => 'Tahun',
        'hour' => 'Jam',
        'minute' => 'Menit',
        'second' => 'Detik',
        'title' => 'Judul',
        'content' => 'Konten',
        'description' => 'Deskripsi',
        'excerpt' => 'Kutipan',
        'date' => 'Tanggal',
        'time' => 'Waktu',
        'available' => 'Tersedia',
        'size' => 'Ukuran',
        'fullname' => 'Nama Lengkap',
        'school_id' => 'Sekolah',
        'role' => 'Peran',
        'status' => 'Status',
    ],

];
