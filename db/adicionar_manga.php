<?php
    include_once "dbh.php";

    $tituloExistente = $_POST['tituloExistente'];
    $tituloNovo = $_POST['tituloNovo'];
    $volumeExistente = $_POST['volumeExistente'];
    $volumeNovo = $_POST['volumeNovo'];
    
    if (empty($tituloExistente)) {
        $titulo = $tituloNovo;
    } else {
        $titulo = $tituloExistente;
    }
    
    if (empty($volumeExistente)) {
        $volume = $volumeNovo;
    } else {
        $volume = $volumeExistente;
    }

    $total = $_POST['total'];
    $artistas = $_POST['artistas'];
    $editora = $_POST['editora'];
    $original = $_POST['original'];

    if ($tituloExistente != "") {
        $sqlNovo = "SELECT DISTINCT Artistas, Editora, Original, Total FROM mangas WHERE Titulo = '$titulo';";
        $resultNovo = mysqli_query($conn, $sqlNovo);
        $resultCheckNovo = mysqli_num_rows($resultNovo);

        if ($resultCheckNovo > 0) {
            while ($rowNovo = mysqli_fetch_assoc($resultNovo)) {
                $artistas = $rowNovo['Artistas'];
                $editora = $rowNovo['Editora'];
                $original = $rowNovo['Original'];
                $total = $rowNovo['Total'];
            }
        }
    }

    $sql = "INSERT INTO mangas VALUES ('$titulo', '$volume', '$artistas', '$editora', '$original', 'N', $total);";
    mysqli_query($conn, $sql);

    header("Location: ../mangas.php?adicionar=sucesso");