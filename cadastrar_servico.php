
<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
  echo "<script>alert('Acesso restrito!'); location.href='index.php';</script>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Serviços</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2>Cadastro de Serviço</h2>
    <form method="POST" action="salvar_servico.php">
      <div class="mb-3">
        <label class="form-label">Nome:</label>
        <input type="text" name="nome" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Tipo:</label>
        <input type="text" name="tipo" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Tempo (min):</label>
        <input type="number" name="tempo" class="form-control" required>
      </div>
    
    <button type="submit" class="btn btn-primary">Cadastrar</button>
    <a href="index.php" class="btn btn-secondary btn-voltar">
        <i class="bi bi-arrow-left"></i> Voltar
      </a>
    </form>
  </div>
</body>
</html>