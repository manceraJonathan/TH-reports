<?php

namespace App\Models;

use Exception, mysqli;

require('../config/config.php');

class Model
{
    protected static $connection;

    public function __construct()
    {
        // Reutilizar la conexión en caso de que ya esté inicializada
        if (!isset(self::$connection)) {
            try {
                self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
                self::$connection->set_charset(DB_CHARSET);
            } catch (Exception $e) {
                die("Database connection error: " . $e->getMessage());
            }
        }
    }

    public function closeConnection()
    {
        if (self::$connection) {
            self::$connection->close();
        }
    }
}