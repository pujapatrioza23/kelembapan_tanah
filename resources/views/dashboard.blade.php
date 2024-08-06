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

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color:#1E90FF;
            color: #F0F8FF;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .sidebar h2 {
            margin-top: 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }

        .sidebar ul li a:hover {
            text-decoration: underline;
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
            background-color: #FFFFF0;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #bottomChartsContainer {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 0;
            min-height: 100vh;
            background: none;
        }
        
        .header img {
            width: 60%;
            height: auto;
            margin-top: -45%;
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

        .tables-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 20px;
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
                            callback: function(value, index, values) {
                                return value + '°C';
                            }
                        }
                    }
                }
            }
        });

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

        // Function to switch content sections
        function showSection(id) {
            document.querySelectorAll('.content').forEach(function (section) {
                section.classList.remove('active');
            });
            document.getElementById(id).classList.add('active');
        }

        // Event listeners for sidebar links
        document.querySelector('.sidebar a[href="#dashboard"]').addEventListener('click', function (e) {
            e.preventDefault();
            showSection('profil');
        });

        document.querySelector('.sidebar a[href="#settings"]').addEventListener('click', function (e) {
            e.preventDefault();
            showSection('grafik');
        });

        document.querySelector('.sidebar a[href="#reports"]').addEventListener('click', function (e) {
            e.preventDefault();
            showSection('data');
        });

        // Show Profil section by default
        showSection('profil');
    });
    </script>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="#dashboard">Profil</a></li>
            <li><a href="#settings">Grafik</a></li>
            <li><a href="#reports">Data</a></li>
        </ul>
    </aside>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Dashboard</a>
    </nav>

    <div class="container mt-5">
        <!-- Profil Section -->
        <div id="profil" class="content active">
            <div class="header">
                <img src="{{ asset('images/logo mosis.png') }}" alt="Logo">
            </div>
        </div>

        <!-- Grafik Section -->
        <div id="grafik" class="content">
            <div id="chartContainer">
                <!-- Canvas for Soil Moisture Chart -->
                <canvas id="soilMoistureChart" class="chart" width="300" height="90"></canvas>
            </div>
            <div id="bottomChartsContainer">
                <!-- Canvas for Temperature Chart -->
                <canvas id="temperatureChart" class="chart" width="300" height="90"></canvas>
                <!-- Canvas for Humidity Chart -->
                <canvas id="suhuChart" class="chart" width="300" height="90"></canvas>
            </div>
        </div>

        <!-- Data Section -->
        <div id="data" class="content">
            <div class="tables-container">
                <!-- Gabungan Tabel Keadaan Tanah dan Status Pompa -->
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
                            <!-- Rows will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
