<template>
	<div class="custom-actions">
      <button class="ui basic button" @click="itemAction('view-item', rowData, rowIndex)"><i class="zoom icon"></i></button>
      <button class="ui basic button" @click="itemAction('edit-item', rowData, rowIndex)"><i class="edit icon"></i></button>
      <button class="ui basic button" @click="itemAction('delete-item', rowData, rowIndex)"><i class="delete icon"></i></button>
      <b-modal id="modal1" ref="modal1" title="Bootstrap-Vue">
        <form method="POST" action="/admin/stock/eliminar" accept-charset="UTF-8" class="form-horizontal">
                <div class="modal-header" style="background: #222d32   ; color: #FFFFFF;  opacity: 0.9;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="titulo"> Deshabilitar area</h4>
                </div>
                <div class="modal-body">
                    <p class="help-block">¿Esta seguro que desea eliminar este registro de stock?</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" class="id" v-model="fordelete">
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="submit" class="btn btn-success" value="Eliminar">
                </div>
            </form>
    	<p class="my-4">Hello from modal!</p>
  		</b-modal>
      <b-modal id="modal2" ref="modal2" title="Bootstrap-Vue"
    </div>
    
</template>
<script>
  export default {
    data: function()
    {
      var datas= {
        csrf: $('meta[name=csrf-token]').attr('content'),
        fordelete: null,  
      }
      return datas;
    },
    props: {
      rowData: {
        type: Object,
        required: true
      },
      rowIndex: {
        type: Number
      }
    },
    methods: {
      itemAction (action, data, index) {
        console.log('custom-actions: ' + action, data.id, index);
        this.$refs.modal1.show();
        this.fordelete = data.id;
      }
    }
  }
</script>
<style>
    .custom-actions button.ui.button {
      padding: 8px 8px;
    }
    .custom-actions button.ui.button > i.icon {
      margin: auto !important;
    }
</style>