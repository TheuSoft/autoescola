<?php
include_once('conexao.php');

$sql = "SELECT * FROM agendamentos"; // Consulta padrão

// Verifica se o formulário foi submetido
if (isset($_POST['submit'])) {
    $aluno_id = $_POST['aluno_id'];
    $carro_id = $_POST['carro_id'];
    $data_aula = $_POST['data_aula'];
    $horario_aula = $_POST['horario_aula'];

    // Inserir dados na tabela de agendamentos
    $result = mysqli_query($conexao, "INSERT INTO `agendamentos`(`aluno_id`, `carro_id`, `data_aula`, `horario_aula`) VALUES ('$aluno_id','$carro_id','$data_aula','$horario_aula')");

    // Atualiza a consulta para exibir os dados atualizados após a inserção
    $sql = "SELECT * FROM agendamentos";
}

$result = $conexao->query($sql);

$alunosResult = $conexao->query("SELECT * FROM alunos");
$carrosResult = $conexao->query("SELECT * FROM carros");
$agendamentosResult = $conexao->query("SELECT * FROM agendamentos");

if (isset($_GET['id_deletar'])) {
    $id_deletar = $_GET['id_deletar'];
    $sqlDelete = "DELETE FROM agendamentos WHERE id=$id_deletar";
    $resultDelete = $conexao->query($sqlDelete);

    if ($resultDelete) {
        // Redirecionar para esta página após a exclusão com um parâmetro na URL indicando o sucesso da exclusão
        header('Location: agendaaulas.php?exclusao=sucesso');
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
    <title>Agendamento Aula</title>
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
        // Verifica se o parâmetro 'exclusao' está presente na URL e exibe a mensagem correspondente
        if (isset($_GET['exclusao']) && $_GET['exclusao'] === 'sucesso') {
            echo "<script>alert('Agendamento cancelado com sucesso');</script>";
        }
        ?>
        <h1>Agendamento Aula</h1>

        <form id="agForm" action="agendaaulas.php" method="POST">
            <input type="hidden" id="id" name="id">
            <select name="aluno_id" id="aluno_id" required>
                <option value="">Selecione um aluno</option>
                 <!-- Puxa a id e o nome do Aluno -->
                <?php
                while ($aluno = $alunosResult->fetch_assoc()) {
                    echo '<option value="' . $aluno['id'] . '">' . $aluno['nome'] . '</option>';
                }
                ?>
            </select>

            <select name="carro_id" id="carro_id" required>
                <option value="">Selecione um carro</option>
                <!-- Puxa a id e o nome do Carro -->
                <?php
                while ($carro = $carrosResult->fetch_assoc()) {
                    echo '<option value="' . $carro['id'] . '">' . $carro['modelo'] . '</option>';
                }
                ?>
            </select>
            <input type="date" name="data_aula" id="data_aula" placeholder="Data Nascimento" required>
            <input type="time" name="horario_aula" id="horario_aula" placeholder="Endereco" required>
            <input type="submit" name="submit" id="submit">
        </form>
        <br>
        <h1>Agendamentos Marcados</h1>
        <div class="resultado">
            <table class="table w-50">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">ALUNO</th>
                        <th scope="col">CARRO</th>
                        <th scope="col">DATA AULA</th>
                        <th scope="col">HORARIO AULA</th>
                        <th scope="col">Cancelar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($user_data = mysqli_fetch_assoc($agendamentosResult)) {
                        echo "<tr>";
                        echo "<td>" . $user_data['id'] . "</td>";

                        // Consulta para obter o nome do aluno com base no aluno_id
                        $aluno_id = $user_data['aluno_id'];
                        $query_aluno = "SELECT nome FROM alunos WHERE id = $aluno_id";
                        $result_aluno = $conexao->query($query_aluno);
                        $aluno = $result_aluno->fetch_assoc();
                        echo "<td>" . $aluno['nome'] . "</td>";

                        // Consulta para obter o modelo do carro com base no carro_id
                        $carro_id = $user_data['carro_id'];
                        $query_carro = "SELECT modelo FROM carros WHERE id = $carro_id";
                        $result_carro = $conexao->query($query_carro);
                        $carro = $result_carro->fetch_assoc();
                        echo "<td>" . $carro['modelo'] . "</td>";

                        echo "<td>" . $user_data['data_aula'] . "</td>";
                        echo "<td>" . $user_data['horario_aula'] . "</td>";
                        echo "<td>
                        <a class='btn btn-sm btn-danger' href='agendaaulas.php?id_deletar=" . $user_data['id'] . "' onclick='return confirmDeleteag();'>
                                Cancelar
                            </a>
                          </td>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="elementos.js"></script>

</html>