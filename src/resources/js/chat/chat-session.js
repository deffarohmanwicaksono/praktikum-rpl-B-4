document.addEventListener('DOMContentLoaded', function() {
    // Auto-scroll ke pesan terbawah
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Emoji button
    const emojiBtn = document.getElementById('emojiBtn');
    const chatInput = document.getElementById('chatInput');

    if (emojiBtn && chatInput) {
        emojiBtn.addEventListener('click', function() {
            const emoji = '😊';
            const startPos = chatInput.selectionStart;
            const endPos = chatInput.selectionEnd;
            chatInput.value = chatInput.value.substring(0, startPos) + emoji + chatInput.value.substring(endPos);
            chatInput.dispatchEvent(new Event('input'));
            chatInput.focus();
            chatInput.selectionStart = chatInput.selectionEnd = startPos + emoji.length;
        });
    }

    // Auto-resize textarea
    if (chatInput) {
        chatInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight - 10) + 'px';
        });
    }
});
