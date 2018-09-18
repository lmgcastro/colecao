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
    $sql = "SELECT * FROM cds ORDER BY Titulo;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $titulo[] = $row['Titulo'];
            $artista[] = $row['Artista'];
            $ano[] = $row['Ano'];
            $selo[] = $row['Selo'];
            $duracao[] = $row['Duracao'];
            $discos[] = $row['Discos'];
            $data[] = $row['Data'];
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
    <div id="addCd">
        <form action="db/adicionar_cd.php" method="POST">
            <input type="text" name="titulo" placeholder="Título" size="30">
            <input list="artista" name="artista" placeholder="Artista" size="25">
<?php
    echo '<datalist id="artista">';
    $temp_unique_artista = array_unique($artista);
    $unique_artista = array_values($temp_unique_artista);
    sort($unique_artista);
    for ($c = 0; $c < count($unique_artista); $c++) {
            echo '<option value="' . $unique_artista[$c] . '">';
    }
    echo '</datalist>';
?>
            <input type="text" name="ano" placeholder="Ano" size="5">
            <input list="selo" name="selo" placeholder="Selo" size="15">
<?php
    echo '<datalist id="selo">';
    $temp_unique_selo = array_unique($selo);
    $unique_selo = array_values($temp_unique_selo);
    sort($unique_selo);
    for ($c = 0; $c < count($unique_selo); $c++) {
            echo '<option value="' . $unique_selo[$c] . '">';
    }
    echo '</datalist>';
?>
            <input type="text" name="duracao" placeholder="Duração" size="10">
            <input type="text" name="discos" placeholder="Discos" size="5">
            <input type="date" name="data" placeholder="Data">
            <button type="submit" name="submit">Adicionar</button>
        </form>
    </div>
    <table id="tblCds">
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
    for ($c = 0; $c < count($titulo); $c++) {
?>
        <tr>
            <td><?php echo $c + 1 ?></td>
            <td class="titulo"><?php echo $titulo[$c] ?></td>
            <td><?php echo $artista[$c] ?></td>
            <td><?php echo $ano[$c] ?></td>
            <td><?php echo $selo[$c] ?></td>
            <td><?php echo $duracao[$c] ?></td>
            <td><?php echo $discos[$c] ?></td>
            <td><?php echo date('d/m/Y', strtotime($data[$c])) ?></td>
        </tr>
<?php
    }
?>
    </table>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/cds.js"></script>
</body>
</html>
