<?php
    header('Content-type: text/html; charset=utf-8 charset=UTF-8');
    include_once 'db/dbh.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quadrinhos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
    //SELECT PREENCHIMENTO TABELA
    $sql = "SELECT * FROM quadrinhos ORDER BY Titulo;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $titulo[] = $row['Titulo'];
            $artistas[] = $row['Artistas'];
            $editora[] = $row['Editora'];
            $original[] = $row['Original'];
            $lido[] = $row['Lido'];
        }
    }
?>
    <ul class="nav">
        <li><button id="novo">Novo</button></li>
        <li><a href="filmes.php">Filmes</a></li>
        <li><a id="atual" href="#">Quadrinhos</a></li>
        <li><a href="mangas.php">Mangás</a></li>
    </ul>
    <div id="addQuadrinho">
        <form action="db/adicionar_quadrinho.php" method="POST">
            <input type="text" name="titulo" placeholder="Título" size="45">
            <input list="artistas" name="artistas" placeholder="Artistas" size="45">
<?php
    echo '<datalist id="artistas">';
    $temp_unique_artistas = array_unique($artistas);
    $unique_artistas = array_values($temp_unique_artistas);
    sort($unique_artistas);
    for ($c = 0; $c < count($unique_artistas); $c++) {
            echo '<option value="' . $unique_artistas[$c] . '">';
    }
    echo '</datalist>';
?>
            <input list="editora" name="editora" placeholder="Editora" size="20">
<?php
    echo '<datalist id="editora">';
    $temp_unique_editora = array_unique($editora);
    $unique_editora = array_values($temp_unique_editora);
    sort($unique_editora);
    for ($c = 0; $c < count($unique_editora); $c++) {
            echo '<option value="' . $unique_editora[$c] . '">';
    }
    echo '</datalist>';
?>
            <input list="original" name="original" placeholder="Original" size="20">
<?php
    echo '<datalist id="original">';
    $temp_unique_original = array_unique($original);
    $unique_original = array_values($temp_unique_original);
    sort($unique_original);
    for ($c = 0; $c < count($unique_original); $c++) {
            echo '<option value="' . $unique_original[$c] . '">';
    }
    echo '</datalist>';
?>
            <button type="submit" name="submit">Adicionar</button>
        </form>
    </div>
    <table id="tblQuadrinhos">
        <tr>
            <th>Nº</th>
            <th>Lido</th>
            <th>Título</th>
            <th>Artistas</th>
            <th>Editora</th>
            <th>Editora original</th>
        </tr>
<?php
    for ($c = 0; $c < count($titulo); $c++) {
        if ($lido[$c] == 'S') {
            $corFundo = 'style="background-color: #66ff33"';
            $lidoTexto = '';
        } else {
            $corFundo = 'style="background-color: #ff3333"';
            $lidoTexto = '+';
        }
?>
        <tr>
            <td><?php echo $c + 1 ?></td>
            <td <?php echo $corFundo ?>>
                <form action="db/status_quadrinho.php" method="POST">
                    <button class="lido" <?php echo $corFundo ?> type="submit" name="submit" value="<?php echo $titulo[$c] ?>"><?php echo $lidoTexto ?></button>
                </form>
            </td>
            <td class="titulo"><?php echo $titulo[$c] ?></td>
            <td><?php echo $artistas[$c] ?></td>
            <td><?php echo $editora[$c] ?></td>
            <td><?php echo $original[$c] ?></td>
        </tr>
<?php
    }
?>
    </table>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/quadrinhos.js"></script>
</body>
</html>
