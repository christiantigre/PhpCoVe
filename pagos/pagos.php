<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Control Parqueadero - </title>
    </head>
    <body>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        PAGOS
                    </div>        
                    <div class="panel-body"  style="font-size: 9px">
                        <div class="table-responsive">
                            <form action="inicio.php" method="POST">
                                </br>
                                <label>Carpeta  :</label>&nbsp;<input type="text" name="txt_carpetapag" placeholder="Ingrese numero"/>&nbsp;<input type="submit" name="buscar_pagcar" value="VER"/>
                                <!--<label>Cliente  :</label>&nbsp;<input type="text" name="txt_idclipag" placeholder="Ingrese Id cliente"/>&nbsp;<input type="submit" name="buscar_pagcli" value="VER"/>-->
                                <label>Vehiculo :</label>&nbsp;<input type="text" name="txt_idvehpag" placeholder="Ingrese placa"/>&nbsp;<input type="submit" name="buscar_pagveh" value="VER"/>

                    <!--            <input type="submit" name="verpendientespag" value="PENDIENTES"/>
                                <input type="submit" name="verpagadospag" value="PAGADOS"/>-->
                                <input type="submit" name="otrospag" value="OTROS"/>

                                <input type="submit" name="transac_cob" value="REGRESAR">
                                </br>
                                </br>
                                <fieldset>
                                    <?php
                                    include_once 'class/pagosclass.php';
                                    $objtrs = new Pagos();
                                    $objtrs->conec_base();
                                    if (isset($_POST['buscar_pagcar'])) {
                                        $objtrs->buscar_transcarppag($_POST['txt_carpetapag']);
                                        echo '<hr><br>';
                                        echo '<h1>VEHICULO</h1>';
                                        $objtrs->buscar_veh_pag($_POST['txt_carpetapag']);
                                        echo '<hr><br>';
                                        echo '<h1>CLIENTE</h1>';
                                        $objtrs->buscar_cliente_pag($_POST['txt_carpetapag']);
                                    } else if (isset($_POST['buscar_pagcli'])) {
                                        $objtrs->buscar_transclipag($_POST['txt_idclipag']);
                                    } elseif (isset($_POST['buscar_pagveh'])) {
                                        $objtrs->buscar_transvehpag($_POST['txt_idvehpag']);
                                    } elseif (isset($_POST['verpendientespag'])) {
                                        $objtrs->verpendientespag();
                                    } elseif (isset ($_POST['verpagadospag'])) {
                                        $objtrs->verpagadospag();
                                    }
                    //                else {
                    //                    $objtrs->listar_transpagos();
                    //                }
                                    ?>  
                                    <hr>
                                    <h1>PAGOS</h1>
                                    <?php
                                    include_once 'class/pagosclass.php';
                                    $objtrs = new Pagos();
                                    $objtrs->conec_base();
                                    if (isset($_POST['buscar_pagcar'])) {
                                        $objtrs->detalle_transacpag($_POST['txt_carpetapag']);
                                    }
                                    ?>
                                    <hr>
                                    <h1>CREDITOS</h1>
                                    <?php
                                    include_once 'class/pagosclass.php';
                                    $objtrs = new Pagos();
                                    $objtrs->conec_base();
                                    if (isset($_POST['buscar_pagcar'])) {
                                        $objtrs->ver_creditospag($_POST['txt_carpetapag']);
                                    }
                                    ?>
                                </fieldset> 
                                <br><br>
                                    <!--<input type="reset" value="CANCELAR">-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <br><br>
    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>
</body>
</html>