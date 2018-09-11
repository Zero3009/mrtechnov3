<template>
	<div class="ui container">    
        <vuetable ref="vuetable"
        	api-url="/datatables/getproductos"
            :fields="columns"
            pagination-path="" 
            @vuetable:pagination-data="onPaginationData"
            :sort-order="sortOrder"
        ></vuetable>
        <vuetable-pagination @vuetable-pagination:change-page="onChangePage" ref="pagination"></vuetable-pagination>
	</div>
</template>
<script>
	export default {
		data: function()
		{
			var datas = 
			{
				columns: [ 
							{name: 'id', title:'ID', sortField:'id'},
							{name: 'tipo', title:'tipo', sortField: 'tipo'},
							{name: 'codbarras', title: 'Código de barras', sortField:'codbarras'},
							{name: 'marca', title: 'Marca', sortField:'marca'},
							{name: 'modelo', title: 'Modelo', sortField: 'modelo'},
						],
				sortOrder: [
			      {
			        field: 'id',
			        direction: 'asc'
			      }
			    ],
			};
			return datas;
		},
		methods:
		{
			onPaginationData (paginationData) {
              this.$refs.pagination.setPaginationData(paginationData)
            },
            onChangePage (page) {
              this.$refs.vuetable.changePage(page)
            },
		}
	}
</script>