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
    //SELECT TAMANHO TABELA
    $sqlTamanho = "SELECT COUNT(*) AS Tamanho FROM filmes;";
    $resultTamanho = mysqli_query($conn, $sqlTamanho);
    $resultCheckTamanho = mysqli_num_rows($resultTamanho);

    if ($resultCheckTamanho > 0) {
        while ($rowTamanho = mysqli_fetch_assoc($resultTamanho)) {
            $tamanho = $rowTamanho['Tamanho'];
        }
    }
    //SELECT PREENCHIMENTO TABELA
    $noResults = false;
    if (isset($_POST['filter'])) {
        $filterValue = $_POST['filterValue'];
        $filterField = $_POST['filterField'];
        if (isset($_POST['setDifferent'])) {
            $likeNotLike = 'NOT LIKE';
        } else {
            $likeNotLike = 'LIKE';
        }
        if (isset($_POST['setOrder'])) {
            if ($filterField == 'Titulo') {
                $orderColumn = $filterField . ' ' . $_POST['setOrder'];
            } else if ($filterField == 'Data') {
                $orderColumn = $filterField . ' ' . $_POST['setOrder'] . ', Lancamento';
            } else {
                $orderColumn = $filterField . ' ' . $_POST['setOrder'] . ', Titulo';
            }
        } else {
            $orderColumn = 'Titulo';
        }
        if ($filterField == 'Todos') {
            $sql = "SELECT *, year(Lancamento) FROM filmes WHERE CONCAT(Titulo, Lancamento, Diretor, Distribuidora, IMDb, Midia, Proporcao, Audio, Replicadora, Barcode, Data) " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY Titulo;";
        } else if ($filterField == 'IMDb') {
            $sql = "SELECT *, year(Lancamento) FROM filmes WHERE " . $filterField . " " . $likeNotLike . " '" . $filterValue . "%' ORDER BY " . $orderColumn . ";";
        } else {
            $sql = "SELECT *, year(Lancamento) FROM filmes WHERE " . $filterField . " " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY " . $orderColumn . ";";
        }

    } else {
        $sql = "SELECT *, year(Lancamento) FROM filmes ORDER BY Colecao, CASE WHEN (Colecao = '') THEN Diretor END, Lancamento;";
    }
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $filmes['colecao'][] = $row['Colecao'];
                $filmes['titulo'][] = $row['Titulo'];
                $filmes['lancamento'][] = $row['Lancamento'];
                $filmes['diretor'][] = $row['Diretor'];
                $filmes['distribuidora'][] = $row['Distribuidora'];
                $filmes['imdb'][] = $row['IMDb'];
                $filmes['duracao'][] = $row['Duracao'];
                $filmes['midia'][] = $row['Midia'];
                $filmes['regiao'][] = $row['Regiao'];
                $filmes['proporcao'][] = $row['Proporcao'];
                $filmes['audio'][] = $row['Audio'];
                $filmes['discos'][] = $row['Discos'];
                $filmes['replicadora'][] = $row['Replicadora'];
                $filmes['barcode'][] = $row['Barcode'];
                $filmes['data'][] = $row['Data'];
                $filmes['ano'][] = $row['year(Lancamento)'];
            }
        } else {
            $noResults = true;
        }
    //SELECT MAX ANO
    $sqlMaxAno = "SELECT year(Lancamento), COUNT(*) FROM filmes GROUP BY year(Lancamento) ORDER BY COUNT(*) DESC LIMIT 1;";
    $resultMaxAno = mysqli_query($conn, $sqlMaxAno);
    $resultCheckMaxAno = mysqli_num_rows($resultMaxAno);

    if ($resultCheckMaxAno > 0) {
        while ($rowMaxAno = mysqli_fetch_assoc($resultMaxAno)) {
            $maxAno = $rowMaxAno['year(Lancamento)'];
        }
    }
    //SELECT MAX DIRETOR
    $sqlMaxDiretor = "SELECT Diretor, COUNT(*) FROM filmes GROUP BY Diretor ORDER BY COUNT(*) DESC LIMIT 1;";
    $resultMaxDiretor = mysqli_query($conn, $sqlMaxDiretor);
    $resultCheckMaxDiretor = mysqli_num_rows($resultMaxDiretor);

    if ($resultCheckMaxDiretor > 0) {
        while ($rowMaxDiretor = mysqli_fetch_assoc($resultMaxDiretor)) {
            $maxDiretor[0] = $rowMaxDiretor['Diretor'];
            $maxDiretor[1] = $rowMaxDiretor['COUNT(*)'];
        }
    }
    //SELECT MAX DISTRIBUIDORA
    $sqlMaxDist = "SELECT Distribuidora, COUNT(*) FROM filmes GROUP BY Distribuidora ORDER BY COUNT(*) DESC LIMIT 1;";
    $resultMaxDist = mysqli_query($conn, $sqlMaxDist);
    $resultCheckMaxDist = mysqli_num_rows($resultMaxDist);

    if ($resultCheckMaxDist > 0) {
        while ($rowMaxDist = mysqli_fetch_assoc($resultMaxDist)) {
            $maxDist = $rowMaxDist['Distribuidora'];
        }
    }
    //SELECT AVG IMDb
    $sqlAvgImdb = "SELECT ROUND(AVG(IMDb), 1) AS 'AVG(IMDb)' FROM filmes;";
    $resultAvgImdb = mysqli_query($conn, $sqlAvgImdb);
    $resultCheckAvgImdb = mysqli_num_rows($resultAvgImdb);

    if ($resultCheckAvgImdb > 0) {
        while ($rowAvgImdb = mysqli_fetch_assoc($resultAvgImdb)) {
            $avgImdb = $rowAvgImdb['AVG(IMDb)'];
        }
    }
    //SELECT SUM DURACAO
    $sqlSumDuracao = "SELECT SUM(Duracao) FROM filmes;";
    $resultSumDuracao = mysqli_query($conn, $sqlSumDuracao);
    $resultCheckSumDuracao = mysqli_num_rows($resultSumDuracao);

    if ($resultCheckSumDuracao > 0) {
        while ($rowSumDuracao = mysqli_fetch_assoc($resultSumDuracao)) {
            $sumDuracao = $rowSumDuracao['SUM(Duracao)'];
        }
    }
    //SELECT MAX MIDIA
    $sqlMaxMidia = "SELECT Midia, COUNT(*) FROM filmes GROUP BY Midia ORDER BY COUNT(*) DESC LIMIT 1;";
    $resultMaxMidia = mysqli_query($conn, $sqlMaxMidia);
    $resultCheckMaxMidia = mysqli_num_rows($resultMaxMidia);

    if ($resultCheckMaxMidia > 0) {
        while ($rowMaxMidia = mysqli_fetch_assoc($resultMaxMidia)) {
            $maxMidia = $rowMaxMidia['Midia'];
        }
    }
    //SELECT MAX REGIAO
    $sqlMaxRegiao = "SELECT Regiao, COUNT(*) FROM filmes GROUP BY Regiao ORDER BY COUNT(*) DESC LIMIT 1;";
    $resultMaxRegiao = mysqli_query($conn, $sqlMaxRegiao);
    $resultCheckMaxRegiao = mysqli_num_rows($resultMaxRegiao);

    if ($resultCheckMaxRegiao > 0) {
        while ($rowMaxRegiao = mysqli_fetch_assoc($resultMaxRegiao)) {
            $maxRegiao = $rowMaxRegiao['Regiao'];
        }
    }
    //SELECT MAX PROPORCAO
    $sqlMaxProp = "SELECT Proporcao, COUNT(*) FROM filmes GROUP BY Proporcao ORDER BY COUNT(*) DESC LIMIT 1;";
    $resultMaxProp = mysqli_query($conn, $sqlMaxProp);
    $resultCheckMaxProp = mysqli_num_rows($resultMaxProp);

    if ($resultCheckMaxProp > 0) {
        while ($rowMaxProp = mysqli_fetch_assoc($resultMaxProp)) {
            $maxProp = $rowMaxProp['Proporcao'];
        }
    }
    //SELECT MAX AUDIO
    $sqlMaxAudio = "SELECT Audio, COUNT(*) FROM filmes GROUP BY Audio ORDER BY COUNT(*) DESC LIMIT 1;";
    $resultMaxAudio = mysqli_query($conn, $sqlMaxAudio);
    $resultCheckMaxAudio = mysqli_num_rows($resultMaxAudio);

    if ($resultCheckMaxAudio > 0) {
        while ($rowMaxAudio = mysqli_fetch_assoc($resultMaxAudio)) {
            $maxAudio = $rowMaxAudio['Audio'];
        }
    }
    //SELECT MAX DISCOS
    $sqlMaxDiscos = "SELECT Discos, COUNT(*) FROM filmes GROUP BY Discos ORDER BY COUNT(*) DESC LIMIT 1;";
    $resultMaxDiscos = mysqli_query($conn, $sqlMaxDiscos);
    $resultCheckMaxDiscos = mysqli_num_rows($resultMaxDiscos);

    if ($resultCheckMaxDiscos > 0) {
        while ($rowMaxDiscos = mysqli_fetch_assoc($resultMaxDiscos)) {
            $maxDiscos = $rowMaxDiscos['Discos'];
        }
    }
    //SELECT MAX REPLICADORA
    $sqlMaxRepl = "SELECT Replicadora, COUNT(*) FROM filmes GROUP BY Replicadora ORDER BY COUNT(*) DESC LIMIT 1;";
    $resultMaxRepl = mysqli_query($conn, $sqlMaxRepl);
    $resultCheckMaxRepl = mysqli_num_rows($resultMaxRepl);

    if ($resultCheckMaxRepl > 0) {
        while ($rowMaxRepl = mysqli_fetch_assoc($resultMaxRepl)) {
            $maxRepl = $rowMaxRepl['Replicadora'];
        }
    }
    //SELECT MAX BARCODE
    $sqlMaxBarcode = "SELECT Barcode, COUNT(*) FROM filmes GROUP BY Barcode ORDER BY COUNT(*) DESC LIMIT 1;";
    $resultMaxBarcode = mysqli_query($conn, $sqlMaxBarcode);
    $resultCheckMaxBarcode = mysqli_num_rows($resultMaxBarcode);

    if ($resultCheckMaxBarcode > 0) {
        while ($rowMaxBarcode = mysqli_fetch_assoc($resultMaxBarcode)) {
            $maxBarcode = $rowMaxBarcode['Barcode'];
        }
    }
    //SELECT MAX DATA
    $sqlMaxData = "SELECT CASE WHEN month(Data) < 10 THEN CONCAT(0, month(Data), '/', year(Data)) ELSE CONCAT(month(Data), '/', year(Data)) END AS MesAno, COUNT(*) FROM filmes GROUP BY CONCAT(month(Data), '/', year(Data)) ORDER BY COUNT(*) DESC LIMIT 1;";
    $resultMaxData = mysqli_query($conn, $sqlMaxData);
    $resultCheckMaxData = mysqli_num_rows($resultMaxData);

    if ($resultCheckMaxData > 0) {
        while ($rowMaxData = mysqli_fetch_assoc($resultMaxData)) {
            $maxData[0] = $rowMaxData['MesAno'];
            $maxData[1] = $rowMaxData['COUNT(*)'];
        }
    }
    //SELECT QUANTIDADE FILMES
    $sqlQtdFilmes = "SELECT COUNT(DISTINCT Titulo) FROM filmes;";
    $resultQtdFilmes = mysqli_query($conn, $sqlQtdFilmes);
    $resultCheckQtdFilmes = mysqli_num_rows($resultQtdFilmes);

    if ($resultCheckQtdFilmes > 0) {
        while ($rowQtdFilmes = mysqli_fetch_assoc($resultQtdFilmes)) {
            $qtdFilmes = $rowQtdFilmes['COUNT(DISTINCT Titulo)'];
        }
    }
    //SELECT QUANTIDADE BLURAYS
    $sqlQtdBluray = "SELECT COUNT(Midia) FROM filmes WHERE Midia = 'Blu-ray' OR Midia = 'Blu-ray 3D';";
    $resultQtdBluray = mysqli_query($conn, $sqlQtdBluray);
    $resultCheckQtdBluray = mysqli_num_rows($resultQtdBluray);

    if ($resultCheckQtdBluray > 0) {
        while ($rowQtdBluray = mysqli_fetch_assoc($resultQtdBluray)) {
            $qtdBluray = $rowQtdBluray['COUNT(Midia)'];
        }
    }
    //SELECT QUANTIDADE DVDS
    $sqlQtdDvd = "SELECT COUNT(Midia) FROM filmes WHERE Midia = 'DVD';";
    $resultQtdDvd = mysqli_query($conn, $sqlQtdDvd);
    $resultCheckQtdDvd = mysqli_num_rows($resultQtdDvd);

    if ($resultCheckQtdDvd > 0) {
        while ($rowQtdDvd = mysqli_fetch_assoc($resultQtdDvd)) {
            $qtdDvd = $rowQtdDvd['COUNT(Midia)'];
        }
    }
    //SELECT DISTINCT BARCODES BLURAY
    $sqlEstBluray = "SELECT COUNT(DISTINCT Barcode) FROM filmes WHERE Midia = 'Blu-ray' OR 'Blu-ray 3D';";
    $resultEstBluray = mysqli_query($conn, $sqlEstBluray);
    $resultCheckEstBluray = mysqli_num_rows($resultEstBluray);

    if ($resultCheckEstBluray > 0) {
        while ($rowEstBluray = mysqli_fetch_assoc($resultEstBluray)) {
            $estBluray = $rowEstBluray['COUNT(DISTINCT Barcode)'];
        }
    }
    //SELECT DISTINCT BARCODES DVD
    $sqlEstDvd = "SELECT COUNT(DISTINCT Barcode) FROM filmes WHERE Midia = 'DVD';";
    $resultEstDvd = mysqli_query($conn, $sqlEstDvd);
    $resultCheckEstDvd = mysqli_num_rows($resultEstDvd);

    if ($resultCheckEstDvd > 0) {
        while ($rowEstDvd = mysqli_fetch_assoc($resultEstDvd)) {
            $estDvd = $rowEstDvd['COUNT(DISTINCT Barcode)'];
        }
    }
    //SELECT PREENCHIMENTO INPUT COLECAO
    $sqlCole = "SELECT DISTINCT Colecao FROM filmes WHERE Colecao IS NOT NULL ORDER BY Colecao;";
    $resultCole = mysqli_query($conn, $sqlCole);
    $resultCheckCole = mysqli_num_rows($resultCole);

    if ($resultCheckCole > 0) {
        while ($rowCole = mysqli_fetch_assoc($resultCole)) {
            $cole[] = $rowCole['Colecao'];
        }
    }
    //SELECT PREENCHIMENTO INPUT DIRETOR
    $sqlDire = "SELECT DISTINCT Diretor FROM filmes ORDER BY Diretor;";
    $resultDire = mysqli_query($conn, $sqlDire);
    $resultCheckDire = mysqli_num_rows($resultDire);

    if ($resultCheckDire > 0) {
        while ($rowDire = mysqli_fetch_assoc($resultDire)) {
            $dire[] = $rowDire['Diretor'];
        }
    }
    //SELECT PREENCHIMENTO INPUT DISTRIBUIDORA
    $sqlDist = "SELECT DISTINCT Distribuidora FROM filmes ORDER BY Distribuidora;";
    $resultDist = mysqli_query($conn, $sqlDist);
    $resultCheckDist = mysqli_num_rows($resultDist);

    if ($resultCheckDist > 0) {
        while ($rowDist = mysqli_fetch_assoc($resultDist)) {
            $dist[] = $rowDist['Distribuidora'];
        }
    }
    //SELECT PREENCHIMENTO INPUT MIDIA
    $sqlMidia = "SELECT DISTINCT Midia FROM filmes ORDER BY Midia;";
    $resultMidia = mysqli_query($conn, $sqlMidia);
    $resultCheckMidia = mysqli_num_rows($resultMidia);

    if ($resultCheckMidia > 0) {
        while ($rowMidia = mysqli_fetch_assoc($resultMidia)) {
            $midia[] = $rowMidia['Midia'];
        }
    }
    //SELECT PREENCHIMENTO INPUT PROPORCAO
    $sqlProp = "SELECT DISTINCT Proporcao FROM filmes ORDER BY Proporcao;";
    $resultProp = mysqli_query($conn, $sqlProp);
    $resultCheckProp = mysqli_num_rows($resultProp);

    if ($resultCheckProp > 0) {
        while ($rowProp = mysqli_fetch_assoc($resultProp)) {
            $prop[] = $rowProp['Proporcao'];
        }
    }
    //SELECT PREENCHIMENTO INPUT AUDIO
    $sqlAudio = "SELECT DISTINCT Audio FROM filmes ORDER BY Audio;";
    $resultAudio = mysqli_query($conn, $sqlAudio);
    $resultCheckAudio = mysqli_num_rows($resultAudio);

    if ($resultCheckAudio > 0) {
        while ($rowAudio = mysqli_fetch_assoc($resultAudio)) {
            $audio[] = $rowAudio['Audio'];
        }
    }
    //SELECT PREENCHIMENTO INPUT REPLICADORA
    $sqlRepl = "SELECT DISTINCT Replicadora FROM filmes ORDER BY Replicadora;";
    $resultRepl = mysqli_query($conn, $sqlRepl);
    $resultCheckRepl = mysqli_num_rows($resultRepl);

    if ($resultCheckRepl > 0) {
        while ($rowRepl = mysqli_fetch_assoc($resultRepl)) {
            $repl[] = $rowRepl['Replicadora'];
        }
    }
    //SELECT PREENCHIMENTO INPUT LOJA
    $sqlLoja = "SELECT DISTINCT Loja FROM filmes ORDER BY Loja;";
    $resultLoja = mysqli_query($conn, $sqlLoja);
    $resultCheckLoja = mysqli_num_rows($resultLoja);

    if ($resultCheckLoja > 0) {
        while ($rowLoja = mysqli_fetch_assoc($resultLoja)) {
            $loja[] = $rowLoja['Loja'];
        }
    }
