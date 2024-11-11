<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Menu-principal</title>
    <link rel="stylesheet" href="{{url('assets/css/admin.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=warning" />
    <style>
        /* Estilo básico para o modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- sidebar inicio -->
    <div class="sidebar">
        <img src="{{url('assets/img/logoConectec4.png')}}" class="logo-sidebar" alt="">
        <ul>
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Úsuario</a></li>
            <li><a href="#">Postagens</a></li>
            <li><a href="#">Postagens</a></li>
        </ul>
    </div>
    <!-- sidebar fim -->

    <!-- cards dashboard inicio -->
    <div class="container">
        <div class="containerCards">
            <div class="card" style="background: linear-gradient(to bottom right, #111111, #222222);">
                <h1>{{$qnt_users}}</h1>
                <h3>Úsuarios Totais</h3>
            </div>
            <div class="card" style="background: linear-gradient(to bottom right, #ca1f13, #ee4b37);">                
                <h1>0</h1>
                <h3>Úsuarios Bloqueados</h3>
            </div>
            <div class="card" id="cardEmAnalise" style="background: linear-gradient(to bottom right, #444444, #555555);">                
                <h1>0</h1>
                <h3>Úsuarios em análise</h3>
            </div>
        </div>
    </div>
    <!-- cards dashboard fim -->

    <!-- Modal -->
    <div id="modalAnalise" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Usuários em Análise</h2>
            <p>Informações sobre os usuários que estão aguardando análise.</p>
        </div>
    </div>

    <!-- TabelaUsers dashboard inicio -->
    <div class="container">
        <div class="containerTabelaUsers1">
            <div class="tabelaUsers1">
                <div>
                    <canvas id="myPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="containerTabelaUsers2">
            <div class="tabelaUsers2">
                <table>
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Seguidores</th>
                            <th>Posição</th>
                            <th>Status</th>
                            <th>Curso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>@vinisilva</td><td>100</td><td>1</td><td>Ativo</td><td>DS</td></tr>
                        <tr><td>@Hygorwanderley</td><td>80</td><td>2</td><td>Bloqueado</td><td>Nutri</td></tr>
                        <tr><td>@mariaeduarda</td><td>60</td><td>3</td><td>Ativo</td><td>ADM</td></tr>
                        <tr><td>@tutudanado</td><td>40</td><td>4</td><td>Ativo</td><td>DS</td></tr>
                        <tr><td>@ronnisilva</td><td>20</td><td>5</td><td>Ativo</td><td>DS</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="containerTabelaUser3">
            <div class="tabelaUsers3">
                <canvas id="myBarChart" style="width: 100%; height: 700px;"></canvas>
            </div>
        </div>
    </div>

    <!-- TabelaUsers dashboard fim -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxPie = document.getElementById('myPieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['DS', 'ADM', 'NUTRI'],
                datasets: [{
                    label: 'Distribuição de Cores',
                    data: [30, 20, 15],
                    backgroundColor: ['#111111', '#151855', '#0BBDFF'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: { display: true, text: 'Distribuição de Cursos', font: { size: 18 }},
                    legend: { position: 'bottom' },
                    tooltip: { callbacks: { label: function(tooltipItem) { return tooltipItem.label + ': ' + tooltipItem.raw + '%'; } }}
                }
            }
        });

        const ctx = document.getElementById('myBarChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Usuário 1', 'Usuário 2', 'Usuário 3', 'Usuário 4', 'Usuário 5'],
                datasets: [{ label: 'Número de Seguidores', data: [100, 80, 60, 40, 20], backgroundColor: '#0BBDFF', borderColor: '#111111', borderWidth: 1, barThickness: 40, barPercentage: 0.5, categoryPercentage: 0.5 }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true, max: 120, grid: { display: false }},
                    y: { beginAtZero: true, grid: { display: false }}
                },
                plugins: {
                    title: { display: true, text: 'Seguidores dos Usuários', font: { size: 18 }},
                    legend: { display: false },
                    tooltip: { callbacks: { label: function(tooltipItem) { return tooltipItem.label + ': ' + tooltipItem.raw + ' seguidores'; } }}
                }
            }
        });

        // Funções do Modal
        const modal = document.getElementById("modalAnalise");
        const cardEmAnalise = document.getElementById("cardEmAnalise");
        const closeModal = document.getElementsByClassName("close")[0];

        cardEmAnalise.addEventListener("click", function() {
            modal.style.display = "flex";
        });

        closeModal.onclick = function() {
            modal.style.display = "none";
        };

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    </script>
</body>

</html>