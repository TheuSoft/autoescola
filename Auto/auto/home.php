<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
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
            background-image: url('img/Car\ accesories-amico.png');
            background-size: contain;
            /* Redimensiona a imagem para caber na div */
            background-position: center;
            /* Posiciona a imagem no centro */
            background-repeat: no-repeat;
            /* Evita a repetição da imagem */
            padding: 450px;
            /* Altura da div, ajuste conforme necessário */
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
        <a href="cdalunos.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'cdaluno.php' ? 'current-page' : ''; ?>">Cadastro Alunos</a>
        <a href="cdcarros.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'cdcarros.php' ? 'current-page' : ''; ?>">Cadastro Carros</a>
        <a href="agendaaulas.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'agendaaulas.php' ? 'current-page' : ''; ?>">Agendamento Aulas</a>
        <!-- Adicione mais links conforme necessário -->
    </div>
    <div class="main-content">
    </div>

</body>

</html>