<?php
session_start();
include 'conexao.php';

//$data = $_GET['data'];
$data = date('Y/m/d');

$query = "
SELECT a.id, p.nome AS profissional, s.nome AS servico, a.hora_inicio, a.hora_fim
FROM agenda a
JOIN profissionais p ON a.profissional_id = p.id
JOIN servicos s ON a.servico_id = s.id
WHERE a.data = '$data'
ORDER BY a.hora_inicio
";
$res = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Dashboard - Dia</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h2>Agendamentos para o dia <?php echo $data; ?></h2>
<table class="table table-bordered">
<thead>
<tr>
<th>Profissional</th>
<th>Serviço</th>
<th>Hora Início</th>
<th>Hora Fim</th>
</tr>
</thead>
<tbody>
<?php while ($row = mysqli_fetch_assoc($res)) { ?>
<tr>
<td><?php echo $row['profissional']; ?></td>
<td><?php echo $row['servico']; ?></td>
<td><?php echo $row['hora_inicio']; ?></td>
<td><?php echo $row['hora_fim']; ?></td>
</tr>
<?php } ?>
</tbody>

</table>
</div>
<div class="container mt-5">
<a href="dashboard.php" class="btn btn-secondary btn-voltar">
<i class="bi bi-arrow-left"></i> Voltar
</a>
</div>

</body>
</html>