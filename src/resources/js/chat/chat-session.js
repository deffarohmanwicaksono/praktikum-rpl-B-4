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
                            <span class="msg-tick">
                                <i class="bi bi-check2-all"></i>
                            </span>
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
                            <span class="msg-tick">
                                <i class="bi bi-check2-all"></i>
                            </span>
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
                <p class="msg-text">
                    Kak, link kadaluwarsa nih! Boleh minta yang baru?
                </p>

                ${msg3_Class === 'msg-out'
                    ? `
                        <div class="msg-out-meta">
                            <span class="msg-time msg-time--out">14:32</span>
                            <span class="msg-tick">
                                <i class="bi bi-check2-all"></i>
                            </span>
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
            <div class="link-card">
                <div class="link-card-icon-wrap link-card-icon-wrap--expired">
                    <i class="bi bi-exclamation-circle"></i>
                </div>

                <div class="link-card-info">
                    <span class="link-card-title">Link Kadaluwarsa</span>

                    <span class="link-card-url link-card-url--expired">
                        semart.app/p/jeans-jacket-old
                    </span>

                    <span class="link-card-sub link-card-sub--expired">
                        Link tidak valid atau sudah kadaluwarsa
                    </span>
                </div>

                <span class="link-card-time">14:32</span>
            </div>
        </div>

        <div class="msg-row ${msg4_Class}">
            ${msg4_Class === 'msg-in'
                ? '<div class="msg-avatar"><i class="bi bi-person-circle"></i></div>'
                : ''}

            <div class="msg-bubble msg-bubble--${msg4_Class === 'msg-out' ? 'out' : 'in'}">

                <div class="msg-quote">
                    <span class="msg-quote-author">
                        Pesan Lawan Bicara
                    </span>

                    <p class="msg-quote-text">
                        Kak, link kadaluwarsa nih! Boleh minta yang baru?
                    </p>
                </div>

                <p class="msg-text">
                    Oke kak, ini link terbaru ya!
                </p>

                ${msg4_Class === 'msg-out'
                    ? `
                        <div class="msg-out-meta">
                            <span class="msg-time msg-time--out">14:33</span>
                            <span class="msg-tick">
                                <i class="bi bi-check2-all"></i>
                            </span>
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
            <div class="link-card">
                <div class="link-card-icon-wrap link-card-icon-wrap--valid">
                    <i class="bi bi-link-45deg"></i>
                </div>

                <div class="link-card-info">
                    <span class="link-card-title">
                        Link Pembelian
                    </span>

                    <a href="#" class="link-card-url">
                        semart.app/p/jeans-jacket-123
                    </a>

                    <span class="link-card-sub">
                        Klik untuk membuka link
                    </span>
                </div>

                <span class="link-card-time">14:33</span>
            </div>
        </div>
    `;
}

function sendMessage() {

    const messageText = chatInput.value.trim();

    if (messageText === "") return;

    const now = new Date();

    const timeString =
        now.getHours().toString().padStart(2, '0')
        + ':'
        + now.getMinutes().toString().padStart(2, '0');

    const newMsgRow = document.createElement("div");

    newMsgRow.className = "msg-row msg-out";

    newMsgRow.innerHTML = `
        <div class="msg-bubble msg-bubble--out">
            <p class="msg-text">${escapeHTML(messageText)}</p>

            <div class="msg-out-meta">
                <span class="msg-time msg-time--out">
                    ${timeString}
                </span>

                <span class="msg-tick">
                    <i class="bi bi-check2"></i>
                </span>
            </div>
        </div>

        <div class="msg-avatar">
            <i class="bi bi-person-circle"></i>
        </div>
    `;

    chatMessages.appendChild(newMsgRow);

    chatInput.value = "";
    chatInput.style.height = "auto";

    scrollToBottom();

    setTimeout(() => {

        const tick = newMsgRow.querySelector(".msg-tick i");

        if (tick) {
            tick.className = "bi bi-check2-all";
        }

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

    chatInput.value =
        chatInput.value.substring(0, startPos)
        + emoji
        + chatInput.value.substring(endPos);

    chatInput.focus();

    chatInput.selectionStart =
    chatInput.selectionEnd =
        startPos + emoji.length;
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