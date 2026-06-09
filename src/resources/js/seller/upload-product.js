
document.addEventListener('DOMContentLoaded', () => {
    const textarea  = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');
    if(textarea && charCount) {
        charCount.textContent = textarea.value.length;
    }
});

// =============================================
// CHAR COUNTER FOR TEXTAREA
// =============================================
const textarea  = document.getElementById('deskripsi');
const charCount = document.getElementById('charCount');

if (textarea && charCount) {
    textarea.addEventListener('input', () => {
        charCount.textContent = textarea.value.length;
    });
}

// =============================================
// PRICE INPUT FORMATTER (RUPIAH STYLE)
// =============================================
const hargaInput = document.getElementById('harga');

if (hargaInput) {
    hargaInput.addEventListener('input', (e) => {
        let raw = e.target.value.replace(/\D/g, '');
        e.target.value = raw ? parseInt(raw, 10).toLocaleString('id-ID') : '';
    });
}

// =============================================
// PHOTO UPLOAD: DRAG & DROP + FILE INPUT
// =============================================
const dropzone    = document.getElementById('uploadDropzone');
const fotoInput   = document.getElementById('fotoInput');
const btnPilih    = document.getElementById('btnPilihFoto');
const placeholder = document.getElementById('uploadPlaceholder');
const previewGrid = document.getElementById('uploadPreviewGrid');

let uploadedFiles = [];

if (btnPilih && fotoInput) {
    btnPilih.addEventListener('click', () => fotoInput.click());
}

if (dropzone && fotoInput) {
    dropzone.addEventListener('click', (e) => {
        if (e.target === dropzone || e.target.closest('.upload-placeholder')) {
            fotoInput.click();
        }
    });

    fotoInput.addEventListener('change', (e) => {
        handleFiles(Array.from(e.target.files));
    });

    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('drag-over');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('drag-over');
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('drag-over');
        const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
        handleFiles(files);
    });
}

function handleFiles(files) {
    if (!files.length) return;

    files.forEach(file => {
        if (uploadedFiles.length >= 6) return; 
        uploadedFiles.push(file);

        const reader = new FileReader();
        reader.onload = (ev) => {
            addPreviewThumb(ev.target.result, uploadedFiles.length - 1);
        };
        reader.readAsDataURL(file);
    });

    if (placeholder && previewGrid) {
        placeholder.style.display = 'none';
        previewGrid.style.display = 'grid';
    }
}

function addPreviewThumb(src, index) {
    if (!previewGrid) return;
    
    const thumb = document.createElement('div');
    thumb.className = 'preview-thumb';
    thumb.dataset.index = index;
    thumb.innerHTML = `
        <img src="${src}" alt="Preview foto ${index + 1}">
        <button type="button" class="preview-remove" data-index="${index}" aria-label="Hapus foto">
            <i class="bi bi-x-lg"></i>
        </button>
    `;
    previewGrid.appendChild(thumb);

    updateAddMoreBtn();

    thumb.querySelector('.preview-remove').addEventListener('click', (e) => {
        e.stopPropagation();
        removePhoto(parseInt(e.currentTarget.dataset.index));
    });
}

function updateAddMoreBtn() {
    if (!previewGrid) return;
    const existing = previewGrid.querySelector('.preview-add-more');
    if (uploadedFiles.length < 6) {
        if (!existing) {
            const addBtn = document.createElement('div');
            addBtn.className = 'preview-add-more';
            addBtn.innerHTML = `<i class="bi bi-plus-lg"></i>`;
            addBtn.addEventListener('click', () => fotoInput.click());
            previewGrid.appendChild(addBtn);
        }
    } else if (existing) {
        existing.remove();
    }
}

function removePhoto(index) {
    uploadedFiles.splice(index, 1);
    if (!previewGrid || !placeholder) return;
    
    previewGrid.innerHTML = '';
    if (uploadedFiles.length === 0) {
        placeholder.style.display = 'flex';
        previewGrid.style.display = 'none';
        return;
    }
    uploadedFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = (ev) => addPreviewThumb(ev.target.result, i);
        reader.readAsDataURL(file);
    });
}

// =============================================
// SUBMIT BUTTON STATE & ACTUAL FORM SUBMIT
// =============================================
const btnSubmit = document.getElementById('btnSubmitUnggah');
const formElement = document.getElementById('formUnggahBarang');

if (btnSubmit && formElement) {
    btnSubmit.addEventListener('click', () => {
        const nama      = document.getElementById('namaBarang').value.trim();
        const deskripsi = document.getElementById('deskripsi').value.trim();
        const harga     = document.getElementById('harga').value.trim();
        const kondisi   = document.getElementById('kondisi').value;
        const kategori  = document.getElementById('kategori').value;

        if (!nama || !deskripsi || !harga || !kondisi || !kategori) {
            btnSubmit.classList.add('shake');
            btnSubmit.textContent = 'Lengkapi semua field terlebih dahulu';
            setTimeout(() => {
                btnSubmit.classList.remove('shake');
                btnSubmit.innerHTML = '<i class="bi bi-send-fill"></i> Menunggu Verifikasi';
            }, 2500);
            return;
        }

        // Strip non-numeric characters from price before submit
        document.getElementById('harga').value = harga.replace(/\D/g, '');

        // Sync uploadedFiles array with the actual file input
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => dataTransfer.items.add(file));
        document.getElementById('fotoInput').files = dataTransfer.files;

        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Mengirim...';
        btnSubmit.disabled = true;
        
        formElement.submit();
    });
}