?>
    <ul class="nav">
        <li><button id="novo">Novo</button></li>
        <li><a id="atual" href="#">Filmes</a></li>
        <li><a href="cds.php">CDs</a></li>
        <li><a href="quadrinhos.php">Quadrinhos</a></li>
        <li><a href="mangas.php">Mangás</a></li>
        <li>
            <form action="filmes.php" method="POST">
                <label for="≠">≠</label><input id="≠" type="checkbox" name="setDifferent" value="NOT LIKE">
                <label for="△">△</label><input id="△" type="radio" name="setOrder" value="ASC">
                <label for="▽">▽</label><input id="▽" type="radio" name="setOrder" value="DESC">
                <input type="text" name="filterValue" placeholder="Buscar" size="10">
                <select id="fieldsCombo" name="filterField">
                    <option id="todos" value="Todos">Todos</option>
                    <option value="Colecao">Coleção</option>
                    <option value="Titulo">Título</option>
                    <option value="Lancamento">Lançamento</option>
                    <option value="Diretor">Diretor</option>
                    <option value="Distribuidora">Distribuidora</option>
                    <option value="IMDb">IMDb</option>
                    <option value="Duracao">Duração</option>
                    <option value="Midia">Mídia</option>
                    <option value="Regiao">Região</option>
                    <option value="Proporcao">Proporção</option>
                    <option value="Audio">Áudio</option>
                    <option value="Discos">Discos</option>
                    <option value="Replicadora">Replicadora</option>
                    <option value="Barcode">Cód. de Barras</option>
                    <option value="Loja">Loja</option>
                    <option value="Data">Data</option>
                </select>
                <button id="filtrar" type="submit" name="filter">Filtrar</button>
            </form>
        </li>
    </ul>
    <img id="posterImg" border="5" src="">
    <img id="barcodeImg" border="5" src="">
    <div id="addFilme">
        <form action="db/adicionar_filme.php" method="POST">
            <input list="colecao" name="colecao" placeholder="Coleção" size="20">
            <datalist id="colecao">
