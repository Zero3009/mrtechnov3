<template>
	<div>
		<div class="card-header" style="background: #222d32   ; color: #FFFFFF;  opacity: 0.9;">
            <div class="row">
                <div class="col-md-4" style="float: left;">
                    <h3 class="panel-title" style="margin-top: 10px;">Gestionar proveedores</h3>
                </div>

                <div class="col-md-8" style="float: right;">
                    <a class="btn btn-success" @click="ShowModal" style="float: right;">
                    <i class="fa fa-plus"></i> Nuevo</a>
                </div>
            </div>
        </div>
        <div class="card-body" style="background: #D7D7D7">
			<proveedorestable ref="vuetab"></proveedorestable>	
		</div>
    	<div class="panel-footer">
        </div>
        <b-modal id="modal1" ref="modal" title="Nuevo registro">
        	<form @submit.prevent="newItem" accept-charset="UTF-8" class="form-horizontal">
	        	<div class="controls">
	                <div class="form-row">
	                    <div class="col-md-6">
	                        <div class="form-group">
	                            <label for="nombre">Nombre:</label>
	                            <input class="form-control" type="text" name="nombre" v-model="data.nombre">
	                        </div>
	                    </div>
	                    <div class="col-md-6">
	                        <div class="form-group">
	                            <label for="tel">Tel:</label>
	                            <input class="form-control" type="number" name="tel" v-model="data.tel"> 
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="d-flex justify-content-end" style="margin-top: 10px">
		            <button class="btn btn-secondary" type="button" @click="hideModal" style="margin-right: 5px">Cancelar</button>
		            <button class="btn btn-success" type="submit">Aceptar</button>
		         </div>
            </form>
            <div slot="modal-footer"></div>
        </b-modal>
	</div>
</template>
<script>
	import proveedorestable from './tables/proveedorestable';
	export default
	{
		data: function()
		{
			var datas =
			{
				data: {
					nombre: "",
					tel: ""
				}
			}
			return datas;
		},
		components:
		{
			proveedorestable
		},
		computed:
        {
            ajaxNuevo: function()
            {
                if(this.data.nombre != "")
                {
                    return this.data;
                }
                return 'fail';
            }
        },
		methods:
		{
			ShowModal: function()
			{
				this.$refs.modal.show();
			},
			hideModal: function()
			{
				this.$refs.modal.hide();
			},
			newItem: function()
			{
				axios.post('/admin/proveedores/nuevo',
					this.ajaxNuevo).then(response => {
						this.$refs.vuetab.$refs.vuetable.refresh();
						this.$refs.modal.hide();
					});
			}
		}
	}
</script>