<?php
    header('Content-type: text/html; charset=utf-8 charset=UTF-8');
    include_once 'db/dbh_filmes.php';
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
    $sql = "SELECT colecao.Colecao, filme.Titulo, filme.Lancamento, diretor.Diretor, diretor2.Diretor AS Diretor2, 
    diretor3.Diretor AS Diretor3, distribuidora.Distribuidora, filme.IMDb, edicao.Filme AS IMDbID, filme.Duracao, 
    midia.Midia, edicao.Regiao, proporcao.Proporcao, audio.Audio, edicao.Discos, replicadora.Replicadora, 
    edicao.CodBarras, edicao.Data, loja.Loja, edicao.Preco FROM edicao 
    INNER JOIN filme ON edicao.Filme = filme.ID
    INNER JOIN colecao ON filme.Colecao = colecao.ID 
    INNER JOIN diretor ON filme.Diretor = diretor.ID 
    INNER JOIN diretor diretor2 ON filme.Diretor2 = diretor2.ID 
    INNER JOIN diretor diretor3 ON filme.Diretor3 = diretor3.ID 
    INNER JOIN distribuidora ON edicao.Distribuidora = distribuidora.ID  
    INNER JOIN midia ON edicao.Midia = midia.ID 
    INNER JOIN proporcao ON edicao.Proporcao = proporcao.ID 
    INNER JOIN audio ON edicao.Audio = audio.ID 
    INNER JOIN replicadora ON edicao.Replicadora = replicadora.ID 
    INNER JOIN loja ON edicao.Loja = loja.ID ";
    if (isset($_POST['filter'])) {
        $filterValue = $_POST['filterValue'];
        $filterField = $_POST['filterField'];
        if (isset($_POST['setDifferent'])) {
            $likeNotLike = 'NOT LIKE';
        } else {
            $likeNotLike = 'LIKE';
        }
        if (isset($_POST['setOrder'])) {
            if ($filterField == 'filme.Titulo') {
                $orderColumn = $filterField . ' ' . $_POST['setOrder'];
            } else if ($filterField == 'filme.Data') {
                $orderColumn = $filterField . ' ' . $_POST['setOrder'] . ', filme.Lancamento';
            } else {
                $orderColumn = $filterField . ' ' . $_POST['setOrder'] . ', filme.Ordem';
            }
        } else {
            $orderColumn = 'Titulo';
        }
        if ($filterField == 'Todos') {
            $sql .= "WHERE CONCAT(filme.Titulo, year(filme.Lancamento), diretor.Diretor, diretor2.Diretor, 
            diretor3.Diretor, distribuidora.Distribuidora, 
            filme.IMDb, filme.ID, midia.Midia, proporcao.Proporcao, audio.Audio, replicadora.Replicadora, 
            edicao.CodBarras, CASE WHEN day(edicao.Data) < 10 THEN CONCAT('0', day(edicao.Data)) 
            ELSE day(edicao.Data) END, '/', CASE WHEN month(edicao.Data) < 10 THEN CONCAT('0', month(edicao.Data)) 
            ELSE month(edicao.Data) END, '/', year(edicao.Data)) " . $likeNotLike . " '%" . $filterValue . 
            "%' ORDER BY filme.Ordem, midia.Midia;";
        } else if ($filterField == 'imdb.IMDb') {
            $sql .= "WHERE " . $filterField . " " . $likeNotLike . " '" . $filterValue . "%' ORDER BY " . $orderColumn . 
            ", midia.Midia;";
        } else if ($filterField == 'midia.Midia') {
            $sql .= "WHERE " . $filterField . " " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY " . $orderColumn . 
            ";";
        } else if ($filterField == 'filme.Data') {
            $sql .= "WHERE CONCAT(CASE WHEN day(edicao.Data) < 10 THEN CONCAT('0', day(edicao.Data)) ELSE day(edicao.Data) 
            END, '/', CASE WHEN month(edicao.Data) < 10 THEN CONCAT('0', month(edicao.Data)) ELSE month(edicao.Data) 
            END, '/', year(edicao.Data)) " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY " . $orderColumn . 
            ", midia.Midia;";
        } else {
            $sql .= "WHERE " . $filterField . " " . $likeNotLike . " '%" . $filterValue . "%' ORDER BY " . $orderColumn . 
            ", midia.Midia;";
        }
        $footer = false;
    } else { 
        $sql .= "ORDER BY colecao.Ordem, 
        CASE WHEN (colecao.Ordem = '') THEN diretor.Ordem END, 
        filme.Lancamento, midia.Midia;";
        $footer = true;
    }
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $colecao[] = $row['Colecao'];
                $titulo[] = $row['Titulo'];
                $lancamento[] = $row['Lancamento'];
                $diretor[] = $row['Diretor'];
                $diretor2[] = $row['Diretor2'];
                $diretor3[] = $row['Diretor3'];
                $distribuidora[] = $row['Distribuidora'];
                $imdb[] = $row['IMDb'];
                $imdbid[] = $row['IMDbID'];
                $duracao[] = $row['Duracao'];
                $midia[] = $row['Midia'];
                $regiao[] = $row['Regiao'];
                $proporcao[] = $row['Proporcao'];
                $audio[] = $row['Audio'];
                $discos[] = $row['Discos'];
                $replicadora[] = $row['Replicadora'];
                $codbarras[] = $row['CodBarras'];
                $data[] = $row['Data'];
                $loja[] = $row['Loja'];
                $preco[] = $row['Preco'];
            }
            $filmesColecao = [];
            $titulo_aux = '';
            for ($c = 0; $c < count($titulo); $c++) {
                $reg = ($regiao[$c] == '') ? '---' : $regiao[$c];
?>
                <div id="filmeInfo<?php echo $c?>" class="filmeInfo"><?php echo nl2br (
                    "<strong>Distribuidora:</strong> \n" . $distribuidora[$c] .
                    "\n<strong>Mídia:</strong> \n" . $midia[$c] . 
                    "\n<strong>Região:</strong> \n" . $reg . 
                    "\n<strong>Proporção:</strong> \n" . $proporcao[$c] .
                    "\n<strong>Áudio:</strong> \n" . $audio[$c] . 
                    "\n<strong>Disco(s):</strong> \n" . $discos[$c] . 
                    "\n<strong>Replicadora:</strong> \n" . $replicadora[$c] . 
                    "\n<strong>Código de barras:</strong> \n<span id='" . $codbarras[$c] . "' class='codBarras'>" . $codbarras[$c] . "</span>" . 
                    "\n<strong>Data:</strong> \n" . date("d/m/Y", strtotime($data[$c])) . 
                    "\n<strong>Loja:</strong> \n" . $loja[$c] . 
                    "\n<strong>Preço:</strong> \nR$ " . number_format($preco[$c], 2, ',', '')
                );
                    if (($c + 1) < count($titulo) && $titulo[$c] == $titulo[$c + 1])
                        echo "<div id='divTrocar'>
                                <button id='" . $c . "_" . ($c + 1) . "' class='btnTrocar'>></button>
                            </div>";
                    if ($c > 0 && $titulo[$c] == $titulo[$c - 1])
                        echo "<div id='divTrocar'>
                                <button id='" . $c . "_" . ($c - 1) . "' class='btnTrocar'><</button>
                            </div>";
                    if ($colecao[$c] != '') {
                        array_push($filmesColecao, $titulo[$c]);
                    }
                ?></div>
<?php
            }
        } else {
            $noResults = true;
        }
