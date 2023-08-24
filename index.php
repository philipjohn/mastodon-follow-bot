<?php
// List of Mastodon instances to target
$instances = array(
    'https://instance1.com',
    'https://instance2.com',
    // Add more instances here
);

// Mastodon API endpoint
$apiEndpoint = '/api/v1/accounts/';

// Access token for your bot
$accessToken = 'your_bot_access_token_here';

// Loop through instances
foreach ($instances as $instance) {
    // Get accounts from the instance
    $accounts = fetchAccounts($instance, $apiEndpoint, $accessToken);

    // Follow each account
    foreach ($accounts as $account) {
        followAccount($instance, $apiEndpoint, $account['id'], $accessToken);
    }
}

function fetchAccounts($instance, $apiEndpoint, $accessToken) {
    $url = $instance . $apiEndpoint;
    
    // Make API request to fetch accounts
    $response = makeApiRequest($url, $accessToken);
    
    return json_decode($response, true);
}

function followAccount($instance, $apiEndpoint, $accountId, $accessToken) {
    $url = $instance . $apiEndpoint . $accountId . '/follow';
    
    // Make API request to follow account
    $response = makeApiRequest($url, $accessToken, 'POST');
    
    // Handle the response as needed
    // ...
}

function makeApiRequest($url, $accessToken, $method = 'GET') {
    // Create cURL request
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute cURL request
    $response = curl_exec($ch);
    
    // Close cURL session
    curl_close($ch);
    
    return $response;
}
