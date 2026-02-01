<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

use App\Classes\General;

class DataGame 
{
    /*
     * @ Título: Obtener objeto inicial del juego
     * Descripción
     * Devuelve la array de jugadores en sesión si existe. Si no, la inicializa con los valores por defecto
     * */
    public function obtain_() 
    {
        $data_game = [];
        if (Session::has('data_game')) { $data_game = Session::get('data_game'); }
        else {
            $data_game["started"] = 0;
            $data_game["jugadores"] = [];
        }
        
        return $data_game;
    }
    
    /*
     * @ Título: Cargar objeto del juego
     * Descripción
     * Preparamos objeto para avanzar al paso 2 y comenzar a jugar 
     * */
    public function start_gaming($data_game, $request) 
    {
        $General = new General();
        
        $data_game["started"] = 1;
        $array_jugadores = json_decode($request->jugadores);
        if(is_array($array_jugadores) && count($array_jugadores) > 0) {
            /* Obtenemos datos aleatorios */
            $array_personajes = $General->get_data_to_game();
            $array_personajes_random = array_rand($array_personajes, count($array_jugadores));
            foreach ($array_jugadores as $ind_jug=>$jug) {
                $jugador = json_decode(json_encode($jug), true);
                $jugador["status"] = 0;
                $jugador["trys"] = 5;
                $jugador["abc"] = $General->get_alphachar();
                $jugador["word"] = strtoupper($array_personajes[$array_personajes_random[$ind_jug]]);
                $jugador["word_keygen"] = $this->get_string_keygen($jugador["word"]);
                $data_game["jugadores"][$jugador["id"]] = $jugador;
            }
        }
        Session::put('data_game', $data_game);
        
        return $data_game;
    }
    
    /*
     * @ Título: Dividimos palabra para juego por caracteres
     * Descripción
     * Fragmentos palabra del juego en caracteres para controlar estado (descubierta o no)
     * */
    private function get_string_keygen($word) 
    {
        $array_word = [];
        for($i=0; $i < strlen($word); $i++) {
            $char = $i;
            if($char != "" && $char != "-") { $char = ""; }
            
            $type = "";
            if($word[$i] == " ") { $type = "espacio"; } else if($word[$i] == "-") { $type = "active_char"; } else { $type = "inactive_char"; }
            $array_word[] = array("char" => $word[$i], "type" => $type);
        }
        
        return $array_word;
    }
    
    /*
     * @ Título: Mostramos zona 2, jugando
     * Descripción
     * Mostramos zona jugando según el turno de cada jugador
     * */
    public function get_html_game_paso2($data_game, $request) 
    {
        $General = new General();
        
        $html_juego = "";
        if($data_game["started"] == 1) {
            if(count($data_game["jugadores"]) > 0) {
                $current_player = false; $trobat_current_player = false;
                foreach ($data_game["jugadores"] as $ind_jug => $jug) {
                    if($jug["status"] == 0 && !$trobat_current_player) { $current_player = true; $trobat_current_player = true; }
                    $next_jug = ""; $jug["btn"] = "btn_continue_gaming_end";
                    if($ind_jug < count($data_game["jugadores"])) { $jug["btn"] = "btn_continue_gaming_pass"; $next_jug = $ind_jug + 1; }
                    $html_juego .= view('parts.part2_jugador', compact('request', 'jug', 'current_player', 'next_jug'));
                    if($current_player) { $current_player = false; }
                }
            }
        }
        
        return $html_juego;
    }
    
