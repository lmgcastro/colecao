<?php
    header('Content-type: text/html; charset=utf-8 charset=UTF-8');
    include_once 'db/dbh.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Filmes</title>
    <link rel="stylesheet" href="css/mangas.css">
</head>
<body>
<?php
    //SELECT PREENCHIMENTO TABELA
    $sql = "SELECT COUNT(Volume) AS Volumes, Titulo, Artistas, Editora, Original, Total FROM mangas GROUP BY Titulo;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $mangas['volumes'][] = $row['Volumes'];
            $mangas['titulo'][] = $row['Titulo'];
            $mangas['artistas'][] = $row['Artistas'];
            $mangas['editora'][] = $row['Editora'];
            $mangas['original'][] = $row['Original'];
            $mangas['total'][] = $row['Total'];
        }
    }
    //SELECT PREENCHIMENTO VOLUMES TABELA
    $sqlVol = "SELECT Titulo, Volume, Lido FROM mangas ORDER BY Titulo, Volume;";
    $resultVol = mysqli_query($conn, $sqlVol);
    $resultCheckVol = mysqli_num_rows($resultVol);

    if ($resultCheckVol > 0) {
        while ($rowVol = mysqli_fetch_assoc($resultVol)) {
            $vol['titulo'][] = $rowVol['Titulo'];
            $vol['volume'][] = $rowVol['Volume'];
            $vol['lido'][] = $rowVol['Lido'];
        }
    }
    //SELECT MAIOR TOTAL DE VOLUMES POR TITULO
    $sqlMaxVol = "SELECT COUNT(Volume) AS Total FROM mangas GROUP BY Titulo ORDER BY Total DESC;";
    $resultMaxVol = mysqli_query($conn, $sqlMaxVol);
    $resultCheckMaxVol = mysqli_num_rows($resultMaxVol);

    if ($resultCheckMaxVol > 0) {
        while ($rowMaxVol = mysqli_fetch_assoc($resultMaxVol)) {
            $maxVol[] = $rowMaxVol['Total'];
        }
    }
    //SELECT PREENCHIMENTO INPUT ARTISTAS
    $sqlArt = "SELECT DISTINCT Artistas FROM mangas ORDER BY Artistas;";
    $resultArt = mysqli_query($conn, $sqlArt);
    $resultCheckArt = mysqli_num_rows($resultArt);

    if ($resultCheckArt > 0) {
        while ($rowArt = mysqli_fetch_assoc($resultArt)) {
            $art[] = $rowArt['Artistas'];
        }
    }
    //SELECT PREENCHIMENTO INPUT EDITORA
    $sqlEdit = "SELECT DISTINCT Editora FROM mangas ORDER BY Editora;";
    $resultEdit = mysqli_query($conn, $sqlEdit);
    $resultCheckEdit = mysqli_num_rows($resultEdit);

    if ($resultCheckEdit > 0) {
        while ($rowEdit = mysqli_fetch_assoc($resultEdit)) {
            $edit[] = $rowEdit['Editora'];
        }
    }
    //SELECT PREENCHIMENTO INPUT ORIGINAL
    $sqlOrig = "SELECT DISTINCT Original FROM mangas ORDER BY Original;";
    $resultOrig = mysqli_query($conn, $sqlOrig);
    $resultCheckOrig = mysqli_num_rows($resultOrig);

    if ($resultCheckOrig > 0) {
        while ($rowOrig = mysqli_fetch_assoc($resultOrig)) {
            $orig[] = $rowOrig['Original'];
        }
    }
?>
    <ul class="nav">
        <li><button id="botaoNovo">Novo</button>
            <button id="botaoExistente">+</button></li>
        <li><a href="filmes.php">Filmes</a></li>
        <li><a href="cds.php">CDs</a></li>
        <li><a href="quadrinhos.php">Quadrinhos</a></li>
        <li><a id="atual" href="#">Mangás</a></li>
    </ul>
    <div id="mangaNovo">
        <form action="db/adicionar_manga.php" method="POST">
            <input type="text" name="tituloNovo" placeholder="Título" size="25">
            <input type="text" name="volumeNovo" placeholder="Volume" size="3">
            <input type="text" name="total" placeholder="Total" size="3">
            <input list="artistas" name="artistas" placeholder="Artistas" size="25">
            <datalist id="artistas">
