 
 <?php

header('Content-Type: application/json');

if (isset($_GET['gameName']) && isset($_GET['tagLine'])) {
    //$gameName = htmlspecialchars($_GET['gameName']);
    //$tagLine = htmlspecialchars($_GET['tagLine']);
    $gameName = urlencode($_GET['gameName']);
    $tagLine = urlencode($_GET['tagLine']);
    $apiKey = 'RGAPI-77170ea8-c5db-471a-93a3-48d4fc950c04';
    $url = "https://americas.api.riotgames.com/riot/account/v1/accounts/by-riot-id/$gameName/$tagLine?api_key=$apiKey";
    file_put_contents("C:\\logs\\logs.txt", "$url" . PHP_EOL, FILE_APPEND);
    //$url = "https://americas.api.riotgames.com/riot/account/v1/accounts/by-riot-id/A%20B%20R%20A%20X%20A%20S/EDB?api_key=RGAPI-6f61bff5-edff-4465-9dc3-fd3dee2c02c7";
    //$url = "https://americas.api.riotgames.com/riot/account/v1/accounts/by-riot-id/A B R A X A S/EDB?api_key=RGAPI-77170ea8-c5db-471a-93a3-48d4fc950c04";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desativa a verificação de certificado SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Desativa a verificação de host SSL
    
    
    
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false) {
        $error_msg = curl_error($ch);
        echo json_encode(['error' => 'Failed to fetch data from Riot Games API.', 'details' => $error_msg]);
    } else {
        switch ($http_status) {
            case 400:
                echo json_encode(['error' => 'Bad request.']);
                break;
            case 401:
                echo json_encode(['error' => 'Unauthorized.']);
                break;
            case 403:
                echo json_encode(['error' => 'Forbidden.']);
                break;
            case 404:
                echo json_encode(['error' => 'Data not found.']);
                break;
            case 405:
                echo json_encode(['error' => 'Method not allowed.']);
                break;
            case 415:
                echo json_encode(['error' => 'Unsupported media type.']);
                break;
            case 429:
                echo json_encode(['error' => 'Rate limit exceeded.']);
                break;
            case 500:
                echo json_encode(['error' => 'Internal server error.']);
                break;
            case 502:
                echo json_encode(['error' => 'Bad gateway.']);
                break;
            case 503:
                echo json_encode(['error' => 'Service unavailable.']);
                break;
            case 504:
                echo json_encode(['error' => 'Gateway timeout.']);
                break;
            default:
                echo $response;
                break;
        }
    }
    curl_close($ch);
} else {
    echo json_encode(['error' => 'No game name or tag line provided.']);
}
