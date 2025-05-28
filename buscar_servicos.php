<?php
include 'conexao.php';
$id_prof = intval($_GET['id_prof']);
$res = mysqli_query($conn, "SELECT * FROM servicos WHERE id IN (
SELECT servico_id FROM profissional_servico WHERE profissional_id = $id_prof
)");
$dados = [];
while ($row = mysqli_fetch_assoc($res)) {
$dados[] = $row;
}
echo json_encode($dados);
?>