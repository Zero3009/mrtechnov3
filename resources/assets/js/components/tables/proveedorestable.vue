<template>
	<div class="ui container">    
        <vuetable ref="vuetable"
        	api-url="/datatables/getproveedores"
            :fields="columns"
            pagination-path="" 
            @vuetable:pagination-data="onPaginationData"
            :sort-order="sortOrder"
        ></vuetable>
        <vuetable-pagination @vuetable-pagination:change-page="onChangePage" ref="pagination"></vuetable-pagination>
	</div>
</template>
<script>
    export default
    {
        data: function()
        {
            var datas =
            {
                columns: [ 
                            {name: 'id', title:'ID', sortField:'id'},
                            {name: 'nombre', title:'Nombre', sortField: 'nombre'},
                            {name: 'tel', title: 'Telefono', sortField:'tel'}
                        ],
                sortOrder: [
                  {
                    field: 'id',
                    direction: 'asc'
                  }
                ],
            }
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
        },
        beforeMount()
        {

        }
    }
</script>