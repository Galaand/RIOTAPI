<?php
require_once 'Riot_API_Handler.php';

// Chave da API da Riot Games
$apiKey = 'RGAPI-77170ea8-c5db-471a-93a3-48d4fc950c04';
$baseApiUrl = "https://americas.api.riotgames.com/riot/account/v1/accounts/by-riot-id/";

// Criando uma instância da classe RiotGamesAPI
$riotAPI = new Riot_API_Handler($apiKey,$baseApiUrl);

// Exemplo de uso: fazendo uma requisição
$gameName = urlencode($_GET['gameName']);
$tagLine = urlencode($_GET['tagLine']);



$response = $riotAPI->fetchBasicAccountData($gameName, $tagLine);

// Exemplo de processamento da resposta
if (isset($response['error'])) {
    echo json_encode(['error' => $response['error']]);
} else {
    echo json_encode($response);
}
