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
    <title>Cadastro de Profissionais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Cadastro de Profissional</h2>
    <form method="POST" action="salvar_profissional.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nome:</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto:</label>
            <input type="file" name="foto" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>

</body>
</html>