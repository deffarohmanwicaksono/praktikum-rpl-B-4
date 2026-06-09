document.addEventListener('DOMContentLoaded', () => {

    // =====================================================
    // ELEMENTS
    // =====================================================

    const textarea = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');

    const hargaInput = document.getElementById('harga');

    const fotoMainImg = document.getElementById('fotoMainImg');
    const fotoEmptyState = document.getElementById('fotoEmptyState');
    const thumbStrip = document.getElementById('fotoThumbStrip');

    const modalHapusFoto = document.getElementById('modalHapusFoto');
    const btnHapusFoto = document.getElementById('btnHapusFotoAktif');

    const btnGantiFoto = document.getElementById('btnGantiFoto');
    const fotoUploadNew = document.getElementById('fotoUploadNew');
    const fotoInputBaru = document.getElementById('fotoInputBaru');

    const btnPilihFotoBaru = document.getElementById('btnPilihFotoBaru');
    const btnEmptyPilihFoto = document.getElementById('btnEmptyPilihFoto');

    const uploadDropzoneSm = document.getElementById('uploadDropzoneSm');

    const formEditBarang = document.getElementById('formEditBarang');

    // =====================================================
    // CONFIG
    // =====================================================

    const MAX_FILE_SIZE = 5 * 1024 * 1024;
    const MAX_TOTAL_PHOTO = 6;

    const ALLOWED_TYPES = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    // =====================================================
    // EMPTY STATE
    // =====================================================

    const showEmptyState = () => {

        fotoMainImg.classList.add('d-none');

        document
            .querySelector('.foto-main-badge')
            ?.classList.add('d-none');

        fotoEmptyState.classList.remove('d-none');
    };

    const hideEmptyState = () => {

        fotoMainImg.classList.remove('d-none');

        document
            .querySelector('.foto-main-badge')
            ?.classList.remove('d-none');

        fotoEmptyState.classList.add('d-none');
    };

    // =====================================================
    // INITIAL CHECK
    // =====================================================

    const initialThumbs = thumbStrip.querySelectorAll('.foto-thumb');
    
    if (initialThumbs.length === 0) {
        showEmptyState();
    } else {
        const activeThumb = thumbStrip.querySelector('.foto-thumb.active');
        if (activeThumb) {
            updateMainImage(activeThumb.dataset.src);
        }
    }

    let uploadedFiles = [];

    // =====================================================
    // CHAR COUNTER
    // =====================================================

    if (textarea && charCount) {

        const updateCharCounter = () => {
            charCount.textContent = textarea.value.length;
        };

        updateCharCounter();

        textarea.addEventListener('input', updateCharCounter);
    }

    // =====================================================
    // PRICE FORMATTER
    // =====================================================

    if (hargaInput) {

        hargaInput.addEventListener('input', (e) => {

            const rawValue =
                e.target.value.replace(/\D/g, '');

            e.target.value = rawValue
                ? parseInt(rawValue, 10).toLocaleString('id-ID')
                : '';
        });
    }

    // =====================================================
    // UPDATE MAIN IMAGE
    // =====================================================

    const updateMainImage = (src) => {

        if (!src) {
            showEmptyState();
            return;
        }

        hideEmptyState();

        fotoMainImg.style.opacity = '0';

        setTimeout(() => {

            fotoMainImg.src = src;
            fotoMainImg.style.opacity = '1';

        }, 150);
    };

    // =====================================================
    // THUMBNAIL CLICK
    // =====================================================

    if (thumbStrip) {

        thumbStrip.addEventListener('click', (e) => {

            const thumb =
                e.target.closest('.foto-thumb');

            if (!thumb) return;

            thumbStrip
                .querySelectorAll('.foto-thumb')
                .forEach(item => {
                    item.classList.remove('active');
                });

            thumb.classList.add('active');

            updateMainImage(thumb.dataset.src);
        });
    }

    // =====================================================
    // DELETE MODAL
    // =====================================================

    const openDeleteModal = () => {

        modalHapusFoto.classList.add('open');

        document.body.style.overflow = 'hidden';
    };

    const closeDeleteModal = () => {

        modalHapusFoto.classList.remove('open');

        document.body.style.overflow = '';
    };

    btnHapusFoto?.addEventListener(
        'click',
        openDeleteModal
    );

    document
        .getElementById('modalHapusBatal')
        ?.addEventListener(
            'click',
            closeDeleteModal
        );

    document
        .getElementById('modalHapusKonfirm')
        ?.addEventListener('click', () => {

            const activeThumb =
                thumbStrip.querySelector('.foto-thumb.active');

            if (!activeThumb) {
                closeDeleteModal();
                return;
            }

            // If it's an existing image, remove the hidden input
            const imageId = activeThumb.dataset.imageId;
            if (imageId) {
                const hiddenInput = document.querySelector(`input[name="existing_images[]"][value="${imageId}"]`);
                if (hiddenInput) hiddenInput.remove();
            } else {
                // If it's a newly uploaded file, we need to remove it from uploadedFiles
                // The index in uploadedFiles matches the order of new thumbnails
                // A reliable way is to recalculate uploadedFiles or just attach a file object to the thumb
                // For simplicity, we just filter it out based on the data-index if we were storing it,
                // but since we just append to uploadedFiles, let's keep track:
                const fileIndex = activeThumb.dataset.fileIndex;
                if (fileIndex !== undefined) {
                    uploadedFiles.splice(fileIndex, 1);
                    // Re-index remaining new thumbs
                    const newThumbs = thumbStrip.querySelectorAll('.foto-thumb:not([data-image-id])');
                    newThumbs.forEach((th, idx) => { th.dataset.fileIndex = idx; });
                }
            }

            activeThumb.remove();

            const remainingThumbs =
                thumbStrip.querySelectorAll('.foto-thumb');

            if (remainingThumbs.length > 0) {

                remainingThumbs[0].classList.add('active');

                updateMainImage(
                    remainingThumbs[0].dataset.src
                );

            } else {

                showEmptyState();
            }

            closeDeleteModal();
        });

    // =====================================================
    // TOGGLE UPLOAD PANEL
    // =====================================================

    if (btnGantiFoto && fotoUploadNew) {

        btnGantiFoto.addEventListener('click', () => {

            const isVisible =
                fotoUploadNew.style.display === 'block';

            fotoUploadNew.style.display =
                isVisible ? 'none' : 'block';

            btnGantiFoto.innerHTML = isVisible
                ? `
                    <i class="bi bi-arrow-repeat"></i>
                    Tambah / Ganti Foto
                `
                : `
                    <i class="bi bi-x-lg"></i>
                    Tutup Upload
                `;
        });
    }

    // =====================================================
    // OPEN FILE PICKER
    // =====================================================

    btnPilihFotoBaru?.addEventListener('click', () => {
        fotoInputBaru.click();
    });

    btnEmptyPilihFoto?.addEventListener('click', () => {
        fotoInputBaru.click();
    });

    // =====================================================
    // DRAG & DROP
    // =====================================================

    if (uploadDropzoneSm) {

        ['dragenter', 'dragover'].forEach(eventName => {

            uploadDropzoneSm.addEventListener(
                eventName,
                (e) => {

                    e.preventDefault();

                    uploadDropzoneSm.classList.add('dragover');
                }
            );
        });

        ['dragleave', 'drop'].forEach(eventName => {

            uploadDropzoneSm.addEventListener(
                eventName,
                (e) => {

                    e.preventDefault();

                    uploadDropzoneSm.classList.remove('dragover');
                }
            );
        });

        uploadDropzoneSm.addEventListener('drop', (e) => {

            const files = e.dataTransfer.files;

            handleFiles(files);
        });
    }

    // =====================================================
    // FILE INPUT CHANGE
    // =====================================================

    fotoInputBaru?.addEventListener('change', (e) => {

        handleFiles(e.target.files);

        e.target.value = '';
    });

    // =====================================================
    // HANDLE FILES
    // =====================================================

    const handleFiles = (files) => {

        if (!files || files.length === 0) return;

        const currentPhotos =
            thumbStrip.querySelectorAll('.foto-thumb').length;

        if (currentPhotos >= MAX_TOTAL_PHOTO) {

            alert(`Maksimal ${MAX_TOTAL_PHOTO} foto`);

            return;
        }

        Array.from(files).forEach(file => {

            // VALIDATE TYPE
            if (!ALLOWED_TYPES.includes(file.type)) {

                alert(
                    `${file.name} bukan format gambar yang didukung`
                );

                return;
            }

            // VALIDATE SIZE
            if (file.size > MAX_FILE_SIZE) {

                alert(
                    `${file.name} melebihi ukuran 5 MB`
                );

                return;
            }

            // VALIDATE TOTAL
            const totalNow =
                thumbStrip.querySelectorAll('.foto-thumb').length;

            if (totalNow >= MAX_TOTAL_PHOTO) {

                alert(`Maksimal ${MAX_TOTAL_PHOTO} foto`);

                return;
            }

            uploadedFiles.push(file);
            createThumbnail(file, uploadedFiles.length - 1);
        });
    };

    // =====================================================
    // CREATE THUMBNAIL
    // =====================================================

    const createThumbnail = (file, fileIndex) => {

        const reader = new FileReader();

        reader.onload = (event) => {

            const imageSrc = event.target.result;

            hideEmptyState();

            const thumb = document.createElement('div');

            thumb.className = 'foto-thumb';

            thumb.dataset.src = imageSrc;
            thumb.dataset.fileIndex = fileIndex;

            thumb.innerHTML = `
                <img
                    src="${imageSrc}"
                    alt="Preview Foto"
                >
            `;

            thumbStrip.insertBefore(
                thumb,
                btnHapusFoto
            );

            const allThumbs =
                thumbStrip.querySelectorAll('.foto-thumb');

            if (allThumbs.length === 1) {

                thumb.classList.add('active');

                updateMainImage(imageSrc);
            }
        };

        reader.readAsDataURL(file);
    };

    // =====================================================
    // FORM VALIDATION
    // =====================================================

    document
        .getElementById('btnSimpanPerubahan')
        ?.addEventListener('click', () => {

            const namaBarang =
                document
                    .getElementById('namaBarang')
                    .value
                    .trim();

            const deskripsi =
                document
                    .getElementById('deskripsi')
                    .value
                    .trim();

            const harga =
                document
                    .getElementById('harga')
                    .value
                    .trim();

            const kondisi =
                document
                    .getElementById('kondisi')
                    .value;

            const kategori =
                document
                    .getElementById('kategori')
                    .value;

            if (!namaBarang) {

                alert('Nama barang wajib diisi');

                return;
            }

            if (namaBarang.length < 3) {

                alert(
                    'Nama barang minimal 3 karakter'
                );

                return;
            }

            if (!deskripsi) {

                alert('Deskripsi wajib diisi');

                return;
            }

            if (!harga) {

                alert('Harga wajib diisi');

                return;
            }

            if (!kondisi) {

                alert('Pilih kondisi barang');

                return;
            }

            if (!kategori) {

                alert('Pilih kategori barang');

                return;
            }

            // Strip non-numeric characters from price before submit
            document.getElementById('harga').value = harga.replace(/\D/g, '');

            // Sync uploadedFiles array with the actual file input
            const dataTransfer = new DataTransfer();
            uploadedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('fotoInputBaru').files = dataTransfer.files;

            formEditBarang.submit();
        });

});
