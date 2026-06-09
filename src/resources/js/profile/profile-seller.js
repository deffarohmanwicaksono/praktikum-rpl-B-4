document.addEventListener('DOMContentLoaded', () => {

    const cards =
        document.querySelectorAll('.review-card');

    cards.forEach((card, index) => {

        card.style.opacity = '0';
        card.style.transform =
            'translateY(10px)';

        setTimeout(() => {

            card.style.transition =
                'all .3s ease';

            card.style.opacity = '1';
            card.style.transform =
                'translateY(0)';

        }, index * 120);

    });

});