<div class="card_player card_player_{{ $jug['id'] }} @if(!$current_player) d-none @endif">
	<div class="row row_to_player">
		<div class="col-12 col_to_player">
			<div class="card p-3">
        		<div class="row text-center">
        			<div class="col-12 col-md-4">
        				<div class="block_jugador">
                			<img id="img_no_perfil_{{ $jug['id'] }}" src="{{ $jug['foto'] }}" class="img_no_perfil" />  
                			<span class="d-block mt-3">Jugador {{ $jug['id'] }}</span>
    						<h3 class="mb-0"><b>{{ $jug['name'] }}</b></h3>              			
                		</div>	
        			</div>
        			<div class="col-12 col-md-4">
        				<div class="zona_ahorcado_dib">
        					<img class="img_hierba img_zona_ahorcado_dib @if($jug['trys'] >= 5) d-none @endif" data-position="4" src="/img/ahorcado/0hierba.png" />
        					<img class="img_arbol img_zona_ahorcado_dib @if($jug['trys'] >= 4) d-none @endif" data-position="3" src="/img/ahorcado/arbol.png" />
        					<img class="img_nudo img_zona_ahorcado_dib @if($jug['trys'] >= 3) d-none @endif" data-position="2" src="/img/ahorcado/nudo.png" />
        					<img class="img_sol img_zona_ahorcado_dib @if($jug['trys'] >= 2) d-none @endif" data-position="1" src="/img/ahorcado/sol.png" />
        					<img class="img_ahorcado img_zona_ahorcado_dib @if($jug['trys'] >= 1) d-none @endif" data-position="0" src="/img/ahorcado/ahorcado.png" />
        				</div>        				
        			</div>
        			<div class="col-12 col-md-4">
        				<p class="intentos_text">Intents restants:</p>
        				<div class="intentos">{{ $jug['trys'] }}</div>
						<hr>
						<p class="word"></p>
        			</div>      		
    			</div>
        	</div>
		</div>
		<div class="col-12 text-center">
			<div class="zona_ahorcado mt-5 mb-5">
				@foreach($jug["word_keygen"] as $in=>$it)
					<div class="letter letter_{{ $it['type'] }} letter_{{ $in }}">
						@if($it['type'] != 'inactive_char')
							{{ $it['char'] }}
						@endif						
					</div>
				@endforeach
			</div>
		</div>
		<div class="col-12 text-center">
			<div class="zona_abc p-3 mt-3">
				@foreach($jug['abc'] as $ind_let => $let)
					<div class="abc_let abc_let_{{ $let }} abc_let_{{ $ind_let }} @if($let != 0) abc_let_desactivated @endif @if($jug['trys'] == 0) abc_let_desactivated @endif" data-id-jugador="{{ $jug['id'] }}">{{ $ind_let }}</div>
				@endforeach
			</div>
		</div>
		<div class="col-12 text-end mb-2">
			<button class="btn btn_continue_gaming {{ $jug['btn'] }} @if($jug['trys'] > 0 && $jug['status'] == 0) d-none @endif" data-next-jug="{{ $next_jug }}">Continuar</button>
		</div>
	</div>	
</div>