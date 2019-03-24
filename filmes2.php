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
<body id="filmes_posters">
<?php
    //SELECT PREENCHIMENTO TABELA
    $noResults = false;
    $sql = "SELECT colecao.Colecao, filme.Titulo, filme.Ordem, filme.Lancamento, diretor.Diretor, 
    distribuidora.Distribuidora, filme.IMDb, edicao.Filme AS IMDbID, filme.Duracao, midia.Midia, 
    edicao.Regiao, proporcao.Proporcao, audio.Audio, edicao.Discos, replicadora.Replicadora, 
    edicao.CodBarras, edicao.Data, loja.Loja, edicao.Preco FROM edicao 
    INNER JOIN filme ON edicao.Filme = filme.ID
    INNER JOIN colecao ON filme.Colecao = colecao.ID 
    INNER JOIN diretor ON filme.Diretor = diretor.ID 
    INNER JOIN distribuidora ON edicao.Distribuidora = distribuidora.ID  
    INNER JOIN midia ON edicao.Midia = midia.ID 
    INNER JOIN proporcao ON edicao.Proporcao = proporcao.ID 
    INNER JOIN audio ON edicao.Audio = audio.ID 
    INNER JOIN replicadora ON edicao.Replicadora = replicadora.ID 
    INNER JOIN loja ON edicao.Loja = loja.ID 
    ORDER BY filme.Ordem, filme.Lancamento";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $colecao[] = $row['Colecao'];
                $titulo[] = $row['Titulo'];
                $ordem[] = $row['Ordem'];
                $lancamento[] = $row['Lancamento'];
                $diretor[] = $row['Diretor'];
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
    $titulo_aux = '';
?>
    <ul class="nav">
        <li><a id="atual" href="filmes.php">Filmes</a></li>
        <li><a href="quadrinhos.php">Quadrinhos</a></li>
        <li><a href="mangas.php">Mangás</a></li>
    </ul>
    <img id="posterImg" border="5" src="">
    <img id="codBarrasImg" border="5" src="">
<?php
    $c = 0;
    $unique_filmesColecao = array_unique($filmesColecao);
    $linha = count($unique_filmesColecao);
    for ($c = 0; $c < count($titulo); $c++) {
        if ($titulo[$c] != $titulo_aux) {
            $horas = floor($duracao[$c] / 60);
            $minutos = ($duracao[$c] % 60);
            $horas_minutos = sprintf('%02dh%02d', $horas, $minutos);
?>
            <div>
                <img title="<?php echo date("Y", strtotime($lancamento[$c])) . " / " . $diretor[$c] . " / " . $horas_minutos . " / " . $imdb[$c] ?>" id="<?php echo $imdbid[$c] . "_" . $c ?>" class="poster <?php echo strtolower(substr($ordem[$c], 0, 1)) ?>" src="images/posters/<?php echo $imdbid[$c] ?>.jpg" width="125" height="187" style="float: left; margin: 3px;" border="1" />
            </div>
<?php       
        }
        $titulo_aux = $titulo[$c];
    }
?>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/filmes.js"></script>
</body>
</html>
