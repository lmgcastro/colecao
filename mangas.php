<?php
    header('Content-type: text/html; charset=utf-8 charset=UTF-8');
    include_once 'db/dbh.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mangás</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
    //SELECT PREENCHIMENTO TABELA
    $sql = "SELECT * FROM mangas ORDER BY Titulo, Volume;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $titulo[] = $row['Titulo'];
            $volume[] = $row['Volume'];
            $artistas[] = $row['Artistas'];
            $editora[] = $row['Editora'];
            $original[] = $row['Original'];
            $lido[] = $row['Lido'];
            $total[] = $row['Total'];
        }
    }
	$volumes_titulo = array_count_values($titulo);
	$titulo_anterior = '';
	for ($c = 0; $c < count($titulo); $c++) {
		if ($titulo[$c] != $titulo_anterior) {
			$unique['titulo'][] = $titulo[$c];
			$unique['artistas'][] = $artistas[$c];
			$unique['editora'][] = $editora[$c];
			$unique['original'][] = $original[$c];
			$unique['total'][] = $total[$c];
			$unique['volumes'][] = $volumes_titulo[$titulo[$c]];
		}
        $titulo_anterior = $titulo[$c];
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
<!-- DIV MANGA NOVO -->
    <div id="addMangaNovo">
        <form action="db/adicionar_manga.php" method="POST">
            <input type="text" name="tituloNovo" placeholder="Título" size="25">
            <input type="text" name="volumeNovo" placeholder="Volume" size="3">
            <input type="text" name="total" placeholder="Total" size="3">
            <input list="artistas" name="artistas" placeholder="Artistas" size="25">
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
            <input list="editora" name="editora" placeholder="Editora" size="15">
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
            <input list="original" name="original" placeholder="Original" size="15">
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
        </div>
<!-- DIV MANGA EXISTENTE -->
        <div id="addManga">
            <select id="tituloExistente" name="tituloExistente">
                <option value="" selected disabled hidden>Selecione</option>
<?php
    $temp_unique_titulo = array_unique($titulo);
    $unique_titulo = array_values($temp_unique_titulo);
    sort($unique_titulo);
    for ($c = 0; $c < count($unique_titulo); $c++) {
            echo '<option value="' . $unique_titulo[$c] . '">' . $unique_titulo[$c] . '</option>';
    }
    echo '</select>';
?>              
            <input type="text" name="volumeExistente" placeholder="Volume" size="3">
            <button type="submit" name="submit">Adicionar</button>
        </form>
    </div>
	
    <table id="tblMangas">
        <tr>
            <th>Nº</th>
            <th>Título</th>
            <th>Artistas</th>
            <th>Editora</th>
            <th>Editora original</th>
            <th>Completo</th>
            <th colspan="
<?php
	$max_titulo = array_count_values($titulo);
	arsort($max_titulo);
	$count_max_titulo = 0;
	foreach ($titulo as $tit) {
		if ($tit == key($max_titulo))
			$count_max_titulo++;
	}
	echo $count_max_titulo;
?>
">Volumes</th>
        </tr>
<?php
    // CONTADOR INDEX VOLUME
    $vTotal = 0;
    // LOOP PREENCHIMENTO TABELA
    for ($c = 0; $c < count($unique['titulo']); $c++) {
?>
        <tr>
            <td><?php echo $c + 1 ?></td>
            <td class="titulo"><?php echo $unique['titulo'][$c] ?></td>
            <td><?php echo $unique['artistas'][$c] ?></td>
            <td><?php echo $unique['editora'][$c] ?></td>
            <td><?php echo $unique['original'][$c] ?></td>
            <td><meter class="completo" value="<?php echo $unique['volumes'][$c] ?>" min="0" max="<?php echo $unique['total'][$c] ?>"></meter></td>
<?php
        for ($v = 0; $v < $unique['volumes'][$c]; $v++) {
            // LOOP COR FUNDO STATUS
            if ($lido[$vTotal] == 'S') {
                $corFundo = 'style="background-color: #66ff33"';
            } else {
                $corFundo = 'style="background-color: #ff3333"';
            }
            // LOOP ADICIONAR ZERO UM DÍGITO
            if ($volume[$vTotal] < 10) {
                $zero = '0';
            } else {
                $zero = '';
            }
?>
            <td <?php echo $corFundo ?>>
                <form action="db/status_manga.php" method="POST">
<?php 
    echo '<button class="lido"' . $corFundo . 'type="submit" name="lido" value="' . $unique['titulo'][$c] . "#" . $volume[$vTotal] . '">' . $zero . $volume[$vTotal] . '</button>'           
?>
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
