@php
    $file = asset('storage/' . $record->dok_lampiran);
    $ext = strtolower(pathinfo($record->dok_lampiran, PATHINFO_EXTENSION));
@endphp

<div class="space-y-4">
    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
        <img src="{{ $file }}" alt="Preview" class="w-full rounded shadow">
    @elseif ($ext === 'pdf')
        <iframe src="{{ $file }}" class="w-full rounded" style="height:500px;" frameborder="0"></iframe>
    @elseif (in_array($ext, ['doc', 'docx']))
        <div class="text-center">
            <p>File Word tidak bisa ditampilkan langsung di browser.</p>
            <a href="{{ $file }}" target="_blank" class="text-blue-600 underline">Klik di sini untuk membuka
                file</a>
        </div>
    @else
        <p>Preview tidak tersedia untuk file ini.</p>
        <a href="{{ $file }}" target="_blank" class="text-blue-600 underline">Unduh file</a>
    @endif
</div>
