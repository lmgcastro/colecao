<?php
    include_once "dbh.php";

    $titulo = $_POST['titulo'];
    $volume = $_POST['volume'];        
    $artistas = $_POST['artistas'];
    $editora = $_POST['editora'];
    $original = $_POST['original'];
    $total = $_POST['total'];
    
    $sql = "INSERT INTO mangas VALUES ('$titulo', '$volume', '$artistas', '$editora', '$original', 'N', $total);";
    mysqli_query($conn, $sql);

    header("Location: ../mangas.php?adicionar=sucesso");