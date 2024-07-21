<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Sidebar Layout</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .header { background-color: rgb(31, 31, 31); height: 100px; }
        .sidebar { background-color: #EDF2F1; height: calc(100vh - 100px); padding-top: 20px; }
        .content { background-color: white; height: calc(100vh - 100px); padding: 20px; }
        .sidebar .btn { width: 100%; text-align: left; }
        .card-body ul li { border: none !important; }

        /* Custom styles for mobile menu */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: #EDF2F1;
                z-index: 1000;
                overflow-y: auto;
            }
            .header{
                justify-content: normal !important;
            }
            .sidebar.show {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Header -->
            <div class="col-12 header justify-content-center d-flex">
                <button class="p-0 btn d-md-none" onclick="toggleSidebar()">
                    <i class="fas fa-bars" style="font-size:30px;color:white"></i>
                </button>
                <p class="navbar-brand mb-0 h1 text-light mx-auto text-center align-content-center ml-5">FLUXO DE CAIXA</p>
            </div>
        </div>
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="accordion bg-transparent" id="sidebarAccordion">
                    <div class="card bg-transparent">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn text-black justify-content-between d-flex align-content-center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Despesas
                                </button>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#sidebarAccordion">
                            <div class="card-body">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="?menu=origem">Origem</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="?menu=tipo">Tipo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="?menu=lancamentos">Lançamentos</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion bg-transparent" id="sidebarAccordionConfig">
                    <div class="card bg-transparent">
                        <div class="card-header" id="headingConfig">
                            <h2 class="mb-0">
                                <button class="btn text-black justify-content-between d-flex align-content-center" type="button" data-toggle="collapse" data-target="#collapseConfig" aria-expanded="true" aria-controls="collapseConfig">
                                    Configurações
                                </button>
                            </h2>
                        </div>
                        <div id="collapseConfig" class="collapse show" aria-labelledby="headingConfig" data-parent="#sidebarAccordionConfig">
                            <div class="card-body">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="?menu=usuario">Gerenciamento de usuários</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="?menu=empresa">Gerenciamento de empresa</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="?menu=lancamentos">Lançamentos</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-md-10 content">
                <?php
                if (isset($_GET['menu'])) {
                    $menu = $_GET['menu'];
                    if ($menu == 'origem') {
                        include '../public/centrocusto.php';
                    } elseif ($menu == 'tipo') {
                        include '../public/tipoDespesa.php';
                    } elseif ($menu == 'lancamentos') {
                        include '../views/lancamentoDespesa/index.php';
                    } elseif ($menu == 'usuario') {
                        include '../public/usuario.php';
                    } elseif ($menu == 'empresa') {
                    include '../public/empresa.php';
                } else {
                        echo "<h3>Bem-vindo ao sistema de Fluxo de Caixa</h3>";
                    }
                } else {
                    echo "<h3>Bem-vindo ao sistema de Fluxo de Caixa</h3>";
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }
    </script> 
</body>
</html>
