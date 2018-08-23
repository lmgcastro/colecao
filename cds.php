<?php
    header('Content-type: text/html; charset=utf-8 charset=UTF-8');
    include_once 'db/dbh.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Filmes</title>
    <link rel="stylesheet" href="css/cds.css">
</head>
<body>
<?php
    //SELECT PREENCHIMENTO TABELA
    $sql = "SELECT * FROM cds ORDER BY Titulo;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cds['titulo'][] = $row['Titulo'];
            $cds['artista'][] = $row['Artista'];
            $cds['ano'][] = $row['Ano'];
            $cds['selo'][] = $row['Selo'];
            $cds['duracao'][] = $row['Duracao'];
            $cds['discos'][] = $row['Discos'];
            $cds['data'][] = $row['Data'];
        }
    }
    //SELECT PREENCHIMENTO INPUT ARTISTA
    $sqlArtista = "SELECT DISTINCT Artista FROM cds ORDER BY Artista;";
    $resultArtista = mysqli_query($conn, $sqlArtista);
    $resultCheckArtista = mysqli_num_rows($resultArtista);

    if ($resultCheckArtista > 0) {
        while ($rowArtista = mysqli_fetch_assoc($resultArtista)) {
            $artista[] = $rowArtista['Artista'];
        }
    }
    //SELECT PREENCHIMENTO INPUT SELO
    $sqlSelo = "SELECT DISTINCT Selo FROM cds ORDER BY Selo;";
    $resultSelo = mysqli_query($conn, $sqlSelo);
    $resultCheckSelo = mysqli_num_rows($resultSelo);

    if ($resultCheckSelo > 0) {
        while ($rowSelo = mysqli_fetch_assoc($resultSelo)) {
            $selo[] = $rowSelo['Selo'];
        }
    }
?>
    <ul class="nav">
        <li><button id="novo">Novo</button></li>
        <li><a href="filmes.php">Filmes</a></li>
        <li><a id="atual" href="#">CDs</a></li>
        <li><a href="quadrinhos.php">Quadrinhos</a></li>
        <li><a href="mangas.php">Mangás</a></li>
    </ul>
    <div id="adicionar">
        <form action="db/adicionar_cd.php" method="POST">
            <input type="text" name="titulo" placeholder="Título" size="30">
            <input list="artista" name="artista" placeholder="Artista" size="25">
            <datalist id="artista">
<?php
    for ($c = 0; $c < count($artista); $c++) {
?>
                <option value="<?php echo $artista[$c] ?>">
<?php
    }
?>
            </datalist>
            <input type="text" name="ano" placeholder="Ano" size="5">
            <input list="selo" name="selo" placeholder="Selo" size="15">
            <datalist id="selo">
<?php
    for ($c = 0; $c < count($selo); $c++) {
?>
                <option value="<?php echo $selo[$c] ?>">
<?php
    }
?>
            </datalist>
            <input type="text" name="duracao" placeholder="Duração" size="10">
            <input type="text" name="discos" placeholder="Discos" size="5">
            <input type="date" name="data" placeholder="Data">
            <button type="submit" name="submit">Adicionar</button>
        </form>
    </div>
    <table>
        <tr>
            <th>Nº</th>
            <th>Título</th>
            <th>Artista</th>
            <th>Ano</th>
            <th>Selo</th>
            <th>Duração</th>
            <th>Discos</th>
            <th>Data</th>
        </tr>
<?php
    for ($c = 0; $c < count($cds['titulo']); $c++) {
?>
        <tr>
            <td><?php echo $c + 1 ?></td>
            <td class="titulo"><?php echo $cds['titulo'][$c] ?></td>
            <td><?php echo $cds['artista'][$c] ?></td>
            <td><?php echo $cds['ano'][$c] ?></td>
            <td><?php echo $cds['selo'][$c] ?></td>
            <td><?php echo $cds['duracao'][$c] ?></td>
            <td><?php echo $cds['discos'][$c] ?></td>
            <td><?php echo $cds['data'][$c] ?></td>
        </tr>
<?php
    }
?>
    </table>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/cds.js"></script>
</body>
</html>