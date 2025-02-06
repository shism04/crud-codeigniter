<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Calculadora extends Controller
{
    public function index()
    {
        return view('calculadora'); 
    }

    public function procesar()
    {
        if ($this->request->getPost('expression')) {
            $expression = $this->request->getPost('expression');
            $parts = explode(" ", $expression);
            $num1 = $parts[0];
            $operation = $parts[1];
            $num2 = isset($parts[2]) ? $parts[2] : null;

            // Llamar a las funciones de operaciones
            switch ($operation) {
                case '+':
                    echo $this->sumar($num1, $num2);
                    break;
                case '-':
                    echo $this->restar($num1, $num2);
                    break;
                case '*':
                    echo $this->multiplicar($num1, $num2);
                    break;
                case '/':
                    echo $this->dividir($num1, $num2);
                    break;
                case '%':
                    echo $this->modulo($num1, $num2);
                    break;
                case '^':
                    echo $this->power($num1, $num2);
                    break;
                case '!':
                    echo $this->factorial($num1);
                    break;
                case 'rand':
                    echo $this->random($num1, $num2);
                    break;
                default:
                    echo "Error: Invalid operation";
            }
        } else {
            echo "No expression provided.";
        }
        exit();
    }

    private function sumar($a, $b)
    {
        return $a + $b;
    }

    private function restar($a, $b)
    {
        return $a - $b;
    }

    private function dividir($a, $b)
    {
        if ($b == 0) {
            return "Div/0 Error";
        }
        return $a / $b;
    }

    private function multiplicar($a, $b)
    {
        return $a * $b;
    }

    private function modulo($a, $b)
    {
        return $a % $b;
    }

    private function factorial($y)
    {
        if ($y < 0) {
            return "fact(-n) error";
        } elseif ($y == 0 || $y == 1) {
            return 1;
        } else {
            $resultado = 1;
            for ($i = 2; $i <= $y; $i++) {
                $resultado *= $i;
            }
            return $resultado;
        }
    }

    private function random($min, $max)
    {
        if ($min > $max) {
            return "rand(min>max) error";
        } else {
            return rand($min, $max);
        }
    }

    private function power($x, $y)
    {
        return pow($x, $y);
    }
}
?>