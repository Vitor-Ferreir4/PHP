<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $biografia = trim($_POST['biografia']);

    $mensagem = '';

    if (empty($nome) || empty($email) || empty($data_nascimento) || empty($genero) || empty($biografia)) {
        $mensagem = "Por favor, preencha todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Por favor, insira um e-mail válido.";
    } elseif (count(explode(' ', $nome)) < 2) {
        $mensagem = "O nome deve conter pelo menos dois nomes.";
    } else {
        $sql = "INSERT INTO usuarios (nome, email, data_nascimento, genero, biografia) 
                VALUES (:nome, :email, :data_nascimento, :genero, :biografia)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':biografia', $biografia);

        if ($stmt->execute()) {
            $mensagem = "Cadastro concluído com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Cadastro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Resultado do Cadastro</h2>
        <p class="mensagem"><?php echo $mensagem; ?></p>
        <a href="index.php" >Voltar ao formulário</a>
        <a href="usuarios.php">Ver Usuários Cadastrados</a>
    </div>
</body>
</html>