<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<canvas id="myChart" width="800" height="200">
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line', // Biểu đồ đường
            data: {
                labels: ['1', '2', '3', '4', '5', '8', '9', '10', '11', '12'], 
                datasets: [
                    {
                        label: 'Học lực giỏi',
                        data: [1000, 1500, 2000, 1000, 1500, 1700, 1400, 1200, 1800, 1600],
                        borderColor: '#01427A',
                        backgroundColor: 'rgba(0, 0, 255, 0.1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Học lực khá',
                        data: [2000, 1700, 1800, 1200, 1900, 2000, 1700, 1500, 1300, 1400],
                        borderColor: '#E14177',
                        backgroundColor: 'rgba(255, 0, 127, 0.1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Học lực trung bình',
                        data: [1500, 1200, 1400, 1300, 1600, 1800, 1400, 1000, 1100, 900],
                        borderColor: '#01B3EF',
                        backgroundColor: 'rgba(0, 255, 255, 0.1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Học lực yếu',
                        data: [800, 900, 600, 500, 700, 1000, 900, 800, 600, 500],
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
                            text: 'Tháng'
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