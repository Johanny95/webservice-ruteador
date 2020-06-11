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
    <small>Registrar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Usuario</a></li>
    <li class="active"><a href="<?php echo site_url('usuairo/registrar')?>">Registrar</a></li>
  </ol>
</section>
<!-- End -->
<!-- Cuerpo -->
<section class="content">
  <div class="box box-default">
    <!-- Tittulo -->
    <div class="box-header with-border">
      <h3 class="box-title">Registrar Usuario</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- End titulo -->
    <!-- /.box-header -->
    <?php echo form_open(site_url('usuairo/add'), $url); ?>
    <!-- Cuerpo -->
    <div class="box-body">
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
    <!-- /.box-body -->
    <!-- Pie -->
    <div class="box-footer">
      <div class="container-fluid">
        <div class="row">
          <div class="col-ms-6 pull-right">
            <button type="submit" class="btn btn-primary">Registrar</button>
          </div>
        </div>
      </div>
    </div>
    <?php echo form_close(); ?>
    <!-- End -->
  </div>
</section>
<script>
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
  });


  $('#form').submit(function(event) {
    /* Act on the event */
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
        'Se creo correctamente', 
        'success',
        'fa fa-check');
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

    // $.post(form.attr('action'), form.serialize(), function(data) {
    //   /*optional stuff to do after success */
    //   console.log("success");
    // },'json')
    // .always(function() {
    //   btn.attr('disabled', false);
    // });
    
  });
</script>