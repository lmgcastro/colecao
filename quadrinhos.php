<?php
    header('Content-type: text/html; charset=utf-8 charset=UTF-8');
    include_once 'db/dbh.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Filmes</title>
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
            $quadrinhos['titulo'][] = $row['Titulo'];
            $quadrinhos['artistas'][] = $row['Artistas'];
            $quadrinhos['editora'][] = $row['Editora'];
            $quadrinhos['original'][] = $row['Original'];
            $quadrinhos['lido'][] = $row['Lido'];
        }
    }
    //SELECT PREENCHIMENTO INPUT ARTISTAS
    $sqlArt = "SELECT DISTINCT Artistas FROM quadrinhos ORDER BY Artistas;";
    $resultArt = mysqli_query($conn, $sqlArt);
    $resultCheckArt = mysqli_num_rows($resultArt);

    if ($resultCheckArt > 0) {
        while ($rowArt = mysqli_fetch_assoc($resultArt)) {
            $art[] = $rowArt['Artistas'];
        }
    }
    //SELECT PREENCHIMENTO INPUT EDITORA
    $sqlEdit = "SELECT DISTINCT Editora FROM quadrinhos ORDER BY Editora;";
    $resultEdit = mysqli_query($conn, $sqlEdit);
    $resultCheckEdit = mysqli_num_rows($resultEdit);

    if ($resultCheckEdit > 0) {
        while ($rowEdit = mysqli_fetch_assoc($resultEdit)) {
            $edit[] = $rowEdit['Editora'];
        }
    }
    //SELECT PREENCHIMENTO INPUT ORIGINAL
    $sqlOrig = "SELECT DISTINCT Original FROM quadrinhos ORDER BY Original;";
    $resultOrig = mysqli_query($conn, $sqlOrig);
    $resultCheckOrig = mysqli_num_rows($resultOrig);

    if ($resultCheckOrig > 0) {
        while ($rowOrig = mysqli_fetch_assoc($resultOrig)) {
            $orig[] = $rowOrig['Original'];
        }
    }
?>
    <ul class="nav">
        <li><button id="novo">Novo</button></li>
        <li><a href="filmes.php">Filmes</a></li>
        <li><a href="cds.php">CDs</a></li>
        <li><a id="atual" href="#">Quadrinhos</a></li>
        <li><a href="mangas.php">Mangás</a></li>
    </ul>
    <div id="addQuadrinho">
        <form action="db/adicionar_quadrinho.php" method="POST">
            <input type="text" name="titulo" placeholder="Título" size="45">
            <input list="artistas" name="artistas" placeholder="Artistas" size="45">
            <datalist id="artistas">
<?php
    for ($c = 0; $c < count($art); $c++) {
?>
                <option value="<?php echo $art[$c] ?>">
<?php
    }
?>
            </datalist>
            <input list="editora" name="editora" placeholder="Editora" size="20">
            <datalist id="editora">
<?php
    for ($c = 0; $c < count($edit); $c++) {
?>
                <option value="<?php echo $edit[$c] ?>">
<?php
    }
?>
            </datalist>
            <input list="original" name="original" placeholder="Original" size="20">
            <datalist id="original">
<?php
    for ($c = 0; $c < count($orig); $c++) {
?>
                <option value="<?php echo $orig[$c] ?>">
<?php
    }
?>
            </datalist>
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
    for ($c = 0; $c < count($quadrinhos['titulo']); $c++) {
        $lido = $quadrinhos['lido'][$c];
        if ($lido == 'S') {
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
                    <button class="lido" <?php echo $corFundo ?> type="submit" name="submit" value="<?php echo $quadrinhos['titulo'][$c] ?>"><?php echo $lidoTexto ?></button>
                </form>
            </td>
            <td class="titulo"><?php echo $quadrinhos['titulo'][$c] ?></td>
            <td><?php echo $quadrinhos['artistas'][$c] ?></td>
            <td><?php echo $quadrinhos['editora'][$c] ?></td>
            <td><?php echo $quadrinhos['original'][$c] ?></td>
        </tr>
<?php
    }
?>
    </table>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/quadrinhos.js"></script>
</body>
</html>