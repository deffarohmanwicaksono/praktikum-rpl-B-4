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
        action="#"
        method="POST"
        enctype="multipart/form-data"
        id="formEditBarang"
        novalidate
    >
        @csrf

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
                                class="form-input-custom"
                                id="namaBarang"
                                name="nama_barang"
                                value="Buku Kalkulus Stewart Edisi 8"
                                placeholder="Masukkan nama barang"
                                autocomplete="off"
                                maxlength="100"
                                required
                            >

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
                                class="form-input-custom form-textarea-custom"
                                id="deskripsi"
                                name="deskripsi"
                                rows="6"
                                maxlength="1000"
                                placeholder="Jelaskan detail barang..."
                                required
                            >Buku Kalkulus karya James Stewart edisi 8.
Kondisi masih bagus, tidak ada coretan.
Cocok untuk mahasiswa semester awal.</textarea>

                            <div class="char-counter">
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
                                    class="form-input-custom price-input"
                                    id="harga"
                                    name="harga"
                                    value="120.000"
                                    placeholder="0"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    required
                                >

                            </div>

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
                                            class="form-input-custom form-select-custom"
                                            id="kondisi"
                                            name="kondisi"
                                            required
                                        >
                                            <option value="" disabled>
                                                Pilih kondisi
                                            </option>

                                            <option value="like_new" selected>
                                                Bekas Seperti Baru
                                            </option>

                                            <option value="baik">
                                                Bekas Baik
                                            </option>

                                            <option value="layak">
                                                Bekas Layak Pakai
                                            </option>

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
                                            class="form-input-custom form-select-custom"
                                            id="kategori"
                                            name="kategori_id"
                                            required
                                        >
                                            <option value="" disabled>Pilih kategori</option>
                                            <option value="1">Elektronik</option>
                                            <option value="2" selected>Buku</option>
                                            <option value="3">Pakaian</option>
                                            <option value="4">Peralatan Kost</option>
                                            <option value="5">Alat Tulis</option>
                                            <option value="6">Sepatu & Tas</option>
                                            <option value="7">Olahraga</option>
                                            <option value="8">Kecantikan</option>
                                            <option value="9">Lainnya</option>

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

                                {{-- THUMB 1 --}}
                                <div
                                    class="foto-thumb active"
                                    data-index="0"
                                    data-src="{{ asset('images/Elemen-1.png') }}"
                                >
                                    <img
                                        src="{{ asset('images/Elemen-1.png') }}"
                                        alt="Foto Barang"
                                    >
                                </div>

                                {{-- THUMB 2 --}}
                                <div
                                    class="foto-thumb"
                                    data-index="1"
                                    data-src="{{ asset('images/Elemen-1.png') }}"
                                >
                                    <img
                                        src="{{ asset('images/Elemen-1.png') }}"
                                        alt="Foto Barang"
                                    >
                                </div>

                                {{-- THUMB 3 --}}
                                <div
                                    class="foto-thumb"
                                    data-index="2"
                                    data-src="{{ asset('images/Elemen-1.png') }}"
                                >
                                    <img
                                        src="{{ asset('images/Elemen-1.png') }}"
                                        alt="Foto Barang"
                                    >
                                </div>

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
                                        name="foto_baru[]"
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
