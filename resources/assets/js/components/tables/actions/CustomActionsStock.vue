<template>
  <div>
    <div class="custom-actions">
      <!--<button class="ui basic button" @click="itemAction('edit-item', rowData, rowIndex)"><i class="zoom icon"></i></button>-->
      <b-button variant="info" @click="itemAction('edit-item', rowData, rowIndex)">
        <i class="fas fa-edit"></i>
      </b-button>
      <!--<button class="ui basic button" @click="deleteAction('edit-item', rowData, rowIndex)"><i class="edit icon"></i></button>-->
      <b-button variant="danger" @click="itemAction('delete-item', rowData, rowIndex)">
        <i class="far fa-trash-alt"></i>
      </b-button>
      <b-button variant="success" v-if="rowData.fecha_salida == null"  @click="itemAction('out-item', rowData, rowIndex)">
        <i class="far fa-check-circle"></i>
      </b-button>
    </div>
    <div>
    <b-modal id="modal1" ref="modal" title="Eliminar registro">
      <template v-if="action =='delete-item'">
        
        <b-list-group>
          <b-list-group-item class="d-flex justify-content-between align-items-center">Código de barras:
            <b-badge variant="primary" pill>{{data.codbarras}}</b-badge>
          </b-list-group-item>
          <b-list-group-item class="d-flex justify-content-between align-items-center">Marca:
            <b-badge variant="primary" pill>{{data.marca}}</b-badge>
          </b-list-group-item>
          <b-list-group-item class="d-flex justify-content-between align-items-center">Modelo:
            <b-badge variant="primary" pill>{{data.modelo}}</b-badge>
          </b-list-group-item>
          <b-list-group-item class="d-flex justify-content-between align-items-center">Serial:
            <b-badge variant="primary" pill>{{data.serial}}</b-badge>
          </b-list-group-item>
          <b-list-group-item class="d-flex justify-content-between align-items-center">Fecha de entrada:
            <b-badge variant="primary" pill>{{data.fecha_entrada}}</b-badge>
          </b-list-group-item>
          <b-list-group-item class="d-flex justify-content-between align-items-center">Precio de entrada:
            <b-badge variant="primary" pill>{{data.precio_entrada}}</b-badge>
          </b-list-group-item>
        </b-list-group>
        <form @submit.prevent="deleteItem" accept-charset="UTF-8" class="form-horizontal">
          <input type="hidden" name="id" :value="data.id">
          <input type="hidden" name="_token" :value="csrf">
          <div class="d-flex justify-content-end" style="margin-top: 10px">
            <button class="btn btn-secondary" type="button" @click="hideModal" style="margin-right: 5px">Cancelar</button>
            <button class="btn btn-success" type="submit">Aceptar</button>
          </div>
        </form>
      <!--EDIT-->
      </template>
      <template v-else-if="action == 'edit-item'">
        <form @submit.prevent="editItem" accept-charset="UTF-8" class="form-horizontal">
          <label for="select-codbarras">Código de barras:</label>
          <v-select 
            :options="options" 
            v-model="codbarras" 
            placeholder="Código de barras">  
          </v-select>
          <b-list-group-item class="d-flex justify-content-between align-items-center">Marca:
            <b-badge variant="primary" pill>{{data.marca}}</b-badge>
          </b-list-group-item>
          <b-list-group-item class="d-flex justify-content-between align-items-center">Modelo:
            <b-badge variant="primary" pill>{{data.modelo}}</b-badge>
          </b-list-group-item>
          <input type="hidden" name="id" :value="data.id">
          <!--<input type="hidden" name="_token" :value="csrf">-->
          <div class="d-flex justify-content-end" style="margin-top: 10px">
            <button class="btn btn-secondary" type="button" @click="hideModal" style="margin-right: 5px">Cancelar</button>
            <button class="btn btn-success" type="submit">Aceptar</button>
          </div>
        </form>
      </template>
      <!--FIN EDIT-->
      <template v-else-if="action == 'out-item'">
        <form @submit.prevent="outItem" accept-charset="UTF-8" class="form-horizontal">
          <b-list-group>
            <b-list-group-item class="d-flex justify-content-between align-items-center">Código de barras:
              <b-badge variant="primary" pill>{{data.codbarras}}</b-badge>
            </b-list-group-item>
            <b-list-group-item class="d-flex justify-content-between align-items-center">Marca:
              <b-badge variant="primary" pill>{{data.marca}}</b-badge>
            </b-list-group-item>
            <b-list-group-item class="d-flex justify-content-between align-items-center">Modelo:
              <b-badge variant="primary" pill>{{data.modelo}}</b-badge>
            </b-list-group-item>
            <b-list-group-item class="d-flex justify-content-between align-items-center">Serial:
              <b-badge variant="primary" pill>{{data.serial}}</b-badge>
            </b-list-group-item>
            <b-list-group-item class="d-flex justify-content-between align-items-center">Fecha de entrada:
              <b-badge variant="primary" pill>{{data.fecha_entrada}}</b-badge>
            </b-list-group-item>
            <b-list-group-item class="d-flex justify-content-between align-items-center">Precio de entrada:
              <b-badge variant="primary" pill>{{data.precio_entrada}}</b-badge>
            </b-list-group-item>
          </b-list-group>
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="fechaSalida">Fecha de salida:</label>
                <vuejs-datepicker input-class="form-control" format="yyyy-MM-dd" name="fecha_out" placeholder="Fecha" v-model="fechaSalida" :language="es" full-month-name></vuejs-datepicker>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="precioSalida">Precio de salida:</label>
                <input type="number" v-model="precioSalida" class="form-control" name="precioSalida">
              </div>
            </div>
          </div>
          <!--<input type="hidden" name="_token" :value="csrf">-->
          <div class="d-flex justify-content-end" style="margin-top: 10px">
            <button class="btn btn-secondary" type="button" @click="hideModal" style="margin-right: 5px">Cancelar</button>
            <button class="btn btn-success" type="submit">Aceptar</button>
          </div>
        </form>
      </template>
      <div slot="modal-footer"></div>
      </b-modal>
  </div>
