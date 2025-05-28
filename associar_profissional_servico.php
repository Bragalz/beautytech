<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
  echo "<script>alert('Acesso restrito!'); location.href='index.php';</script>";
  exit;
}
?>
<!-- associar_profissional_servico.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Associar Profissional a Serviço</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2>Associação Profissional - Serviço</h2>
    <form method="POST" action="salvar_associacao.php">
      <div class="mb-3">
        <label class="form-label">Profissional:</label>
        <select name="id_profissional" class="form-select" required>
          <?php
          include 'conexao.php';
          $res = mysqli_query($conn, "SELECT * FROM profissionais");
          while ($row = mysqli_fetch_assoc($res)) {
            echo "<option value='{$row['id']}'>{$row['nome']}</option>";
          }
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Serviço:</label>
        <select name="id_servico" class="form-select" required>
          <?php
          $res = mysqli_query($conn, "SELECT * FROM servicos");
          while ($row = mysqli_fetch_assoc($res)) {
            echo "<option value='{$row['id']}'>{$row['nome']} ({$row['tempo']} min)</option>";
          }
          ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Associar</button>
      <a href="index.php" class="btn btn-secondary btn-voltar">
        <i class="bi bi-arrow-left"></i> Voltar
      </a>
    </form>
  </div>
</body>
</html>