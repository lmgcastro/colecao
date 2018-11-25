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
            $sql = "SELECT * FROM filmes WHERE CONCAT(Titulo, year(Lancamento), Diretor, Distribuidora, IMDb, `IMDb ID`, Midia, Proporcao, Audio, Replicadora, Barcode, CASE WHEN day(Data) < 10 THEN CONCAT('0', day(Data)) ELSE day(Data) END, '/', CASE WHEN month(Data) < 10 THEN CONCAT('0', month(Data)) ELSE month(Data) END, '/', year(Data)) " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY Titulo, Midia;";
        } else if ($filterField == 'IMDb') {
            $sql = "SELECT * FROM filmes WHERE " . $filterField . " " . $likeNotLike . " '" . $filterValue . "%' ORDER BY " . $orderColumn . ", Midia;";
        } else if ($filterField == 'IMDb ID') {
            $sql = "SELECT * FROM filmes WHERE `" . $filterField . "` " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY " . $orderColumn . ", Midia;";
        } else if ($filterField == 'Midia') {    
            $sql = "SELECT * FROM filmes WHERE " . $filterField . " " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY " . $orderColumn . ";";
        } else if ($filterField == 'Data') {
            $sql = "SELECT * FROM filmes WHERE CONCAT(CASE WHEN day(Data) < 10 THEN CONCAT('0', day(Data)) ELSE day(Data) END, '/', CASE WHEN month(Data) < 10 THEN CONCAT('0', month(Data)) ELSE month(Data) END, '/', year(Data)) " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY " . $orderColumn . ", Midia;";
        } else {
            $sql = "SELECT * FROM filmes WHERE " . $filterField . " " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY " . $orderColumn . ", Midia;";
        }
        $footer = false;
    } else {
        $sql = "SELECT * FROM filmes ORDER BY Colecao, CASE WHEN (Colecao = '') THEN Diretor END, Lancamento, Midia;";
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
                $imdbid[] = $row['IMDb ID'];
                $duracao[] = $row['Duracao'];
                $midia[] = $row['Midia'];
                $regiao[] = $row['Regiao'];
                $proporcao[] = $row['Proporcao'];
                $audio[] = $row['Audio'];
                $discos[] = $row['Discos'];
                $replicadora[] = $row['Replicadora'];
                $barcode[] = $row['Barcode'];
                $data[] = $row['Data'];
                $loja[] = $row['Loja'];
                $preco[] = $row['Preco'];
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
                    <option value="IMDb ID">IMDb ID</option>
                    <option value="Duracao">Duração</option>
                    <option value="Midia">Mídia</option>
                    <option value="Regiao">Região</option>
                    <option value="Proporcao">Proporção</option>
                    <option value="Audio">Áudio</option>
                    <option value="Discos">Discos</option>
                    <option value="Replicadora">Replicadora</option>
                    <option value="Barcode">Cód. de Barras</option>
                    <option value="Data">Data</option>
                    <option value="Loja">Loja</option>
                    <option value="Preco">Preço</option>
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
            <input type="text" name="titulo" placeholder="Título" size="25">
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
            <input type="text" name="imdbid" placeholder="IMDb ID" size="15" maxlength="9">
            <input type="text" name="duracao" placeholder="Duração" size="5">
            <label><input class="midia" type="radio" name="midia" value="Blu-ray">Blu-ray</label>
            <label><input class="midia" type="radio" name="midia" value="DVD">DVD</label>
            <div id="regiaoBD">
                <label><input type="checkbox" name="regiao[]" value="A">A</label>
                <label><input type="checkbox" name="regiao[]" value="B">B</label>
                <label><input type="checkbox" name="regiao[]" value="C">C</label>
			</div>
			<div id="regiaoDVD">
                <label><input type="checkbox" name="regiao[]" value="1">1</label>
                <label><input type="checkbox" name="regiao[]" value="2">2</label>
                <label><input type="checkbox" name="regiao[]" value="3">3</label>
                <label><input type="checkbox" name="regiao[]" value="4">4</label>
			</div>
            <input list="proporcao" name="proporcao" placeholder="Proporção" size="10">
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
            <input list="audio" name="audio" placeholder="Áudio" size="10">
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
            <input type="text" name="discos" placeholder="Discos" size="3">
            <input list="replicadora" name="replicadora" placeholder="Replicadora" size="12">
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
            <input id="barcodeForm" type="text" name="barcode" placeholder="Código de Barras" size="14" maxlength="13">
            <label>Data <input type="date" name="data"></label>
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
            <input type="text" name="preco" placeholder="Preço" size="2">
            <button id="submit" type="submit" name="submit">Adicionar</button>
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
                <td id="<?php echo $imdbid[$c] ?>" class="titulo"><?php echo $titulo[$c] ?></td>
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
            <tr id="footer"><?php
                $imdbid_aux = 'test';
                for ($c = 0; $c < count($imdbid); $c++) {
                    if ($imdbid[$c] != $imdbid_aux) {
                        $ano_footer[] = $ano[$c];
                        $diretor_footer[] = $diretor[$c];
                        $distribuidora_footer[] = $distribuidora[$c];
                        $imdb_footer[] = $imdb[$c];
                        $imdbid_footer[] = $imdbid[$c];
                        $duracao_footer[] = $duracao[$c];
                        $proporcao_footer[] = $proporcao[$c];
                        $replicadora_footer[] = $replicadora[$c];
                    }
                    $imdbid_aux = $imdbid[$c];
                }
                $barcode_aux = 789;
                $preco_total = 0;
                for ($c = 0; $c < count($barcode); $c++) {
                    if ($barcode[$c] != $barcode_aux) {
                        $preco_total += $preco[$c];
                    }
                    $barcode_aux = $barcode[$c];
                }
                ?><td colspan="2"><?php
                for ($c = 0; $c < count($midia); $c++) {
                    if ($midia[$c] == 'Blu-ray') {
                        $barcodes_bluray[] = $barcode[$c];
                    } else {
                        $barcodes_dvd[] = $barcode[$c];
                    }
                }
                $unique_barcodes_bluray = array_unique($barcodes_bluray);
                $unique_barcodes_dvd = array_unique($barcodes_dvd);
                echo 'Filmes: ' . count($imdbid_footer) . ' | Blu-rays: ' . count($barcodes_bluray) . ' (' . count($unique_barcodes_bluray) . ')' . ' | DVDs: ' . count($barcodes_dvd) . ' (' . count($unique_barcodes_dvd) . ')';
                ?></td>
                <td><?php 
                    $max_ano = array_count_values($ano_footer);
                    arsort($max_ano);
                    echo key($max_ano);
                ?></td>
                <td><?php 
                    $max_diretor = array_count_values($diretor_footer);
                    arsort($max_diretor);
                    echo key($max_diretor) . ' (' . $max_diretor[key($max_diretor)] . ')';
                ?></td>
                <td><?php 
                    $max_distribuidora = array_count_values($distribuidora_footer);
                    arsort($max_distribuidora);
                    echo key($max_distribuidora);
                ?></td>
                <td><?php 
                    $avg_imdb = round(array_sum($imdb_footer) / count($imdb_footer), 1);
                    $avg_imdb_percent = $avg_imdb * 10;
                    echo '<div id="imdbdivfooter" style="width:' . $avg_imdb_percent . '%">' . $avg_imdb . '</div>';
                ?></td>
                <td>~<?php echo round(array_sum($duracao_footer) / 60, 0) ?>h</td>
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
                    $max_proporcao = array_count_values($proporcao_footer);
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
                    $max_replicadora = array_count_values($replicadora_footer);
                    arsort($max_replicadora);
                    echo key($max_replicadora);
                ?></td>
                <td><?php
                    echo 'Total: R$ ' . $preco_total; 
                    /*$max_barcode = array_count_values($barcode);
                    arsort($max_barcode);
                    echo key($max_barcode);*/
                ?></td>
                <td><?php 
                    foreach ($data as $dat) {
                        $temp_max_data[] = date('m/Y', strtotime($dat));
                    }
                    $max_data = array_count_values($temp_max_data);
                    arsort($max_data);
                    echo key($max_data) . ' (' . $max_data[key($max_data)] . ')';
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
