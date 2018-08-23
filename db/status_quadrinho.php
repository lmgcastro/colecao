<?php
    include_once "dbh.php";

    $titulo = $_POST['submit'];

    $sql = "UPDATE quadrinhos SET Lido = 'S' WHERE Titulo = '$titulo';";
    mysqli_query($conn, $sql);

    header("Location: ../quadrinhos.php?status=sucesso");