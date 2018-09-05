<?php
    include_once "dbh.php";

    $colecao = $_POST['colecao'];
    $titulo = $_POST['titulo'];
    $ano = $_POST['ano'];
    $diretor = $_POST['diretor'];
    $distribuidora = $_POST['distribuidora'];
    $imdb = $_POST['imdb'];
    $duracao = $_POST['duracao'];
    $midia = $_POST['midia'];
    $proporcao = $_POST['proporcao'];
    $audio = $_POST['audio'];
    $discos = $_POST['discos'];
    $replicadora = $_POST['replicadora'];
    $data = $_POST['data'];
    $barcode = $_POST['barcode'];
    $loja = $_POST['loja'];

    $sql = "INSERT INTO filmes VALUES ('$titulo', $ano, '$diretor', '$distribuidora', $imdb, $duracao, '$midia', '$proporcao', '$audio', $discos, '$replicadora', '$barcode', '$data', '$loja', '$colecao');";
    mysqli_query($conn, $sql);

    header("Location: ../filmes.php?adicionar=sucesso");
