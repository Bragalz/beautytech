<?php
session_start();
if (!isset($_SESSION['usuario'])) {
header("Location: login.html");
exit();
}
include 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Agendar Serviço</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
background-color: #f8f9fa;
}
.profissionais {
display: flex;
gap: 20px;
overflow-x: auto;
margin-bottom: 20px;
}
.prof-card {
border: 2px solid #dee2e6;
border-radius: 10px;
padding: 10px;
text-align: center;
cursor: pointer;
transition: 0.3s;
width: 120px;
}
.prof-card:hover, .prof-card.active {
border-color: #0d6efd;
background-color: #e7f1ff;
}
.calendar {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
gap: 20px;
}
.day-card {
background: white;
padding: 15px;
border-radius: 10px;
border: 1px solid #dee2e6;
}
.occupied {
color: red;
}
.available {
color: green;
cursor: pointer;
}
</style>
</head>
<body>

<div class="container mt-4">
<a href="index.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Voltar</a>
<h3><i class="bi bi-calendar-plus"></i> Agendar um Serviço</h3>

<!-- Seleção de Profissionais -->
<h5 class="mt-4">Selecione o Profissional:</h5>
<div class="profissionais">
<?php
$res = mysqli_query($conn, "SELECT * FROM profissionais");
while ($row = mysqli_fetch_assoc($res)) {
echo "<div class='prof-card' data-id='{$row['id']}'>
<img src='{$row['foto_url']}' width='80' height='80' style='border-radius:50%'><br>
<strong>{$row['nome']}</strong>
</div>";
}
?>
</div>

<!-- Formulário -->
<form method="POST" action="salvar_agendamento.php" id="formAgendamento">
<input type="hidden" name="id_profissional" id="id_profissional" required>

<div class="mb-3">
<label class="form-label">Serviço:</label>
<select name="id_servico" id="servico" class="form-select" required>
<option value="">Selecione um profissional...</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Data:</label>
<input type="date" name="data" id="data" class="form-control" required>
</div>

<div class="calendar" id="calendario">
<!-- Calendário gerado dinamicamente -->
</div>

<input type="hidden" name="hora" id="hora_selecionada" required>
<input type="hidden" name="id_usuario" value="<?php echo $_SESSION['usuario']['id']; ?>">

<button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check-circle"></i> Confirmar Agendamento</button>
</form>
</div>

<script>
const profissionais = document.querySelectorAll('.prof-card');
const id_prof_input = document.getElementById('id_profissional');
const servicoSelect = document.getElementById('servico');
const calendario = document.getElementById('calendario');
const dataInput = document.getElementById('data');
const horaInput = document.getElementById('hora_selecionada');

// Seleção do profissional
profissionais.forEach(prof => {
prof.addEventListener('click', () => {
profissionais.forEach(p => p.classList.remove('active'));
prof.classList.add('active');
id_prof_input.value = prof.dataset.id;
carregarServicos(prof.dataset.id);
calendario.innerHTML = "";
});
});

// Carregar serviços do profissional
function carregarServicos(id_prof) {
fetch(`buscar_servicos.php?id_prof=${id_prof}`)
.then(res => res.json())
.then(data => {
servicoSelect.innerHTML = '<option value="">Selecione</option>';
data.forEach(item => {
servicoSelect.innerHTML += `<option value="${item.id}" data-tempo="${item.tempo}">${item.nome} (${item.tempo} min)</option>`;
});
});
}

// Atualizar calendário ao escolher data
dataInput.addEventListener('change', atualizarCalendario);
servicoSelect.addEventListener('change', atualizarCalendario);

function atualizarCalendario() {
const data = dataInput.value;
const id_prof = id_prof_input.value;
if (!data || !id_prof) return;

fetch(`buscar_agendamentos.php?id_prof=${id_prof}&data=${data}`)
.then(res => res.json())
.then(agendados => {
calendario.innerHTML = "";
const horas = gerarHoras();
const card = document.createElement('div');
card.className = 'day-card';
card.innerHTML = `<h5>${data}</h5>`;
horas.forEach(h => {
const ocupado = agendados.find(a => h >= a.hora_inicio && h < a.hora_fim);
const btn = document.createElement('div');
btn.className = ocupado ? 'occupied' : 'available';
btn.innerHTML = ocupado ? `<i class="bi bi-person-fill"></i> ${h} - Ocupado` : `<i class="bi bi-check-circle"></i> ${h} - Disponível`;

if (!ocupado) {
btn.addEventListener('click', () => {
document.querySelectorAll('.available').forEach(b => b.style.fontWeight = 'normal');
btn.style.fontWeight = 'bold';
horaInput.value = h;
});
}
card.appendChild(btn);
});
calendario.appendChild(card);
});
}

// Gerar horários
function gerarHoras() {
let horas = [];
for (let h = 8; h <= 22; h++) {
horas.push((h < 10 ? '0' : '') + h + ':00');
horas.push((h < 10 ? '0' : '') + h + ':30');
}
return horas;
}
</script>
</body>
</html>