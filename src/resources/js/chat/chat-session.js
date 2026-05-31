const currentPOV = window.currentPOV || 'buyer';

const chatMessages = document.getElementById("chatMessages");
const chatInput = document.getElementById("chatInput");
const sendBtn = document.getElementById("sendBtn");
const emojiBtn = document.getElementById("emojiBtn");

document.addEventListener("DOMContentLoaded", function () {
    renderChatData(currentPOV);
    scrollToBottom();
});

function renderChatData(pov) {
    chatMessages.innerHTML = `
        <div class="msg-date-sep">
            <span>Hari ini, 12 Mei 2024</span>
        </div>
    `;

    const msg1_Class = (pov === 'buyer') ? 'msg-out' : 'msg-in';
    const msg2_Class = (pov === 'buyer') ? 'msg-in' : 'msg-out';
    const msg3_Class = (pov === 'buyer') ? 'msg-out' : 'msg-in';
    const msg4_Class = (pov === 'buyer') ? 'msg-in' : 'msg-out';

    chatMessages.innerHTML += `
        <div class="msg-row ${msg1_Class}">
            ${msg1_Class === 'msg-in'
                ? '<div class="msg-avatar"><i class="bi bi-person-circle"></i></div>'
                : ''}

            <div class="msg-bubble msg-bubble--${msg1_Class === 'msg-out' ? 'out' : 'in'}">
                <p class="msg-text">Halo kak, jaketnya masih ada?</p>
                ${msg1_Class === 'msg-out'
                    ? `
                        <div class="msg-out-meta">
                            <span class="msg-time msg-time--out">14:30</span>
                            <span class="msg-tick"><i class="bi bi-check2-all"></i></span>
                        </div>
                    `
                    : '<span class="msg-time">14:30</span>'
                }
            </div>

            ${msg1_Class === 'msg-out'
                ? '<div class="msg-avatar"><i class="bi bi-person-circle"></i></div>'
                : ''}
        </div>

        <div class="msg-row ${msg2_Class}">
            ${msg2_Class === 'msg-in'
                ? '<div class="msg-avatar"><i class="bi bi-person-circle"></i></div>'
                : ''}

            <div class="msg-bubble msg-bubble--${msg2_Class === 'msg-out' ? 'out' : 'in'}">
                <p class="msg-text">Iya kak, masih ada 😊</p>
                ${msg2_Class === 'msg-out'
                    ? `
                        <div class="msg-out-meta">
                            <span class="msg-time msg-time--out">14:31</span>
                            <span class="msg-tick"><i class="bi bi-check2-all"></i></span>
                        </div>
                    `
                    : '<span class="msg-time">14:31</span>'
                }
            </div>

            ${msg2_Class === 'msg-out'
                ? '<div class="msg-avatar"><i class="bi bi-person-circle"></i></div>'
                : ''}
        </div>

        <div class="msg-row ${msg3_Class}">
            ${msg3_Class === 'msg-in'
                ? '<div class="msg-avatar"><i class="bi bi-person-circle"></i></div>'
                : ''}

            <div class="msg-bubble msg-bubble--${msg3_Class === 'msg-out' ? 'out' : 'in'}">
                <p class="msg-text">Kak, link kadaluwarsa nih! Boleh minta yang baru?</p>
                ${msg3_Class === 'msg-out'
                    ? `
                        <div class="msg-out-meta">
                            <span class="msg-time msg-time--out">14:32</span>
                            <span class="msg-tick"><i class="bi bi-check2-all"></i></span>
                        </div>
                    `
                    : '<span class="msg-time">14:32</span>'
                }
            </div>

            ${msg3_Class === 'msg-out'
                ? '<div class="msg-avatar"><i class="bi bi-person-circle"></i></div>'
                : ''}
        </div>

        <div class="msg-row msg-system">
            <div class="msg-purchase-card msg-purchase-card--expired">
                <div class="msg-purchase-info">
                    <img src="/images/Elemen-1.png" alt="Produk" class="msg-purchase-img">
                    <div>
                        <span class="msg-purchase-title">Jaket Denim Pria</span>
                        <span class="msg-purchase-price">Rp 150.000</span>
                        <span class="msg-purchase-cond">
                            <i class="bi bi-exclamation-circle-fill"></i> Link Kadaluwarsa
                        </span>
                    </div>
                </div>
                <button type="button" class="msg-purchase-btn msg-purchase-btn--expired" disabled>
                    Sesi Berakhir
                </button>
            </div>
        </div>

        <div class="msg-row ${msg4_Class}">
            ${msg4_Class === 'msg-in'
                ? '<div class="msg-avatar"><i class="bi bi-person-circle"></i></div>'
                : ''}

            <div class="msg-bubble msg-bubble--${msg4_Class === 'msg-out' ? 'out' : 'in'}">
                <div class="msg-quote">
                    <span class="msg-quote-author">Pesan Lawan Bicara</span>
                    <p class="msg-quote-text">Kak, link kadaluwarsa nih! Boleh minta yang baru?</p>
                </div>
                <p class="msg-text">Oke kak, ini link terbaru ya!</p>
                ${msg4_Class === 'msg-out'
                    ? `
                        <div class="msg-out-meta">
                            <span class="msg-time msg-time--out">14:33</span>
                            <span class="msg-tick"><i class="bi bi-check2-all"></i></span>
                        </div>
                    `
                    : '<span class="msg-time">14:33</span>'
                }
            </div>

            ${msg4_Class === 'msg-out'
                ? '<div class="msg-avatar"><i class="bi bi-person-circle"></i></div>'
                : ''}
        </div>

        <div class="msg-row msg-system">
            <div class="msg-purchase-card">
                <div class="msg-purchase-info">
                    <img src="/images/Elemen-1.png" alt="Produk" class="msg-purchase-img">
                    <div>
                        <span class="msg-purchase-title">Jaket Denim Pria</span>
                        <span class="msg-purchase-price">Rp 150.000</span>
                        <span class="msg-purchase-cond">
                            <i class="bi bi-tag-fill"></i> Bekas Seperti Baru
                        </span>
                    </div>
                </div>
                <button type="button" class="msg-purchase-btn" onclick="window.location.href='${window.checkoutUrl}'">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    `;
}

