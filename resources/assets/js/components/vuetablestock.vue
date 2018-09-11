<template>
	<div class="ui container">    
        <vuetable ref="vuetable"
        	api-url="/datatables/getstock"
            :fields="columns"
            pagination-path="" 
            @vuetable:pagination-data="onPaginationData"
            :sort-order="sortOrder"
        ></vuetable>
        <vuetable-pagination @vuetable-pagination:change-page="onChangePage" ref="pagination"></vuetable-pagination>
	</div>
</template>
<script>
	//@vuetable:pagination-data="onPaginationData"
	//@vuetable-pagination:change-page="onChangePage"
	import CustomActions from './tables/actions/CustomActions';
	import axios from 'axios';
	Vue.component('custom-actions', CustomActions);
	export default {
		data: function()
		{
			var datatables ={
				columns: [ 
							{name: 'id', title:'ID'},
							{name: 'codbarras', title: 'Código de barras', sortField:'codbarras'},
							{name: 'marca', title: 'Marca', sortField:'marca'},
							{name: 'modelo', title: 'Modelo', sortField: 'modelo'},
							{name: 'serial', title: 'Serial', sortField: 'serial'},
							{name: 'nombre', title: 'Proveedor', sortField: 'nombre'},
							{name: 'fechaEntrada', title: 'Fecha entrada', sortField: 'fechaEntrada'},
							{name: 'fechaSalida', title: 'Fecha salida', sortField: 'fechaSalida'},
							{name: 'precioEntrada', title: 'Precio entrada', sortField: 'precioEntrada'},
							{name: 'precioSalida', title: 'Precio salida', sortField:'precioSalida'},
							{name: '__component:custom-actions',   // <----
      						title: 'Actions',
					        titleClass: 'center aligned',
					        dataClass: 'center aligned'}
						],
				sortOrder: [
			      {
			        field: 'codbarras',
			        direction: 'asc'
			      }
			    ],
                rows:[],
                options: {
	                filterByColumn: true,
	                perPage:2,
	                texts: {
	                    filter: "Filtrar:",
	                    filterBy: 'Filtrar por ',
	                    count:' '
	                },
	                dateColumns:['birth'],
	                dateFormat: 'YYYY-MM-DD',
	                datepickerOptions: {
	                    showDropdowns: true,
	                    autoUpdateInput: true,
	                },
	                pagination: { chunk:10,dropdown:false },
	                filterable:['modelo','marca','codbarras'],
	                headings: {
	                    codbarras: 'Codigo de barras',
	                    marca: 'Marca',
	                    modelo: 'Modelo',
	                    id: 'ID',
	                    serial: 'Serial'
	                }
				}
			}
			return datatables;
		},
		methods:
		{
			/*datatable: function()
            {
                axios.get('/datatables/getstock')
                    .then(response => {
                    	this.rows = response.data;
                */    	//var a = [];
                    	/*response.data.forEach(function(item){
                    		a.push({
                    			id: item.id,
                    			codbarras: item.codbarras,
                    			marca: item.marca,
                    			modelo: item.modelo,
                    			serial: item.serial
                    		})
                    	});
                        this.rows = a;
                        console.log(this.rows);*/
               // });
            //},
            onPaginationData (paginationData) {
              this.$refs.pagination.setPaginationData(paginationData)
            },
            onChangePage (page) {
              this.$refs.vuetable.changePage(page)
            },
		}
		/*beforeMount()
		{
                this.datatable();
		}*/
	}
</script>