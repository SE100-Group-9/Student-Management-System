<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<canvas id="myChart" width="800" height="200">
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line', // Biểu đồ đường
            data: {
                labels: ['Học kỳ 1 2023-2024', 'Học kỳ 2 2023-2024', 'Học kỳ 1 2024-2025', 'Học kỳ 2 2024-2025'], 
                datasets: [
                    {
                        label: 'Học lực giỏi',
                        data: [1000, 1500, 2000, 1000],
                        borderColor: '#01427A',
                        backgroundColor: 'rgba(0, 0, 255, 0.1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Học lực khá',
                        data: [2000, 1700, 1800, 1200],
                        borderColor: '#E14177',
                        backgroundColor: 'rgba(255, 0, 127, 0.1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Học lực trung bình',
                        data: [1500, 1200, 1400, 1300],
                        borderColor: '#01B3EF',
                        backgroundColor: 'rgba(0, 255, 255, 0.1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Học lực yếu',
                        data: [800, 900, 600, 500],
                        borderColor: '#6C6C6C',
                        backgroundColor: 'rgba(128, 128, 128, 0.1)',
                        borderWidth: 1,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true, // Hiển thị chú thích
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: ''
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Số lượng học sinh'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</canvas>