<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'proekt');

// We try to establish connection to the database
try {
    $pdo = new PDO("mysql:host=". DB_SERVER .";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);

    // Error exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    echo 'The connection was not successful' . $e->getMessage();
}