    /*
     * @ Título: Jugando en zona 2
     * Descripción
     * Comprobamos si la letra está en la palabra del juego y devolvemos estado del jugador hasta que acaba su turno.
     * */
    public function gaming_and_searching($data_game, $request) 
    {
        $respuesta = array("letter" => $request->letter, "new_letter_class" => "", "num_intents" => 0, "positions" => array(), "acabado_juego" => true);
        if(array_key_exists($request->id_jugador, $data_game["jugadores"])) {
            $jugador = $data_game["jugadores"][$request->id_jugador];
            /* Buscamos si la letra existe */
            $trobat = false;
            foreach ($jugador["word_keygen"] as $in_word_keygen => $word_keygen) {
                if($word_keygen["char"] == $request->letter) {
                    $respuesta["positions"][] = $in_word_keygen;
                    $jugador["word_keygen"][$in_word_keygen]["type"] = "active_char";
                    $jugador["abc"][$request->letter] = 1;
                    $respuesta["new_letter_class"] = "abc_let_1"; $trobat = true;
                }
            }
            /* Si la letra no está, se pone como desactivado y se resta un intento */
            if(!$trobat) { $jugador["trys"] -= 1; $jugador["abc"][$request->letter] = 2; $respuesta["new_letter_class"] = "abc_let_2"; }
            /* Si me quedo sin intentos, se acaba */
            $respuesta["num_intents"] = $jugador["trys"];
            if($respuesta["num_intents"] == 0) { $respuesta["acabado_juego"] = true; }
            else {
                /* Recorremos array, si hay algo inactivo, se pone como juego desactivado */
                foreach ($jugador["word_keygen"] as $in_word_keygen => $word_keygen) {
                    if($word_keygen["type"] == "inactive_char") { $respuesta["acabado_juego"] = false; }
                }
            }
            /* Si el juego ha acabado, el jugador pierde su turno */
            if($respuesta["acabado_juego"]) { 
                $jugador["status"] = 1;
                $respuesta["word"] = $jugador["word"];
            }

            /* Volvemos a cargar datos */
            $data_game["jugadores"][$request->id_jugador] = $jugador;
            Session::put('data_game', $data_game);
        }

        return $respuesta;
    }
    
    /*
     * @ Título: Cerrar juego al terminar turnos
     * Descripción
     * Cuadno todos los jugadores acaban el turno, actualizamos estado del juego
     * */
    public function close_game($data_game) 
    {
        $data_game["started"] = 2;        
        Session::put('data_game', $data_game);
        
        return $data_game;
    }
    
    /*
     * @ Título: Mostrar zona 3 para resultados
     * Descripción
     * Devolvemos html con los resultados de ganadores/perdedores
     * */
    public function get_html_game_paso3($data_game, $request) 
    {
        $General = new General();
        
        $html_juego = "";
        if($data_game["started"] == 2) {
            $array_jugadores = array("ganadores" => array(), "perdedores" => array());
            $jugadores = $data_game["jugadores"];
            foreach ($jugadores as $jug) {
                if($jug["trys"] == 0) { $array_jugadores["perdedores"][] = $jug; }
                else { $array_jugadores["ganadores"][] = $jug; }
            }
            $html_juego = view('parts.part3_jugador', compact('request', 'array_jugadores'));
        }
        
        return $html_juego;
    }
    
    /*
     * @ Título: Reiniciar juego completamente
     * Descripción
     * Borramos de la sesión el objeto del juego para empezar otra vez
     * */
    public function delete_() 
    {
        Session::forget('data_game'); 
    }
    
    /*
     * @ Título: Reiniciar juego con los mismos jugadores
     * Descripción
     * Asignamos una nueva palabra para jugar a cada jugador y empezamos a jugar
     * */
    public function restart_($data_game) 
    {
        $General = new General();
        
        $data_game["started"] = 1;
        $array_personajes = $General->get_data_to_game();
        $array_personajes_random = array_rand($array_personajes, count($data_game["jugadores"]));
        foreach($data_game["jugadores"] as $ind_jug=>$jug) {
            $data_game["jugadores"][$ind_jug]["status"] = 0;
            $data_game["jugadores"][$ind_jug]["trys"] = 5;
            $data_game["jugadores"][$ind_jug]["abc"] = $General->get_alphachar();
            $data_game["jugadores"][$ind_jug]["word"] = strtoupper($array_personajes[$array_personajes_random[$ind_jug-1]]);
            $data_game["jugadores"][$ind_jug]["word_keygen"] = $this->get_string_keygen($data_game["jugadores"][$ind_jug]["word"]);
        }
        Session::put('data_game', $data_game);
    }
}