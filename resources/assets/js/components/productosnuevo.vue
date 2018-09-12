<template>
    <form method="POST" action="/admin/productos/nuevo/post" accept-charset="UTF-8" class="form-horizontal">
        <div class="card-header" style="background: #222d32   ; color: #FFFFFF;  opacity: 0.9;">
            <div class="row">
                <div class="col-md-4" style="float: left;">
                    <h3 class="panel-title" style="margin-top: 10px;">Nuevo producto</h3>
                </div>
            </div>
        </div>
    	<div class="card-body" style="background: #D7D7D7">
            <div class="controls">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo-select">Tipo:</label>
                        	<v-select :options="tipos" v-model="tipo" id="tipo-select" placeholder="Tipo de producto" taggable required></v-select>
                            <template v-if="tipo != null">
                                <input type="hidden" name="tipo" v-model="tipo.label" required>
                            </template>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marca-select">Marca:</label> 
            				<v-select :options="marcas" id="marca-select" v-model="marca" placeholder="Marca" taggable required></v-select>
                            <template v-if="marca != null">
                                <input type="hidden" name="marca" v-model="marca.label">
                            </template>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="modelo">Modelo:</label>
                            <input class="form-control" id="modelo" style="width: 100%" name="modelo" v-model="modelo" type="text" required>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="codbarras">Código de barras:</label>
            				<input class="form-control" id="codbarras" stype="text" v-model="codbarras" name="codbarras" required>
                        </div>
                   </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <template v-if='tipo != null && marca != null && modelo != "" && codbarras != ""'>
                <input class="btn btn btn-success" tabindex="1" type="submit" value="Crear producto">
            </template>
            <input type="hidden" name="_token" :value="csrf">
        </div>
    </form>
</template>
<script>
	export default
	{
		data: function()
		{
			var datas = 
			{
				tipo: null,
				tipos: [],
				marca: null,
				marcas: [],
                modelo: "",
                codbarras: "",
                csrf: $('meta[name=csrf-token]').attr('content')
			}
			return datas;
		},
		methods:
		{
			cargarSelects: function()
			{
				this.tiposdeproductos();
				this.getmarcas();
			},
			tiposdeproductos: function()
            {
                axios.get('/ajax/tiposprods')
                    .then(response => {
                        this.tipos = response.data;
                });
            },
            getmarcas: function()
            {
            	axios.get('/ajax/marcas')
            		.then(response => {
            			this.marcas = response.data;		
        		});
            }
		},
		beforeMount()
        {
            this.cargarSelects();
        }
	}
</script>