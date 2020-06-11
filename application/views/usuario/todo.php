<?php $attributes = array('id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ignacio') ?>
<?php $attributesap = array('id' => 'apaterno', 'class' => 'form-control', 'placeholder' => 'Rivera') ?>
<?php $attributescar = array('id' => 'cargo', 'class' => 'form-control') ?>
<?php $attributeslab = array('id' => 'laboratorio', 'class' => 'form-control') ?>
<?php $url = array('id' => 'form') ?>
<style type="text/css">
.has-error .select2-selection {
  border-color: rgb(185, 74, 72) !important;
}
</style>
<!-- Cabecera Titulo, menu -->
<section class="content-header">
  <h1>
    Usuario
    <small>Ver</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Usuario</a></li>
    <li class="active"><a href="<?php echo site_url('usuario/ver')?>">Ver</a></li>
  </ol>
</section>
<!-- End -->
<!-- Cuerpo -->
<section class="content">
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Ver Usuario</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label>Mostrar</label>
            <select id="show_record" class="form-control select2" style="width: 100%">
              <option value="5">5 registros</option>
              <option value="10">10 registros</option>
              <option value="25">25 registros</option>
              <option value="50">50 registros</option>
              <option value="100">100 registros</option>
              <option value="-1">Todos los registros</option>
            </select>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label>Buscar</label>
            <input id="search_input" class="form-control" placeholder="EJ: Asistente">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table id="example1" class="table table-bordered table-hover dataTable" role="grid">
            <thead>
              <tr>
                <td>#</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Laboratorio</td>
                <td>Cargo</td>
                <td>Función</td>
              </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              <tr>
                <td>#</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Laboratorio</td>
                <td>Cargo</td>
                <td>Función</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="container-fluid">
      </div>
    </div>
  </div>
