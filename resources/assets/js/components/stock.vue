<template>
    
    <div>
        <table class="table table-striped table-bordered" name="tabla" id="tabla">
            
            <tr>
                <th scope="col" style="width:18%">Codigo de barras</th>
                <th scope="col" style="width:15%">Modelo</th>
                <th scope="col" style="width:20%">Serial</th>
                <th scope="col" style="width:10%">Proveedor</th>
                <th scope="col" style="width:12%">Precio Entrada</th>
                <th scope="col" style="width:15%">Fecha Entrada</th>
                <th scope="col" style="width:10%">Accion</th>
            </tr>
            <tr v-bind:id="'row_' + n.id" v-for="n in rowsdynamic">
                
                <td style="width:18%">
                    <v-select :options="options" v-model="n.codbarras" placeholder="Código de barras"></v-select>
                    <template v-if="n.codbarras != null">
                        <input type="hidden" name="codbarras[]" v-model="n.codbarras.value">
                    </template>
                </td>
                <td style="width:15%">
                    <template v-if="n.codbarras != null">
                        <label class="form-control">{{n.codbarras.modelo}}</label>
                    </template>
                </td>
                <td style="width:20%">
                    <v-select   v-model="n.seriales" 
                                :options="seriales" 
                                taggable 
                                multiple 
                                placeholder="Seriales">
                    </v-select>
                    <template v-if="n.seriales != null">
                        <input type="hidden" name="seriales[]" v-model="n.seriales">
                    </template>
                </td>
                <td style="width:10%">

                    <v-select :options="proveedores" v-model="n.proveedor" placeholder="Proveedor"></v-select>
                    <template v-if="n.proveedor != null">
                        <input type="hidden" name="proveedor[]" v-model="n.proveedor.value">
                    </template>
                </td>
                <td style="width:12%">
                    <input type="number" class="form-control" name="precioEntrada[]" id="precioEntrada_1">
                </td>
                <td style="width:15%">
                    <vuejs-datepicker input-class="form-control" :value="state" format="yyyy-MM-dd" name="fecha[]" placeholder="Fecha" :language="es" full-month-name></vuejs-datepicker>
                </td>
                <td style="width:10%">
                    <input data-bot="add" class="btn btn-success" v-on:click="aument()" tabindex="1" type="button" name="add"  id="add_1" value="+">
                    <button  type="button" name="remove" v-on:click="decrease($event)" v-bind:id="n.id" v-show="n.id > 1" class="btn btn-danger">X</button>
                </td>
            </tr>
            
        </table>
    </div>
</template>
<script>
    export default {
        //el: "#app",
        data: function()
        {   

            var state = {
                date: new Date()
            }
            var datas=
            {
                state: state.date,
                selected: null,
                tag: null,
                selected2: null,
                options: [],
                proveedores: [],
                seriales: [],
                rowsdynamic: [
                    {
                        id: 1,
                        codbarras: null,
                        proveedor: null,
                        seriales: null
                    }
                ],
                es: {Language: 'Spanish',
                       months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                       monthsAbbr: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                       days: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sab'],
                       rtl: false,
                       ymd: false,
                       yearSuffix: ''
                },
                url: '/ajax/productos',
                url2: '/ajax/codbarras',
                url3: '/ajax/proveedores',
                url4: '/ajax/seriales',
            }
            return datas;
        },
        methods: {
            cargarSelects()
            {
                this.codbarras();
                this.provees();
                this.serials();
            },
            codbarras()
            {
                axios.get(this.url2)
                    .then(response => {
                        this.options = response.data;
                        this.$parent.$options.methods.setGlobalOptions(response.data);
                });
            },
            serials()
            {
                axios.get(this.url4)
                    .then(response => {
                        var a = [];
                        response.data.forEach(function(item){
                            a.push(item.label);
                        });   
                        this.seriales = a;
                        this.$parent.$options.methods.setGlobalSerials(a);
                })
            },
            provees()
            {
                axios.get(this.url3)
                    .then(response => {
                        
                        this.proveedores = response.data;

                });
            },
            aument() 
            {
                return this.rowsdynamic.push({id: this.rowsdynamic[this.rowsdynamic.length - 1].id + 1, codbarras: null, proveedor: null, seriales: null});
            },
            decrease(event) 
            {
                var index = this.rowsdynamic.findIndex(x => x.id==event.currentTarget.id);
                return Vue.delete(this.rowsdynamic, index);
            }
        },
        beforeMount()
        {
            this.cargarSelects();
        }
    }
</script>