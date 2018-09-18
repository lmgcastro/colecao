<?php
    include_once "dbh.php";

    $titulo = $_POST['titulo'];
    $volume = $_POST['volume'];
	
    // SELECT DADOS NAO INFORMADOS
    $sql = "SELECT DISTINCT Artistas, Editora, Original, Total FROM mangas WHERE Titulo = '$titulo';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $artistas = $row['Artistas'];
            $editora = $row['Editora'];
            $original = $row['Original'];
            $total = $row['Total'];
        }
    }

    $sql = "INSERT INTO mangas VALUES ('$titulo', '$volume', '$artistas', '$editora', '$original', 'N', $total);";
    mysqli_query($conn, $sql);

    header("Location: ../mangas.php?adicionar=sucesso");
