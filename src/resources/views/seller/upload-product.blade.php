@extends('layouts.app')

@section('title', 'Unggah Barang - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/upload-product.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/seller/upload-product.js')
@endpush

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="page-title-group">
        <h1 class="page-title">Unggah Barang</h1>
        <p class="page-subtitle">Lengkapi informasi barang yang akan kamu jual</p>
    </div>
</section>

{{-- FORM UNGGAH BARANG --}}
<section class="form-section">
    <form action="{{ route('seller.product.store') }}" method="POST" enctype="multipart/form-data" id="formUnggahBarang">
        @csrf

        <div class="row g-4">

            <div class="col-lg-7 col-xl-7">

                <div class="form-card mb-4">
                    <div class="form-card-body">
                        <div class="form-group-custom">
                            <label class="form-label-custom" for="namaBarang">
                                Nama Barang <span class="required-star">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-input-custom @error('name') is-invalid @enderror"
                                id="namaBarang"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Contoh: Buku Kalkulus Stewart Edisi 8"
                                autocomplete="off"
                            >
                            @error('name')
                                <span class="input-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-card mb-4">
                    <div class="form-card-body">
                        <div class="form-group-custom">
                            <label class="form-label-custom" for="deskripsi">
                                Deskripsi <span class="required-star">*</span>
                            </label>
                            <textarea
                                class="form-input-custom form-textarea-custom @error('description') is-invalid @enderror"
                                id="deskripsi"
                                name="description"
                                placeholder="Jelaskan kondisi, kelebihan, dan detail lainnya..."
                                maxlength="1000"
                                rows="6"
                            >{{ old('description') }}</textarea>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <div>
                                    @error('description')
                                        <span class="input-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="char-counter">
                                    <span id="charCount">0</span> / 1000
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-card mb-4">
                    <div class="form-card-body">
                        <div class="form-group-custom">
                            <label class="form-label-custom" for="harga">
                                Harga (Rp) <span class="required-star">*</span>
                            </label>
                            <div class="price-input-wrapper">
                                <span class="price-prefix">Rp</span>
                                <input
                                    type="text"
                                    class="form-input-custom price-input @error('price') is-invalid @enderror"
                                    id="harga"
                                    name="price"
                                    value="{{ old('price') }}"
                                    placeholder="Masukkan harga jual"
                                    inputmode="numeric"
                                    autocomplete="off"
                                >
                            </div>
                            @error('price')
                                <span class="input-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="form-group-custom">
                                    <label class="form-label-custom" for="kondisi">
                                        Kondisi <span class="required-star">*</span>
                                    </label>
                                    <div class="select-wrapper">
                                        <select class="form-input-custom form-select-custom @error('condition') is-invalid @enderror" id="kondisi" name="condition">
                                            <option value="" disabled {{ old('condition') ? '' : 'selected' }}>Pilih kondisi</option>
                                            <option value="bekas_seperti_baru" {{ old('condition') == 'bekas_seperti_baru' ? 'selected' : '' }}>Bekas Seperti Baru</option>
                                            <option value="bekas_baik" {{ old('condition') == 'bekas_baik' ? 'selected' : '' }}>Bekas Baik</option>
                                            <option value="bekas_layak_pakai" {{ old('condition') == 'bekas_layak_pakai' ? 'selected' : '' }}>Bekas Layak Pakai</option>
                                        </select>
                                        <i class="bi bi-chevron-down select-chevron"></i>
                                    </div>
                                    @error('condition')
                                        <span class="input-error">{{ $message }}</span>
                                    @enderror
                                    <p class="form-hint">Pilih kondisi yang paling sesuai</p>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group-custom">
                                    <label class="form-label-custom" for="kategori">
                                        Kategori <span class="required-star">*</span>
                                    </label>
                                    <div class="select-wrapper">
                                        <select class="form-input-custom form-select-custom @error('kategori_id') is-invalid @enderror" id="kategori" name="kategori_id">
                                            <option value="" disabled {{ old('kategori_id') ? '' : 'selected' }}>Pilih kategori</option>
                                            <option value="1" {{ old('kategori_id') == '1' ? 'selected' : '' }}>Elektronik</option>
                                            <option value="2" {{ old('kategori_id') == '2' ? 'selected' : '' }}>Buku</option>
                                            <option value="3" {{ old('kategori_id') == '3' ? 'selected' : '' }}>Pakaian</option>
                                            <option value="4" {{ old('kategori_id') == '4' ? 'selected' : '' }}>Peralatan Kost</option>
                                            <option value="5" {{ old('kategori_id') == '5' ? 'selected' : '' }}>Alat Tulis</option>
                                            <option value="6" {{ old('kategori_id') == '6' ? 'selected' : '' }}>Sepatu & Tas</option>
                                            <option value="7" {{ old('kategori_id') == '7' ? 'selected' : '' }}>Olahraga</option>
                                            <option value="8" {{ old('kategori_id') == '8' ? 'selected' : '' }}>Kecantikan</option>
                                            <option value="9" {{ old('kategori_id') == '9' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                        <i class="bi bi-chevron-down select-chevron"></i>
                                    </div>
                                    @error('kategori_id')
                                        <span class="input-error">{{ $message }}</span>
                                    @enderror
                                    <p class="form-hint">Pilih kategori yang tersedia</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-5 col-xl-5">

                <div class="form-card mb-4">
                    <div class="form-card-body">
                        <div class="form-group-custom">
                            <label class="form-label-custom">
                                Foto Barang <span class="required-star">*</span>
                            </label>

                            <div class="upload-dropzone @error('images') is-invalid-zone @enderror" id="uploadDropzone">
                                <div class="upload-preview-grid d-none" id="uploadPreviewGrid"></div>

                                <div class="upload-placeholder" id="uploadPlaceholder">
                                    <div class="upload-icon-wrap">
                                        <i class="bi bi-image upload-img-icon"></i>
                                    </div>
                                    <p class="upload-title">Upload Foto Barang</p>
                                    <p class="upload-subtitle">Minimal 1 foto</p>
                                    <button type="button" class="btn-pilih-foto" id="btnPilihFoto">
                                        <i class="bi bi-plus-lg"></i> Pilih Foto
                                    </button>
                                </div>

                                <input
                                    type="file"
                                    id="fotoInput"
                                    name="images[]"
                                    multiple
                                    accept="image/png,image/jpeg,image/webp"
                                    class="d-none"
                                >
                            </div>

                            @error('images')
                                <span class="input-error">{{ $message }}</span>
                            @enderror
                            
                            <p class="upload-hint-text">
                                <i class="bi bi-info-circle"></i>
                                Upload foto yang jelas dan menarik untuk menarik pembeli
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-card submit-card">
                    <div class="form-card-body">
                        <p class="submit-card-label">Kirim</p>
                        <button type="button" class="btn-submit-unggah w-100" id="btnSubmitUnggah">
                            <i class="bi bi-send-fill"></i>
                            Menunggu Verifikasi
                        </button>
                        <p class="submit-hint">
                            Barang akan ditinjau oleh tim admin sebelum ditampilkan.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </form>
</section>

{{-- INFO PENTING BANNER --}}
<section class="info-banner mt-4">
    <div class="info-banner-inner">
        <i class="bi bi-info-circle-fill info-banner-icon"></i>
        <div>
            <span class="info-banner-title">Informasi Penting</span>
            <span class="info-banner-text">Pastikan semua informasi sudah benar. Barang akan diverifikasi oleh tim sebelum ditampilkan.</span>
        </div>
    </div>
</section>

@endsection