function sendMessage() {
    const messageText = chatInput.value.trim();
    if (messageText === "") return;

    const now = new Date();
    const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

    const newMsgRow = document.createElement("div");
    newMsgRow.className = "msg-row msg-out";
    newMsgRow.innerHTML = `
        <div class="msg-bubble msg-bubble--out">
            <p class="msg-text">${escapeHTML(messageText)}</p>
            <div class="msg-out-meta">
                <span class="msg-time msg-time--out">${timeString}</span>
                <span class="msg-tick"><i class="bi bi-check2"></i></span>
            </div>
        </div>
        <div class="msg-avatar"><i class="bi bi-person-circle"></i></div>
    `;

    chatMessages.appendChild(newMsgRow);
    chatInput.value = "";
    chatInput.style.height = "auto";
    scrollToBottom();

    setTimeout(() => {
        const tick = newMsgRow.querySelector(".msg-tick i");
        if (tick) tick.className = "bi bi-check2-all";
    }, 800);
}

sendBtn.addEventListener("click", sendMessage);

chatInput.addEventListener("keydown", function (e) {
    if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
});

emojiBtn.addEventListener("click", function () {
    const emoji = "😊";
    const startPos = chatInput.selectionStart;
    const endPos = chatInput.selectionEnd;

    chatInput.value = chatInput.value.substring(0, startPos) + emoji + chatInput.value.substring(endPos);
    chatInput.focus();
    chatInput.selectionStart = chatInput.selectionEnd = startPos + emoji.length;
});

chatInput.addEventListener("input", function () {
    this.style.height = "auto";
    this.style.height = (this.scrollHeight - 10) + "px";
});

function scrollToBottom() {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function escapeHTML(str) {
    return str.replace(/[&<>'"]/g, tag => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#39;',
        '"': '&quot;'
    }[tag] || tag));
}

// --- LOGIKA OTOMATIS GENERATE CARD BARU SETELAH SELLER KIRIM FORM ---
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('link_sent') === 'true') {
        setTimeout(() => {
            renderPurchaseLinkBubble();
            const cleanUrl = window.location.pathname + "?pov=" + urlParams.get('pov');
            window.history.replaceState({}, document.title, cleanUrl);
        }, 500);
    }
});

function renderPurchaseLinkBubble() {
    const chatMessages = document.getElementById("chatMessages");
    const urlParams = new URLSearchParams(window.location.search);
    
    // Mengambil parameter input dari form secara otomatis, jika kosong ada nilai fallback defaultnya
    const productName = urlParams.get('product') || 'Jaket Denim Pria';
    const rawPrice = urlParams.get('price') || '150000';
    const productPrice = isNaN(rawPrice) ? rawPrice : parseInt(rawPrice).toLocaleString('id-ID');
    const productCondition = urlParams.get('condition') || 'Bekas Seperti Baru';

    // Output diset memakai class 'msg-system' agar posisinya otomatis pas di tengah
    const linkHTML = `
        <div class="msg-row msg-system" style="margin-top: 10px;">
            <div class="msg-purchase-card">
                <div class="msg-purchase-info">
                    <img src="/images/Elemen-1.png" alt="Produk" class="msg-purchase-img">
                    <div>
                        <span class="msg-purchase-title">${escapeHTML(productName)}</span>
                        <span class="msg-purchase-price">Rp ${productPrice}</span>
                        <span class="msg-purchase-cond"><i class="bi bi-tag-fill"></i> ${escapeHTML(productCondition)}</span>
                    </div>
                </div>
                <button type="button" class="msg-purchase-btn" onclick="window.location.href='${window.checkoutUrl}'">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    `;

    chatMessages.insertAdjacentHTML('beforeend', linkHTML);
    scrollToBottom();
}