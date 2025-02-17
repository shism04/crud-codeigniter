<?php

namespace App\Controllers;

class User extends BaseController
{

    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        return view('signup');
    }

    public function signup()
    {
        $validationResult = $this->validateInputs();
        if ($validationResult instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $validationResult;
        }

        $nombre = $this->request->getPost('nombre');
        $password = $this->request->getPost('password');

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'USUARIOS'   => $nombre,
            'PASSWORD' => $hashedPassword
        ];
        $this->userModel->insert($data);

        $this->session->set('user', $nombre);

        return redirect()->to('/')->with('success', '✅ Registro exitoso');
    }

    public function login()
    {
        $nombre = $this->request->getPost('nombre');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('USUARIOS', $nombre)->first();

        if (!$user || !password_verify($password, $user['PASSWORD'])) {
            return redirect()->back()->with('error', '❌ Usuario o contraseña incorrectos');
        }

        $this->session->set('user', $user['USUARIOS']);

        return redirect()->to('/')->with('success', '✅ Inicio de sesión exitoso');
    }   

    public function getlogin(){
        return view('login');
    }


    private function validateInputs()
    {
        $rules = [
            'nombre'          => 'required|min_length[3]|max_length[50]|alpha',
            'password'        => 'required|alpha_numeric',
            'confirm_pswd'    => 'required|matches[password]',
        ];

        $messages = [
            'nombre' => [
                'required'    => 'El nombre es obligatorio.',
                'min_length'  => 'El nombre debe tener al menos 3 caracteres.',
                'max_length'  => 'El nombre no puede exceder los 50 caracteres.',
                'alpha'       => 'El nombre solo puede contener letras.',
            ],
            'password' => [
                'required'        => 'La contraseña es obligatoria.',
                'alpha_numeric'   => 'La contraseña debe contener solo letras y números.',
            ],
            'confirm_pswd' => [
                'required'        => 'Es necesario confirmar la contraseña.',
                'matches'         => 'La confirmación de la contraseña no coincide con la contraseña.',
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }
    }
}
