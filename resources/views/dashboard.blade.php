<!DOCTYPE html>
<html>
<head>
    <title>Monitoring Smart Irrigation System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            position: relative;
            margin: 0;
            padding: 0;
            color: #fff;
            background-color: #1E90FF;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('assets/images/background.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            filter: blur(5px);
            z-index: -1;
        }
        .container {
            margin-left: 250px;
            padding: 20px;
        }

        .navbar {
            background-color: #1E90FF;
            padding: 10px;
        }

        .navbar-nav {
            margin-left: 60%;
        }

        .navbar-nav li {
            display: inline;
            margin-left: 80px;
        }

        .navbar-nav a {
            color: #fff;
            text-decoration: none;
            font-size: 20px;
        }

        .navbar-nav a:hover {
            text-decoration: underline;
        }

        .header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            flex-direction: column; /* Untuk menempatkan logo dan teks secara vertikal */
            padding-top: 0;
            min-height: 100vh;
            text-align: center; /* Agar teks di bawah logo juga rata tengah */

        }

        .header img {
            width: 30%;
            height: auto;
            margin-top: -5%;
            align-self: flex-start; /* Agar logo tetap di kiri */
            margin-right: auto; /* Untuk memastikan logo tetap di tengah */

        }
        .header .text {
            max-width: 40%;
            color: #E0FFFF;
            font-size: 30px;
            line-height: 1.5;
            text-align: left; /* Memindahkan tulisan ke sebelah kanan */
            margin-top: -12%; /* Mengatur jarak kiri dan kanan agar teks berada di tengah */
            margin-left: 65%; /* Tambahkan jarak kiri untuk memindahkan teks ke kanan dari logo */
        }

        .content {
            display: none;
        }

        .active {
            display: block;
        }

        #chartContainer {
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .chart {
            max-width: 500px;
            height: auto;
            margin: 20px;
            background-color: #E0FFFF;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        #bottomChartsContainer {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .tables-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 20px;
        }

        .small-table {
            max-width: 1000px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .small-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .small-table th, .small-table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .small-table thead {
            background-color: #1E90FF;
            color: #fff;
        }

        .small-table tbody tr:nth-child(odd) {
            background-color: #E0FFFF;
        }

        .small-table tbody tr:nth-child(even) {
            background-color: #E0FFFF;
        }

        .small-table tbody tr:hover {
            background-color: #F0FFF0;
        }

        .small-table .table-info {
            background-color: #F0FFF0;
            color: #000;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var data = @json($data);

            var soilWet = 65;  // Nilai kelembapan tanah lembab
        var soilDry = 35;  // Nilai kelembapan tanah kering

        function convertToLocalTime(utcTime) {
            var date = new Date(utcTime + 'Z');
            return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        var labels = data.map(item => convertToLocalTime(item.recorded_at));
        var soilMoistureData = data.map(item => item.moisture);
        var temperatureData = data.map(item => item.temperature);
        var humidityData = data.map(item => item.humidity);

        var ctx1 = document.getElementById('soilMoistureChart').getContext('2d');
        new Chart(ctx1, {

                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Kelembapan Tanah (%)',
                        data: soilMoistureData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Inisialisasi grafik suhu
            var ctx2 = document.getElementById('temperatureChart').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Suhu (°C)',
                        data: temperatureData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + '°C';
                                }
                            }
                        }
                    }
                }
            });

            // Inisialisasi grafik kelembapan udara
            var ctx3 = document.getElementById('suhuChart').getContext('2d');
            new Chart(ctx3, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Kelembapan Udara (%)',
                        data: humidityData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Fungsi untuk memperbarui tabel dengan data terbaru
            function updateTable(labels, soilMoistureData, temperatureData, humidityData) {
                var tableBody = document.querySelector('#data-table tbody');
                tableBody.innerHTML = '';

                for (var i = 0; i < labels.length; i++) {
                    var row = document.createElement('tr');
                    var timeCell = document.createElement('td');
                    var soilMoistureCell = document.createElement('td');
                    var temperatureCell = document.createElement('td');
                    var humidityCell = document.createElement('td');
                    var conditionCell = document.createElement('td');
                    var actionCell = document.createElement('td');

                    var condition;
                    var status;

                    if (soilMoistureData[i] < soilDry) {
                        condition = 'Tanah Kering';
                        status = 'Hidupkan Pompa';
                    } else if (soilMoistureData[i] >= soilWet) {
                        condition = 'Tanah Lembab';
                        status = 'Pompa Hidup';
                    } else {
                        condition = 'Tanah Normal';
                        status = 'Pompa Mati';
                    }

                    timeCell.textContent = labels[i];
                    soilMoistureCell.textContent = soilMoistureData[i];
                    temperatureCell.textContent = temperatureData[i];
                    humidityCell.textContent = humidityData[i];
                    conditionCell.textContent = condition;
                    actionCell.textContent = status;

                    row.appendChild(timeCell);
                    row.appendChild(soilMoistureCell);
                    row.appendChild(temperatureCell);
                    row.appendChild(humidityCell);
                    row.appendChild(conditionCell);
                    row.appendChild(actionCell);

                    tableBody.appendChild(row);
                }
            }

            // Perbarui tabel dengan data terbaru
            updateTable(labels, soilMoistureData, temperatureData, humidityData);

            // Fungsi untuk menampilkan section yang aktif
            function showSection(id) {
                document.querySelectorAll('.content').forEach(function (section) {
                    section.classList.remove('active');
                });
                document.getElementById(id).classList.add('active');
            }

            // Event listeners untuk menu
            document.querySelector('.navbar-nav a[href="#profil"]').addEventListener('click', function (e) {
                e.preventDefault();
                showSection('profil');
            });
            document.querySelector('.navbar-nav a[href="#grafik"]').addEventListener('click', function (e) {
                e.preventDefault();
                showSection('grafik');
            });
            document.querySelector('.navbar-nav a[href="#about"]').addEventListener('click', function (e) {
                e.preventDefault();
                showSection('about');
            });
        });
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <ul class="navbar-nav">
            <li><a href="#profil">Profil</a></li>
            <li><a href="#grafik">Grafik</a></li>
            <li><a href="#about">Data</a></li>
        </ul>
    </nav>

     <!-- Profil Section -->
     <div id="profil" class="content active">
            <div class="header">
                <img src="{{ asset('images/logo mosis.png') }}" alt="Logo">
                <div class="text">
                <p style="font-size: -40%; color: #F8F8FF; font-weight: bold;">REVOLUTIONIZE YOUR FARMING WITH OUT SMART IRRIGATION SYSTEM</p>
                <br>
                <p style="font-size: 80%; color: #F8F8FF;">Monitoring Smart irrigation system ini dapat memantau kelembaban tanah, suhu, dan pengairan pada tanaman bawang merah. Adanya smart irrigation system diharapkan juga dapat menjadikan tanaman bawang merah bisa tumbuh dengan baik dan optimal disetiap musim.</p>
                </div>
            </div>
          </div>
        </div>


    <!-- Grafik Section -->
    <div id="grafik" class="content">
        <div id="chartContainer">
            <!-- Canvas untuk Grafik Kelembapan Tanah -->
            <canvas id="soilMoistureChart" class="chart" width="300" height="90"></canvas>
        </div>
        <div id="bottomChartsContainer">
            <!-- Canvas untuk Grafik Suhu -->
            <canvas id="temperatureChart" class="chart" width="300" height="90"></canvas>
            <!-- Canvas untuk Grafik Kelembapan Udara -->
            <canvas id="suhuChart" class="chart" width="300" height="90"></canvas>
        </div>
    </div>

    <!-- Data Section -->
    <div id="about" class="content">
        <!-- Tabel Data -->
        <div class="tables-container">
        <div class="table-wrapper small-table">
        <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Jam</th>
                            <th>Kelembapan Tanah (%)</th>
                            <th>Suhu (°C)</th>
                            <th>Kelembapan Udara (%)</th>
                            <th>Kondisi Tanah</th>
                            <th>Aksi Pompa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Tabel akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
