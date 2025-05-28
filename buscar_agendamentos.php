<?php
include 'conexao.php';
$id_prof = intval($_GET['id_prof']);
$data = $_GET['data'];

$res = mysqli_query($conn, "SELECT hora_inicio, hora_fim FROM agenda
WHERE profissional_id = $id_prof AND data = '$data'");

$dados = [];
while ($row = mysqli_fetch_assoc($res)) {
$dados[] = [
'hora_inicio' => $row['hora_inicio'],
'hora_fim' => $row['hora_fim']
];
}
echo json_encode($dados);
?>