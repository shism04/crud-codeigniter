<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $session = session();
        $user = $session->get('user');
    
        if (!$user) {
            return redirect()->to('/loginview');
        }

        $page = $this->request->getGet('pagina') ?? 1;
        $limit = $this->request->getGet('limit') ?? 10;
        $ordenar_por = $this->request->getGet('ordenar_por');
        $direccion = $this->request->getGet('direccion');

        // Obtener jugadores paginados
        $data['jugadores'] = $this->getPaginatedJugadores($page, $limit);

        // Ordenar con usort
        if (!empty($ordenar_por)) {
            usort($data['jugadores'], function ($a, $b) use ($ordenar_por, $direccion) {
                if (!isset($a[$ordenar_por]) || !isset($b[$ordenar_por])) {
                    return 0; // Evita errores si el campo no existe
                }

                if (is_numeric($a[$ordenar_por]) && is_numeric($b[$ordenar_por])) {
                    return ($direccion === 'ASC') ? $a[$ordenar_por] <=> $b[$ordenar_por] : $b[$ordenar_por] <=> $a[$ordenar_por];
                } else {
                    return ($direccion === 'ASC') ? strcasecmp($a[$ordenar_por], $b[$ordenar_por]) : strcasecmp($b[$ordenar_por], $a[$ordenar_por]);
                }
            });
        }

        // Filtro de búsqueda
        if (($this->request->getPost('busqueda') !== null) && !empty($this->request->getPost('busqueda'))) {
            $searchKey = strtolower($this->request->getPost('busqueda'));
            $data['jugadores'] = array_filter($data['jugadores'], function ($player) use ($searchKey) {
                return stripos($player['nombre'], $searchKey) !== false ||
                    stripos($player['equipo'], $searchKey) !== false ||
                    stripos($player['posicion'], $searchKey) !== false ||
                    stripos($player['altura'], $searchKey) !== false ||
                    stripos($player['peso'], $searchKey) !== false ||
                    stripos($player['descripcion'], $searchKey) !== false;
            });
        }

        $data['totalJugadores'] = $this->jugadorModel->countAll();
        $data['limit'] = $limit;
        $data['pagina'] = $page;
        $data['ordenar_por'] = $ordenar_por;
        $data['direccion'] = $direccion;


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


        $limit = $this->request->getVar('limit');

        $totalJugadores = $this->jugadorModel->countAll();

        $paginadestin = ceil($totalJugadores / $limit);

        return redirect()->to('/jugadores?limit=' . $limit . '&pagina=' . $paginadestin)->with('success', 'Jugador añadido correctamente');
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

        return redirect()->back()->with('success', 'Jugador actualizado correctamente.');
    }

    public function deletePlayer($id)
    {
        $pagina = $this->request->getVar('pagina') ?? 1;
        $limit = $this->request->getVar('limit') ?? 10;

        $jugador = $this->jugadorModel->find($id);

        if (!$jugador) {
            return redirect()->back()->with('error', 'El jugador no existe.');
        }

        $this->jugadorModel->delete($id);

        $totalJugadores = $this->jugadorModel->countAll();
        $desPage = ceil($totalJugadores / $limit);

        if ($desPage == 0) {
            $desPage = 1;
        }


        return redirect()->to('/jugadores?limit=' . $limit . '&pagina=' . $desPage)
            ->with('success', 'Jugador eliminado correctamente.');
    }
}