<?php
    for ($c = 0; $c < count($cole); $c++) {
?>
                <option value="<?php echo $cole[$c] ?>">
<?php
    }
?>
            </datalist>
            <input type="text" name="titulo" placeholder="Título" size="24">
            <label>Lançamento <input type="date" name="lancamento"></label>
            <input list="diretor" name="diretor" placeholder="Diretor" size="25">
            <datalist id="diretor">
<?php
    for ($c = 0; $c < count($dire); $c++) {
?>
                <option value="<?php echo $dire[$c] ?>">
<?php
    }
?>
            </datalist>
            <input list="distribuidora" name="distribuidora" placeholder="Distribuidora" size="15">
            <datalist id="distribuidora">
<?php
    for ($c = 0; $c < count($dist); $c++) {
?>
                <option value="<?php echo $dist[$c] ?>">
<?php
    }
?>
            </datalist>
            <input type="text" name="imdb" placeholder="IMDb" size="2">
            <input type="text" name="duracao" placeholder="Duração" size="5">
            <input list="midia" name="midia" placeholder="Mídia" size="10">
            <datalist id="midia">
<?php
    for ($c = 0; $c < count($midia); $c++) {
?>
                <option value="<?php echo $midia[$c] ?>">
<?php
    }
?>
            </datalist>
            <label>Região 
            <label><input type="checkbox" name="regiao[]" value="A">A</label>
            <label><input type="checkbox" name="regiao[]" value="B">B</label>
            <label><input type="checkbox" name="regiao[]" value="C">C</label>
            </label>
            <input list="proporcao" name="proporcao" placeholder="Proporção" size="20">
            <datalist id="proporcao">
