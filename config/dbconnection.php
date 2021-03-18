<?php
require_once 'credentials.php';

function pdo_connect_mysql() {
    $host = '127.0.0.1'; //localhost
    $db   = 'mypdodb';
    $user = USERNAME;
    $pass = PASSWORD;
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset"; //data source name
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
    	return new PDO($dsn, $user, $pass, $options);
    } 
    catch (PDOException $e) {
    	// If there is an error with the connection, stop the script and display the error.
        throw new PDOException($e->getMessage(), (int)$e->getCode());
        //die("ERROR: Could not connect. " . $e->getMessage());
    }
}