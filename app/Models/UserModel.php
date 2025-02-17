<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model 
{
    protected $table = 'usuarios_pass'; 
    protected $primaryKey = 'ID'; // Clave primaria
    protected $allowedFields = ['ID','USUARIOS', 'PASSWORD'];
}