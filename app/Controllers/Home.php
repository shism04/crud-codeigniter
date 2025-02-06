<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $page = $this->request->getGet('pagina') ?? 1;
        $limit = $this->request->getGet('limit') ?? 10;

        $data['jugadores'] = $this->getPaginatedJugadores($page, $limit);
        $data['totalJugadores'] = $this->jugadorModel->countAll();
        $data['limit'] = $limit;
        $data['pagina']=$page;

        return view('home',$data);
    }

    public function getPaginatedJugadores($page,$limit){
        $offset=intval((int)($page)-1)*$limit;
        
        return $this->jugadorModel->findAll($limit,$offset) ;
    }
}
