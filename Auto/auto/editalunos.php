<?php
include_once('conexao.php');

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sqlSelect = "SELECT * FROM alunos WHERE id=$id";
    $result =  $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {
        while ($user_data = mysqli_fetch_assoc($result)) {
            $nome = $user_data['nome'];
            $cpf = $user_data['cpf'];
            $data_nascimento = $user_data['data_nascimento'];
            $endereco = $user_data['endereco'];
            $telefone = $user_data['telefone'];
        }
    } else {
        header('Location: cdalunos.php');
        exit;
    }
} else {
    header('Location: cdalunos.php');
    exit;
}

if (isset($_POST['update'])) {
    // Lógica para atualizar os dados do aluno
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];

    $sqlUpdate = "UPDATE alunos SET nome='$nome', cpf='$cpf', data_nascimento='$data_nascimento', endereco='$endereco', telefone='$telefone' WHERE id= '$id'";

    $result = $conexao->query($sqlUpdate);

    if ($result) {
        // Redirecionamento para cdalunos.php com mensagem de sucesso
        header('Location: cdalunos.php?mensagem=Aluno+editado+com+sucesso');
        exit;
    } else {
        // Se houver um erro na atualização, pode adicionar um tratamento de erro aqui
        echo "Erro ao atualizar os dados.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Editar Alunos</title>
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            /* Largura do menu lateral */
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            /* Cor de fundo do menu */
            overflow-x: hidden;
            padding-top: 20px;
        }

        .sidebar a.current-page {
            background-color: #555;
            /* Cor de fundo para a página atual */
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
        }

        .sidebar a:hover {
            background-color: #555;
            /* Cor de fundo ao passar o mouse */
        }

        /* Estilos para o conteúdo principal */
        .main-content {
            margin-left: 250px;
            /* Largura do menu lateral */
            padding: 20px;

        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="time"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"],
        button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button {
            margin-top: 10px;
            background-color: #f44336;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .search {
            margin-bottom: 20px;
        }

        .box-search {
            display: flex;
            justify-content: center;
            gap: .1%;
        }

        .resultado {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href="home.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'current-page' : ''; ?>">Home</a>
        <a href="cdalunos.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'cdalunos.php' ? 'current-page' : ''; ?>">Cadastro Alunos</a>
        <a href="cdcarros.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'cdcarros.php' ? 'current-page' : ''; ?>">Cadastro Carros</a>
        <a href="agendaaulas.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'agendaaulas.php' ? 'current-page' : ''; ?>">Agendamento Aulas</a>
        <!-- Adicione mais links conforme necessário -->
    </div>
    <div class="main-content">
    <h1>Editar Alunos</h1>

    <!-- Formulário para cadastro e edição de carros -->
    <form id="aluForm" action="editalunos.php?id=<?php echo $id; ?>" method="POST">
        <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
        <input type="text" name="nome" id="nome" placeholder="Nome" value="<?php echo $nome ?>" required>
        <input type="text" name="cpf" id="cpf" placeholder="CPF" value="<?php echo $cpf ?>" required oninput="formatarCpf(this)">
        <input type="date" name="data_nascimento" id="data_nascimento" placeholder="Data Nascimento" value="<?php echo $data_nascimento ?>" required>
        <input type="text" name="endereco" id="endereco" placeholder="Endereco" value="<?php echo $endereco ?>" required>
        <input type="text" name="telefone" id="telefone" placeholder="Telefone" value="<?php echo $telefone ?>" required oninput="formatarTelefone(this)">
        <input type="submit" name="update" id="submit" value="Atualizar">        
    </form>
    </div>
    <script src="elementos.js" ></script>
</body>
</html>