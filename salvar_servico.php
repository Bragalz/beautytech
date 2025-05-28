
<?php
include 'conexao.php';
$nome = $_POST['nome'];
$tipo = $_POST['tipo'];
$tempo = $_POST['tempo'];
mysqli_query($conn, "INSERT INTO servicos (nome, tipo, tempo) VALUES ('$nome', '$tipo', '$tempo')");
echo "<script>alert('Serviço cadastrado!'); location.href='cadastrar_servico.php';</script>";
?>