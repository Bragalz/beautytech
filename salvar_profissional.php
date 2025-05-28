<?php
include 'conexao.php';

// Recebe dados
$nome = $_POST['nome'];
$email = $_POST['email'];

// Upload da imagem
$diretorio = "img/profissionais/";
if (!is_dir($diretorio)) {
    mkdir($diretorio, 0755, true);
}

$nome_arquivo = basename($_FILES['foto']['name']);
$extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
$permitidos = ['jpg', 'jpeg', 'png', 'bmp'];

if (in_array($extensao, $permitidos)) {
    $novo_nome = uniqid() . '.' . $extensao;
    $caminho = $diretorio . $novo_nome;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho)) {
        // Salvar no banco
        $foto_url = $caminho;
        mysqli_query($conn, "INSERT INTO profissionais (nome, email, foto_url) VALUES ('$nome', '$email', '$foto_url')");
        echo "<script>alert('Profissional cadastrado com sucesso!'); location.href='cadastrar_profissional.php';</script>";
    } else {
        echo "<script>alert('Erro ao fazer upload da foto!'); history.back();</script>";
    }
} else {
    echo "<script>alert('Formato de imagem não permitido!'); history.back();</script>";
}
?>