?>
    <ul class="nav">
        <li><button id="novo">Novo</button></li>
        <li><a id="atual" href="filmes2.php">Filmes</a></li>
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
                    <option value="colecao.Ordem">Coleção</option>
                    <option value="filme.Ordem">Título</option>
                    <option value="filme.Lancamento">Lançamento</option>
                    <option value="diretor.Ordem">Diretor</option>
                    <option value="distribuidora.Distribuidora">Distribuidora</option>
                    <option value="filme.IMDb">IMDb</option>
                    <option value="filme.ID">IMDb ID</option>
                    <option value="filme.Duracao">Duração</option>
                    <option value="midia.Midia">Mídia</option>
                    <option value="edicao.Regiao">Região</option>
                    <option value="proporcao.Proporcao">Proporção</option>
                    <option value="audio.Audio">Áudio</option>
                    <option value="edicao.Discos">Discos</option>
                    <option value="replicadora.Replicadora">Replicadora</option>
                    <option value="edicao.CodBarras">Cód. de Barras</option>
                    <option value="edicao.Data">Data</option>
                    <option value="loja.Loja">Loja</option>
                    <option value="edicao.Preco">Preço</option>
                </select>
                <button id="filtrar" type="submit" name="filter">Filtrar</button>
            </form>
        </li>
    </ul>
    <img id="posterImg" border="5" src="">
    <img id="codBarrasImg" border="5" src="">
    
    <!-- INPUTS -->
    <div id="addFilme">
        <form action="db/adicionar_filme.php" method="POST">
            <input type="text" name="imdbid" placeholder="IMDb ID" size="5" maxlength="9">
            <!--<input id="tit_ord" type="button">
                <input id="titulo_inp" type="text" name="titulo" placeholder="Título" size="25">
                <input id="ordem_titulo" type="text" name="ordem_titulo" placeholder="Ordem (Título)" size="25">
                <label>Lançamento <input type="date" name="lancamento"></label>-->
            <input type="text" name="imdb" placeholder="IMDb" size="2">
            <!-- <input id="dir_ord" type="button">
            <input id="diretor_inp" list="diretor" name="diretor" placeholder="Diretor" size="20">
