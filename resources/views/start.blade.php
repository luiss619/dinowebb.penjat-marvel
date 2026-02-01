@extends('layouts.vertical')
@section('css')
@stop
@section('content')
<div class="container-fluid">	
	<div id="container_start_1" class="container container_start mt-2 mb-2 @if($data_game['started'] != 0) d-none @endif">
		<div class="card text-center p-3">
			<h3>Benvingut al joc del Penjat <br> ¡Edició Marvel!</h3>
			<div class="row justify-content-center">
				<div class="col-12 col-md-6">
					<div class="card card-reglas">
						<p>Regles del Joc</p>
						<small>Sense trampes !!!</small>
						<ul class="list mb-0">
							<li>Podeu jugar entre 1 y 6 jugadors</li>
							<li>Cada jugador complirà el seu torn fins descobrir el personatge.</li>
							<li>Pots equivocar-te fins a 5 cops a l'hora de descobrir el personatge ocult.</li>
							<li>Totes les opcions son personatges de Marvel</li>
							<li>Després del torn de l'ùltim jugador podreu veure els guanayadors !!!</li>
						</ul>
					</div>				
				</div>
				<div class="col-12 col-md-6">
					<p>Selecciona nombre de jugadors:</p>
					<div class="row mt-3 text-center">
						@foreach(range(1, 6) as $i)
							<div class="col-2">
								<span class="num_jugadors" data-num="{{ $i }}">{{ $i }}</span>
							</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="row row_list_jugadors row_list_jugadors_list d-none justify-content-center d-flex mt-3"></div>	
			<div class="row row_list_jugadors d-none justify-content-center d-flex">
				<div class="col-12">
					<small class="msg_error d-none">
						Tots el jugadors han de tenir nom i avatar. Els jugadors marcats en vermell no compleixen aquestes característiques.
					</small><br>
					<button class="btn btn_start_game">Comença a jugar</button>				
				</div>
			</div>	
		</div>
	</div>
	<div id="container_start_2" class="container container_start mt-2 mb-2 @if($data_game['started'] != 1) d-none @endif">
		{!! $html_game_paso2 !!}
	</div>
	<div id="container_start_3" class="container container_start mt-2 mb-2 @if($data_game['started'] != 2) d-none @endif">
		{!! $html_game_paso3 !!}
	</div>
</div>
<div id="modal_perfil_foto" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered modal-lg">
    	<div class="modal-content text-center">
      		<div class="modal-body p-3">      		
        		<h3 class="d-block mb-4">¡Tria el teu avatar preferit!</h3>
        		<input type="hidden" id="current_player_foto" value="" />
        		<div class="row mt-3 mb-3">
        			@foreach($array_avatares as $av)
        				<div class="col-12 col-md-2">
        					<img src="{{ $av }}" class="img_do_perfil" />
        				</div>
        			@endforeach
        		</div>
      		</div>
    	</div>
  	</div>
</div>
@stop
@section('scripts')
@endsection