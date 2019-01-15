<template>
    <div>
        <div class="form-inline">
                <input type="text" class="form-control mb-2 mr-sm-2" v-model="searchText" placeholder="Search..." @keyup="search">        
        </div>    
        <vuetable ref="vuetable"
            api-url="/datatables/getproveedores"
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
    export default
    {
        data: function()
        {
            var datas =
            {
                data: null,
                searchText: "",
                css: CssConfig,
                moreParams: {},
                columns: [ 
                            {name: 'nombre', title:'Nombre', sortField: 'nombre'},
                            {name: 'tel', title: 'Telefono', sortField:'tel'}
                        ],
            }
            return datas;
        },
        methods:
        {
            search () {
              this.moreParams={
                searchable: [
                  //    'prods.id', 
                  'provs.nombre',
                  'provs.tel'       
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
        beforeMount()
        {

        }
    }
</script>