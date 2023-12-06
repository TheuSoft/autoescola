<?php
include_once('conexao.php');
//Inserir Tabela Alunos
if (isset($_POST['submit'])) {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $placa = $_POST['placa'];
    $capacidade_passageiros = $_POST['capacidade_passageiros'];

    $result = mysqli_query($conexao, "INSERT INTO `carros`(`marca`, `modelo`, `ano`, `placa`, `capacidade_passageiros`) VALUES ('$marca','$modelo','$ano','$placa','$capacidade_passageiros')");
}
if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT * FROM carros WHERE id LIKE '%$data%' OR marca LIKE '%$data%' OR modelo LIKE '%$data%' OR placa LIKE '%$data%' ORDER BY id DESC";
} else {

    $sql = "SELECT * FROM carros ORDER BY id DESC";
}

$result =  $conexao->query($sql);

// Deletar tabela Carros
if (isset($_GET['id_deletar'])) {
    $id_deletar = $_GET['id_deletar'];
    $sqlDelete = "DELETE FROM carros WHERE id=$id_deletar";
    $resultDelete = $conexao->query($sqlDelete);

    if ($resultDelete) {
        // Redirecionar para esta página após a exclusão com um parâmetro na URL indicando o sucesso da exclusão
        header('Location: cdcarros.php?exclusao=sucesso');
        exit();
    } else {
        // Em caso de erro na exclusão
        echo "<script>alert('Ocorreu um erro ao deletar o carro');</script>";
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Cadastro de Carros</title>
    <style>
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
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .sidebar a.current-page {
            background-color: #555;
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
        }

        .main-content {
            margin-left: 250px;
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
        <!-- PHP_SELF indica onde esta a pagina atual para que o Hover permaneca -->
        <a href="home.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'current-page' : ''; ?>">Home</a>
        <a href="cdalunos.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'cdaluno.php' ? 'current-page' : ''; ?>">Cadastro Alunos</a>
        <a href="cdcarros.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'cdcarros.php' ? 'current-page' : ''; ?>">Cadastro Carros</a>
        <a href="agendaaulas.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'agendaaulas.php' ? 'current-page' : ''; ?>">Agendamento Aulas</a>
    </div>
    <div class="main-content">
        <?php
        // Verifica se existe uma mensagem na URL
        if (isset($_GET['mensagem'])) {
            $mensagem = $_GET['mensagem'];
            // Exibe a mensagem para o usuário
            echo "<script>alert('$mensagem');</script>";
        }
        ?>
        <?php
        // Verifica se o parâmetro 'exclusao' está presente na URL e exibe a mensagem correspondente
        if (isset($_GET['exclusao']) && $_GET['exclusao'] === 'sucesso') {
            echo "<script>alert('Carro excluído com sucesso');</script>";
        }
        ?>
        <h1>Cadastro de Carro</h1>

        <!-- Formulário para cadastro e edição de carros -->
        <form id="carForm" action="cdcarros.php" method="POST">
            <input type="hidden" id="id" name="id">
            <select name="marca" id="marca" required>
                <option value="">Selecione uma Marca</option>
                <option value="Fiat">Fiat</option>
                <option value="Renault">Renault</option>
                <option value="Chevrolet ">Chevrolet </option>
                <option value="Volkswagen">Volkswagen</option>
            </select>
            <select name="modelo" id="modelo" required>
                <option value="">Selecione um Modelo</option>
                <option value="Uno">Uno</option>
                <option value="Kwid">Kwid</option>
                <option value="Onix">Onix </option>
                <option value="Gol">Gol</option>
                <option value="Gol">Gol</option>
                <option value="Gol">Up</option>
            </select>
            <input type="number" id="ano" name="ano" placeholder="Ano" min="1998" max="2023" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" required>
            <input type="text" name="placa" id="placa" placeholder="Placa" required oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
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
        " maxlength="7" pattern="[A-Za-z]{3}\s?[0-9]{1}[A-Za-z]{1}[0-9]{2}" title="Insira uma placa válida no formato XXX 1X11">
            <input type="number" name="capacidade_passageiros" id="capacidade_passageiros" placeholder="Capacidade de Passageiros" min="2" max="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2" required>
            <input type="submit" name="submit" id="submit">
        </form>
        <br>

        <div class="box-search">
            <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar">
            <button onclick="searchData()" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
            </button>
        </div>
        <br>
        <h1>Carros Cadastrados</h1>

        <div class="resultado">
            <table class="table w-50">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Ano</th>
                        <th scope="col">Placa</th>
                        <th scope="col">Capacidade</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($user_data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $user_data['id'] . "</td>";
                        echo "<td>" . $user_data['marca'] . "</td>";
                        echo "<td>" . $user_data['modelo'] . "</td>";
                        echo "<td>" . $user_data['ano'] . "</td>";
                        echo "<td>" . $user_data['placa'] . "</td>";
                        echo "<td>" . $user_data['capacidade_passageiros'] . "</td>";
                        echo "<td>
                        <a class='btn btn-sm btn-primary' href='editcarros.php?id=$user_data[id]'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
  <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
</svg>
</a>
</td>";
                        echo "<td>
<a class='btn btn-sm btn-danger' href='cdcarros.php?id_deletar=" . $user_data['id'] . "' onclick='return confirmDeletecr();'>
    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
        <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
    </svg>
</a>
</td>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
</body>
<script src="elementos.js"></script>
<script>
    var search = document.getElementById('pesquisar');

    search.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            searchData();
        }
    });

    function searchData() {
        window.location = 'cdcarros.php?search=' + search.value;
    }
</script>

</html>