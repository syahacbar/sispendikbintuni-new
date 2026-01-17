@php
    $footerMode = \App\Models\SysSetting::getValue('footer_mode', 'classic');
    $footerColumns = (int) \App\Models\SysSetting::getValue('footer_columns', 3);
    $footerBgColor = \App\Models\SysSetting::getValue('footer_bg_color', '#212529');
@endphp

<footer class="text-white pt-5 pb-3 mb-4" style="background-color: {{ $footerBgColor }};">
    <div class="container">
        <div class="row align-items-start mb-4">
            <div class="col-lg-3">
                <div class="mb-3 d-flex gap-2 justify-content-start align-items-center">
                    <img class="logoFooter mr-3" src="{{ asset('themes/frontend/logo.png') }}"
                        alt="{{ $pengaturan['site_name'] ?? 'SERASI' }}" style="max-width: 60px;">
                    <h6 class="mb-0">
                        <strong class="text-success fw-bold">
                            {{ $pengaturan['site_name'] ?? 'SERASI' }}
                        </strong>
                    </h6>
                </div>

                <p class="small text-white-50 mb-3">
                    {{ $pengaturan['site_description'] ?? 'Sistem informasi pendidikan yang menyediakan data dan informasi pendidikan.' }}
                </p>
            </div>

            <div class="col-lg-9 mt-4 mt-md-0">
                <div class="row mt-4">
                    @if ($footerMode === 'classic')
                        {{-- CLASSIC MODE - 3 Column Fixed --}}
                        @php
                            $footerNavigasi =
                                json_decode(\App\Models\SysSetting::getValue('footer_navigasi', '[]'), true) ?? [];
                            $footerLink = json_decode(\App\Models\SysSetting::getValue('footer_link', '[]'), true) ?? [];
                            $footerKemendikdasmen =
                                json_decode(\App\Models\SysSetting::getValue('footer_kemendikdasmen', '[]'), true) ?? [];
                        @endphp

                        <div class="col-lg-4">
                            <h6 class="text-success fw-bold">NAVIGASI</h6>
                            <ul class="list-unstyled small">
                                @forelse($footerNavigasi ?? [] as $item)
                                    <li>
                                        <a href="{{ $item['url'] ?? '#' }}"
                                            class="text-white text-decoration-none">{{ $item['label'] ?? 'Tidak ada label' }}</a>
                                    </li>
                                @empty
                                    <li class="text-white-50">Belum ada data navigasi</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="col-lg-4">
                            <h6 class="text-success fw-bold">LINK UMUM</h6>
                            <ul class="list-unstyled small">
                                @forelse($footerLink ?? [] as $item)
                                    <li>
                                        <a href="{{ $item['url'] ?? '#' }}"
                                            class="text-white text-decoration-none">{{ $item['label'] ?? 'Tidak ada label' }}</a>
                                    </li>
                                @empty
                                    <li class="text-white-50">Belum ada data link umum</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="col-lg-4">
                            <h6 class="text-success fw-bold">KEMENDIKDASMEN</h6>
                            <ul class="list-unstyled small">
                                @forelse($footerKemendikdasmen ?? [] as $item)
                                    <li>
                                        <a href="{{ $item['url'] ?? '#' }}"
                                            class="text-white text-decoration-none">{{ $item['label'] ?? 'Tidak ada label' }}</a>
                                    </li>
                                @empty
                                    <li class="text-white-50">Belum ada data Kemendikdasmen</li>
                                @endforelse
                            </ul>
                        </div>
                    @else
                        {{-- WIDGET MODE - Dynamic Columns --}}
                        @php
                            $colClass = match ($footerColumns) {
                                2 => 'col-lg-6',
                                3 => 'col-lg-4',
                                4 => 'col-lg-3',
                                default => 'col-lg-4',
                            };
                        @endphp

                        @for ($i = 1; $i <= $footerColumns; $i++)
                            @php
                                $widgetData = json_decode(
                                    \App\Models\SysSetting::getValue("footer_widget_{$i}", '{}'),
                                    true,
                                );
                                $widgetEnabled = $widgetData['enabled'] ?? false;
                                $widgetTitle = $widgetData['title'] ?? '';
                                $widgetType = $widgetData['type'] ?? 'custom_text';
                            @endphp

                            @if ($widgetEnabled)
                                <div class="{{ $colClass }} mb-4 mb-lg-0">
                                    @if ($widgetTitle)
                                        <h6 class="text-success fw-bold text-uppercase">{{ $widgetTitle }}</h6>
                                    @endif

                                    @if ($widgetType === 'navigation')
                                        {{-- Navigation Links Widget --}}
                                        <ul class="list-unstyled small">
                                            @foreach (($widgetData['links'] ?? []) as $link)
                                                <li class="mb-2">
                                                    <a href="{{ $link['url'] ?? '#' }}" class="text-white text-decoration-none hover-link">
                                                        {{ $link['label'] ?? 'Link' }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @elseif ($widgetType === 'custom_text')
                                        {{-- Custom Text/HTML Widget --}}
                                        <div class="small custom-html-content">
                                            {!! $widgetData['content'] ?? '' !!}
                                        </div>
                                    @elseif ($widgetType === 'contact')
                                        {{-- Contact Info Widget --}}
                                        <ul class="list-unstyled small">
                                            @if (!empty($widgetData['address']))
                                                <li class="mb-2">
                                                    <i class="bi bi-geo-alt me-2"></i>{{ $widgetData['address'] }}
                                                </li>
                                            @endif
                                            @if (!empty($widgetData['phone']))
                                                <li class="mb-2">
                                                    <i class="bi bi-telephone me-2"></i>{{ $widgetData['phone'] }}
                                                </li>
                                            @endif
                                            @if (!empty($widgetData['email']))
                                                <li class="mb-2">
                                                    <i class="bi bi-envelope me-2"></i>
                                                    <a href="mailto:{{ $widgetData['email'] }}" class="text-white text-decoration-none">
                                                        {{ $widgetData['email'] }}
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    @elseif ($widgetType === 'social_media')
                                        {{-- Social Media Widget --}}
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach (($widgetData['platforms'] ?? []) as $platform)
                                                @php
                                                    $iconMap = [
                                                        'facebook' => 'bi-facebook',
                                                        'instagram' => 'bi-instagram',
                                                        'twitter' => 'bi-twitter',
                                                        'youtube' => 'bi-youtube',
                                                        'tiktok' => 'bi-tiktok',
                                                        'linkedin' => 'bi-linkedin',
                                                    ];
                                                    $icon = $iconMap[$platform['platform']] ?? 'bi-link';
                                                @endphp
                                                <a href="{{ $platform['url'] ?? '#' }}" class="text-white text-decoration-none"
                                                    target="_blank">
                                                    <i class="bi {{ $icon }} fs-4"></i>
                                                </a>
                                            @endforeach
                                        </div>
                                    @elseif ($widgetType === 'recent_posts')
                                        {{-- Recent Posts Widget --}}
                                        @php
                                            $postCount = $widgetData['post_count'] ?? 5;
                                            $showDate = $widgetData['show_date'] ?? true;
                                            $recentPosts = \App\Models\ExtInformasi::where('status', 'published')
                                                ->orderBy('published_at', 'desc')
                                                ->limit($postCount)
                                                ->get();
                                        @endphp
                                        <ul class="list-unstyled small">
                                            @forelse($recentPosts as $post)
                                                <li class="mb-3">
                                                    <a href="{{ url('/informasi/' . $post->slug) }}"
                                                        class="text-white text-decoration-none hover-link">
                                                        {{ Str::limit($post->title, 50) }}
                                                    </a>
                                                    @if ($showDate && $post->published_at)
                                                        <br>
                                                        <small class="text-white-50">
                                                            {{ \Carbon\Carbon::parse($post->published_at)->format('d M Y') }}
                                                        </small>
                                                    @endif
                                                </li>
                                            @empty
                                                <li class="text-white-50">Belum ada post</li>
                                            @endforelse
                                        </ul>
                                    @endif
                                </div>
                            @endif
                        @endfor
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center border-top border-secondary pt-3 mt-3 mb-4">
            <span
                class="small">{{ $pengaturan['copyright'] ?? 'Hak Cipta SERASI Kabupaten Teluk Bintuni © 2025' }}</span>
        </div>
    </div>
</footer>

<style>
    .hover-link:hover {
        color: #28a745 !important;
        transition: color 0.3s ease;
    }

    .custom-html-content p {
        margin-bottom: 0.5rem;
    }

    .custom-html-content a {
        color: #fff;
        text-decoration: none;
    }

    .custom-html-content a:hover {
        color: #28a745;
    }
</style>