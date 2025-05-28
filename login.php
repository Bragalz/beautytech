<?php
session_start();
include 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];


// Verifica se o usuário existe
$sql = "SELECT * FROM usuarios WHERE email='$email' AND senha='$senha'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 1) {
    $usuario = mysqli_fetch_assoc($result);

    // Salva os dados do usuário na sessão
    $_SESSION['usuario'] = $usuario;
    $_SESSION['usuario']['id'] = $usuario['id'];

    // Redireciona para a index
    header("Location: index.php");
    exit;
} else {
    echo "<script>alert('Email ou senha incorretos!'); location.href='login.html';</script>";
}
?>