<?php
    include_once "dbh.php";

    $titulo = $_POST['titulo'];
    $artistas = $_POST['artistas'];
    $editora = $_POST['editora'];
    $original = $_POST['original'];

    $sql = "INSERT INTO quadrinhos VALUES ('$titulo', '$artistas', '$editora', '$original', 'N');";
    mysqli_query($conn, $sql);

    header("Location: ../quadrinhos.php?adicionar=sucesso");