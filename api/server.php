<?php
// api/server.php

// Set the server to listen on localhost (127.0.0.1) and port 8000
$server = new SoapServer(null, array('uri' => 'http://localhost:8000'));

// Include the SOAP functions file
require_once '../functions/soap_functions.php';

// Register the SOAP functions
$server->addFunction('helloWorld');

// Handle SOAP requests
$server->handle();
?>