<?php
    for ($c = 0; $c < count($prop); $c++) {
?>
                <option value="<?php echo $prop[$c] ?>">
<?php
    }
?>
            </datalist>
            <input list="audio" name="audio" placeholder="Áudio" size="15">
            <datalist id="audio">
<?php
    for ($c = 0; $c < count($audio); $c++) {
?>
                <option value="<?php echo $audio[$c] ?>">
<?php
    }
?>
            </datalist>
            <input type="text" name="discos" placeholder="Discos" size="4">
            <input list="replicadora" name="replicadora" placeholder="Replicadora" size="15">
            <datalist id="replicadora">
<?php
    for ($c = 0; $c < count($repl); $c++) {
?>
                <option value="<?php echo $repl[$c] ?>">
<?php
    }
?>
            </datalist>
            <input id="barcodeForm" type="text" name="barcode" placeholder="Código de Barras" size="15" maxlength="13">
            <input list="loja" name="loja" placeholder="Loja" size="15">
            <label>Data <input type="date" name="data"></label>
            <datalist id="loja">
<?php
    for ($c = 0; $c < count($loja); $c++) {
?>
                <option value="<?php echo $loja[$c] ?>">
<?php
    }
?>
            </datalist>
            <button id="submit" type="submit" name="submit">+</button>
        </form>
    </div>
    <table id="tblFilmes">
        <tr>
            <th>Nº</th>
            <th>Título original</th>
            <th>Ano</th>
            <th>Diretor</th>
            <th>Distribuidora</th>
            <th>IMDb</th>
            <th>Duração</th>
            <th>Mídia</th>
            <th>Região</th>
            <th>Proporção</th>
            <th>Áudio</th>
            <th>Discos</th>
            <th>Replicadora</th>
            <th>Código de Barras</th>
            <th>Data</th>
        </tr>
