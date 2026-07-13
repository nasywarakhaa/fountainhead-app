@extends('layouts.app')

@section('title', 'Pengaturan Situs')

@section('styles')
{{-- Tidak perlu lagi link untuk bootstrap-iconpicker --}}
<style>
/* Style yang sama persis dari modul sebelumnya */
.hover-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.hover-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important; }
.nav-tabs .nav-link { font-weight: 600; }
.nav-tabs .nav-link.active { color: #495057; background-color: #fff; border-color: #dee2e6 #dee2e6 #fff; }
.tab-content { border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 0.25rem 0.25rem; }
.img-preview { max-width: 200px; max-height: 80px; object-fit: contain; border-radius: 5px; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 text-white"><i class="fas fa-cog mr-2"></i>Pengaturan Situs</h3>
                            <p class="mb-0 text-white-50">Kelola semua pengaturan utama untuk website Anda</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.site-settings.create') }}" class="btn btn-light btn-lg"><i class="fas fa-plus mr-2"></i>Add Site Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #667eea;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total Pengaturan</h6>
                    <h3 class="mb-0 font-weight-bold" id="total-settings-count">-</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #764ba2;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Grup Pengaturan</h6>
                    <h3 class="mb-0 font-weight-bold" id="setting-groups-count">-</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #f093fb;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Terakhir Diperbarui</h6>
                    <h3 class="mb-0 font-weight-bold" id="last-updated-text">-</h3>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Kolom Kiri: Form Pengaturan -->
            <div class="col-lg-8">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        @php
                            function getSettingValue($group, $key, $default = '') {
                                return $group->firstWhere('key', $key)->value ?? $default;
                            }

                            // Grup dinamis dari $settings
                            $groupTranslations = collect($settings)->mapWithKeys(function ($_, $key) {
                                return [$key => ucfirst(str_replace('_', ' ', $key))];
                            })->toArray();
                            // Gabungkan hasil dinamis + custom
                            $groupTranslations = array_merge($groupTranslations);
                        @endphp


                        <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                            @foreach ($settings as $group => $groupSettings)
                                <li class="nav-item">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{$group}}-tab" data-toggle="tab" href="#{{$group}}" role="tab">{{ $groupTranslations[$group] ?? ucfirst($group) }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content p-3">
                            @foreach ($settings as $group => $groupSettings)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $group }}" role="tabpanel">
                                    @foreach($groupSettings as $setting)
                                        @php
                                            // Buat label yang ramah pengguna
                                            $label = match ($setting->key) {
                                                'site_name' => 'Nama Situs',
                                                'site_tagline' => 'Slogan / Tagline',
                                                'contact_email' => 'Email Kontak',
                                                'contact_phone' => 'Nomor Telepon',
                                                'contact_address' => 'Alamat Lengkap',
                                                'facebook_url' => 'Link Facebook',
                                                'instagram_url' => 'Link Instagram',
                                                'twitter_url' => 'Link Twitter',
                                                'youtube_url' => 'Link YouTube',
                                                'linkedin_url' => 'Link LinkedIn',
                                                'tiktok_url' => 'Link TikTok',
                                                'site_logo' => 'Logo Situs',
                                                'site_favicon' => 'Ikon Situs (Favicon)',
                                                'total_residents' => 'Jumlah Penghuni',
                                                'average_rating' => 'Rata-rata Penilaian',
                                                'events_hosted' => 'Jumlah Acara',
                                                default => ucwords(str_replace('_', ' ', $setting->key))
                                            };

                                            // Placeholder natural (hanya untuk UX)
                                            $placeholder = match (true) {
                                                str_contains($setting->key, 'email') => 'Masukkan alamat email aktif...',
                                                str_contains($setting->key, 'phone') => 'Masukkan nomor telepon...',
                                                str_contains($setting->key, 'url') => 'Masukkan tautan lengkap, contoh: https://...',
                                                str_contains($setting->key, 'address') => 'Masukkan alamat lengkap...',
                                                str_contains($setting->key, 'name') => 'Masukkan nama...',
                                                str_contains($setting->key, 'tagline') => 'Masukkan slogan singkat...',
                                                default => 'Masukkan nilai...'
                                            };

                                            $isFile = $setting->type === 'file';
                                            $isTextarea = $setting->type === 'textarea';
                                            $isBoolean = $setting->type === 'boolean';
                                        @endphp

                                        <div class="form-group">
                                            <label for="{{ $setting->key }}" class="font-weight-bold">{{ $label }}</label>

                                            {{-- Input File --}}
                                            @if($isFile)
                                                @if($setting->value)
                                                    <div class="mb-2">
                                                        @if(Str::contains($setting->value, ['.png','.jpg','.jpeg','.svg','.webp']))
                                                            <img src="{{ Storage::url($setting->value) }}" alt="{{ $label }}" class="img-preview d-block mb-2" style="max-height: 80px; object-fit: contain;">
                                                        @else
                                                            <a href="{{ Storage::url($setting->value) }}" target="_blank">{{ basename($setting->value) }}</a>
                                                        @endif
                                                    </div>
                                                @endif
                                                <div class="custom-file">
                                                    <input type="file" name="{{ $setting->key }}" id="{{ $setting->key }}" class="custom-file-input" accept="image/*">
                                                    <label class="custom-file-label" for="{{ $setting->key }}">Pilih gambar...</label>
                                                </div>

                                            {{-- Textarea --}}
                                            @elseif($isTextarea)
                                                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="4" class="form-control" placeholder="{{ $placeholder }}">{{ $setting->value }}</textarea>

                                            {{-- Boolean Switch --}}
                                            @elseif($isBoolean)
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="{{ $setting->key }}" name="{{ $setting->key }}" {{ $setting->value ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="{{ $setting->key }}">Aktifkan</label>
                                                </div>

                                            {{-- Default: Input Text --}}
                                            @else
                                                <input
                                                    type="text"
                                                    name="{{ $setting->key }}"
                                                    id="{{ $setting->key }}"
                                                    class="form-control"
                                                    value="{{ $setting->value }}"
                                                    placeholder="{{ $placeholder }}">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Aksi -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-lightbulb mr-2"></i>Tips Bermanfaat</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i>Gunakan logo format PNG transparan agar hasilnya bagus.</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i>Ukuran favicon idealnya kecil, seperti 32x32 piksel.</li>
                            <li><i class="fas fa-check-circle text-success mr-2"></i>Perubahan akan berlaku di seluruh situs setelah disimpan.</li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" style="border-radius: 10px; font-weight: 600;">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
{{-- Tidak perlu lagi script untuk bootstrap-iconpicker --}}
<script>
$(document).ready(function() {
    // Load Stats
    function loadStats() {
        $.ajax({
            url: '{{ route("admin.site-settings.stats") }}',
            type: 'GET',
            success: function(response) {
                $('#total-settings-count').text(response.total_settings || 0);
                $('#setting-groups-count').text(response.setting_groups || 0);
                $('#last-updated-text').text(response.last_updated || 'N/A');
            }
        });
    }
    loadStats();

    // File input label updater
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    // Image previewer function
    function readURL(input, previewElement, isFavicon = false) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                let style = isFavicon ? 'style="max-width: 32px; max-height: 32px; object-fit: contain;"' : '';
                $(previewElement).html('<img src="' + e.target.result + '" class="img-preview" ' + style + '>').show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#site_logo").change(function(){ readURL(this, '#logo-preview', false); });
    $("#site_favicon").change(function(){ readURL(this, '#favicon-preview', true); });

    // Prevent double submit
     $('form').on('submit', function(e) {
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');
    });
});
</script>
@endsection