<?php
    /* echo '<datalist id="diretor">';
    $temp_unique_diretor = array_unique($diretor);
    $unique_diretor = array_values($temp_unique_diretor);
    sort($unique_diretor);
    for ($c = 0; $c < count($unique_diretor); $c++) {
            echo '<option value="' . $unique_diretor[$c] . '">';
    }
    echo '</datalist>'; */
?>
            <input id="ordem_diretor" type="text" name="ordem_diretor" placeholder="Ordem (Diretor)" size="20"> -->
            <input id="col_ord" type="button">
            <input id="colecao_inp" list="colecao" name="colecao" placeholder="Coleção" size="20">
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
            <input id="ordem_colecao" type="text" name="ordem_colecao" placeholder="Ordem (Coleção)" size="20">
            <input id="codBarrasForm" type="text" name="codbarras" placeholder="Código de Barras" size="11" maxlength="13">
            <input list="distribuidora" name="distribuidora" placeholder="Distribuidora" size="12">
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
            <input type="text" name="duracao" placeholder="Duração" size="5">
            <input list="proporcao" name="proporcao" placeholder="Proporção" size="8">
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
            <input type="text" name="discos" placeholder="Discos" size="3">
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
            <label><input type="checkbox" name="loja_fisica" value="sim">Física</label>
            <input type="text" name="preco" placeholder="Preço" size="2">
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
            <button id="submit" type="submit" name="submit">Adicionar</button>
        </form>
    </div>
    <!-- END OF INPUTS -->

