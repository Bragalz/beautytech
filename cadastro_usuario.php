<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($nome) || empty($email) || empty($senha)) {
        echo "<script>alert('Todos os campos são obrigatórios.'); location.href='cadastro.php';</script>";
        exit;
    }

    // Verifica se o email já está cadastrado (SQL seguro)
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('E-mail já cadastrado.'); location.href='login.php?email=" . urlencode($email) . "';</script>";
        exit;
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserção com segurança
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha_hash);
    
    if ($stmt->execute()) {
        $id = $stmt->insert_id;
        $_SESSION['usuario'] = ['id' => $id, 'nome' => $nome, 'email' => $email];
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Erro ao cadastrar.'); location.href='cadastro.php';</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Usuário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Cadastro de Novo Usuário</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nome</label>
      <input type="text" name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">E-mail</label>
      <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Senha</label>
      <input type="password" name="senha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Cadastrar e Entrar</button>
  </form>
</div>
</body>
</html>
