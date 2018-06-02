<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;

class ClientsController extends Controller{
    public function showClientInfo($id){
        $client = DB::select('SELECT * FROM CLIENTES WHERE ID_CLIENTE = ?', [$id]);
        return view('client/show', ['client' => $client[0]]);
    }
}

?>