<?php
    if (!$noResults) {
        $ccount = 0;
        for ($c = 0; $c < count($filmes['titulo']); $c++) {
            $barcode_year = $filmes['barcode'][$c] . "_" . $filmes['ano'][$c];
            $imdb = $filmes['imdb'][$c] * 10;
            if ($filmes['colecao'][$c] != "" && $ccount == 0 && !isset($_POST['filter'])) {
                $ccount += 1;
?>
                <tr><th colspan="15">Coleções</th></tr>
<?php
            }
?>
            <tr>
                <td><?php echo $c + 1 ?></td>
                <td id="<?php echo $barcode_year ?>" class="titulo"><?php echo $filmes['titulo'][$c] ?></td>
                <td><?php echo $filmes['ano'][$c] ?></td>
                <td><?php echo $filmes['diretor'][$c] ?></td>
                <td><?php echo $filmes['distribuidora'][$c] ?></td>
                <td><div class="imdbdiv" style="width: <?php echo $imdb ?>%"><?php echo $filmes['imdb'][$c] ?></div></td>
                <td><?php echo $filmes['duracao'][$c] ?> min.</td>
                <td><?php echo $filmes['midia'][$c] ?></td>
                <td><?php echo $filmes['regiao'][$c] ?></td>
                <td><?php echo $filmes['proporcao'][$c] ?></td>
                <td><?php echo $filmes['audio'][$c] ?></td>
                <td><?php echo $filmes['discos'][$c] ?></td>
                <td><?php echo $filmes['replicadora'][$c] ?></td>
                <td class="barcode"><?php echo $filmes['barcode'][$c] ?></td>
                <td><?php echo $filmes['data'][$c] ?></td>
            </tr>
<?php
            if ($c > 0) {
                $coleAnt = $filmes['colecao'][($c - 1)];
                $direAnt = $filmes['diretor'][($c - 1)];
            }
        }
            if (count($filmes['titulo']) == $tamanho) {
?>
            <tr id="footer">
                <td colspan="2"><?php echo 'Filmes: ' . $qtdFilmes . ' | Blu-rays: ' . $qtdBluray . ' (' . $estBluray . ')' . ' | DVDs: ' . $qtdDvd . ' (' . $estDvd . ')' ?></td>
                <td><?php echo $maxAno ?></td>
                <td><?php echo $maxDiretor[0] . ' (' . $maxDiretor[1] . ')' ?></td>
                <td><?php echo $maxDist ?></td>
                <td><div id="imdbdivfooter" style="width: <?php echo $avgImdb * 10 ?>%"><?php echo $avgImdb ?></div></td>
                <td>~<?php echo round($sumDuracao / 60, 0) ?>h</td>
                <td><?php echo $maxMidia ?></td>
                <td><?php echo $maxRegiao ?></td>
                <td><?php echo $maxProp ?></td>
                <td><?php echo $maxAudio ?></td>
                <td><?php echo $maxDiscos ?></td>
                <td><?php echo $maxRepl ?></td>
                <td><?php echo $maxBarcode ?></td>
                <td><?php echo $maxData[0] . ' (' . $maxData[1] . ')' ?></td>
            </tr>
<?php
            }
        } else {
?>
        <tr><td colspan="14"><strong>Nenhum registro encontrado!</strong></td></tr>
<?php
}
?>
    </table>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/filmes.js"></script>
</body>
</html>
