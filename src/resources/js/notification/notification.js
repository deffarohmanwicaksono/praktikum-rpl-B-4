document.addEventListener('DOMContentLoaded', () => {

    // =============================================
    // MARK AS READ INTERACTIVITY
    // =============================================
    const notificationCards = document.querySelectorAll('.notif-card.unread');

    notificationCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Jika ada link default, kita tidak mencegahnya (kecuali untuk demo)
            // e.preventDefault(); 
            
            // Hapus class unread
            this.classList.remove('unread');
            
            // Cari dan hilangkan titik unread dengan animasi yang halus
            const unreadDot = this.querySelector('.unread-dot');
            if (unreadDot) {
                unreadDot.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                unreadDot.style.opacity = '0';
                unreadDot.style.transform = 'scale(0)';
                
                // Hapus elemen dari DOM setelah animasi selesai
                setTimeout(() => {
                    unreadDot.remove();
                }, 300);
            }

            // Di sini Anda bisa menambahkan Fetch API/Axios untuk hit endpoint 'mark as read'
            // const notifId = this.dataset.id;
            // axios.post(`/api/notifications/${notifId}/mark-as-read`);
        });
    });

});