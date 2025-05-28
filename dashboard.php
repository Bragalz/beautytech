<?php
session_start();
if (!isset($_SESSION['usuario'])) {
header("Location: login.php");
exit;
}

$nome = $_SESSION['usuario']['nome'];
$tipo = $_SESSION['usuario']['tipo'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Painel - Salão</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
<h2>Olá, <?= $nome ?> (<?= $tipo ?>)</h2>

<?php if ($tipo === 'admin'): ?>
<a href="dashboard_dia.php" class="btn btn-primary">Dashboard Diário</a>
<a href="dashboard_geral.php" class="btn btn-primary">Dashboard Geral</a>
<a href="dashboard_profissional.php" class="btn btn-primary">Dashboard por profissional</a>
<a href="lista_profissionais.php" class="btn btn-warning">Lista profissionais</a>
<?php endif; ?>
</div>
<div class="container mt-5">
<a href="index.php" class="btn btn-secondary btn-voltar">
<i class="bi bi-arrow-left"></i> Voltar
</a>
</div>
</body>
</html>