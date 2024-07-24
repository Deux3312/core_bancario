<!DOCTYPE html>
<html lang="en">

<head>
  <title>Grupo Laeisz</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,
      user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="" />
  <meta name="keywords" content="">
  <meta name="author" content="Phoenixcoded" />
  <!-- Favicon icon -->
  <link rel="icon" href="../../plugins/images/favicon.ico" type="image/x-icon">

  <!-- prism css -->
  <link rel="stylesheet" href="../../plugins/css/plugins/prism-coy.css">
  <!-- vendor css -->
  <link rel="stylesheet" href="../../plugins/css/style.css">
  <!--Swal-->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!--Swal 2-->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../../plugins/css/bootstrap.css">
  <link rel="stylesheet" href="../../plugins/css/dataTables.bootstrap4.min.css">

</head>
<style>
  ::-webkit-scrollbar {
    display: none;
  }
</style>

<body>
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <div class="content-wrapper pb-0">
    <div class="pcoded-wrapper container">
      <div class="pcoded-content">
        <div class="pcoded-inner-content">
          <div class="main-body">
            <div class="page-wrapper">
              <div class="page-header">
                <div class="page-block">
                  <div class="row align-items-center">
                    <div class="col-md-12">
                      <div class="page-header-title">
                        <CENTER>
                          <h2 class="m-b-10">Creación de Empresas</h2>
                        </CENTER>
                      </div>

                    </div>
                  </div>
                </div>
              </div>


              <button type="button" class="btn btn-primary me-2 abc1" style="float:right" data-toggle="modal" data-target="#crearEmpresa">Crear Empresa</button>


              <table id="example" class="table table-striped table-bordered" style="width:100%">

                <thead>
                  <tr>
                    <th>Editar</th>
                    <th>Empresa</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Logo</th>
                    <th>Fecha Creación</th>
                  </tr>
                </thead>
                <tbody id="data_table">
                  <?php
                  require_once("../../model/conexion.php");
                  $sql = "SELECT * FROM Empresa";
                  $result = pg_query($conn, $sql);
                  if ($result === false) {
                    $data = "Problemas en query";
                  } else {
                    while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC) ) {
                  ?>
                      <tr>
                        <td>
                          <button type="button" class="btn btn-warning me-2" onclick="editar_empresa('<?php echo $row['id']; ?>');"><i class="fas fa-edit"></i></button>
                        </td>
                        <td><?php echo $row['empresa']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td>
                          <?php
                          if ($row['estado'] == 'A') {
                            echo 'ACTIVO';
                          } else {
                            echo 'INACTIVO';
                          }
                          ?>
                        </td>
                        <td><?php echo '<img width="86" height="84" alt="" src="'.$row['logo'].'">'; ?></td>
                        <td>
                          <?php
                             $date = new DateTime($row["fecha_creacion"]);
                             $fecha = $date->format('Y-m-d H:i:s');
                             echo  $fecha;
                          ?>
                        </td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>

              </table>

              <!--Modal de creacion  de Empresas -->
              <div class="modal fade" id="crearEmpresa" tabindex="-1" role="dialog" aria-labelledby="crearEmpresaLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <CENTER>
                        <h5 class="modal-title" id="crearEmpresaLabel">Creación de Empresa</h5>
                      </CENTER>
                      <button type="button" class="close" onclick="cerrar_modal();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <div class="form-group" id="empresa_div">
                          <label for="recipient-name" class="col-form-label">Empresa:</label>
                          <input type="text" class="form-control" id="empresa" onkeypress="return /[a-zA-Z ]/i.test(event.key)">
                        </div>
                        <div class="form-group" id="descrip_div">
                          <label for="recipient-name" class="col-form-label">Descripción:</label>
                          <input type="text" class="form-control" id="descrip" onkeypress="return /[a-zA-Z ]/i.test(event.key)">
                        </div>
                        <div class="form-group" id="estado_div">
                          <label for="exampleFormControlSelect1">Estado:</label>
                          <select class="form-control" id="estado">
                            <option value="">SELECCIONE</option>
                            <option value="A">Activo</option>
                            <option value="I">Inactivo</option>
                          </select>
                        </div>
                        <div class="form-group" id="base_div">
                          <label for="recipient-name" class="col-form-label">Base de Datos:</label>
                          <input type="text" class="form-control" id="base" onkeypress="return /[a-zA-Z ]/i.test(event.key)">
                        </div>
                        <div class="form-group" id="input_div">
                          <div class="table-responsive">
                            <label for="exampleFormControlSelect1">Logo:</label>
                            <div class="input-group cust-file-button mb-3">

                              <div class="custom-file">
                                <input type="file"  accept="image/*" class="custom-file-input" id="inputGroupFile03" onchange="encodeImgtoBase64(this)">
                                <label class="custom-file-label" for="inputGroupFile03">Adjuntar</label>
                              </div>

                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn  btn-secondary" onclick="cerrar_modal();">Cancelar</button>
                      <button type="button" class="btn  btn-primary" id="guardar_empresa">Guardar</button>
                      <input type="hidden" id="output">
                    </div>
                  </div>
                </div>
              </div>
              <!--Modal de edición de empresas-->
              <div class="modal fade" id="editarEmpresa" tabindex="-1" role="dialog" aria-labelledby="crearEmpresaLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <CENTER>
                        <h5 class="modal-title" id="editarEmpresaLabel">Edición de Empresa</h5>
                      </CENTER>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <div class="form-group" id="empresa_div_edicion">
                          <label for="recipient-name" class="col-form-label">Empresa:</label>
                          <input type="text" class="form-control" id="empresa_edicion"  onkeypress="return /[a-zA-Z ]/i.test(event.key)">
                          <input type="hidden" class="form-control" id="id_empresa">
                        </div>
                        <div class="form-group" id="descrip_div_edicion">
                          <label for="recipient-name" class="col-form-label">Descripción:</label>
                          <input type="text" class="form-control" id="descrip_edicion"  onkeypress="return /[a-zA-Z ]/i.test(event.key)">
                        </div>
                        <div class="form-group" id="estado_div_edicion">
                          <label for="exampleFormControlSelect1">Estado:</label>
                          <select class="form-control" id="estado_edicion">
                            <option value="">SELECCIONE</option>
                            <option value="A">Activo</option>
                            <option value="N">Inactivo</option>
                          </select>
                        </div>
                        <div class="form-group" id="base_div_edicion">
                          <label for="recipient-name" class="col-form-label">Base de Datos:</label>
                          <input type="text" class="form-control" id="base_E" onkeypress="return /[a-zA-Z ]/i.test(event.key)">
                        </div>
                        <div class="form-group" id="input_div_edicion">
                          <div class="table-responsive">
                            <label for="exampleFormControlSelect1">Logo:</label>
                            <div class="input-group cust-file-button mb-3">

                              <div class="custom-file">
                                <input type="file" accept="image/*" class="custom-file-input" id="inputGroupFile03_edicion"  onchange="encodeImgtoBase64(this)">
                                <label class="custom-file-label" for="inputGroupFile03">Adjuntar</label>
                                <input type="hidden" id="output_edicion">
                              </div>

                            </div>
                          </div>
                        </div>

                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="button" class="btn  btn-primary" id="guardar_empresa_edicion">Guardar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Required Js -->
  <script src="../../plugins/js/vendor-all.min.js"></script>
  <script src="../../plugins/js/plugins/bootstrap.min.js"></script>
  <script src="../../plugins/js/pcoded.min.js"></script>
  <!--Tablas-->
  <script src="../../plugins/js/jquery.dataTables.min.js"></script>
  <script src="../../plugins/js/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });
  </script>
  <!-- prism Js -->
  <script src="../../plugins/js/plugins/prism.js"></script>
  <script src="../../plugins/js/horizontal-menu.js"></script>
  <script>
    (function() {
      if ($('#layout-sidenav').hasClass('sidenav-horizontal') ) {
        return;
      }
      try {
        window.layoutHelpers._getSetting("Rtl")
        window.layoutHelpers.setCollapsed(
          localStorage.getItem('layoutCollapsed') === 'true',
          false
        );
      } catch (e) {}
    })();
    $(function() {
      $('#layout-sidenav').each(function() {
        new SideNav(this, {
          orientation: $(this).hasClass('sidenav-horizontal') ? 'horizontal' : 'vertical'
        });
      });
      $('body').on('click', '.layout-sidenav-toggle', function(e) {
        e.preventDefault();
        window.layoutHelpers.toggleCollapsed();
        if (!window.layoutHelpers.isSmallScreen()) {
          try {
            localStorage.setItem('layoutCollapsed', String(window.layoutHelpers.isCollapsed()));
          } catch (e) {}
        }
      });
    });
    $(document).ready(function() {
      $("#pcoded").pcodedmenu({
        themelayout: 'horizontal',
        MenuTrigger: 'hover',
        SubMenuTrigger: 'hover',
      });
    });
  </script>
  <script src="../../plugins/js/analytics.js"></script>
  <!--Librerias para Mask Money-->
  <script src="../../plugins/jquery-maskmoney-master/src/jquery.maskMoney.js" type="text/javascript"></script>
  <!--Fin Librerias MAsk MOney-->
  <!--Librerias para Select2-->
  <link href="../../plugins/select2-develop/dist/css/select2.min.css" rel="stylesheet" />
  <script src="../../plugins/select2-develop/dist/js/select2.min.js"></script>
  <!--Fin Librerias para Select2-->
</body>
<script type="text/javascript">

  function encodeImgtoBase64(element) {
    var img = element.files[0];
    var reader = new FileReader();
    reader.onloadend = function() {
      $("#output").val(reader.result);
    }
    reader.readAsDataURL(img);
  }
  function editar_empresa(empresa) {
    //Realizando el proceso para el llenado de la información de la empresa
    $.ajax({
        type: "POST",
        url: "../../model/model_seguridad/mstr_empresa.php",
        dataType: "json",
        data: {
          Id_Empresa: empresa

        }
      })
      .done(function(data) {
        var est = 'N';
        if (data["empresa"] == 'A') {
          est = 'A';
        }
        $("#empresa_edicion").val(data["empresa"]);
        $("#descrip_edicion").val(data["descripcion"]);
        $("#estado_edicion").val(est);
        $("#base_E").val(data["base"]);
      })
      .fail(function(data) {
        Swal.fire(
          'Error!',
          'Ha ocurrido un error al actualizar la empresa',
          'error'
        )
      });
    $("#id_empresa").val(empresa);
    $("#editarEmpresa").modal("show");
  }
  $("#guardar_empresa").click(function() {
    //Realizando las validaciones de los imputs
    var apr = 0;
    //validacion para tipo de solicitud llena
    if ($("#empresa").val() == null || $("#empresa").val() == "") {
      apr = 0;
      $("#empresa_div").addClass("alert alert-danger");
      return;
    } else {
      $("#empresa_div").removeClass("alert alert-danger")
      apr = 1;
    }
    //validacion de campo lleno para descripcion
    if ($("#descrip").val() == null || $("#descrip").val() == "") {
      apr = 0;
      $("#descrip_div").addClass("alert alert-danger");
      return;
    } else {
      $("#descrip_div").removeClass("alert alert-danger")
      apr = 1;
    }
    //validacion de campo lleno para estado
    if ($("#estado").val() == null || $("#estado").val() == "") {
      apr = 0;
      $("#estado_div").addClass("alert alert-danger");
      return;
    } else {
      $("#estado_div").removeClass("alert alert-danger")
      apr = 1;
    }

    //validacion de campo lleno para base
    if ($("#base").val() == null || $("#base").val() == "") {
      apr = 0;
      $("#base_div").addClass("alert alert-danger");
      return;
    } else {
      $("#base_div").removeClass("alert alert-danger")
      apr = 1;
    }
    //validacion de campo lleno para adjunto
    if ($("#inputGroupFile03").val() == null || $("#inputGroupFile03").val() == "") {
      apr = 0;
      $("#input_div").addClass("alert alert-danger");
      return;
    } else {
      $("#input_div").removeClass("alert alert-danger")
      apr = 1;
    }
    if (apr == 1) {
      var empresa = $("#empresa").val();
      var descripcion = $("#descrip").val();
      var estado = $("#estado").val();
      var adjunto = $("#output").val();
      var base = $("#base").val();
        $.ajax({
          type: "POST",
          url: "../../model/model_seguridad/insrt_empresa.php",
          dataType: "json",
          data: {
            Empresa: empresa,
            Descripcion: descripcion,
            Estado: estado,
            Logo: adjunto,
            Base: base
          }
        })
        .done(function(data) {

          if(data==1)
          {
            Swal.fire({
            icon: 'success',
            title: 'Éxito! <br> Empresa Creada exitosamente',
            showConfirmButton: false,
            timer: 2000
            })
            //Realizando la limpieza de todos los campos que se han llenado manualmente
            setTimeout(function() {
              location.reload();
            }, 2000);
          }
          else
          {
            Swal.fire({
            icon: 'warning',
            title: 'Advertencia! <br> Empresa Ya existe en la Base de Datos',
            showConfirmButton: false,
            timer: 2000
            })
            return;
          }
          
        })
        .fail(function(data) {
          Swal.fire(
            'Error!',
            'Ha ocurrido un error al cargar usuarios',
            'error'
          )
        });
    }
  });
  //boton de edicion de empresa
  $("#guardar_empresa_edicion").click(function() {
    //Realizando las validaciones de los imputs
    var apr = 0;
    //validacion para tipo de solicitud llena
    if ($("#empresa_edicion").val() == null || $("#empresa_edicion").val() == "") {
      apr = 0;
      $("#empresa_div_edicion").addClass("alert alert-danger");
      return;
    } else {
      $("#empresa_div_edicion").removeClass("alert alert-danger")
      apr = 1;
    }
    //validacion de campo lleno para descripcion
    if ($("#descrip_edicion").val() == null || $("#descrip_edicion").val() == "") {
      apr = 0;
      $("#descrip_div_edicion").addClass("alert alert-danger");
      return;
    } else {
      $("#descrip_div_edicion").removeClass("alert alert-danger")
      apr = 1;
    }
    //validacion de campo lleno para base
    if ($("#base_E").val() == null || $("#base_E").val() == "") {
      apr = 0;
      $("#base_div_edicion").addClass("alert alert-danger");
      return;
    } else {
      $("#base_div_edicion").removeClass("alert alert-danger")
      apr = 1;
    }
    //validacion de campo lleno para estado
    if ($("#estado_edicion").val() == null || $("#estado_edicion").val() == "") {
      apr = 0;
      $("#estado_div_edicion").addClass("alert alert-danger");
      return;
    } else {
      $("#estado_div_edicion").removeClass("alert alert-danger")
      apr = 1;
    }
    //validacion de campo lleno para adjunto
    if ($("#inputGroupFile03_edicion").val() == null || $("#inputGroupFile03_edicion").val() == "") {
      apr = 1;
    } else {
      $("#input_div_edicion").removeClass("alert alert-danger")
      apr = 1;
    }
    if (apr == 1) {
      var empresa = $("#empresa_edicion").val();
      var descripcion = $("#descrip_edicion").val();
      var estado = $("#estado_edicion").val();
      var adjunto_edicion = $("#output").val();
      var base = $("#base_E").val();
      console.log(adjunto_edicion);
      var id_empresa = $("#id_empresa").val();
      $.ajax({
          type: "POST",
          url: "../../model/model_seguridad/edt_empresa.php",
          dataType: "json",
          data: {
            Empresa: empresa,
            Descripcion: descripcion,
            Estado: estado,
            Logo: adjunto_edicion,
            Id_Empresa: id_empresa,
            Base:base

          }
        })
        .done(function(data) {
          Swal.fire({
            icon: 'success',
            title: 'Éxito! <br> Empresa Actualizada exitosamente',
            showConfirmButton: false,
            timer: 2000
          })
          //Realizando la limpieza de todos los campos que se han llenado manualmente
          setTimeout(function() {
            location.reload();
          }, 2000);
        })
        .fail(function(data) {
          Swal.fire(
            'Error!',
            'Ha ocurrido un error al actualizar la empresa',
            'error'
          )
        });
    }
  });
  function cerrar_modal()
  {
      $("#empresa").val("");
      $("#descrip").val("");
      $("#estado").val("");
      $("#crearEmpresa").modal("hide");
  };
</script>

</html>