<?php
    // LOOP PREENCHIMENTO ARTISTAS
    for ($c = 0; $c < count($art); $c++) {
?>
                <option value="<?php echo $art[$c] ?>">
<?php
    }
?>
            </datalist>
            <input list="editora" name="editora" placeholder="Editora" size="15">
            <datalist id="editora">
<?php
    // LOOP PREENCHIMENTO EDITORA
    for ($c = 0; $c < count($edit); $c++) {
?>
                <option value="<?php echo $edit[$c] ?>">
<?php
    }
?>
            </datalist>
            <input list="original" name="original" placeholder="Original" size="15">
            <datalist id="original">
<?php
    // LOOP PREENCHIMENTO EDITORA ORIGINAL
    for ($c = 0; $c < count($orig); $c++) {
?>
                <option value="<?php echo $orig[$c] ?>">
<?php
    }
?>
            </datalist>
            <button type="submit" name="submit">Adicionar</button>
        </div>
        <div id="mangaExistente">
            <select id="tituloExistente" name="tituloExistente">
                <option value=""  selected disabled hidden>Selecione</option>
<?php
    // LOOP PREENCHIMENTO TITULOS
    for ($c = 0; $c < count($mangas['titulo']); $c++) {
?>
                <option value="<?php echo $mangas['titulo'][$c] ?>"><?php echo $mangas['titulo'][$c] ?></option>
<?php
    }
?>
            </select>
            <input type="text" name="volumeExistente" placeholder="Volume" size="3">
            <button type="submit" name="submit">Adicionar</button>
        </form>
    </div>
    <table>
        <tr>
            <th>Nº</th>
            <th>Título</th>
            <th>Artistas</th>
            <th>Editora</th>
            <th>Editora original</th>
            <th>Completo</th>
            <th colspan="<?php echo $maxVol[0] ?>">Volumes</th>
        </tr>
<?php
    // CONTADOR INDEX VOLUME
    $vTotal = 0;
    // LOOP PREENCHIMENTO TABELA
    for ($c = 0; $c < count($mangas['titulo']); $c++) {
?>
        <tr>
            <td><?php echo $c + 1 ?></td>
            <td class="titulo"><?php echo $mangas['titulo'][$c] ?></td>
            <td><?php echo $mangas['artistas'][$c] ?></td>
            <td><?php echo $mangas['editora'][$c] ?></td>
            <td><?php echo $mangas['original'][$c] ?></td>
            <td><meter class="completo" value="<?php echo $mangas['volumes'][$c] ?>" min="0" max="<?php echo $mangas['total'][$c] ?>"></meter></td>
<?php
        for ($v = 0; $v < $mangas['volumes'][$c]; $v++) {
            $lido =  $vol['lido'][$vTotal];
            // LOOP COR FUNDO STATUS
            if ($lido == 'S') {
                $corFundo = 'style="background-color: #66ff33"';
            } else {
                $corFundo = 'style="background-color: #ff3333"';
            }
            // LOOP ADICIONAR ZERO UM DÍGITO
            if ($vol['volume'][$vTotal] >= 0 && $vol['volume'][$vTotal] < 10) {
                $zero = '0';
            } else {
                $zero = '';
            }
?>
            <td <?php echo $corFundo ?>>
                <form action="db/status_manga.php" method="POST">
                    <button class="lido" <?php echo $corFundo ?> type="submit" name="lido" value="<?php echo $mangas['titulo'][$c] . "#" . $vol['volume'][$vTotal] ?>"><?php echo $zero . $vol['volume'][$vTotal] ?></button>
                </form>
            </td>
<?php
            $vTotal++;
        }
    }
?>
        </tr>
    </table>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/mangas.js"></script>
</body>
</html>