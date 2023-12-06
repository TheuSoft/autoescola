<?php
include_once('conexao.php');

//Inserir a Tabela alunos
if (isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];

    $result = mysqli_query($conexao, "INSERT INTO `alunos`(`nome`, `cpf`, `data_nascimento`, `endereco`, `telefone`) VALUES ('$nome','$cpf','$data_nascimento','$endereco','$telefone')");
}
if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT * FROM alunos WHERE id LIKE '%$data%' OR nome LIKE '%$data%' OR cpf LIKE '%$data%'ORDER BY id DESC";
} else {

    $sql = "SELECT * FROM alunos ORDER BY id DESC";
}

$result =  $conexao->query($sql);
// Excluir a Tabela alunos 
if (isset($_GET['id_deletar'])) {
    $id_deletar = $_GET['id_deletar'];
    $sqlDelete = "DELETE FROM alunos WHERE id=$id_deletar";
    $resultDelete = $conexao->query($sqlDelete);

    if ($resultDelete) {
        // Redirecionar para esta página após a exclusão com um parâmetro na URL indicando o sucesso da exclusão
        header('Location: cdalunos.php?exclusao=sucesso');
        exit();
    } else {
        // Em caso de erro na exclusão
        echo "<script>alert('Ocorreu um erro ao deletar o aluno');</script>";
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
    <title>Cadastro de Alunos</title>
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
        <a href="cdalunos.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'cdalunos.php' ? 'current-page' : ''; ?>">Cadastro Alunos</a>
        <a href="cdcarros.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'cdcarros.php' ? 'current-page' : ''; ?>">Cadastro Carros</a>
        <a href="agendaaulas.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'agendaaulas.php' ? 'current-page' : ''; ?>">Agendamento Aulas</a>
        <!-- Adicione mais links conforme necessário -->
    </div>
    <div class="main-content">
        <h1>Cadastro de Aluno</h1>
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
            echo "<script>alert('Aluno excluído com sucesso');</script>";
        }
        ?>

        <!-- Formulário para cadastro e edição de carros -->
        <form id="alForm" action="cdalunos.php" method="POST">
            <input type="hidden" id="id" name="id">
            <input type="text" name="nome" id="nome" placeholder="Nome" required>
            <input type="text" name="cpf" id="cpf" placeholder="CPF" required oninput="formatarCPF(this)">
            <input type="date" name="data_nascimento" id="data_nascimento" placeholder="Data Nascimento">
            <input type="text" name="endereco" id="endereco" placeholder="Endereco" required>
            <input type="text" name="telefone" id="telefone" placeholder="Telefone" required oninput="formatarTelefone(this)">
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
        <h1>Alunos Cadastrados</h1>

        <div class="resultado">
            <table class="table w-50">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Data Nascimento</th>
                        <th scope="col">Endereco</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Mostrar os registros dos dados criados
                    while ($user_data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $user_data['id'] . "</td>";
                        echo "<td>" . $user_data['nome'] . "</td>";
                        echo "<td>" . $user_data['cpf'] . "</td>";
                        echo "<td>" . $user_data['data_nascimento'] . "</td>";
                        echo "<td>" . $user_data['endereco'] . "</td>";
                        echo "<td>" . $user_data['telefone'] . "</td>";
                        echo "<td>
            <a class='btn btn-sm btn-primary' href='editalunos.php?id=$user_data[id]'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
                    <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
                </svg>
            </a>
        </td>";
                        echo "<td>
        <a class='btn btn-sm btn-danger' href='cdalunos.php?id_deletar=" . $user_data['id'] . "' onclick='return confirmDelete();'>
            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
            </svg>
        </a>
    </td>";
                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
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
        window.location = 'cdalunos.php?search=' + search.value;
    }
</script>

</html>