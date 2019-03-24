<html>
    <head>
        <title>Test</title>
    </head>
    <body>
<?php
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.themoviedb.org/3/movie/281957?api_key=c5306c3e7e7062462c32abdcd28f87f4&append_to_response=credits",
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

    $count_diretor = 1;
    $diretor2 = null;
    foreach ($response['credits']['crew'] as $crewEntry) {
        if ($crewEntry['job'] == 'Director') {
            if ($count_diretor == 1) {
                $diretor = $crewEntry['name'];
                $ordem_diretor = $diretor;
                $count_diretor++;
            } else if ($count_diretor == 2) {
                $diretor2 = $crewEntry['name'];
                $ordem_diretor2 = $diretor;
            }
        }
    }
?>
    <h1><?php //echo $response['credits']['crew'][0]['name'] . ', ' . $response['credits']['crew'][1]['name']  
    echo $diretor . ', ' .  ?></h1>
    </body>
</html>