<?php 

namespace App\Classes;

use Illuminate\Support\Facades\Session;

class General 
{
    /*
     * @ Título: Obtener lista de avatares disponibles para los jugadores
     * Descripción
     * Obtener array de avatares fijos
     * */
    public function get_array_avatares() 
    { 
        $array_avatares = array();
        $array_avatares[] = "/img/personajes/antman.jpg";
        $array_avatares[] = "/img/personajes/capitan_america.png";
        $array_avatares[] = "/img/personajes/doctor_strange.jpg";
        $array_avatares[] = "/img/personajes/hulk.jpg";
        $array_avatares[] = "/img/personajes/ironman.jpg";
        $array_avatares[] = "/img/personajes/thor.jpg";
        
        view()->share('array_avatares', $array_avatares);
    }
    
    /*
     * @ Título: Obtener listado de opciones para el juego
     * Descripción
     * Lista de opciones para jugar obtenidas de fichero estático JSON
     * */
    public function get_data_to_game() 
    {
        $array_personajes = array();
        $data = file_get_contents("personajes.json");
        $personajes = json_decode($data, true);
        foreach ($personajes as $p) { $array_personajes[$p["id"]] = $p["value"]; }
        
        return $array_personajes;
    }
    
    /* GENERAL FUNCTIONS */
    public function get_alphachar() 
    {
        $array_alphabet = array();
        $alphachar = range('A', 'Z');
        foreach ($alphachar as $al) { $array_alphabet[$al] = 0; }
        
        return $array_alphabet;
    }
}

?>