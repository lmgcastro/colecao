<?php
    include_once "dbh.php";

    $colecao = $_POST['colecao'];
    $titulo = $_POST['titulo'];
    $lancamento = $_POST['lancamento'];
    $diretor = $_POST['diretor'];
    $distribuidora = $_POST['distribuidora'];
    $imdb = $_POST['imdb'];
    $imdbid = $_POST['imdbid'];
    $duracao = $_POST['duracao'];
    $midia = $_POST['midia'];
    $regiao = '';
    if (!empty($_POST['regiao'])) {
        foreach ($_POST['regiao'] as $selected) {
            $regiao .= $selected;
        }
    }
    $proporcao = $_POST['proporcao'];
    $audio = $_POST['audio'];
    $discos = $_POST['discos'];
    $replicadora = $_POST['replicadora'];
    $barcode = $_POST['barcode'];
    $data = $_POST['data'];
    $loja = $_POST['loja'];
    $preco = $_POST['preco'];

    $sql = "INSERT INTO filmes VALUES ('$colecao', '$titulo', '$lancamento', '$diretor', '$distribuidora', $imdb, '$imdbid', $duracao, '$midia', '$regiao', '$proporcao', '$audio', $discos, '$replicadora', '$barcode', '$data', '$loja', $preco);";
    mysqli_query($conn, $sql);

    header("Location: ../filmes.php?adicionar=sucesso");
