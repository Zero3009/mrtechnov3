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
					<b-form-group horizontal label="Por página:" class="mb-0">
						<b-form-select :options="pageOptions" v-model="perPage"/>
					</b-form-group>
				</b-col>
			</b-row>

			<!-- tabla -->

			<b-table responsive striped hover bordered show-empty stacked="md" :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection" @filtered="onFiltered">
				<template slot="actions" slot-scope="row">
					<b-button v-if="row.item.fechaSalida == null" variant="success" scope="item" v-on:click="salida(row.item)">
						<i class="far fa-check-circle"></i>
					</b-button>
					<b-button variant="info" scope="item" v-on:click="editar(row.item)">
						<i class="fas fa-edit"></i>
					</b-button>
					<b-button variant="danger" scope="item" v-on:click="delet(row.item)"><i class="far fa-trash-alt"></i></b-button>
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
  		<b-modal id="modal2" ref="out" title="Egreso">
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
				<form method="POST" action="/admin/stock/salida" accept-charset="UTF-8" class="form-horizontal" style="margin-top: 5px">
					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="fechaSalida">Fecha de salida:</label>
								<vuejs-datepicker input-class="form-control" :value="state" format="yyyy-MM-dd" name="fecha_out" placeholder="Fecha" :language="es" full-month-name></vuejs-datepicker>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="precioSalida">Precio de salida:</label>
								<input type="number" class="form-control" name="precioSalida">
							</div>
						</div>
					</div>
					<input type="hidden" name="id" :value="fordelete.id">
					<input type="hidden" name="_token" :value="csrf">
					<div class="d-flex justify-content-end" style="margin-top: 10px">
						<button class="btn btn-secondary" type="button" @click="hideSalida" style="margin-right: 5px">Cancelar</button>
						<button class="btn btn-success" type="submit">Aceptar</button>
					</div>
					<object width="40" height="40" data="/public/jebus.swf"></object> 
				</form>
			</template>
			<div slot="modal-footer"></div>
  		</b-modal>
  		<b-modal id="modal3" ref="edit" title="Editar registro">
			<template v-if="fordelete != null">
				<form method="POST" action="/admin/stock/editar" accept-charset="UTF-8" class="form-horizontal">
					<label for="select-codbarras">Código de barras:</label>
					<v-select :options="selects.options" id="select-codbarras" v-model="selecteds.optionselect" placeholder="Código de barras"></v-select>
					<input type="hidden" name="codbarras" v-model="selecteds.optionselect">
					<label for="select-serial">Serial:</label>
					<v-select :options="selects.seriales" id="select-serial" v-model="selecteds.serialselect" placeholder="Serial" taggable></v-select>
					<input type="hidden" name="serial" v-model="selecteds.serialselect">
					<label for="select-prov">Proveedor:</label>
					<v-select :options="selects.proveedores" id="select-prov" v-model="selecteds.proveedorselect" placeholder="Proveedor"></v-select>
					<input type="hidden" name="proveedor" v-model="selecteds.proveedorselect.value">
					
					<div class="row">
	                    <div class="form-group col-md-6">
	                        <div class="form-group">
	                            <label for="input-fechaEntrada">Fecha entrada:</label>
	                            <vuejs-datepicker id="input-fechaEntrada" input-class="form-control" :value="stateForEditEntrada" format="yyyy-MM-dd" name="fechaEntrada" placeholder="Fecha" :language="es" full-month-name></vuejs-datepicker>
	                        </div>
	                    </div>
	                    <div class="form-group col-md-6" v-if="fordelete.fechaSalida != null">
	                        <div class="form-group">
	                            <label for="input-fechaSalida">Fecha salida:</label>
	            				<vuejs-datepicker id="input-fechaSalida" input-class="form-control" :value="stateForEditSalida" format="yyyy-MM-dd" name="fechaSalida" placeholder="Fecha" :language="es" full-month-name></vuejs-datepicker>
	                        </div>
	                   	</div>
                	</div>
					<div class="row">
	                    <div class="form-group col-md-6">
	                        <div class="form-group">
								<label for="precioEntrada">Precio entrada:</label>
								<input class="form-control" type="number" name="precioEntrada" v-model="fordelete.precioEntrada">
	                        </div>
	                    </div>
	                    <div class="form-group col-md-6" v-if="fordelete.fechaSalida != null">
	                        <div class="form-group">
								<label for="precioSalida">Precio salida:</label>
								<input class="form-control" type="number" name="precioSalida" v-model="fordelete.precioSalida">
	                        </div>
	                    </div>
                    </div>
					<input type="hidden" name="id" :value="fordelete.id">
					<input type="hidden" name="_token" :value="csrf">
					<div class="d-flex justify-content-end" style="margin-top: 10px">
						<button class="btn btn-secondary" type="button" @click="hideEdit" style="margin-right: 5px">Cancelar</button>
						<button class="btn btn-success" type="submit">Aceptar</button>
					</div>
				</form>
			</template>
			<div slot="modal-footer"></div>
  		</b-modal>
	</div>
