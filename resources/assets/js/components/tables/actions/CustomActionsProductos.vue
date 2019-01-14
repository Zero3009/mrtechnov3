<template>
  <div>
    <div class="custom-actions">
      <!--<button class="ui basic button" @click="itemAction('edit-item', rowData, rowIndex)"><i class="zoom icon"></i></button>-->
      <b-button variant="info" @click="itemAction('edit-item', rowData, rowIndex)">
        <i class="fas fa-edit"></i>
      </b-button>
      <!--<button class="ui basic button" @click="deleteAction('edit-item', rowData, rowIndex)"><i class="edit icon"></i></button>-->
      <b-button variant="danger" @click="itemAction('delete-item', rowData, rowIndex)"><i class="far fa-trash-alt"></i></b-button>
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
        </b-list-group>
        <form @submit.prevent="deleteItem" accept-charset="UTF-8" class="form-horizontal">
          <input type="hidden" name="id" :value="data.id">
          <input type="hidden" name="_token" :value="csrf">
          <div class="d-flex justify-content-end" style="margin-top: 10px">
            <button class="btn btn-secondary" type="button" @click="hideModal" style="margin-right: 5px">Cancelar</button>
            <button class="btn btn-success" type="submit" @click="deleteItem">Aceptar</button>
          </div>
        </form>
        
      </template>
      <template v-else-if="action == 'edit-item'">
        <form @submit.prevent="editItem" accept-charset="UTF-8" class="form-horizontal">
          <label for="select-codbarras">Código de barras:</label>
          <input class="form-control" type="numeric" name="codbarras" v-model="data.codbarras">
          <label for="select-serial">Marca:</label>
          <input class="form-control" type="text" name="marca" v-model="data.marca">
          <label for="select-prov">Tipo de producto:</label>
          <input class="form-control" type="text" name="tipo" v-model="data.tipo">
          <label for="modelo">Tipo de producto:</label>
          <input class="form-control" type="text" name="modelo" v-model="data.modelo">
          <input type="hidden" name="id" :value="data.id">
          <!--<input type="hidden" name="_token" :value="csrf">-->
          <div class="d-flex justify-content-end" style="margin-top: 10px">
            <button class="btn btn-secondary" type="button" @click="hideModal" style="margin-right: 5px">Cancelar</button>
            <button class="btn btn-success" type="submit" @click="editItem">Aceptar</button>
          </div>
        </form>
      </template>
      <div slot="modal-footer"></div>
      </b-modal>
  </div>
</div>
  </template>

  <script>
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
      var data = {
        
        data: null,
        action: "",
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
      }
    },
    methods: {
      itemAction (action, data, index) {
        console.log('custom-actions: ' + action, data.id, index)
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
        axios.post('/admin/productos/eliminar',
          this.ajaxEdit).then(response => {
            this.hideModal();
            this.$parent.refresh();
          });
      },
      editItem()
      {
        axios.post('/admin/productos/editar',
          this.ajaxEdit).then(response => {
            this.hideModal();
            this.$parent.refresh();
          });
      }

    }
  }
  </script>