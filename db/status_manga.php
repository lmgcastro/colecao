<?php
    include_once "dbh.php";

    $titulo_volume = $_POST['lido'];
    $parte = explode('#', $titulo_volume);

    $sql = "UPDATE mangas SET Lido = 'S' WHERE Titulo = '$parte[0]' AND Volume = $parte[1];";
    mysqli_query($conn, $sql);

    header("Location: ../mangas.php?status=sucesso");