@extends('layouts.app')

@section('title', 'Edit Barang - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/edit-product.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/seller/edit-product.js')
@endpush

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="page-title-group">
        <h1 class="page-title">Edit Barang</h1>
        <p class="page-subtitle">Perbarui informasi barang kamu</p>
    </div>
</section>

{{-- FORM EDIT BARANG --}}
<section class="form-section">
    <form
        action="{{ route('seller.product.update', $product->id) }}"
        method="POST"
        enctype="multipart/form-data"
        id="formEditBarang"
        novalidate
    >
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- KOLOM KIRI --}}
            <div class="col-lg-7">

                {{-- NAMA BARANG --}}
                <div class="form-card mb-4">
                    <div class="form-card-body">

                        <div class="form-group-custom">

                            <label
                                class="form-label-custom"
                                for="namaBarang"
                            >
                                Nama Barang
                                <span class="required-star">*</span>
                            </label>

                            <input
                                type="text"
                                class="form-input-custom @error('name') is-invalid @enderror"
                                id="namaBarang"
                                name="name"
                                value="{{ old('name', $product->name) }}"
                                placeholder="Masukkan nama barang"
                                autocomplete="off"
                                maxlength="100"
                                required
                            >
                            @error('name')
                                <span class="input-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="form-card mb-4">
                    <div class="form-card-body">

                        <div class="form-group-custom">

                            <label
                                class="form-label-custom"
                                for="deskripsi"
                            >
                                Deskripsi
                                <span class="required-star">*</span>
                            </label>

                            <textarea
                                class="form-input-custom form-textarea-custom @error('description') is-invalid @enderror"
                                id="deskripsi"
                                name="description"
                                rows="6"
                                maxlength="1000"
                                placeholder="Jelaskan detail barang..."
                                required
                            >{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <span class="input-error">{{ $message }}</span>
                            @enderror

                            <div class="char-counter mt-1">
                                <span id="charCount">0</span> / 1000
                            </div>

                        </div>
                    </div>
                </div>

                {{-- HARGA --}}
                <div class="form-card mb-4">
                    <div class="form-card-body">

                        <div class="form-group-custom">

                            <label
                                class="form-label-custom"
                                for="harga"
                            >
                                Harga (Rp)
                                <span class="required-star">*</span>
                            </label>

                            <div class="price-input-wrapper">

                                <span class="price-prefix">
                                    Rp
                                </span>

                                <input
                                    type="text"
                                    class="form-input-custom price-input @error('price') is-invalid @enderror"
                                    id="harga"
                                    name="price"
                                    value="{{ old('price', $product->price) }}"
                                    placeholder="0"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    required
                                >

                            </div>
                            @error('price')
                                <span class="input-error">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>
                </div>

                {{-- KONDISI & KATEGORI --}}
                <div class="form-card">
                    <div class="form-card-body">

                        <div class="row g-3">

                            {{-- KONDISI --}}
                            <div class="col-md-6">

                                <div class="form-group-custom">

                                    <label
                                        class="form-label-custom"
                                        for="kondisi"
                                    >
                                        Kondisi
                                        <span class="required-star">*</span>
                                    </label>

                                    <div class="select-wrapper">

                                        <select
                                            class="form-input-custom form-select-custom @error('condition') is-invalid @enderror"
                                            id="kondisi"
                                            name="condition"
                                            required
                                        >
                                            <option value="" disabled {{ old('condition', $product->condition) ? '' : 'selected' }}>Pilih kondisi</option>
                                            <option value="bekas_seperti_baru" {{ old('condition', $product->condition) == 'bekas_seperti_baru' ? 'selected' : '' }}>Bekas Seperti Baru</option>
                                            <option value="bekas_baik" {{ old('condition', $product->condition) == 'bekas_baik' ? 'selected' : '' }}>Bekas Baik</option>
                                            <option value="bekas_layak_pakai" {{ old('condition', $product->condition) == 'bekas_layak_pakai' ? 'selected' : '' }}>Bekas Layak Pakai</option>

                                        </select>

                                        <i class="bi bi-chevron-down select-chevron"></i>

                                    </div>

                                    <p class="form-hint">
                                        Pilih kondisi yang paling sesuai
                                    </p>

                                </div>

                            </div>

                            {{-- KATEGORI --}}
                            <div class="col-md-6">

                                <div class="form-group-custom">

                                    <label
                                        class="form-label-custom"
                                        for="kategori"
                                    >
                                        Kategori
                                        <span class="required-star">*</span>
                                    </label>

                                    <div class="select-wrapper">

                                        <select
                                            class="form-input-custom form-select-custom @error('category_id') is-invalid @enderror"
                                            id="kategori"
                                            name="category_id"
                                            required
                                        >
                                            <option value="" disabled {{ old('category_id', $product->category_id) ? '' : 'selected' }}>Pilih kategori</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>

                                        <i class="bi bi-chevron-down select-chevron"></i>

                                    </div>

                                    <p class="form-hint">
                                        Pilih kategori yang tersedia
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div class="col-lg-5">

                {{-- FOTO --}}
                <div class="form-card mb-4">
                    <div class="form-card-body">

                        <div class="form-group-custom">

                            <label class="form-label-custom mb-2">
                                Foto Barang
                                <span class="required-star">*</span>
                            </label>

                            {{-- MAIN PREVIEW --}}
                            <div
                                class="foto-main-preview"
                                id="fotoMainPreview"
                            >

                                {{-- EMPTY STATE --}}
                                <div
                                    class="foto-empty-state d-none"
                                    id="fotoEmptyState"
                                >

                                    <div class="upload-icon-wrap">
                                        <i class="bi bi-image upload-img-icon"></i>
                                    </div>

                                    <p class="upload-title">
                                        Belum ada foto
                                    </p>

                                    <p class="upload-subtitle">
                                        Minimal 1 foto
                                    </p>

                                    <button
                                        type="button"
                                        class="btn-pilih-foto"
                                        id="btnEmptyPilihFoto"
                                    >
                                        <i class="bi bi-plus-lg"></i>
                                        Pilih Foto
                                    </button>

                                </div>

                                {{-- MAIN IMAGE --}}
                                <img
                                    src="{{ asset('images/Elemen-1.png') }}"
                                    alt="Foto utama barang"
                                    id="fotoMainImg"
                                    class="foto-main-img"
                                >

                                <span class="foto-main-badge">
                                    Foto Utama
                                </span>

                            </div>

                            {{-- THUMB STRIP --}}
                            <div
                                class="foto-thumb-strip"
                                id="fotoThumbStrip"
                            >

                                @foreach ($product->productImages as $index => $image)
                                    @php
                                        $imgUrl = str_starts_with($image->image_url, 'http') 
                                            ? $image->image_url 
                                            : (str_starts_with($image->image_url, 'products/') ? asset('storage/' . $image->image_url) : asset($image->image_url));
                                    @endphp
                                    <div
                                        class="foto-thumb {{ $index === 0 ? 'active' : '' }}"
                                        data-index="{{ $index }}"
                                        data-src="{{ $imgUrl }}"
                                        data-image-id="{{ $image->id }}"
                                    >
                                        <img
                                            src="{{ $imgUrl }}"
                                            alt="Foto Barang"
                                        >
                                    </div>
                                    <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                                @endforeach

                                {{-- BUTTON HAPUS --}}
                                <button
                                    type="button"
                                    class="foto-thumb-hapus"
                                    id="btnHapusFotoAktif"
                                    aria-label="Hapus foto aktif"
                                >
                                    <i class="bi bi-trash3-fill"></i>
                                    <span>Hapus</span>
                                </button>

                            </div>

                            <p class="foto-hint-text">
                                <i class="bi bi-info-circle"></i>
                                Klik foto untuk menjadikannya foto utama
                            </p>

                            {{-- PANEL UPLOAD --}}
                            <div
                                class="foto-upload-new"
                                id="fotoUploadNew"
                            >

                                <div
                                    class="upload-dropzone-sm"
                                    id="uploadDropzoneSm"
                                >

                                    <input
                                        type="file"
                                        id="fotoInputBaru"
                                        name="images[]"
                                        class="d-none"
                                        multiple
                                        accept="image/png,image/jpeg,image/webp"
                                    >

                                    <i class="bi bi-cloud-arrow-up upload-sm-icon"></i>

                                    <p class="upload-sm-text">

                                        Seret foto ke sini atau

                                        <button
                                            type="button"
                                            class="upload-sm-link"
                                            id="btnPilihFotoBaru"
                                        >
                                            pilih file
                                        </button>

                                    </p>

                                    <p class="upload-sm-hint">
                                        PNG, JPG, WEBP —
                                        Maks 5 MB per foto
                                    </p>

                                </div>

                            </div>

                            {{-- BUTTON TOGGLE --}}
                            <button
                                type="button"
                                class="btn-ganti-foto w-100 mt-3"
                                id="btnGantiFoto"
                            >
                                <i class="bi bi-arrow-repeat"></i>
                                Tambah / Ganti Foto
                            </button>

                        </div>

                    </div>
                </div>

                {{-- AKSI --}}
                <div class="form-card aksi-card">
                    <div class="form-card-body">

                        {{-- SIMPAN --}}
                        <button
                            type="button"
                            class="btn-simpan-perubahan w-100"
                            id="btnSimpanPerubahan"
                        >
                            <i class="bi bi-floppy2-fill"></i>
                            Simpan Perubahan
                        </button>

                        {{-- BATAL --}}
                        <a
                            href="{{ route('seller.dashboard-seller') }}"
                            class="btn-batal w-100"
                            id="btnBatal"
                        >
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Batal
                        </a>

                        <p class="aksi-hint">
                            Perubahan akan langsung terlihat
                            setelah disimpan.
                        </p>

                    </div>
                </div>

            </div>

        </div>
    </form>
</section>

{{-- INFO BANNER --}}
<section class="info-banner mt-4">

    <div class="info-banner-inner">

        <i class="bi bi-info-circle-fill info-banner-icon"></i>

        <div>

            <span class="info-banner-title">
                Catatan Penting
            </span>

            <span class="info-banner-text">
                Perubahan data barang akan diproses ulang
                oleh admin sebelum kembali ditampilkan ke publik.
            </span>

        </div>

    </div>

</section>

{{-- MODAL HAPUS FOTO --}}
<div
    class="modal-overlay-custom"
    id="modalHapusFoto"
>

    <div class="modal-card-custom">

        <div class="modal-header-custom">

            <div class="modal-header-icon modal-icon-danger">
                <i class="bi bi-trash3-fill"></i>
            </div>

            <div>

                <h4 class="modal-title-custom">
                    Hapus Foto Ini?
                </h4>

                <p class="modal-subtitle-custom">
                    Foto yang dihapus tidak dapat dikembalikan.
                </p>

            </div>

        </div>

        <div class="modal-footer-custom">

            {{-- BATAL --}}
            <button
                type="button"
                class="btn-modal-batal"
                id="modalHapusBatal"
            >
                Batal
            </button>

            {{-- HAPUS --}}
            <button
                type="button"
                class="btn-modal-hapus"
                id="modalHapusKonfirm"
            >
                <i class="bi bi-trash3-fill"></i>
                Hapus Foto
            </button>

        </div>

    </div>

</div>

@endsection
