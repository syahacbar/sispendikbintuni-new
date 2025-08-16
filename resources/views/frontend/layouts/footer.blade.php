<footer class="bg-dark text-white pt-5 pb-3 mb-4">
    <div class="container">
        <div class="row align-items-start mb-4">
            <div class="col-sm-5">
                <div class="mb-3 d-flex gap-2 justify-content-start align-items-center">
                    <img class="w-25 mr-3" src="{{ asset('themes/frontend/logo.png') }}"
                        alt="{{ $pengaturan['site_name'] ?? 'SERASI' }}">
                    <h5>
                        <strong class="text-success fw-bold">
                            Dinas Pendidikan, Kebudayaan, Pemuda dan Olahraga Kabupaten Teluk Bintuni
                        </strong>
                    </h5>
                </div>
                <p class="small mb-1">
                    {{ $pengaturan['address'] ?? '' }}, {{ $pengaturan['postal_code'] ?? '' }} <br />
                    Telepon: {{ $pengaturan['phone'] ?? '' }} <br />
                    Email: <a href="mailto:{{ $pengaturan['email'] ?? '' }}" class="text-white text-decoration-none">
                        <i class="fas fa-envelope me-1"></i>
                        {{ $pengaturan['email'] ?? '' }} </a>
                </p>

                <div class="d-flex mt-3">
                    <a href="{{ $pengaturan['youtube'] ?? '' }}" class="text-white me-3"><i
                            class="bi bi-youtube fs-5"></i></a>
                    <a href="{{ $pengaturan['twitter'] ?? '' }}" class="text-white me-3"><i
                            class="bi bi-twitter fs-5"></i></a>
                    <a href="{{ $pengaturan['facebook'] ?? '' }}" class="text-white me-3"><i
                            class="bi bi-facebook fs-5"></i></a>
                    <a href="{{ $pengaturan['instagram'] ?? '' }}" class="text-white me-3"><i
                            class="bi bi-instagram fs-5"></i></a>
                </div>
            </div>

            <div class="col-lg-7 mt-4 mt-md-0">
                <div class="row mt-4">
                    @php
                        $footerNavigasi =
                            json_decode(\App\Models\SysSetting::getValue('footer_navigasi', '[]'), true) ?? [];
                        $footerLink = json_decode(\App\Models\SysSetting::getValue('footer_link', '[]'), true) ?? [];
                        $footerKemendikdasmen =
                            json_decode(\App\Models\SysSetting::getValue('footer_kemendikdasmen', '[]'), true) ?? [];
                    @endphp

                    <div class="row">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center border-top border-secondary pt-3 mt-3 mb-4">
            <i class="fas fa-university fa-2x text-success me-2"></i>
        </div>
    </div>
</footer>
