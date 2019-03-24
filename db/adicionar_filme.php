<?php
    include_once "dbh_filmes.php";

    /*$titulo = $_POST['titulo'];
    $ordem_titulo = $_POST['ordem_titulo'];
    if ($ordem_titulo == '') {
        $ordem_titulo = $titulo;
    }
    $lancamento = $_POST['lancamento'];*/
    $imdbid = $_POST['imdbid'];
    $imdb = $_POST['imdb'];
    /*$diretor = $_POST['diretor'];
    $ordem_diretor = $_POST['ordem_diretor'];*/
    $colecao = $_POST['colecao'];
    $ordem_colecao = $_POST['ordem_colecao'];
    if ($ordem_colecao == '') {
        $ordem_colecao = $colecao;
    }
    $codbarras = $_POST['codbarras'];
    $distribuidora = $_POST['distribuidora'];
    $duracao = $_POST['duracao'];
    $proporcao = $_POST['proporcao'];
    $audio = $_POST['audio'];
    $discos = $_POST['discos'];
    $replicadora = $_POST['replicadora'];
    $data = $_POST['data'];
    $loja = $_POST['loja'];
    if ($_POST['loja_fisica'] == 'sim') {
        $loja_fisica = 1;
    } else {
        $loja_fisica = 0;
    }
    $preco = $_POST['preco'];
    $midia = $_POST['midia'];
    $regiao = '';
    if (!empty($_POST['regiao'])) {
        foreach ($_POST['regiao'] as $selected) {
            $regiao .= $selected;
        }
    }

    // BUSCANDO DADOS DO TMDB POR IMDB ID
    $curl = curl_init();
    $url = 'https://api.themoviedb.org/3/find/' . $imdbid
    . '?api_key=c5306c3e7e7062462c32abdcd28f87f4&language=en-US&external_source=imdb_id';
    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $response = json_decode($response, true); //because of true, it's in an array

    $id = $response['movie_results'][0]['id'];

    // PEGANDO DADOS DO TMDB
    $curl = curl_init();
    $url = 'https://api.themoviedb.org/3/movie/' . $id
    . '?api_key=c5306c3e7e7062462c32abdcd28f87f4&append_to_response=credits';
    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $response = json_decode($response, true); //because of true, it's in an array

    $titulo = $response['original_title'];
    $ordem_titulo = $titulo;
    if (substr($titulo, 0, 4) == 'The ') {
        $ordem_titulo = substr($titulo, 4, strlen($titulo));
    }
    if (substr($titulo, 0, 2) == 'A ' || substr($titulo, 0, 2) == 'O ') {
        $ordem_titulo = substr($titulo, 2, strlen($titulo));
    }
    $lancamento = $response['release_date'];
    $count_diretor = 1;
    $diretor2 = null;
    $diretor3 = null;
    foreach ($response['credits']['crew'] as $crewEntry) {
        if ($crewEntry['job'] == 'Director') {
            if ($count_diretor == 1) {
                $diretor = $crewEntry['name'];
                $ordem_diretor = substr($diretor, strrpos($diretor, ' ') + 1) . ', ' . substr($diretor, 0, strrpos($diretor, ' '));
                $count_diretor++;
            } else if ($count_diretor == 2) {
                $diretor2 = $crewEntry['name'];
                $ordem_diretor2 = substr($diretor2, strrpos($diretor2, ' ') + 1) . ', ' . substr($diretor2, 0, strrpos($diretor2, ' '));
                $count_diretor++;
            } else {
                $diretor3 = $crewEntry['name'];
                $ordem_diretor3 = substr($diretor3, strrpos($diretor3, ' ') + 1) . ', ' . substr($diretor3, 0, strrpos($diretor3, ' '));
            }
        }
    }
    // BAIXANDO POSTER
    $url_poster = 'https://image.tmdb.org/t/p/w600_and_h900_bestv2' . $response['poster_path'];
    $file_poster = 'C:\xampp\htdocs\colecao\images\posters\\' . $imdbid . '.jpg'; // '/images/posters/' . 
    copy($url_poster, $file_poster);
    // BAIXANDO CODIGO DE BARRAS
    $url_codbarras = 'https://barcode.tec-it.com/barcode.ashx?data=' . $codbarras . '&code=EAN13&dpi=96';
    $file_codbarras = 'C:\xampp\htdocs\colecao\images\barcodes\\' . $codbarras . '.gif'; // '/images/barcodes/' . 
    copy($url_codbarras , $file_codbarras);
    
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

    if ($diretor2 != null) {
        //CHECANDO EXISTENCIA DE DIRETOR
        $sql = "SELECT * FROM diretor WHERE Diretor = '$diretor2';";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        
        if ($resultCheck == 0) {
            $sql = "INSERT INTO diretor VALUES (DEFAULT, '$diretor2', '$ordem_diretor2');";
            mysqli_query($conn, $sql);
        }
    }

    if ($diretor3 != null) {
        //CHECANDO EXISTENCIA DE DIRETOR
        $sql = "SELECT * FROM diretor WHERE Diretor = '$diretor3';";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        
        if ($resultCheck == 0) {
            $sql = "INSERT INTO diretor VALUES (DEFAULT, '$diretor3', '$ordem_diretor3');";
            mysqli_query($conn, $sql);
        }
    }

    //CHECANDO EXISTENCIA DA DISTRIBUIDORA
    $sql = "SELECT * FROM distribuidora WHERE Distribuidora = '$distribuidora';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck == 0) {
        $sql = "INSERT INTO distribuidora VALUES (DEFAULT, '$distribuidora');";
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

    //CHECANDO EXISTENCIA DO CÓDIGO DE BARRAS
    $sql = "SELECT * FROM edicao WHERE CodBarras = '$codbarras';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck != 0) {
        $sql = "SELECT d.Distribuidora, r.Replicadora, e.CodBarras, e.Data, l.Loja, e.Preco FROM edicao e 
        INNER JOIN Distribuidora d ON e.Distribuidora = d.ID INNER JOIN replicadora r ON e.Replicadora = r.ID 
        INNER JOIN Loja l ON e.Loja = l.ID WHERE e.CodBarras = '$codbarras' LIMIT 1;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $distribuidora = $row['Distribuidora'];
        $replicadora = $row['Replicadora'];
        $codbarras = $row['CodBarras'];
        $data = $row['Data'];
        $loja = $row['Loja'];
        $preco = $row['Preco'];
    }

    //CHECANDO EXISTENCIA DA LOJA
    $sql = "SELECT * FROM loja WHERE Loja = '$loja';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck == 0) {
        $sql = "INSERT INTO loja VALUES (DEFAULT, '$loja');";
        mysqli_query($conn, $sql);
    }

    //CHECANDO EXISTENCIA DO FILME
    $sql = "SELECT * FROM filme WHERE ID = '$imdbid';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck == 0) {
        $sql = "INSERT INTO filme VALUES ('$imdbid', '$titulo', '$ordem_titulo', '$lancamento',
        (SELECT ID FROM diretor WHERE Diretor = '$diretor'), $imdb, $duracao,
        (SELECT ID FROM colecao WHERE Colecao = '$colecao'), 
        (SELECT ID FROM diretor WHERE Diretor = '$diretor2'), 
        (SELECT ID FROM diretor WHERE Diretor = '$diretor3'));";
        mysqli_query($conn, $sql);
    }

    if (true) {
        $sql = "INSERT INTO edicao VALUES (DEFAULT,
        (SELECT ID FROM filme WHERE Titulo = '$titulo'),
        (SELECT ID FROM distribuidora WHERE Distribuidora = '$distribuidora'),
        (SELECT ID FROM midia WHERE Midia = '$midia'), '$regiao', 
        (SELECT ID FROM proporcao WHERE Proporcao = '$proporcao'), 
        (SELECT ID FROM audio WHERE Audio = '$audio'), $discos, 
        (SELECT ID FROM replicadora WHERE Replicadora = '$replicadora'), $codbarras, '$data', 
        (SELECT ID FROM loja WHERE Loja = '$loja'), $preco, $loja_fisica);";
        mysqli_query($conn, $sql);
    }

    header("Location: ../filmes.php?adicionar=sucesso");
