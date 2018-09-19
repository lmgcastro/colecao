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
            $sql = "SELECT * FROM filmes WHERE CONCAT(Titulo, year(Lancamento), Diretor, Distribuidora, IMDb, Midia, Proporcao, Audio, Replicadora, Barcode, CASE WHEN day(Data) < 10 THEN CONCAT('0', day(Data)) ELSE day(Data) END, '/', CASE WHEN month(Data) < 10 THEN CONCAT('0', month(Data)) ELSE month(Data) END, '/', year(Data)) " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY Titulo;";
        } else if ($filterField == 'IMDb') {
            $sql = "SELECT * FROM filmes WHERE " . $filterField . " " . $likeNotLike . " '" . $filterValue . "%' ORDER BY " . $orderColumn . ";";
        } else if ($filterField == 'Data') {
            $sql = "SELECT * FROM filmes WHERE CONCAT(CASE WHEN day(Data) < 10 THEN CONCAT('0', day(Data)) ELSE day(Data) END, '/', CASE WHEN month(Data) < 10 THEN CONCAT('0', month(Data)) ELSE month(Data) END, '/', year(Data)) " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY " . $orderColumn . ";";
        } else {
            $sql = "SELECT * FROM filmes WHERE " . $filterField . " " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY " . $orderColumn . ";";
        }
        $footer = false;
    } else {
        $sql = "SELECT * FROM filmes ORDER BY Colecao, CASE WHEN (Colecao = '') THEN Diretor END, Lancamento;";
        $footer = true;
    }
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $colecao[] = $row['Colecao'];
                $titulo[] = $row['Titulo'];
                $ano[] = date('Y', strtotime($row['Lancamento']));
                $diretor[] = $row['Diretor'];
                $distribuidora[] = $row['Distribuidora'];
                $imdb[] = $row['IMDb'];
                $duracao[] = $row['Duracao'];
                $midia[] = $row['Midia'];
                $regiao[] = $row['Regiao'];
                $proporcao[] = $row['Proporcao'];
                $audio[] = $row['Audio'];
                $discos[] = $row['Discos'];
                $replicadora[] = $row['Replicadora'];
                $barcode[] = $row['Barcode'];
                $loja[] = $row['Loja'];
                $data[] = $row['Data'];
            }
        } else {
            $noResults = true;
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
    
    <!-- INPUTS -->
    <div id="addFilme">
        <form action="db/adicionar_filme.php" method="POST">
            <input list="colecao" name="colecao" placeholder="Coleção" size="20">
<?php
    echo '<datalist id="colecao">';
    $temp_unique_colecao = array_unique($colecao);
    $unique_colecao = array_values($temp_unique_colecao);
    sort($unique_colecao);
    for ($c = 0; $c < count($unique_colecao); $c++) {
            echo '<option value="' . $unique_colecao[$c] . '">';
    }
    echo '</datalist>';
?>
            <input type="text" name="titulo" placeholder="Título" size="24">
            <label>Lançamento <input type="date" name="lancamento"></label>
            <input list="diretor" name="diretor" placeholder="Diretor" size="25">
<?php
    echo '<datalist id="diretor">';
    $temp_unique_diretor = array_unique($diretor);
    $unique_diretor = array_values($temp_unique_diretor);
    sort($unique_diretor);
    for ($c = 0; $c < count($unique_diretor); $c++) {
            echo '<option value="' . $unique_diretor[$c] . '">';
    }
    echo '</datalist>';
?>
            <input list="distribuidora" name="distribuidora" placeholder="Distribuidora" size="15">
<?php
    echo '<datalist id="distribuidora">';
    $temp_unique_distribuidora = array_unique($distribuidora);
    $unique_distribuidora = array_values($temp_unique_distribuidora);
    sort($unique_distribuidora);
    for ($c = 0; $c < count($unique_distribuidora); $c++) {
            echo '<option value="' . $unique_distribuidora[$c] . '">';
    }
    echo '</datalist>';
?>
            <input type="text" name="imdb" placeholder="IMDb" size="2">
            <input type="text" name="duracao" placeholder="Duração" size="5">
            <input list="midia" name="midia" placeholder="Mídia" size="10">
<?php
    echo '<datalist id="midia">';
    $temp_unique_midia = array_unique($midia);
    $unique_midia = array_values($temp_unique_midia);
    sort($unique_midia);
    for ($c = 0; $c < count($unique_midia); $c++) {
            echo '<option value="' . $unique_midia[$c] . '">';
    }
    echo '</datalist>';
?>
            <label>Região 
            <label><input type="checkbox" name="regiao[]" value="A">A</label>
            <label><input type="checkbox" name="regiao[]" value="B">B</label>
            <label><input type="checkbox" name="regiao[]" value="C">C</label>
            </label>
            <input list="proporcao" name="proporcao" placeholder="Proporção" size="20">
<?php
    echo '<datalist id="proporcao">';
    $temp_unique_proporcao = array_unique($proporcao);
    $unique_proporcao = array_values($temp_unique_proporcao);
    sort($unique_proporcao);
    for ($c = 0; $c < count($unique_proporcao); $c++) {
            echo '<option value="' . $unique_proporcao[$c] . '">';
    }
    echo '</datalist>';
?>
            <input list="audio" name="audio" placeholder="Áudio" size="15">
<?php
    echo '<datalist id="audio">';
    $temp_unique_audio = array_unique($audio);
    $unique_audio = array_values($temp_unique_audio);
    sort($unique_audio);
    for ($c = 0; $c < count($unique_audio); $c++) {
            echo '<option value="' . $unique_audio[$c] . '">';
    }
    echo '</datalist>';
?>
            <input type="text" name="discos" placeholder="Discos" size="4">
            <input list="replicadora" name="replicadora" placeholder="Replicadora" size="15">
<?php
    echo '<datalist id="replicadora">';
    $temp_unique_replicadora = array_unique($replicadora);
    $unique_replicadora = array_values($temp_unique_replicadora);
    sort($unique_replicadora);
    for ($c = 0; $c < count($unique_replicadora); $c++) {
            echo '<option value="' . $unique_replicadora[$c] . '">';
    }
    echo '</datalist>';
?>
            <input id="barcodeForm" type="text" name="barcode" placeholder="Código de Barras" size="15" maxlength="13">
            <input list="loja" name="loja" placeholder="Loja" size="15">
<?php
    echo '<datalist id="loja">';
    $temp_unique_loja = array_unique($loja);
    $unique_loja = array_values($temp_unique_loja);
    sort($unique_loja);
    for ($c = 0; $c < count($unique_loja); $c++) {
            echo '<option value="' . $unique_loja[$c] . '">';
    }
    echo '</datalist>';
?>
            <label>Data <input type="date" name="data"></label>
            <button id="submit" type="submit" name="submit">Add</button>
        </form>
    </div>
    <!-- END OF INPUTS -->

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
        for ($c = 0; $c < count($titulo); $c++) {
            $barcode_year = $barcode[$c] . '_' . $ano[$c];
            $imdb_percent = $imdb[$c] * 10;
            if ($colecao[$c] != '' && $ccount == 0 && !isset($_POST['filter'])) {
                $ccount += 1;
?>
                <tr><th colspan="15">Coleções</th></tr>
<?php
            }
?>
            <tr>
                <td><?php echo $c + 1 ?></td>
                <td id="<?php echo $barcode_year ?>" class="titulo"><?php echo $titulo[$c] ?></td>
                <td><?php echo $ano[$c] ?></td>
                <td><?php echo $diretor[$c] ?></td>
                <td><?php echo $distribuidora[$c] ?></td>
                <td><div class="imdbdiv" style="width: <?php echo $imdb_percent ?>%"><?php echo $imdb[$c] ?></div></td>
                <td><?php echo $duracao[$c] ?> min.</td>
                <td><?php echo $midia[$c] ?></td>
                <td><?php echo $regiao[$c] ?></td>
                <td><?php echo $proporcao[$c] ?></td>
                <td><?php echo $audio[$c] ?></td>
                <td><?php echo $discos[$c] ?></td>
                <td><?php echo $replicadora[$c] ?></td>
                <td class="barcode"><?php echo $barcode[$c] ?></td>
                <td><?php echo date('d/m/Y', strtotime($data[$c])) ?></td>
            </tr>
<?php
        }
        if ($footer) {
?>
            <tr id="footer">
                <td colspan="2"><?php
                for ($c = 0; $c < count($midia); $c++) {
                    if ($midia[$c] == 'Blu-ray') {
                        $barcodes_bluray[] = $barcode[$c];
                    } else {
                        $barcodes_dvd[] = $barcode[$c];
                    }
                }
                $unique_barcodes_bluray = array_unique($barcodes_bluray);
                $unique_barcodes_dvd = array_unique($barcodes_dvd);
                echo 'Filmes: ' . count($titulo) . ' | Blu-rays: ' . count($barcodes_bluray) . ' (' . count($unique_barcodes_bluray) . ')' . ' | DVDs: ' . count($barcodes_dvd) . ' (' . count($unique_barcodes_dvd) . ')'
                ?></td>
                <td><?php 
                    $max_ano = array_count_values($ano);
                    arsort($max_ano);
                    echo key($max_ano);
                ?></td>
                <td><?php 
                    $max_diretor = array_count_values($diretor);
                    arsort($max_diretor);
                    $count_max_diretor = 0;
                    foreach ($diretor as $dir) {
                        if ($dir == key($max_diretor))
                        $count_max_diretor++;
                    }
                    echo key($max_diretor) . ' (' . $count_max_diretor . ')';
                ?></td>
                <td><?php 
                    $max_distribuidora = array_count_values($distribuidora);
                    arsort($max_distribuidora);
                    echo key($max_distribuidora);
                ?></td>
                <td><?php 
                    $avg_imdb = round(array_sum($imdb) / count($imdb), 1);
                    $avg_imdb_percent = $avg_imdb * 10;
                    echo '<div id="imdbdivfooter" style="width:' . $avg_imdb_percent . '%">'. $avg_imdb . '</div>';
                ?></td>
                <td>~<?php echo round(array_sum($duracao) / 60, 0) ?>h</td>
                <td><?php 
                    $max_midia = array_count_values($midia);
                    arsort($max_midia);
                    echo key($max_midia);
                ?></td>
                <td><?php 
                    $max_regiao = array_count_values($regiao);
                    arsort($max_regiao);
                    echo key($max_regiao);
                ?></td>
                <td><?php 
                    $max_proporcao = array_count_values($proporcao);
                    arsort($max_proporcao);
                    echo key($max_proporcao);
                ?></td>
                <td><?php 
                    $max_audio = array_count_values($audio);
                    arsort($max_audio);
                    echo key($max_audio);
                ?></td>
                <td><?php 
                    $max_discos = array_count_values($discos);
                    arsort($max_discos);
                    echo key($max_discos);
                ?></td>
                <td><?php 
                    $max_replicadora = array_count_values($replicadora);
                    arsort($max_replicadora);
                    echo key($max_replicadora);
                ?></td>
                <td><?php 
                    $max_barcode = array_count_values($barcode);
                    arsort($max_barcode);
                    echo key($max_barcode);
                ?></td>
                <td><?php 
                    $max_data = array_count_values($data);
                    arsort($max_data);
                    $count_max_data = 0;
                    foreach ($data as $dat) {
                        if (date('m/Y', strtotime($dat)) == date('m/Y', strtotime(key($max_data))))
                            $count_max_data++;
                    }
                    echo date('m/Y', strtotime(key($max_data))) . ' (' . $count_max_data . ')';
                ?></td>
            </tr>
<?php
        }
    } else {
?>
        <tr><td colspan="15"><strong>Nenhum registro encontrado!</strong></td></tr>
<?php
}
?>
    </table>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/filmes.js"></script>
</body>
</html>
