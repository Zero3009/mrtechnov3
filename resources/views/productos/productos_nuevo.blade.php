@extends('layouts.admin')

@section('main-content')
<form method="POST" action="/admin/productos/nuevo/post" accept-charset="UTF-8" class="form-horizontal">
	<div class="row">
	    <div class="col-md-12" >
	        <div class="panel panel-default">
	            <div class="panel-heading" style="background: #222d32   ; color: #FFFFFF;  opacity: 0.9;">
	                <div class="row">
	                    <div class="col-md-4" style="float: left;">
	                        <h3 class="panel-title" style="margin-top: 10px;">Nuevo producto</h3>
	                    </div>
	            	</div>
	            </div>
	            <productosnuevo></productosnuevo>
	            <div class="panel-footer">
	                <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
	                <input class="btn btn btn-success" tabindex="1" type="submit" value="Crear producto">
	            </div>  
	        </div>
	    </div>
    </div>
</form>
@stop
@section('js')
@push('scripts')
<script>
	/*$(document).ready(function(){
		$('#tipo').select2({
			placeholder: 'Tipo de producto',
			tags: true,
			ajax: {
					url: '/ajax/tiposprods',
					data: function(params){
						var query ={
							search: params.term,
						}
						return query;
					},
					dataType: 'json',
					processResults: function(data){
						data.forEach(function(e){
							e.id = e.text;
						});
						return {
							results: data
						}
					}
			}
		});
		$('#marca').select2({
			placeholder: 'Marca',
			tags: true,
			ajax: {
				url: '/ajax/marcas',
				data: function(params){
					var query ={
						search: params.term,
					}
					return query;
				},
				dataType: 'json',
				processResults: function(data){
					data.forEach(function(e){
						e.id = e.text;
					});
					return {
						results: data
					}
				}
			}
		});
	});*/
	/*$.getJSON("/ajax/productos", function (json) {
		console.log(json);
	    $.each(json, function(i, item) {
	       $('#tipo').append('<option value="'+item.nombre+'">'+item.nombre+'</option>');
	    });
	});*/
</script>
@endsection