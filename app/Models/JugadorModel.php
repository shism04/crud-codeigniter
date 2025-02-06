<?php

namespace App\Models;

use CodeIgniter\Model;

class JugadorModel extends Model 
{
    protected $table = 'jugadores'; 
    protected $primaryKey = 'id'; // Clave primaria
    protected $allowedFields = ['id','nombre', 'equipo', 'posicion', 'altura', 'peso', 'fecha_nacimiento', 'edad', 'champion', 'mvp', 'all_nba', 'descripcion', 'foto','salario'];
}