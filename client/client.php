<?php
// client.php

// Create a SOAP client
$client = new SoapClient(null, array('location' => "http://localhost:8000",
    'uri'      => "http://localhost:8000"));

// Call the SOAP function
$result = $client->helloWorld("Alice");

// Display the result
echo $result;  // Output: Hello, Alice!
?>