</section>
<div class="modal fade in" id="modal-editar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Editar Usuario</h4>
        </div>
        <?php echo form_open(site_url('usuairo/upd'), $url); ?>
        <?php echo form_hidden('id', ''); ?>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Nombre</label>
                <!-- Helper Framerwork -->
                <?php echo form_input('nombre', '', $attributes); ?>
                <!-- Helper Framerwork -->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Apellido Paterno</label>
                <!-- Helper Framerwork -->
                <?php echo form_input('apaterno', '', $attributesap); ?>
                <!-- Helper Framerwork -->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Laboratorio</label>
                <select class="form-control select2 select2-hidden-accesible" style="width:100%" tabindex="-1" aria-hidden="true" name="laboratorio" id="laboratorio">
                  <option selected="selected" value="">Seleccione una opción</option>
                  <!-- <?php foreach ($laboratorio as $value): ?>
                    <option value="<?php echo $value->ID_LABORATORIO ?>"><?php echo $value->NOMBRE ?></option>
                  <?php endforeach ?> -->
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Cargo</label>
                <select class="form-control select2 select2-hidden-accesible" style="width:100%" tabindex="-1" aria-hidden="true" name="cargo" id="cargo">
                  <option selected="selected" value="">Seleccione una opción</option>
                  <!-- <?php foreach ($cargo as $value): ?>
                    <option value="<?php echo $value->ID_CARGO ?>"><?php echo $value->NOMBRE ?></option>
                  <?php endforeach ?> -->
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cierra</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
  <div class="modal modal-danger fade in" id="modal-del">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Eliminar Usuario</h4>
              </div>
              <div class="modal-body">
                <p>Esta seguro de eliminar <span id="texto"></span> ?</p>
              </div>
              <div class="modal-footer">
                <?php echo form_hidden('id_del', ''); ?>
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-outline btn-del-usuario">Eliminar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<script>
  var table;
  
  var buttonCommon = {
    exportOptions: {
      columns: [ 0, 1, 2, 3, 4 ]
    }
  };

  jQuery(document).ready(function($) {
    $('.select2').select2({
      'language' : 'es',
      'width' : '100%'
    });

    $('#laboratorio').select2({
      'ajax': {
        url: "<?php echo site_url('laboratorio/get_like')?>", 
        type: "GET",
        dataType: 'json',
        data: function(params) {
          return {
            filter: params.term
          };
        },
        processResults: function(data) {
          return {
            results: $.map(data, function (item) {
              return {
                text: item.nombre,
                id: item.id
              }
            })
          };
        }
      },
      'width' : '100%',
      'language' : 'es',
      'minimumInputLength': 0
    });

    $('#cargo').select2({
      'ajax': {
        url: "<?php echo site_url('cargo/get_like')?>", 
        type: "GET",
        dataType: 'json',
        data: function(params) {
          return {
            filter: params.term,
            laboratorio: $('#laboratorio').val()
          };
        },
        processResults: function(data) {
          return {
            results: $.map(data, function (item) {
              return {
                text: item.nombre,
                id: item.id
              }
            })
          };
        }
      },
      'width' : '100%',
      'language' : 'es',
      'minimumInputLength': 0
    });

    table = $('#example1').DataTable({
      "ajax": {
        "url": "<?php echo site_url('usuario/get')?>",
        'type': 'POST',
        "dataSrc":"",
      },
      "columns":[
      {data : "id_usuario","className": "text-center"},
      {data : "nombre_usuario","className": "text-left"},
      {data : "apellido_usuario","className": "text-left"},
      {data : "laboratorio","className": "text-left"},
      {data : "cargo","className": "text-left"},
      {"render" : function (data, type, row){
          // console.log(row)
          var html = '';

          html = '<div class="btn-group"><button type="button" data-toggle="tooltip-modal" data-placement="top" title="Editar" data-target="#modal-editar" class="btn btn-primary btn-xs btn-edit"><i class="fa fa-edit"></i></button><button type="button" data-toggle="tooltip-modal" data-placement="top" title="Eliminar" class="btn btn-danger btn-xs btn-del"><i class="fa fa-trash"></i></button></div>';
          $('[data-toggle="tooltip-modal"]').tooltip();
          return html;
        },
        "className": "text-center"
      }
      ],
      "columnDefs": [
      {
        "targets": [ -1 ],
        "orderable": false,
      },
      {   
        "targets" : 'no-sort', orderable : false 
      }
      ],
      "buttons"     : [
        $.extend( true, {}, buttonCommon, {
          extend: 'excelHtml5',
                title: 'Informe'
        }),
        $.extend( true, {}, buttonCommon, {
          extend: 'csvHtml5',
                title: 'Informe'
        }),
        $.extend( true, {}, buttonCommon, {
          extend: 'copyHtml5',
                title: 'Informe'
        }),
        $.extend( true, {}, buttonCommon, {
          extend: 'pdfHtml5',
                title: 'Informe'
        }),
      ],
      "dom" : "Bfrtip",
      "paging": true,
      "info": true,
      "autoWidth": true,
      "bPaginate":true,
      "sPaginationType":"full_numbers",
      "bLengthChange": true,
      "bInfo" : true,
      "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
        }, 
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      },
    });
  });


  jQuery("#footer").ready(function(){
    jQuery("#example1_length").addClass('hidden');
    jQuery("#example1_filter").addClass('hidden');
    jQuery("#footer-left").text(jQuery("#example1_info").text());
    jQuery("#example1_paginate").appendTo(jQuery("#footer-right"));
  });

  $('#search_input').keyup(function(){
    table.search($(this).val()).draw() ;
  })

  $('#show_record').click(function() {
    table.page.len($('#show_record').val()).draw();
    jQuery("#footer-left").text(jQuery("#example1_inc_info").text());
  });

  jQuery("#example1").on("page.dt", function(){
    var info = table.page.info();
    jQuery("#footer-left").text("Mostrando registros del "+(info.start+1)+" al "+info.end+" de un total de "+info.recordsTotal+" registros");
  });

  $(document).on('click', '#example1 tbody tr td .btn-edit', function(event){
    event.preventDefault();
    var tr        = $(this).closest('tr');
    var row       = table.row(tr);
    var data      = row.data();
    $('#nombre').val(data.nombre_usuario);
    $('#apaterno').val(data.apellido_usuario);

    $("input[name=id]").val(data.id_usuario);

    $('#laboratorio').val(null).trigger('change');
    $('#cargo').val(null).trigger('change');

    var laboratorio = new Option(data.laboratorio, data.id_laboratorio, true, true);
    $('#laboratorio').append(laboratorio).trigger('change');

    var cargo = new Option(data.cargo, data.id_cargo, true, true);
    $('#cargo').append(cargo).trigger('change');

    $('#form').find('.form-group')
    .removeClass('has-success')
    .removeClass('has-error')
    .find('.text-danger')
    .remove();

    $('#modal-editar').modal('show');
  });


  $('#form').submit(function(event) {
    event.preventDefault();
    var form = $(this), btn = $(this).find('button');
    btn.attr('disabled', true);
    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      dataType: 'json',
      data: form.serialize(),
    })
    .done(function(data) {
      if (data.status) {
        form.find('.form-group')
            .removeClass('has-success')
            .removeClass('has-error')
            .find('.text-danger')
            .remove();
        form[0].reset();
        pf_notify(  'Usuario', 
        'Se edito correctamente', 
        'success',
        'fa fa-check');
        table.ajax.reload();
        $('#modal-editar').modal('hide');
      }else{
        $.each(data.mensaje,function(key, value) {
          var element = $('#' + key);
          if (element.is('input') || element.is('textarea')) {
            element.closest('div.form-group')
            .removeClass('has-success')
            .removeClass('has-error')
            .addClass(value.length > 0 ? 'has-error' : 'has-success')
            .find('.text-danger')
            .remove();
            element.after(value);
          }

          if (element.is('select')) {
            element.closest('div.form-group')
            .removeClass('has-success')
            .removeClass('has-error')
            .addClass(value.length > 0 ? 'has-error' : 'has-success')
            .find('.text-danger')
            .remove();
            element.next('span').after(value);
          }
        });

        if (data.error.length) {
          pf_notify(  'Usuario', 
          data.error, 
          'danger',
          'fa fa-close');
        }
      }
    })
    .always(function() {
      btn.attr('disabled', false);
    });
  });



  $(document).on('click', '#example1 tbody tr td .btn-del', function(event){
    var tr        = $(this).closest('tr');
    var row       = table.row(tr);
    var data      = row.data();
    $('#texto').text(data.nombre_usuario);
    $("input[name=id_del]").val(data.id_usuario);
    $('#modal-del').modal('show')
  });

  $('.btn-del-usuario').click(function(event) {
    event.preventDefault();
    $.post('<?php echo site_url('usuairo/del') ?>', {id: $("input[name=id_del]").val()}, function(data) {
      if (data.status) {
        pf_notify(  'Usuario', 
        'Fue eliminado correctamente', 
        'success',
        'fa fa-check');
        table.ajax.reload();
        $('#modal-del').modal('hide');
      }else{
        $.each(data.mensaje,function(key, value) {
          var element = $('#' + key);
          if (element.is('input') || element.is('textarea')) {
            element.closest('div.form-group')
            .removeClass('has-success')
            .removeClass('has-error')
            .addClass(value.length > 0 ? 'has-error' : 'has-success')
            .find('.text-danger')
            .remove();
            element.after(value);
          }

          if (element.is('select')) {
            element.closest('div.form-group')
            .removeClass('has-success')
            .removeClass('has-error')
            .addClass(value.length > 0 ? 'has-error' : 'has-success')
            .find('.text-danger')
            .remove();
            element.next('span').after(value);
          }
        });

        if (data.error.length) {
          pf_notify(  'Usuario', 
          data.error, 
          'danger',
          'fa fa-close');
        }
      }
    },'json');
  });
  
</script>