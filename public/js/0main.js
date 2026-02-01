$(document).ready(function() {
	
	/* ZONA 1 */
	
	$(".num_jugadors").click(function() {
		$(".num_jugadors").removeClass("active");
		$(this).addClass("active");		
		var num_jugadors = $(this).attr("data-num");
		$.ajax({
	        url: "/game/mostrar_jugadores",
	        type: 'GET',
	        contentType: 'application/json; charset=utf-8',
	        data: { 
	        	num_jugadors: num_jugadors,
        	},		        
	        success: function (response) {
	        	$(".row_list_jugadors").removeClass("d-none");
	        	$(".row_list_jugadors_list").html(response);
	        }
	    }); 		
	});
	
	$(document).on('click', '.btn_cambiar_foto_perfil, .img_no_perfil', function() {
		var id_jugador = $(this).attr("data-id-jugador");	
		charge_new_profile_foto(id_jugador);
	});
	
	function charge_new_profile_foto(id_jugador) {
		$("#current_player_foto").val(id_jugador);
		$("#modal_perfil_foto").modal("show");		
	}
	
	$(".img_do_perfil").click(function() {
		var id_jugador = $("#current_player_foto").val();
		var url_img = $(this).attr("src");
		$("#img_no_perfil_" + id_jugador).attr("src", url_img);
		$("#img_no_perfil_" + id_jugador).attr("data-foto", 1);
		$("#modal_perfil_foto").modal("hide");	
	});
	
	$(".btn_start_game").click(function() {
		
		var num_jugadors = $(".num_jugadors.active").attr("data-num");
		var control_imgs = false; var control_names = false;
		$(".msg_error").addClass("d-none");
		$(".block_jugador").removeClass("block_jugador_error");
		
		/* Control data */
		$(".img_no_perfil").each(function() {
			var id_jugador = $(this).attr("data-id-jugador");
			if(id_jugador <= num_jugadors) {
				var foto_perfil = $(this).attr("data-foto");
				var name_jugador = $("#name_jugador_" + id_jugador).val();
				if(foto_perfil == 0) { $(this).parent().addClass("block_jugador_error"); control_imgs = true; }
				if(name_jugador == "") { $(this).parent().addClass("block_jugador_error"); control_names = true; }
			}
		});
		
		/* Si ok, enviar datos */
		if(control_names == true || control_imgs == true) { $(".msg_error").removeClass("d-none"); }
		else {
			
			var jugadores = [];
			$(".img_no_perfil").each(function() {
				var id_jugador = $(this).attr("data-id-jugador");
				if(id_jugador <= num_jugadors) {
					var jugador = {};
					var foto_perfil = $(this).attr("src");
					var name_jugador = $("#name_jugador_" + id_jugador).val();
					jugador["id"] = id_jugador;
					jugador["name"] = name_jugador;
					jugador["foto"] = foto_perfil;
					jugadores.push(jugador);
				}
			});
			/* Enviamos datos de jugadores */
			$.ajax({
		        url: "/game/guardar_jugadores",
		        type: 'GET',
		        contentType: 'application/json; charset=utf-8',
		        data: { 
		        	jugadores: JSON.stringify(jugadores),
	        	},		        
		        success: function (response) {
		            $("#container_start_1").addClass("d-none");
		            $("#container_start_2").removeClass("d-none").html(response);
		        }
		    }); 
			
		}
		
	});
	
	/* PARTE 2 */
	
	$(document).on('click', '.abc_let', function() {
		
		var id_jugador = $(this).attr("data-id-jugador");
		var letter = $(this).html();
		if($(this).hasClass("abc_let_0") && !$(this).hasClass("abc_let_desactivated")) { //clase que indica que no ha sido pulsada la letra
			$.ajax({
		        url: "/game/comprobar_letra",
		        type: 'GET',
		        contentType: 'application/json; charset=utf-8',
		        data: { 
		        	id_jugador: id_jugador,
		        	letter: letter,
	        	},		        
		        success: function (response) {
		        	var data = JSON.parse(response);
		        	var posiciones = data["positions"];
		        	$(".card_player_" + id_jugador + " .intentos").html(data["num_intents"]);
		        	$(".card_player_" + id_jugador + " .abc_let_" + letter).removeClass("abc_let_0").addClass(data["new_letter_class"]);
		        	posiciones.forEach(function(letter_, index) {
		        	    $(".card_player_" + id_jugador + " .zona_ahorcado .letter.letter_" + letter_).removeClass("letter_inactive_char").addClass("letter_active_char").html(letter);
		        	});
		        	if(data["acabado_juego"]) {
		        		$(".card_player_" + id_jugador + " .abc_let").addClass("abc_let_desactivated");
		        		$(".card_player_" + id_jugador + " .btn_continue_gaming").removeClass("d-none");
		        	}
		        	/* Mostramos dibujo del ahorcado */
		        	if(data["num_intents"] < 5) {
		        		$(".card_player_" + id_jugador + " .img_zona_ahorcado_dib").each(function() {
		        			var id_position = $(this).attr("data-position");
		        			if(id_position >= data["num_intents"]) { $(this).removeClass("d-none"); }
		        		});
		        	}
					if(data['word'] && data['word'] != '') {
						$(".word").html(data['word']);
					}
		        }
		    });
		}	
		
	});
	
	$(document).on('click', '.btn_continue_gaming_pass', function() {
		var next_player = $(this).attr("data-next-jug");
		$(".card_player").addClass("d-none");
		$(".card_player_" + next_player).removeClass("d-none");
	});
	
	$(document).on('click', '.btn_continue_gaming_end', function() {
		$.ajax({
	        url: "/game/terminar_juego",
	        type: 'GET',
	        contentType: 'application/json; charset=utf-8',
	        data: { 
        	},		        
	        success: function (response) {
	        	$("#container_start_1").addClass("d-none");
	        	$("#container_start_2").addClass("d-none");
	            $("#container_start_3").removeClass("d-none").html(response);
	        }
	    });
	});
	
});