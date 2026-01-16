@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @php
                $logo = \App\Models\SysSetting::where('key', 'logo')->value('value');
                $logoUrl = $logo ? asset('storage/' . $logo) : asset('themes/frontend/logoserasi.png');
            @endphp
            <img src="{{ $logoUrl }}" class="logo" alt="{{ config('app.name') }}">
        </a>
    </td>
</tr>