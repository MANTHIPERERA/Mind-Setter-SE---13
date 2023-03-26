// Define the API endpoint URL
$url = "http://example.com/api/endpoint";

// Define the data to send in JSON format
$data = array(
    "name" => "John Doe",
    "email" => "johndoe@example.com",
);

$json_data = json_encode($data);

// Set up the cURL request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json_data))
);

// Execute the request and get the response
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    echo 'cURL Error: ' . curl_error($ch);
} else {
    // Display the response from the API
    echo $response;
}

// Close the cURL request
curl_close($ch);