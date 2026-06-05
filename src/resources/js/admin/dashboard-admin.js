import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {

    // ==========================
    // DROPDOWN
    // ==========================

    const periodTrigger = document.getElementById('periodTrigger');
    const periodMenu    = document.getElementById('periodMenu');
    const periodLabel   = document.getElementById('periodLabel');

    if (periodTrigger) {

        periodTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            periodMenu.classList.toggle('open');
        });

        document.addEventListener('click', () => {
            periodMenu.classList.remove('open');
        });
    }

    // ==========================
    // COUNTER
    // ==========================

    document.querySelectorAll('.counter')
        .forEach(counter => {

            const target = parseInt(
                counter.dataset.target
            );

            animateCount(counter, target);
        });

    function animateCount(el, target, duration = 900) {

        const startTime = performance.now();

        function step(now) {

            const progress =
                Math.min(
                    (now - startTime) / duration,
                    1
                );

            const eased =
                1 - Math.pow(1 - progress, 3);

            el.textContent =
                Math.round(target * eased);

            if (progress < 1) {
                requestAnimationFrame(step);
            }
        }

        requestAnimationFrame(step);
    }

    // ==========================
    // CHART
    // ==========================

    const chartCanvas =
        document.getElementById('growthChart');

    if (!chartCanvas) return;

    const datasets = {
        6: {
            labels: ["Nov '23","Des '23","Jan '24","Feb '24","Mar '24","Apr '24"],
            user: [70,80,92,105,115,128],
            produk: [28,36,50,62,72,80]
        },
        3: {
            labels: ["Feb '24","Mar '24","Apr '24"],
            user: [105,115,128],
            produk: [62,72,80]
        },
        12: {
            labels: [
                "May '23","Jun '23","Jul '23","Aug '23",
                "Sep '23","Oct '23","Nov '23","Des '23",
                "Jan '24","Feb '24","Mar '24","Apr '24"
            ],
            user: [
                30,38,44,52,58,64,
                70,80,92,105,115,128
            ],
            produk: [
                8,12,16,18,22,25,
                28,36,50,62,72,80
            ]
        }
    };

    const chart = new Chart(chartCanvas, {
        type: 'line',
        data: {
            labels: datasets[6].labels,
            datasets: [
                {
                    label: 'User',
                    data: datasets[6].user,
                    borderColor: '#3B9DF8',
                    tension: 0.4
                },
                {
                    label: 'Produk',
                    data: datasets[6].produk,
                    borderColor: '#62B5FF',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    document
        .querySelectorAll('.period-option')
        .forEach(btn => {

            btn.addEventListener('click', () => {

                document
                    .querySelectorAll('.period-option')
                    .forEach(el =>
                        el.classList.remove('active')
                    );

                btn.classList.add('active');

                const period =
                    parseInt(btn.dataset.period);

                periodLabel.textContent =
                    btn.textContent.trim();

                chart.data.labels =
                    datasets[period].labels;

                chart.data.datasets[0].data =
                    datasets[period].user;

                chart.data.datasets[1].data =
                    datasets[period].produk;

                chart.update();

                periodMenu.classList.remove('open');
            });

        });

});