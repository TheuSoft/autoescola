<?php
include_once('conexao.php');

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sqlSelect = "SELECT * FROM carros WHERE id=$id";
    $result =  $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {
        while ($user_data = mysqli_fetch_assoc($result)) {
            $marca = $user_data['marca'];
            $modelo = $user_data['modelo'];
            $ano = $user_data['ano'];
            $placa = $user_data['placa'];
            $capacidade_passageiros = $user_data['capacidade_passageiros'];
        }
    } else {
        // Se não encontrar um carro com o ID fornecido, redireciona para a página de cadastro de carros
        header('Location: cdcarros.php');
        exit;
    }
} else {
    // Se não houver ID fornecido, redireciona para a página de cadastro de carros
    header('Location: cdcarros.php');
    exit;
}

if (isset($_POST['update'])) {
    // Lógica para atualizar os dados
    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $placa = $_POST['placa'];
    $capacidade_passageiros = $_POST['capacidade_passageiros'];

    $sqlUpdate = "UPDATE carros SET marca='$marca', modelo='$modelo', ano='$ano', placa='$placa', capacidade_passageiros='$capacidade_passageiros' WHERE id= '$id'";

    $result = $conexao->query($sqlUpdate);

    if ($result) {
        // Redirecionamento para cdalunos.php com mensagem de sucesso
        header('Location: cdcarros.php?mensagem=Carro+editado+com+sucesso');
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
    <title>Cadastro de Carros</title>
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
        <h1>Cadastro de Carros</h1>

        <!-- Formulário para cadastro e edição de carros -->
        <form id="carForm" action="editcarros.php?id=<?php echo $id; ?>" method="POST">
            <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
            <select name="marca" id="marca" required>
                <option value="">Selecione uma Marca</option>
                <option value="Fiat" <?php echo ($marca == 'Fiat') ? 'selected' : ''; ?>>Fiat</option>
                <option value="Renault" <?php echo ($marca == 'Renault') ? 'selected' : ''; ?>>Renault</option>
                <option value="Chevrolet" <?php echo ($marca == 'Chevrolet') ? 'selected' : ''; ?>>Chevrolet</option>
                <option value="Volkswagen" <?php echo ($marca == 'Volkswagen') ? 'selected' : ''; ?>>Volkswagen</option>
            </select>
            <select name="modelo" id="modelo" required>
                <option value="">Selecione um Modelo</option>
                <option value="Uno" <?php echo ($modelo == 'Uno') ? 'selected' : ''; ?>>Uno</option>
                <option value="Kwid" <?php echo ($modelo == 'Kwid') ? 'selected' : ''; ?>>Kwid</option>
                <option value="Onix" <?php echo ($modelo == 'Onix') ? 'selected' : ''; ?>>Onix</option>
                <option value="Gol" <?php echo ($modelo == 'Gol') ? 'selected' : ''; ?>>Gol</option>
                <option value="Up" <?php echo ($modelo == 'Up') ? 'selected' : ''; ?>>Up</option>
            </select>
            <input type="number" name="ano" id="ano" placeholder="Ano" value="<?php echo $ano ?>" min="1998" max="2023" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" required>
            <input type="text" name="placa" id="placa" placeholder="Placa" value="<?php echo $placa ?>" required oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
        if (this.value.length > 7) this.value = this.value.slice(0, 7);
        if (this.value.length === 3) {
            if (!isNaN(this.value[3])) {
                this.value = this.value.substring(0, 3) + ' ' + this.value[3];
            }
        }
        if (this.value.length === 5) {
            if (isNaN(this.value[4])) {
                this.value = this.value.substring(0, 4) + ' ' + this.value[4];
            }
        }
        this.value = this.value.toUpperCase();
        "
        maxlength="7" pattern="[A-Za-z]{3}\s?[0-9]{1}[A-Za-z]{1}[0-9]{2}"
        title="Insira uma placa válida no formato XXX 1X11">
            <input type="number" name="capacidade_passageiros" id="capacidade_passageiros" placeholder="Capacidade de Passageiros" value="<?php echo $capacidade_passageiros ?>" min="2" max="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" required>
            <input type="submit" name="update" id="submit">

        </form>
    </div>
</body>

</html>