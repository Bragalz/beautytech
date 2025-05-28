<!-- salvar_agendamento.php -->
<?php
session_start();

include 'conexao.php';

// Escapar entradas para segurança
$id_profissional = mysqli_real_escape_string($conn, $_POST['id_profissional']);
$id_servico = mysqli_real_escape_string($conn, $_POST['id_servico']);
$data = mysqli_real_escape_string($conn, $_POST['data']);
$hora = mysqli_real_escape_string($conn, $_POST['hora']);

// Buscar tempo do serviço
$result_servico = mysqli_query($conn, "SELECT tempo FROM servicos WHERE id = $id_servico");
if (!$result_servico) {
    die("Erro ao buscar tempo do serviço: " . mysqli_error($conn));
}
$servico = mysqli_fetch_assoc($result_servico);
$tempo_servico = (int)$servico['tempo'];

$inicio = new DateTime("$data $hora");
$fim = clone $inicio;
$fim->modify("+{$tempo_servico} minutes");
$hora_fim = $fim->format('H:i');

// Verificar conflito de horários
$query = "
    SELECT * FROM agenda
    WHERE profissional_id = $id_profissional
      AND data = '$data'
      AND (
            (hora_inicio <= '$hora' AND hora_fim > '$hora') OR
            (hora_inicio < '$hora_fim' AND hora_fim >= '$hora_fim') OR
            (hora_inicio >= '$hora' AND hora_fim <= '$hora_fim')
          )
";

$check = mysqli_query($conn, $query);
if (!$check) {
    die("Erro ao verificar conflitos: " . mysqli_error($conn));
}

if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Conflito de horário com outro agendamento!'); history.back();</script>";
} else {
    $insert = mysqli_query($conn, "
        INSERT INTO agenda (profissional_id, servico_id, data, hora_inicio, hora_fim, usuario_id)
        VALUES ($id_profissional, $id_servico, '$data', '$hora', '$hora_fim', {$_SESSION['usuario']['id']})
    ");
    if ($insert) {
        echo "<script>alert('Agendamento realizado com sucesso!'); location.href='index.php';</script>";
    } else {
        die("Erro ao inserir agendamento: " . mysqli_error($conn));
    }
}
?>