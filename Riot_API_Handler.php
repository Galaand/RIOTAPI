<?php

class Riot_API_Handler{
    
    private $apiKey;
    private $baseApiUrl;

    public function __construct($apiKey,$baseApiUrl){
        $this->apiKey = $apiKey;
        $this->baseApiUrl = $baseApiUrl;
    }

    public function fetchBasicAccountData($gameName, $tagLine){
        
        $url = "{$this->baseApiUrl}{$gameName}/{$tagLine}?api_key={$this->apiKey}";
        file_put_contents("C:\\logs\\logs.txt", "$url" . PHP_EOL, FILE_APPEND);
       
        $ch = curl_init();
       
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $error_msg = curl_error($ch);
            return ['error' => 'Failed to fetch data from Riot Games API.', 'details' => $error_msg];
        }

        curl_close($ch);

        if ($httpStatus >= 400 && $httpStatus <= 504) {
            return $this->handleError($httpStatus);
        }

        return json_encode($response, true);

    }

    private function handleError($httpStatus){
        switch ($httpStatus) {
            case 400:
                return ['error' => 'Bad request.'];
            case 401:
                return ['error' => 'Unauthorized.'];
            case 403:
                return ['error' => 'Forbidden.'];
            case 404:
                return ['error' => 'Data not found.'];
            case 405:
                return ['error' => 'Method not allowed.'];
            case 415:
                return ['error' => 'Unsupported media type.'];
            case 429:
                return ['error' => 'Rate limit exceeded.'];
            case 500:
                return ['error' => 'Internal server error.'];
            case 502:
                return ['error' => 'Bad gateway.'];
            case 503:
                return ['error' => 'Service unavailable.'];
            case 504:
                return ['error' => 'Gateway timeout.'];
            default:
                return ['error' => 'Unexpected error.'];
        }
    }
}