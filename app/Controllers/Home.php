<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $page = $this->request->getGet('pagina') ?? 1;
        $limit = $this->request->getGet('limit') ?? 10;


        $data['jugadores'] = $this->getPaginatedJugadores($page, $limit);
        if (($this->request->getPost('busqueda') !== null) && !empty($this->request->getPost('busqueda'))) {
            $searchKey = $this->request->getPost('busqueda');
            $data['jugadores'] = array_filter($data['jugadores'], function ($player) use ($searchKey) {
                return strpos(strtolower($player['nombre']), strtolower($searchKey)) !== false ||
                    strpos(strtolower($player['equipo']), strtolower($searchKey)) !== false ||
                    strpos(strtolower($player['posicion']), strtolower($searchKey)) !== false ||
                    strpos(strtolower($player['altura']), strtolower($searchKey)) !== false ||
                    strpos(strtolower($player['peso']), strtolower($searchKey)) !== false ||
                    strpos(strtolower($player['descripcion']), strtolower($searchKey)) !== false;
            });
        }
        $data['totalJugadores'] = $this->jugadorModel->countAll();
        $data['limit'] = $limit;
        $data['pagina'] = $page;

        return view('home', $data);
    }

    public function getPaginatedJugadores($page, $limit)
    {
        $offset = intval((int)($page) - 1) * $limit;

        return $this->jugadorModel->findAll($limit, $offset);
    }

    public function insertPlayer()
    {
        $rules = [
            'nombre'      => 'required|min_length[3]|max_length[50]',
            'equipo'      => 'required|min_length[3]|max_length[50]',
            'posicion'    => 'required|max_length[30]',
            'altura'      => 'required|decimal',
            'peso'        => 'required|decimal',
            'edad'        => 'required|integer|greater_than[15]|less_than[50]',
            'descripcion' => 'permit_empty|max_length[255]',
            'foto'        => 'uploaded[foto]|is_image[foto]|max_size[foto,2048]|mime_in[foto,image/png,image/jpg,image/jpeg]'
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no puede tener más de 50 caracteres.'
            ],
            'equipo' => [
                'required'   => 'El equipo es obligatorio.',
                'min_length' => 'El equipo debe tener al menos 3 caracteres.',
                'max_length' => 'El equipo no puede tener más de 50 caracteres.'
            ],
            'posicion' => [
                'required'   => 'La posición es obligatoria.',
                'max_length' => 'La posición no puede tener más de 30 caracteres.'
            ],
            'altura' => [
                'required' => 'La altura es obligatoria.',
                'decimal'  => 'La altura debe ser un número decimal.'
            ],
            'peso' => [
                'required' => 'El peso es obligatorio.',
                'decimal'  => 'El peso debe ser un número decimal.'
            ],
            'edad' => [
                'required'     => 'La edad es obligatoria.',
                'integer'      => 'La edad debe ser un número entero.',
                'greater_than' => 'La edad debe ser mayor de 15 años.',
                'less_than'    => 'La edad debe ser menor de 50 años.'
            ],
            'descripcion' => [
                'max_length' => 'La descripción no puede superar los 255 caracteres.'
            ],
            'foto' => [
                'uploaded'  => 'Debe subir una imagen.',
                'is_image'  => 'El archivo debe ser una imagen válida.',
                'max_size'  => 'El tamaño máximo de la imagen es 2MB.',
                'mime_in'   => 'El formato de la imagen debe ser PNG, JPG o JPEG.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errorsadd', $this->validator->getErrors());
        }

        $data = [
            'nombre'      => $this->request->getPost('nombre'),
            'equipo'      => $this->request->getPost('equipo'),
            'posicion'    => $this->request->getPost('posicion'),
            'altura'      => $this->request->getPost('altura'),
            'peso'        => $this->request->getPost('peso'),
            'edad'        => $this->request->getPost('edad'),
            'descripcion' => $this->request->getPost('descripcion')
        ];

        $file = $this->request->getFile('foto');

        if ($file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/'; // Ruta correcta en public/

            // Crear el directorio si no existe
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $data['foto'] = file_get_contents($file->getTempName());

            $fileName = $file->getName();
            $file->move('uploads/', $fileName);
        }

        // Guardar en la base de datos

        $this->jugadorModel->insert($data);

        return redirect()->to('/')->with('success', 'Jugador añadido correctamente');
    }

    public function updatePlayer()
    {
        // Definir reglas de validación
        $rules = [
            'nombre'      => 'required|min_length[3]|max_length[50]',
            'equipo'      => 'required|min_length[3]|max_length[50]',
            'posicion'    => 'required|max_length[30]',
            'altura'      => 'required|decimal',
            'peso'        => 'required|decimal',
            'edad'        => 'required|integer|greater_than[15]|less_than[50]',
            'descripcion' => 'permit_empty|max_length[255]',
            'foto'        => 'if_exist|is_image[foto]|max_size[foto,2048]|mime_in[foto,image/png,image/jpg,image/jpeg]'
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no puede tener más de 50 caracteres.'
            ],
            'equipo' => [
                'required'   => 'El equipo es obligatorio.',
                'min_length' => 'El equipo debe tener al menos 3 caracteres.',
                'max_length' => 'El equipo no puede tener más de 50 caracteres.'
            ],
            'posicion' => [
                'required'   => 'La posición es obligatoria.',
                'max_length' => 'La posición no puede tener más de 30 caracteres.'
            ],
            'altura' => [
                'required' => 'La altura es obligatoria.',
                'decimal'  => 'La altura debe ser un número decimal.'
            ],
            'peso' => [
                'required' => 'El peso es obligatorio.',
                'decimal'  => 'El peso debe ser un número decimal.'
            ],
            'edad' => [
                'required'     => 'La edad es obligatoria.',
                'integer'      => 'La edad debe ser un número entero.',
                'greater_than' => 'La edad debe ser mayor de 15 años.',
                'less_than'    => 'La edad debe ser menor de 50 años.'
            ],
            'descripcion' => [
                'max_length' => 'La descripción no puede superar los 255 caracteres.'
            ],
            'foto' => [
                'is_image' => 'El archivo debe ser una imagen válida.',
                'max_size' => 'El tamaño máximo de la imagen es 2MB.',
                'mime_in'  => 'El formato de la imagen debe ser PNG, JPG o JPEG.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errorsupd', $this->validator->getErrors());
        }

        // Verificar si el jugador existe
        $jugador = $this->jugadorModel->find($this->request->getVar('id'));
        if (!$jugador) {
            return redirect()->back()->with('error', 'El jugador no existe.');
        }

        // Obtener datos del formulario
        $data = [
            'nombre'      => $this->request->getPost('nombre'),
            'equipo'      => $this->request->getPost('equipo'),
            'posicion'    => $this->request->getPost('posicion'),
            'altura'      => $this->request->getPost('altura'),
            'peso'        => $this->request->getPost('peso'),
            'edad'        => $this->request->getPost('edad'),
            'descripcion' => $this->request->getPost('descripcion')
        ];

        $file = $this->request->getFile('foto');

        if ($file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/'; // Ruta correcta en public/

            // Crear el directorio si no existe
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $data['foto'] = file_get_contents($file->getTempName());

            $fileName = $file->getName();
            $file->move('uploads/', $fileName);
        }


        // Actualizar el jugador en la base de datos
        $this->jugadorModel->update($this->request->getVar('id'), $data);

        return redirect()->to('/')->with('success', 'Jugador actualizado correctamente.');
    }

    public function deletePlayer($id)
    {
        // Buscar el jugador por ID
        $jugador = $this->jugadorModel->find($id);

        if (!$jugador) {
            return redirect()->back()->with('error', 'El jugador no existe.');
        }

        // Eliminar el jugador
        $this->jugadorModel->delete($id);

        return redirect()->to('/')->with('success', 'Jugador eliminado correctamente.');
    }
}