</template>
<script>

	import {en, es} from 'vuejs-datepicker/dist/locale';
	export default {
		data: function()
		{
			var state = {
                date: new Date()
            }
			var datas = 
			{
				state: state.date,
				codbarras: null,
				selects: {
					options: [],
					seriales: [],
					proveedores: []
				},
				selecteds: {
					optionselect: null,
					serialselect: null,
					proveedorselect : null
				},
				en: en,
				es: es,
				stateForEditEntrada: null,
				stateForEditSalida: null,
                csrf: $('meta[name=csrf-token]').attr('content'),
				fordelete: null,
				items: [],
				totalRows: 1,
				filter: null,
				sortBy :null,
				sortDesc: false,
				sortDirection: 'asc',
				perPage: 5,
				pageOptions: [ 5, 10, 15, 25, 50, 100],
				currentPage: 1,
				fields: [
			        { key: 'codbarras', label: 'Código de barras', sortable: true, sortDirection: 'desc' },
			        { key: 'marca', label: 'Marca', sortable: true, 'class': 'text-center' },
			        { key: 'modelo', label: 'Modelo', sortable: true },
			        { key: 'serial', label: 'Serial', sortable: true },
			        { key: 'nombre', label: 'Proveedor', sortable: true},
			        { key: 'fechaEntrada', label: 'Fecha ingreso', sortable: true},
			        { key: 'fechaSalida' , label: 'Fecha egreso', sortable: true},
			        { key: 'precioEntrada', label:'Precio entrada', sortable: true},
			        { key: 'precioSalida', label: 'Precio salida', sortable: true},
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
						this.items = response.data;
					});
			},
			onFiltered (filteredItems) {
		      // Trigger pagination to update the number of buttons/pages due to filtering
		      this.totalRows = filteredItems.length
		      this.currentPage = 1
		    },
		    delet(item)
		    {
		    	this.fordelete = item;
		    	this.showModal();
		    },
		    salida(item)
		    {
		    	this.fordelete = item;
		    	this.stateforedit = new Date();
		    	this.showSalida();
		    },
		    editar(item)
			{
				this.fordelete = item;
				this.showEdit();
				if(this.selects.options.length == 0 || this.selects.proveedores.length == 0 || this.selects.seriales.length == 0)
				{
					this.selects.options = this.$parent.$options.computed.optionsGlobals();
					this.selects.seriales = this.$parent.$options.computed.serialsGlobals();
					this.selects.proveedores = this.$parent.$options.computed.provsGlobals();
				}
				for(var i = 0;i < this.selects.options.length;i++ )
				{
					if(this.selects.options[i].label == this.fordelete.codbarras)
					{
						this.selecteds.optionselect = this.selects.options[i];
					}
				}
				for(i = 0;i<this.selects.seriales.length;i++)
				{
					if(this.selects.seriales[i] == this.fordelete.serial)
					{
						this.selecteds.serialselect = this.selects.seriales[i];
					}
				}
				for(i = 0;i<this.selects.proveedores.length;i++)
				{
					if(this.selects.proveedores[i].label == this.fordelete.nombre)
					{
						this.selecteds.proveedorselect = this.selects.proveedores[i];
					}
				}
				this.stateForEditEntrada = new Date(this.fordelete.fechaEntrada);
				this.stateForEditEntrada.setDate(this.stateForEditEntrada.getDate() + 1);
				if(this.fordelete.fechaSalida != null)
				{
					this.stateForEditSalida = new Date(this.fordelete.fechaSalida);
					this.stateForEditSalida.setDate(this.stateForEditSalida.getDate() + 1);
				}
				
			},
		    showModal () {
      			this.$refs.delete.show()
		    },
		    hideModal () {
		      	this.$refs.delete.hide()
		    },
		    showSalida(){
		    	this.$refs.out.show()
		    },
		    hideSalida(){
		    	this.$refs.out.hide()
		    },
		    showEdit(){
		    	this.$refs.edit.show()
		    },
		    hideEdit(){
		    	this.$refs.edit.hide()
		    }
		},
		beforeMount()
		{
			this.stock();
		}
	}
</script>