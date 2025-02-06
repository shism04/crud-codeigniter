<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class TestDatabase extends Controller
{
    public function index()
    {
        // Test the database connection
        $db = Database::connect();
        $query = $db->query("SELECT 1");

        if ($query) {
            echo "Database connected successfully!";
        } else {
            echo "Database connection failed.";
        }
    }
}
