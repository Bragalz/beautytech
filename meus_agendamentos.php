<!-- meus_agendamentos.php -->
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
header("Location: login.php");
exit;
}
include 'conexao.php';

$id_usuario = $_SESSION['usuario']['id'];

// Protegendo contra SQL Injection (bom hábito)
$id_usuario = intval($id_usuario);

$sql = "SELECT a.data, a.hora_inicio,a.hora_fim, s.nome as servico, p.nome as profissional
FROM agenda a
JOIN servicos s ON a.servico_id = s.id
JOIN profissionais p ON a.profissional_id = p.id
WHERE a.usuario_id = $id_usuario
ORDER BY a.data, a.hora_inicio";

$agenda = mysqli_query($conn, $sql);

// Verifica se a consulta deu certo
if (!$agenda) {
die("Erro na consulta: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Meus Agendamentos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h2>Meus Agendamentos</h2>
<table class="table table-striped">
<thead>
<tr><th>Data</th><th>Hora Inicio</th><th>Hora Fim</th><th>Profissional</th><th>Serviço</th></tr>
</thead>
<tbody>
<?php while ($ag = mysqli_fetch_assoc($agenda)) {
echo "<tr><td>{$ag['data']}</td><td>{$ag['hora_inicio']}</td><td>{$ag['hora_fim']}</td><td>{$ag['profissional']}</td><td>{$ag['servico']}</td></tr>";
} ?>
</tbody>
</table>
</div>
<div class="container mt-5">
<a href="index.php" class="btn btn-secondary btn-voltar">
<i class="bi bi-arrow-left"></i> Voltar
</a>
</div>
</body>
</html>