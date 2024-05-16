<?php

require('config.php');

$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

if ($db->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}