<?php
namespace App\Controllers;

class User extends BaseController {

    protected $users;
    protected $session;


    public function __construct()
    {
        $this->session = \Config\Services::session();

        if (!$this->session->has('users')) {
            $this->session->set('users', []); 
        }

        $this->users = $this->session->get('users');
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
        $apellido = $this->request->getPost('apellido');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $fecha_nacimiento = $this->request->getPost('fecha_nacimiento');

        // Comprobar si el email ya está registrado
        if ($this->user_exist($email)) {
            return redirect()->back()->with('failed', 'Ya existe un usuario con este email');
        } else {
            $this->users[] = [
                'nombre'          => $nombre,
                'apellido'        => $apellido,
                'email'           => $email,
                'password'        => $password,
                'fecha_nacimiento' => $fecha_nacimiento
            ];
            $this->session->set('users', $this->users);
            return redirect()->to('/')->with('success', '✅ Registro exitoso');
        }
    }

    private function validateInputs(){
        $rules = [
            'nombre'          => 'required|min_length[3]|max_length[50]|alpha',
            'apellido'        => 'required|min_length[3]|max_length[50]|alpha_space',
            'email'           => 'required|valid_email',
            'password'        => 'required|alpha_numeric',
            'confirm_pswd'    => 'required|matches[password]',
            'fecha_nacimiento'=> 'required|valid_date[Y-m-d]',
        ];
        
        $messages = [
            'nombre' => [
                'required'    => 'El nombre es obligatorio.',
                'min_length'  => 'El nombre debe tener al menos 3 caracteres.',
                'max_length'  => 'El nombre no puede exceder los 50 caracteres.',
                'alpha'       => 'El nombre solo puede contener letras.',
            ],
            'apellido' => [
                'required'    => 'El apellido es obligatorio.',
                'min_length'  => 'El apellido debe tener al menos 3 caracteres.',
                'max_length'  => 'El apellido no puede exceder los 50 caracteres.',
                'alpha_space' => 'El apellido solo puede contener letras y espacios.',
            ],
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, ingresa un correo electrónico válido.',
            ],
            'password' => [
                'required'        => 'La contraseña es obligatoria.',
                'alpha_numeric'   => 'La contraseña debe contener solo letras y números.',
            ],
            'confirm_pswd' => [
                'required'        => 'Es necesario confirmar la contraseña.',
                'matches'         => 'La confirmación de la contraseña no coincide con la contraseña.',
            ],
            'fecha_nacimiento' => [
                'required'    => 'La fecha de nacimiento es obligatoria.',
                'valid_date'  => 'Por favor, ingresa una fecha válida en formato Y-m-d.',
            ],
        ];
        
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }        
    }

    private function user_exist($userEmail){
        $all_emails = array_column($this->users, 'email');
        return in_array($userEmail, $all_emails); 
    }
}
