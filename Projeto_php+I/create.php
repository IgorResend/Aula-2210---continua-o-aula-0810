<?php
require 'banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeErro = $enderecoErro = $emailErro = $idadeErro = null;
    $validacao = true;

    $nome = $_POST['nome'] ?? null;
    $endereco = $_POST['endereco'] ?? null;
    $email = $_POST['email'] ?? null;
    $idade = $_POST['idade'] ?? null;

    if (empty($nome)) {
        $nomeErro = 'Por favor, digite o seu nome!';
        $validacao = false;
    }
    
    if (empty($endereco)) {
        $enderecoErro = 'Por favor, digite o seu endereço!';
        $validacao = false;
    }
    
    if (empty($email)) {
        $emailErro = 'Por favor, digite um endereço de email!';
        $validacao = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErro = 'Por favor, digite um endereço de email válido!';
        $validacao = false;
    }

    if (empty($idade)) {
        $idadeErro = 'Por favor, selecione um campo!';
        $validacao = false;
    }

    if ($validacao) {
        try {
            $pdo = Banco::conectar();
            $sql = "INSERT INTO tb_alunos (nome, endereco, email, idade) VALUES (?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nome, $endereco, $email, $idade));
            Banco::desconectar();
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            echo "Erro ao inserir dados: " . $e->getMessage();
            Banco::desconectar();
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Adicionar Contato</title>
</head>
<body>
<div class="container">
    <div class="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3>Adicionar Contato</h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="create.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input class="form-control" name="nome" type="text" placeholder="Nome" value="<?php echo htmlspecialchars($nome ?? ''); ?>">
                        <?php if (!empty($nomeErro)): ?>
                            <div class="text-danger"><?php echo $nomeErro; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <input class="form-control" name="endereco" type="text" placeholder="Endereço" value="<?php echo htmlspecialchars($endereco ?? ''); ?>">
                        <?php if (!empty($enderecoErro)): ?>
                            <div class="text-danger"><?php echo $enderecoErro; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" name="email" type="text" placeholder="Email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                        <?php if (!empty($emailErro)): ?>
                            <div class="text-danger"><?php echo $emailErro; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Idade</label>
                        <input class="form-control" type="text" name="idade" value="<?php echo htmlspecialchars($idade ?? ''); ?>">
                        <?php if (!empty($idadeErro)): ?>
                            <div class="text-danger"><?php echo $idadeErro; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Adicionar</button>
                        <a href="index.php" class="btn btn-default">Voltar</a>
                    </div>
                </form>
            </div>
        </div