<?php
    $titulo_aux = '';
    if (!$noResults) {
        if (!isset($_POST['filter'])) {
?>
    <table id="tblFilmes">
    <tr>
        <th>Título original</th>
        <th>Ano</th>
        <th>Diretor</th>
        <th>IMDb</th>
        <th>Duração</th>
    </tr>
<?php
        $c = 0;
        $unique_filmesColecao = array_unique($filmesColecao);
        while ($colecao[$c] == '') {
            if ($titulo[$c] != $titulo_aux) {
                $imdb_percent = $imdb[$c] * 10;
                $horas = floor($duracao[$c] / 60);
                $minutos = ($duracao[$c] % 60);
                $horas_minutos = sprintf('%02dh%02d', $horas, $minutos);
?>
            <tr>
                <td id="<?php echo $imdbid[$c] . "_" . $c ?>" class="titulo" <?php if (strlen($titulo[$c]) >= 37) echo 'title="' . $titulo[$c] . '"' ?>><?php if (strlen($titulo[$c]) < 37) { echo $titulo[$c]; } else { echo substr($titulo[$c], 0, 35) . '...'; } ?></td>
                <td title="<?php echo date("d/m/Y", strtotime($lancamento[$c])) ?>"><?php echo date("Y", strtotime($lancamento[$c])) ?></td>
                <td <?php if ($diretor2[$c] != null && $diretor3[$c] == null) { echo 'title="' . $diretor2[$c] . '"'; } else if ($diretor3[$c] != null) { echo 'title="' . $diretor2[$c] . ', ' . $diretor3[$c] . '"'; } ?>><?php if (strlen($diretor[$c]) < 30) { echo $diretor[$c]; } else { echo substr($diretor[$c], 0, 30); }; if ($diretor2[$c] != null) echo ' +' ?></td>
                <td><div class="imdbdiv" style="width: <?php echo $imdb_percent ?>%"><a class="imdblink" target="_blank" href="https://www.imdb.com/title/<?php echo $imdbid[$c] ?>"><?php echo $imdb[$c] ?></a></div></td>
                <td title="<?php echo $horas_minutos ?>"><?php echo $duracao[$c] ?> min.</td>
            </tr>
<?php
            }
            $titulo_aux = $titulo[$c];
            $c++;
        }
?>
    </table>
    <table id="tblColecoes">
        <tr>
            <th>Título original</th>
            <th>Ano</th>
            <th>Diretor</th>
            <th>IMDb</th>
            <th>Duração</th>
        </tr>
<?php
            $current_colecao = '';
            for ($c = $c; $c < count($titulo); $c++) {
                if ($titulo[$c] != $titulo_aux) {
                    $imdb_percent = $imdb[$c] * 10;
                    $horas = floor($duracao[$c] / 60);
                    $minutos = ($duracao[$c] % 60);
                    $horas_minutos = sprintf('%02dh%02d', $horas, $minutos);
                    if ($colecao[$c] != $current_colecao) {
?>           
                <tr class="headerColecao"><th colspan="6" style="font-weight: normal"><?php echo $colecao[$c] ?></th></tr>
<?php
                    }
?>
            
            <tr>
                <td id="<?php echo $imdbid[$c] . "_" . $c ?>" class="titulo" <?php if (strlen($titulo[$c]) >= 37) echo 'title="' . $titulo[$c] . '"' ?>><?php if (strlen($titulo[$c]) < 37) { echo $titulo[$c]; } else { echo substr($titulo[$c], 0, 35) . '...'; } ?></td>
                <td title="<?php echo date("d/m/Y", strtotime($lancamento[$c])) ?>"><?php echo date("Y", strtotime($lancamento[$c])) ?></td>
                <td <?php if ($diretor2[$c] != null && $diretor3[$c] == null) { echo 'title="' . $diretor2[$c] . '"'; } else if ($diretor3[$c] != null) { echo 'title="' . $diretor2[$c] . ', ' . $diretor3[$c] . '"'; } ?>><?php if (strlen($diretor[$c]) < 30) { echo $diretor[$c]; } else { echo substr($diretor[$c], 0, 30); }; if ($diretor2[$c] != null) echo ' +' ?></td>
                <td><div class="imdbdiv" style="width: <?php echo $imdb_percent ?>%"><a class="imdblink" target="_blank" href="https://www.imdb.com/title/<?php echo $imdbid[$c] ?>"><?php echo $imdb[$c] ?></a></div></td>
                <td title="<?php echo $horas_minutos ?>"><?php echo $duracao[$c] ?> min.</td>
            </tr>
<?php
                }
                $current_colecao = $colecao[$c];
                $titulo_aux = $titulo[$c];
            }
?>
        </table>
<?php
        } else {
?>
        <table id="tblFilmes" style="float:none; margin: auto;">
        <tr>
            <th>Título original</th>
            <th>Ano</th>
            <th>Diretor</th>
            <th>IMDb</th>
            <th>Duração</th>
        </tr>
<?php
            for ($c = 0; $c < count($titulo); $c++) {
                if ($titulo[$c] != $titulo_aux) {
                    $imdb_percent = $imdb[$c] * 10;
                    $horas = floor($duracao[$c] / 60);
                    $minutos = ($duracao[$c] % 60);
                    $horas_minutos = sprintf('%02dh%02d', $horas, $minutos);
?>
            <tr>
                <td id="<?php echo $imdbid[$c] . "_" . $c ?>" class="titulo" <?php if (strlen($titulo[$c]) >= 37) echo 'title="' . $titulo[$c] . '"' ?>><?php if (strlen($titulo[$c]) < 37) { echo $titulo[$c]; } else { echo substr($titulo[$c], 0, 35) . '...'; } ?></td>
                <td title="<?php echo date("d/m/Y", strtotime($lancamento[$c])) ?>"><?php echo date("Y", strtotime($lancamento[$c])) ?></td>
                <td <?php if ($diretor2[$c] != null && $diretor3[$c] == null) { echo 'title="' . $diretor2[$c] . '"'; } else if ($diretor3[$c] != null) { echo 'title="' . $diretor2[$c] . ', ' . $diretor3[$c] . '"'; } ?>><?php if (strlen($diretor[$c]) < 30) { echo $diretor[$c]; } else { echo substr($diretor[$c], 0, 30); }; if ($diretor2[$c] != null) echo ' +' ?></td>
                <td><div class="imdbdiv" style="width: <?php echo $imdb_percent ?>%"><a class="imdblink" target="_blank" href="https://www.imdb.com/title/<?php echo $imdbid[$c] ?>"><?php echo $imdb[$c] ?></a></div></td>
                <td title="<?php echo $horas_minutos ?>"><?php echo $duracao[$c] ?> min.</td>
            </tr>
<?php
                }
                $titulo_aux = $titulo[$c];
            }
        }
    } else {
?>
        <table id="tblFilmes" style="float:none; margin: auto;">
            <tr>
                <td colspan="6"><strong>Nenhum registro encontrado!</strong></td>
            </tr>
        </table>
<?php
}
?>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/filmes.js"></script>
</body>
</html>
