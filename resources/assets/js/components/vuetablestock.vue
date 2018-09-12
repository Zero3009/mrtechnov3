<template>
	<div class="border border-dark" style="border-width:1.5px !important;">
		<b-container fluid>
			<b-row>
				<b-col md="6" class="my-1">
					<b-form-group horizontal label="Filter" class="mb-0">
						<b-input-group>
							<b-form-input v-model="filter" placeholder="Type to Search"/>
							<b-input-group-append>
								<b-btn :disabled="!filter" @click="filter = ''">Clear</b-btn>
							</b-input-group-append>
						</b-input-group>
					</b-form-group>
				</b-col>
				<b-col md="6" class="my-1">
					<b-form-group>
						<b-input-group>
							<b-form-select v-model="sortBy" :options="sortOptions">
								<option slot="first" :value="null">-- none --</option>
							</b-form-select>
							<b-form-select :disabled="!sortBy" v-model="sortDesc" slot="apped">
								<option :value="false">Asc</option>
								<option :value ="true">Desc</option>
							</b-form-select>
						</b-input-group>
					</b-form-group>
				</b-col>
				<b-col md="6" class="my-1">
					<b-form-group horizontal label="Sort direction" class="mb-0">
						<b-input-group>
							<b-form-select v-model="sortDirection" slot="append">
								<option value="asc">Asc</option>
								<option value="desc">Desc</option>
								<option value="last">Last</option>
							</b-form-select>
						</b-input-group>
					</b-form-group>
				</b-col>
				<b-col md="6" class="my-1">
					<b-form-group horizontal label="Per page" class="mb-0">
						<b-form-select :options="pageOptions" v-model="perPage"/>
					</b-form-group>
				</b-col>
			</b-row>

			<!-- tabla -->

			<b-table responsive striped hover bordered show-empty stacked="md" :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection" @filtered="onFiltered">
				<template slot="actions" slot-scope="row">
					<b-button class="btn btn-success" scope="item"><i class="fas fa-check-circle"></i></b-button>
					<b-button class="btn btn-info" scope="item"><i class="fas fa-edit"></i></b-button>
					<b-button class="btn btn-danger" scope="item" v-on:click="delet(row.item)"><i class="far fa-trash-alt"></i></b-button>
				</template>
				<!--<span slot="html" slot-scope="data" v-html="data.value"></span>-->
			</b-table>
			<b-row>
		      <b-col md="6" class="my-1">
		        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
		      </b-col>
	    	</b-row>
		</b-container>
		<b-modal id="modal1" ref="delete" title="Eliminar registro">
			<template v-if="fordelete != null">
				<b-list-group>
					<b-list-group-item class="d-flex justify-content-between align-items-center">Serial:
						<b-badge variant="primary" pill>{{fordelete.serial}}</b-badge>
					</b-list-group-item>
					<b-list-group-item class="d-flex justify-content-between align-items-center">Marca:
						<b-badge variant="primary" pill>{{fordelete.marca}}</b-badge>
					</b-list-group-item>
					<b-list-group-item class="d-flex justify-content-between align-items-center">Modelo:
						<b-badge variant="primary" pill>{{fordelete.modelo}}</b-badge>
					</b-list-group-item>
				</b-list-group>
				<form method="POST" action="/admin/stock/eliminar" accept-charset="UTF-8" class="form-horizontal">
					<input type="hidden" name="id" :value="fordelete.id">
					<input type="hidden" name="_token" :value="csrf">
					<div class="d-flex justify-content-end" style="margin-top: 10px">
						<button class="btn btn-secondary" type="button" @click="hideModal" style="margin-right: 5px">Cancelar</button>
						<button class="btn btn-success" type="submit">Aceptar</button>
					</div>
				</form>
			</template>
			<div slot="modal-footer"></div>
  		</b-modal>
	</div>
</template>
<script>
	export default {
		data: function()
		{
			var datas = 
			{

                csrf: $('meta[name=csrf-token]').attr('content'),
				fordelete: null,
				items: [],
				totalRows: 1,
				filter: null,
				sortBy :null,
				sortDesc: false,
				sortDirection: 'asc',
				perPage: 5,
				pageOptions: [ 5, 10, 15 ],
				currentPage: 1,
				fields: [
			        { key: 'codbarras', label: 'Código de barras', sortable: true, sortDirection: 'desc' },
			        { key: 'marca', label: 'Marca', sortable: true, 'class': 'text-center' },
			        { key: 'modelo', label: 'Modelo', sortable: true },
			        { key: 'serial', label: 'Serial', sortable: true },
			        { key: 'fechaEntrada', label: 'Fecha ingreso'},
			        { key: 'fechaSalida' , label: 'Fecha egreso'},
			        { key: 'precioEntrada', label:'Precio entrada'},
			        { key: 'precioSalida', label: 'Precio salida'},
			        { key: 'actions', label: 'Acciones'}
			      ],
			}
			return datas;
			
		},
		computed:{
			sortOptions () {
			      // Create an options list from our fields
			      return this.fields
			        .filter(f => f.sortable)
			        .map(f => { return { text: f.label, value: f.key } })
		    }
		},
		methods:
		{
			stock()
			{
				axios.get('/datatables/getstock')
					.then(response => {
						
						
						this.rows = response.data.length;
						/*response.data.forEach(function(item){
							item.html = '<button type="button" class="btn btn-danger" v-on:click="delet('+item.id+')">X</button>'
						})*/
						this.items = response.data;
						//console.log(response.data);
					});
			},
			onFiltered (filteredItems) {
		      // Trigger pagination to update the number of buttons/pages due to filtering
		      this.totalRows = filteredItems.length
		      this.currentPage = 1
		    },
		    delet(item)
		    {
		    	console.log(item);
		    	this.fordelete = item;
		    	this.showModal();

		    	//alert(item);
		    	//console.log(event);
		    	//alert(event);
		    },
		    showModal () {
      			this.$refs.delete.show()
		    },
		    hideModal () {
		      	this.$refs.delete.hide()
		    }
		},
		beforeMount()
		{
			this.stock();
		}
	}
</script>