</div>
  </template>

  <script>
  import {en, es} from 'vuejs-datepicker/dist/locale';
  export default {
    props: {
      rowData: {
        type: Object,
        required: true
      },
      rowIndex: {
        type: Number
      }
    },
    data: function()
    {
      var state = {
                date: new Date()
            };
      var data = {
        options:[],
        codbarras: null,
        en: en,
        es: es,
        fechaSalida: state.date,
        precioSalida: 0,
        data: null,
        action: "",
        url2: '/ajax/codbarras',
        csrf: $('meta[name=csrf-token]').attr('content')
      }
      return data;
    },
    computed: {
      ajaxDelete: function()
      {
        if (this.data != null)
        {
          return this.data;
        }
        return "fail";
      },
      ajaxEdit: function()
      {
        if(this.data.id && this.data.modelo && this.data.marca && this.data.codbarras)
        {
          return this.data
        }
        return 'fail'
      },
      ajaxOut: function()
      {

        if(this.data.id && this.fechaSalida)
        {
          if(this.precioSalida != null && this.precioSalida > 0)
          {
            return {
                      id: this.data.id,
                      fechaSalida: this.fechaSalida,
                      precioSalida: this.precioSalida
                    }
          }
          else
          {
            return {
                      id: this.data.id,
                      fechaSalida: this.fechaSalida
                    } 
          }
        }
        return 'fail'  
      }
    },
    methods: {
      codbarrasselect()
      {
        axios.get(this.url2)
            .then(response => {
                this.options = response.data;
        });
      },
      itemAction (action, data, index) {
        this.action = action;
        this.data = data;
        this.$refs.modal.show();
      },
      hideModal()
      {
        this.$refs.modal.hide();
      },
      deleteItem()
      {
        //e.preventDefault();
        axios.post('/admin/stock/eliminar',
          this.ajaxEdit).then(response => {
            this.$toastr('add', response.data)
            this.hideModal();
            this.$parent.refresh();
          });
      },
      editItem()
      {
        axios.post('/admin/stock/editar',
          this.ajaxEdit).then(response => {
            this.hideModal();
            this.$parent.refresh();
          });
      },
      outItem()
      {
        axios.post('/admin/stock/salida',
          this.ajaxOut).then(response => {
            this.$toastr('add', response.data)
            this.hideModal();
            this.$parent.refresh();
          });
      }


    },
    beforeMount()
    {
      this.codbarrasselect();
    }
  }
  </script>