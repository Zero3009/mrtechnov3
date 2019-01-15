<template>
    
    <div>
        <div class="border border-primary">
                    <form @submit.prevent="newItem" accept-charset="UTF-8" class="form-horizontal">
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
                    <!--<template v-if="n.codbarras != null">
                        <input type="hidden" name="codbarras[]" v-model="n.codbarras.value">
                    </template>-->
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
                    <!--<template v-if="n.seriales != null">
                        <input type="hidden" name="seriales[]" v-model="n.seriales">
                    </template>-->
                </td>
                <td style="width:10%">

                    <v-select :options="proveedores" v-model="n.proveedor" placeholder="Proveedor"></v-select>
                    <!--<template v-if="n.proveedor != null">
                        <input type="hidden" name="proveedor[]" v-model="n.proveedor.value">
                    </template>-->
                </td>
                <td style="width:12%">
                    <input type="number" class="form-control" v-model="n.precioEntrada" name="precioEntrada[]" id="precioEntrada_1">
                </td>
                <td style="width:15%">
                    <vuejs-datepicker input-class="form-control" v-model="n.state" format="yyyy-MM-dd" name="fecha[]" placeholder="Fecha" :language="es" full-month-name></vuejs-datepicker>
                </td>
                <td style="width:10%">
                    <input data-bot="add" class="btn btn-success" v-on:click="aument()" tabindex="1" type="button" name="add"  id="add_1" value="+">
                    <button  type="button" name="remove" v-on:click="decrease($event)" v-bind:id="n.id" v-show="n.id > 1" class="btn btn-danger">X</button>
                </td>
            </tr>
            
        </table>
            <input class="btn btn btn-success" tabindex="1" type="submit" value="Cargar" style="margin-bottom: 10px; margin-left: 10px">
        </form>
        </div>
    </div>
</template>
<script>
    import {en, es} from 'vuejs-datepicker/dist/locale';
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
                en: en,
                es: es,
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
                        seriales: null,
                        state: state.date,
                        precioEntrada: 0
                    }
                ],
                url: '/ajax/productos',
                url2: '/ajax/codbarras',
                url3: '/ajax/proveedores',
                url4: '/ajax/seriales',
            }
            return datas;
        },
        computed: {
            data: function(){
                return this.rowsdynamic
            }
        },
        methods: {
            newItem: function()
            {
                axios.post('/admin/stock/nuevo',
                    this.data).then(response => {
                        for(var i = 0; i < this.rowsdynamic.length; i++){
                           Vue.delete(this.rowsdynamic, i)
                        }
                        this.rowsdynamic.push({id: 1, codbarras: null, proveedor: null, seriales: null, state: this.state, precioEntrada: 0});

                    });
            },
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
                        this.$parent.$options.methods.setGlobalProvs(response.data);

                });
            },
            aument() 
            {
                return this.rowsdynamic.push({id: this.rowsdynamic[this.rowsdynamic.length - 1].id + 1, codbarras: null, proveedor: null, seriales: null, state: this.state, precioEntrada: 0});
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