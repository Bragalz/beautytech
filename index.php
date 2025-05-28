<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
$is_admin = $_SESSION['usuario']['tipo'] === 'admin';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Menu Principal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
    }
    .menu-container {
      max-width: 800px;
      margin: 50px auto;
    }
    .card-option {
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      transition: transform 0.2s;
    }
    .card-option:hover {
      transform: scale(1.02);
    }
  </style>
</head>
<body>
  <div class="container menu-container">
    <h2 class="text-center mb-4">Olá, <?php echo $_SESSION['usuario']['nome']; ?> 👋</h2>
    <div class="row g-4">
      <?php if ($is_admin): ?>
        <div class="col-md-6">
          <a href="cadastrar_profissional.php" class="text-decoration-none">
            <div class="card card-option p-4 text-center">
              <i class="bi bi-person-plus fs-2 mb-2 text-primary"></i>
              <h5 class="text-dark">Cadastrar Profissional</h5>
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="cadastrar_servico.php" class="text-decoration-none">
            <div class="card card-option p-4 text-center">
              <i class="bi bi-tools fs-2 mb-2 text-success"></i>
              <h5 class="text-dark">Cadastrar Serviço</h5>
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="associar_profissional_servico.php" class="text-decoration-none">
            <div class="card card-option p-4 text-center">
              <i class="bi bi-link-45deg fs-2 mb-2 text-warning"></i>
              <h5 class="text-dark">Associar Serviço</h5>
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="dashboard.php" class="text-decoration-none">
            <div class="card card-option p-4 text-center">
              <i class="bi bi-bar-chart-line fs-2 mb-2 text-danger"></i>
              <h5 class="text-dark">Dashboards</h5>
            </div>
          </a>
        </div>
      <?php else: ?>
        <div class="col-md-6">
          <a href="agendar.php" class="text-decoration-none">
            <div class="card card-option p-4 text-center">
              <i class="bi bi-calendar-plus fs-2 mb-2 text-primary"></i>
              <h5 class="text-dark">Agendar Serviço</h5>
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a href="meus_agendamentos.php" class="text-decoration-none">
            <div class="card card-option p-4 text-center">
              <i class="bi bi-calendar-check fs-2 mb-2 text-success"></i>
              <h5 class="text-dark">Meus Agendamentos</h5>
            </div>
          </a>
        </div>
      <?php endif; ?>
      <div class="col-md-6">
        <a href="logout.php" class="text-decoration-none">
          <div class="card card-option p-4 text-center bg-danger text-white">
            <i class="bi bi-box-arrow-right fs-2 mb-2"></i>
            <h5>Sair</h5>
          </div>
        </a>
      </div>
    </div>
  </div>
</body>
</html>
 