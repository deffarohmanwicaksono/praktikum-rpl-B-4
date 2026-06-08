document.addEventListener('DOMContentLoaded', () => {

    const statCards = document.querySelectorAll('.stat-card');

    statCards.forEach((card, index) => {

        card.style.opacity = '0';
        card.style.transform = 'translateY(10px)';

        setTimeout(() => {

            card.style.transition =
                'all 0.35s ease';

            card.style.opacity = '1';
            card.style.transform =
                'translateY(0)';

        }, index * 120);

    });

});