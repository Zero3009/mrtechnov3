<template>
	<div>
		{{moreParams}}
		<div class="form-inline">
		    <input type="text" class="form-control mb-2 mr-sm-2" v-model="searchText" placeholder="Search..." @keyup="search">        
	  	</div>
		<vuetable ref="vuetable"
		    api-url="/datatables/getproductos"
		    :css="css.table"
		    :fields="columns"
		    pagination-path=""
		    :per_page="1"
		    :append-params="moreParams"
		    @vuetable:pagination-data="onPaginationData"
	  	>
	  	</vuetable>
	  	<vuetable-pagination ref="pagination"
	  		@vuetable-pagination:change-page="onChangePage"
	  		:css="css.pagination">
	  	</vuetable-pagination>
	</div>
</template>
<script>
	import CssConfig from './CssConfig.js'
	

  	
	export default {
		data: function()
		{

			var datas =
			{
				searchText: "",
				css: CssConfig,
				moreParams: {},
				columns: 
						[
							{
								name: 'tipo',
								sortField: 'tipo',
								title: 'Tipó de producto'
							},
							{
								name: 'marca',
								sortField: 'marca',
								title: 'Marca'
							},
							{
								name: 'modelo',
								sortField: 'modelo',
								title: 'Modelo'
							},
							{
								name: 'codbarras',
								sortField: 'codbarras',
								title: 'Código de barras'
							},
							{
					          name: '__component:custom-actions-productos',   // <----
					          title: 'Actions',
					          titleClass: 'center aligned',
					          dataClass: 'center aligned'
					        }
							
						]
			}
			return datas;
		},
		methods:
		{
			search () {
			  this.moreParams={
			    searchable: [
			      //	'prods.id', 
			      'prods.tipo',
			      'prods.marca', 
			      'prods.modelo',
			      'prods.codbarras'        
			    ],
			    'filter': this.searchText
			  }
			  Vue.nextTick( () => this.$refs.vuetable.refresh())
			},
			onPaginationData (paginationData) {
      			this.$refs.pagination.setPaginationData(paginationData)
		    },
		    onChangePage (page) {
		      	this.$refs.vuetable.changePage(page)
		    },
		    onFilterSet (filterText) {
		        this.moreParams = {
		            'filter': filterText
		        }
		        Vue.nextTick( () => this.$refs.vuetable.refresh())
		    },
		    onFilterReset () {
		        this.moreParams = {}
		        Vue.nextTick( () => this.$refs.vuetable.refresh())
		    }
		},
	    mounted() {
		   this.$events.$on('filter-set', eventData => this.onFilterSet(eventData))
		   this.$events.$on('filter-reset', e => this.onFilterReset())
		},
	

	}
</script>