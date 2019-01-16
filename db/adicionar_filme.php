<?php
    include_once "dbh_filmes.php";

    $colecao = $_POST['colecao'];
    $ordem_colecao = $_POST['ordem_colecao'];
    if ($ordem_colecao == '') {
        $ordem_colecao = $colecao;
    }
    $titulo = $_POST['titulo'];
    $ordem_titulo = $_POST['ordem_titulo'];
    if ($ordem_titulo == '') {
        $ordem_titulo = $titulo;
    }
    $lancamento = $_POST['lancamento'];
    $diretor = $_POST['diretor'];
    $ordem_diretor = $_POST['ordem_diretor'];
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
    $codbarras = $_POST['codbarras'];
    $data = $_POST['data'];
    $loja = $_POST['loja'];
    $preco = $_POST['preco'];

    //CHECANDO EXISTENCIA DA COLECAO
    $sql = "SELECT * FROM colecao WHERE Colecao = '$colecao';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck == 0) {
        $sql = "INSERT INTO colecao VALUES (DEFAULT, '$colecao', '$ordem_colecao');";
        mysqli_query($conn, $sql);
    }

    //CHECANDO EXISTENCIA DE DIRETOR
    $sql = "SELECT * FROM diretor WHERE Diretor = '$diretor';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck == 0) {
        $sql = "INSERT INTO diretor VALUES (DEFAULT, '$diretor', '$ordem_diretor');";
        mysqli_query($conn, $sql);
    }

    //CHECANDO EXISTENCIA DA DISTRIBUIDORA
    $sql = "SELECT * FROM distribuidora WHERE Distribuidora = '$distribuidora';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck == 0) {
        $sql = "INSERT INTO distribuidora VALUES (DEFAULT, '$distribuidora');";
        mysqli_query($conn, $sql);
    }

    //CHECANDO EXISTENCIA DO IMDB
    $sql = "SELECT * FROM imdb WHERE ID = '$imdbid';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck == 0) {
        $sql = "INSERT INTO imdb VALUES ('$imdbid', $imdb);";
        mysqli_query($conn, $sql);
    }

    //CHECANDO EXISTENCIA DA MIDIA
    $sql = "SELECT * FROM midia WHERE Midia = '$midia';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck == 0) {
        $sql = "INSERT INTO midia VALUES (DEFAULT, '$midia');";
        mysqli_query($conn, $sql);
    }

    //CHECANDO EXISTENCIA DA PROPORCAO
    $sql = "SELECT * FROM proporcao WHERE Proporcao = '$proporcao';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck == 0) {
        $sql = "INSERT INTO proporcao VALUES (DEFAULT, '$proporcao');";
        mysqli_query($conn, $sql);
    }

    //CHECANDO EXISTENCIA DA AUDIO
    $sql = "SELECT * FROM audio WHERE Audio = '$audio';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck == 0) {
        $sql = "INSERT INTO audio VALUES (DEFAULT, '$audio');";
        mysqli_query($conn, $sql);
    }

    //CHECANDO EXISTENCIA DA REPLICADORA
    $sql = "SELECT * FROM replicadora WHERE Replicadora = '$replicadora';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck == 0) {
        $sql = "INSERT INTO replicadora VALUES (DEFAULT, '$replicadora');";
        mysqli_query($conn, $sql);
    }

    //CHECANDO EXISTENCIA DA LOJA
    $sql = "SELECT * FROM loja WHERE Loja = '$loja';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck == 0) {
        $sql = "INSERT INTO loja VALUES (DEFAULT, '$loja');";
        mysqli_query($conn, $sql);
    }

    if ($colecao == '') {
        $sql = "INSERT INTO filme VALUES (DEFAULT, 1, '$titulo', '$ordem_titulo', '$lancamento', 
        (SELECT ID FROM diretor WHERE Diretor = '$diretor'), 
        (SELECT ID FROM distribuidora WHERE Distribuidora = '$distribuidora'), '$imdbid', '$duracao', 
        (SELECT ID FROM midia WHERE Midia = '$midia'), '$regiao', 
        (SELECT ID FROM proporcao WHERE Proporcao = '$proporcao'), 
        (SELECT ID FROM audio WHERE Audio = '$audio'), '$discos', 
        (SELECT ID FROM replicadora WHERE Replicadora = '$replicadora'), '$codbarras', '$data', 
        (SELECT ID FROM loja WHERE Loja = '$loja'), '$preco');";
    } else {
        $sql = "INSERT INTO filme VALUES (DEFAULT, (SELECT ID FROM colecao WHERE Colecao = '$colecao'), 
        '$titulo', '$ordem_titulo', '$lancamento', (SELECT ID FROM diretor WHERE Diretor = '$diretor'), 
        (SELECT ID FROM distribuidora WHERE Distribuidora = '$distribuidora'), '$imdbid', '$duracao', 
        (SELECT ID FROM midia WHERE Midia = '$midia'), '$regiao', 
        (SELECT ID FROM proporcao WHERE Proporcao = '$proporcao'), 
        (SELECT ID FROM audio WHERE Audio = '$audio'), '$discos', 
        (SELECT ID FROM replicadora WHERE Replicadora = '$replicadora'), '$codbarras', '$data', 
        (SELECT ID FROM loja WHERE Loja = '$loja'), '$preco');";
    }

    mysqli_query($conn, $sql);

    header("Location: ../filmes.php?adicionar=sucesso");
