<?php
session_start();

require('../accesorios/accesos_bd.php');

$con=conectar();
					
$tabla_encuestas = mysqli_query($con, "select * from encuestas where estado = 1");

if($registro_encuestas = mysqli_fetch_array($tabla_encuestas)){

    $id_encuesta = $_SESSION['id_encuesta']	= $registro_encuestas[0];

    $_SESSION['id_encuesta']= $registro_encuestas[0];
    $_SESSION['nombre']     = $registro_encuestas[1];

    $tabla_respuestas       = mysqli_query($con, "select count(id_pregunta) from preguntas where id_encuesta = $id_encuesta");
    $registro_preguntas     = mysqli_fetch_array($tabla_respuestas);
    $_SESSION['cant_preg']  = $registro_preguntas[0];    
}

if(isset($_SESSION['cant_preg']) && $_SESSION['cant_preg'] > 5){
    
    $paginador = array();
    $contador = 1;
    $tabla_paginadores = mysqli_query($con, "select * from paginadores order by nro_pregunta");
    while($registro_paginadores = mysqli_fetch_array($tabla_paginadores, MYSQLI_BOTH)){
        
        $paginador[] = array("nombre" => $registro_paginadores[1], "pagina" => $registro_paginadores[2]);        
        $contador ++;
    }    
  

?>
<!DOCTYPE html>
<html>
<head>
    <title>SGE-v2.0 BootSt</title>
    <meta charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>    
    <link href="ymz_box.css" rel="stylesheet" type="text/css"/>
    
    <style>
        body { padding-top: 70px; padding-bottom: 70px; font-size: 1.1em !important }
    </style>
    
</head>

<body>
    
    <nav class="navbar navbar-default navbar-fixed-top">
        <table class="table table-condensed table-bordered">
            <tr class="bg-info text-center">
                <td>
                    <h5>
                        <a href="#tabla_cuota">SGE-v2 BootSt&TRADE;</a>
                    </h5>    
                </td>
                <?php                     
                foreach ($paginador as $pagina) {?>                        
                <td><a href="#div<?php echo $pagina['pagina']-1 ?>"><h5> <span class="badge"><?php echo $pagina['pagina'] ?></span> </h5> </a></td>                        
                <?php                        
                }
                ?>    
            </tr>
        </table>        
    </nav>
    
    <nav class="navbar navbar-default navbar-fixed-bottom">      
        <table class="table table-responsive">
            <tr class=" text-center">
                <td>
                    <a href="#" onClick="salida()"><span class=" glyphicon glyphicon-log-out"> QUIT </span> </a>
                </td>
                <td>
                    <a href="#" onclick="limpiar();"><span class=" glyphicon glyphicon-trash"> RESET </span> </a>
                </td>
                <td>
                    <a href="#" onclick="acerca()"><span class=" glyphicon glyphicon-info-sign"> ABOUT </span> </a>
                </td>
                <td>
                    <a href="#" onclick="no_vacio(<?php echo $_SESSION['cant_preg'] ?>)"><span class=" glyphicon glyphicon-save-file"> SAVE </span> </a>
                </td>
                
            </tr>
        </table>
    </nav>
 
    <div class="container-fluid">

        <form id="encuesta">
            <div id="tabla_cuota"></div>
            
            <div style="display:none">
                <input type="hidden" name="usuario" id="usuario" value="1" />
                <input type="hidden" name="id_encuesta" id="id_encuesta" value="<?php echo $_SESSION['id_encuesta'] ?>"/>                 
            </div>                             

            <br>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class=" col-xs-12 text-center text-muted">
                            TOTAL DE CUOTAS DEL ENCUESTADOR
                        </div>                       
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>EDAD</th>
                                <th class="text-center">VARON</th>
                                <th class="text-center">MUJER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>16-19</td>
                                <td><input type="number" name="tv16" id="tv16" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                                <td><input type="number" name="tm16" id="tm16" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                            </tr>
                            <tr>
                                <td>20-29</td>
                                <td><input type="number" name="tv20" id="tv20" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                                <td><input type="number" name="tm20" id="tm20" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                            </tr>
                            <tr>
                                <td>30-39</td>
                                <td><input type="number" name="tv30" id="tv30" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                                <td><input type="number" name="tm30" id="tm30" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                            </tr> 
                            <tr>
                                <td>40-49</td>
                                <td><input type="number" name="tv40" id="tv40" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                                <td><input type="number" name="tm40" id="tm40" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                            </tr>
                            <tr>
                                <td>50-59</td>
                                <td><input type="number" name="tv50" id="tv50" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                                <td><input type="number" name="tm50" id="tm50" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                            </tr>
                            <tr>
                                <td>60 +</td>
                                <td><input type="number" name="tv60" id="tv60" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                                <td><input type="number" name="tm60" id="tm60" value="0" readonly="readonly" class="form-control text-center informe"/></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>TOTAL</th>
                                <th><input type="number" name="totalv" id="totalv" value="0" readonly="readonly" class="form-control text-center informe"/></th>
                                <th><input type="number" name="totalm" id="totalm" value="0" readonly="readonly" class="form-control text-center informe"/></th>
                            </tr> 
                        </tfoot>
                    </table> 
                </div>    
            </div>    
            <div class="row">
                <hr>
            </div>
            <div class="panel panel-info" id="detalle_cuota">
                <div class="panel-heading">
                    <div class="row">
                        <div class=" col-xs-12">
                            DETALLE DE LA CUOTA
                        </div>                       
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class=" col-xs-12">
                            <strong>1) ZONA</strong>
                        </div>
                        <div class=" col-xs-12">
                            <select id="1" name="1" class="form-control">
                                <option value="0" disabled="disabled" selected="selected"></option>
                                <?php
                                $seleccion_respuestas = mysqli_query($con, "select * from tabla_zonas");
                                while ($registro_respuestas = mysqli_fetch_array($seleccion_respuestas)){?>
                                    <option value="<?php echo $registro_respuestas[0]?>"><?php echo $registro_respuestas[1] ?></option>                    
                                <?php    
                                }
                                ?>
                            </select>
                        </div>          
                    </div>
                    <div class="row">
                        <div class=" col-xs-12">
                            <strong>2) SEXO</strong>
                        </div>
                        <div class=" col-xs-12">
                            <select id="2" name="2" class="form-control">
                                <option value="0" disabled="disabled" selected="selected"></option>
                                <option value="1">VARON</option>
                                <option value="2">MUJER</option>
                            </select>
                        </div>
                    </div>    
                    <div class="row">
                        <div class=" col-xs-12">
                            <strong>3) EDAD</strong>
                        </div>
                        <div class=" col-xs-12">    
                            <select id="3" name="3" class="form-control">
                                <option value="0"></option>
                                <?php
                                $seleccion_respuestas = mysqli_query($con, "select * from tabla_edades");
                                while ($registro_respuestas = mysqli_fetch_array($seleccion_respuestas)){?>
                                    <option value="<?php echo $registro_respuestas[0]?>"><?php echo $registro_respuestas[1] ?></option>                    
                                <?php    
                                }
                                ?>
                            </select>    
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-xs-12">
                            <strong>4) NIVEL INSTRUCCION </strong>
                        </div>
                        <div class=" col-xs-12">                                                       
                            <select id="4" name="4" class="form-control">
                                <option value="0" disabled="disabled" selected="selected"></option>
                                <?php
                                $seleccion_respuestas = mysqli_query($con, "select * from tabla_nivel_instruccion");
                                while ($registro_respuestas = mysqli_fetch_array($seleccion_respuestas)){?>
                                    <option value="<?php echo $registro_respuestas[0]?>"><?php echo $registro_respuestas[1] ?></option>                    
                                <?php    
                                }
                                ?>
                            </select>    
                        </div>
                    </div>   
                    <div class="row">
                        <div class=" col-xs-12">
                            <strong>5) OCUPACION PRINCIPAL </strong>
                        </div>
                        <div class=" col-xs-12">                                        
                            <select id="5" name="5" class="form-control"> 
                                <option value="0" disabled="disabled" selected="selected"></option>
                                <?php
                                $seleccion_respuestas = mysqli_query($con, "select * from tabla_ocupacion");
                                while ($registro_respuestas = mysqli_fetch_array($seleccion_respuestas)){?>
                                    <option value="<?php echo $registro_respuestas[0]?>"><?php echo $registro_respuestas[1] ?></option>                    
                                <?php    
                                }
                                ?>
                            </select>
                        </div>
                    </div>                    
                </div>
            </div>    
                  
            
            <div class="row">
                <hr>
            </div>
            
            <div class="panel panel-info" id="cuerpo">
                <div class="panel-heading">
                    <div class="row">
                        <div class=" col-xs-12">
                            CUERPO CUESTIONARIO
                        </div>                       
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    $seleccion_preguntas = mysqli_query($con,"select * from preguntas where nro > 5 order by nro asc");

                    while($registro_preguntas = mysqli_fetch_array($seleccion_preguntas)){

                        $id_pregunta = $registro_preguntas[0];
                        $nro_pregunta= $registro_preguntas[4];

                        $seleccion_respuestas = mysqli_query($con,"select * from respuestas where id_pregunta = $id_pregunta order by valor_spss");
                        $tipo_respuesta = $registro_preguntas[2];
                        $cant_respuestas= mysqli_num_rows($seleccion_respuestas);?>   

                        <?php $id = $nro_pregunta; ?>
                        <div id="div<?php echo $id ?>" name="div<?php echo $id ?>" >
                            <div class="row">
                                <div class="col-xs-12 text-justify" style=" padding-bottom: 20px">
                                    <strong><?php echo $nro_pregunta .') '; ?><?php echo $registro_preguntas[3]; ?></strong>
                                </div>
                            </div>
                            
                            <?php
                            switch ($tipo_respuesta){
                            ///// RESPUESTAS ABIERTAS  
                            case 1:
                            ?>
                            <div class="row">
                                <div class=" col-xs-12">
                                    <input id="<?php echo $id ?>" name="<?php echo $id ?>" type="text" value="-" class="form-control" />
                                </div>
                            </div>                      
                            <?php
                            break;
                            ///// RESPUESTAS OPCIONES MULTIPLES	
                            case 2:    
                            if($cant_respuestas > 3){   // MUCHAS OPCIONES
                            ?>    
                            <div class="row">
                                <div class=" col-xs-12">
                                    <select id="<?php echo $id ?>" name="<?php echo $id ?>" class="form-control">
                                        <option value="0">&nbsp;</option>
                                        <?php
                                        while ($registro_respuestas = mysqli_fetch_array($seleccion_respuestas)){
                                            echo "<option value=\"".$registro_respuestas[0]."\">".$registro_respuestas[2]."</option>\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php                       // POCAS OPCIONES
                            }else{ ?>
                            <div class="row">                            
                                <?php
                                $cont = 1;
                                while ($registro_respuestas = mysqli_fetch_array($seleccion_respuestas)){
                                ?>  
                                <div class="col-xs-4 text-center">                                  
                                    <label class="radio-inline">
                                        <input type="radio" id="r<?php echo $id ?><?php echo $registro_respuestas[0]?>" name="opcion<?php echo $id ?>" value="<?php echo $registro_respuestas[0]?>" onclick="asignar(<?php echo $id ?>,<?php echo $registro_respuestas[0]?>)"/>
                                        <?php echo $registro_respuestas[2]?>
                                    </label>
                                </div>                                    
                                <?php  
                                $cont ++;
                                }
                                ?>                                    
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <input type="hidden" id="<?php echo $id ?>" value="0" class="cerear">
                                    &nbsp;
                                </div>
                            </div>
                                
                            <?php 
                            }
                            break;
                            ///// RESPUESTAS MB/B/RB/RM/M/MM/NsNc	
                            case 3:
                            $seleccion_respuestas = mysqli_query($con,"select * from tabla_opinion");
                            ?>
                            <div class="row">
                                <div class=" col-xs-12">
                                    <select id="<?php echo $id ?>" name="<?php echo $id ?>" class="form-control">
                                        <option value="0">&nbsp;</option>
                                        <?php
                                        while ($registro_respuestas = mysqli_fetch_array($seleccion_respuestas)){
                                            echo "<option value=\"".$registro_respuestas[0]."\">".$registro_respuestas[1]."</option>\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>                     
                            <?php
                            break;
                            ///// RESPUESTAS TABLA CRUZADA	
                            case 4:

                            $seleccion_titulo = mysqli_query($con,"select enunciado from respuestas where id_pregunta = $id_pregunta and fila = 3");    
                            $registro_respuestas = mysqli_fetch_array($seleccion_titulo);
                            $titulo_fila    = $registro_respuestas[0];

                            $seleccion_titulo = mysqli_query($con,"select enunciado from respuestas where id_pregunta = $id_pregunta and fila = 4");    
                            $registro_respuestas = mysqli_fetch_array($seleccion_titulo);
                            $titulo_columna    = $registro_respuestas[0];

                            ?>
                            <div class="row">
                                <div class="col-xs-4">                        
                                    <select id="c<?php echo $id ?>" name="c<?php echo $id ?>" size="1" class=" form-control">
                                        <option value="0" disabled="disabled" selected="selected"><?php echo $titulo_fila ?></option>
                                        <?php 
                                        $seleccion_titulo = mysqli_query($con,"select id_respuesta, enunciado from respuestas where id_pregunta = $id_pregunta and fila = 1");    
                                        while($registro_respuestas = mysqli_fetch_array($seleccion_titulo)){
                                        ?>
                                        <option value="<?php echo $registro_respuestas[0] ?>"><?php echo $registro_respuestas[1] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-xs-5">                        
                                    <select id="f<?php echo $id ?>" name="f<?php echo $id ?>" class=" form-control" onblur="agrega_cruzado(<?php echo $id ?>)">
                                        <option value="0" disabled="disabled" selected="selected"><?php echo $titulo_columna ?></option>
                                        <?php 
                                        $seleccion_titulo = mysqli_query($con,"select id_respuesta, enunciado from respuestas where id_pregunta = $id_pregunta and fila = 2");    
                                        while($registro_respuestas = mysqli_fetch_array($seleccion_titulo)){
                                        ?>
                                        <option value="<?php echo $registro_respuestas[0] ?>"><?php echo $registro_respuestas[1] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-xs-1 text-left" style="padding-top: 10px">  
                                    <span class=" glyphicon glyphicon-ok"></span>                                    
                                </div>
                                <div class="col-xs-1 text-right" style="padding-top: 10px">  
                                    <span class=" glyphicon glyphicon-trash" style="color:red" onclick="vaciar_lista(<?php echo $id ?>)"></span>                                    
                                </div>
                            </div>

                            <div class="row">    
                                <div class="col-xs-12">
                                    <div style="display:none">
                                        <input type="text" id="<?php echo $id ?>" value="0" class="cerear">
                                    </div>                     
                                    
                                    <h5>Su selección :</h5>
                                    <textarea id="textarea<?php echo $id ?>" name="textarea<?php echo $id ?>" class="form-control" readonly>0</textarea>
                                </div> 
                            </div>    
                            <!-- FIN RESPUESTA RESPUESTAS CRUZADAS -->
                            
                            <!-- RESPUESTAS MULTIPLES CHECK  -->
                            <?php
                            break;
                            case 10:
                            ?>
                            <div class="row">                                
                                <?php
                                while ($registro_respuestas = mysqli_fetch_array($seleccion_respuestas)){ ?>
                                    <div class="col-xs-12" style=" padding-top: 20px">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="check<?php echo $id ?>" onClick="if (this.checked) asignar_check(this.value,1,<?php echo $id ?>); else asignar_check(this.value,0,<?php echo $id ?>)" value="<?php echo $registro_respuestas[0] ?>"><?php echo $registro_respuestas[2]?>
                                        </label>
                                    </div>
                                <?php    
                                }
                                ?>
                            </div>    
                            <div class="row">  
                                <div class="col-xs-12">
                                    <div style="display:none">
                                        <input type="text" id="<?php echo $id ?>" value="0" class="cerear">                                                                        
                                    </div>    
                                </div>                                                               
                            </div>   
                            <!-- FIN MULTIPLES CHECK -->
                            <?php
                            break;
                            ///// RESPUESTAS SI/NO/NsNc	
                            case 11:
                            $seleccion_respuestas = mysqli_query($con,"select * from tabla_sino");
                            ?>
                            <div class="row">                                                                    
                            <?php
                            $cont = 1;
                            while ($registro_respuestas = mysqli_fetch_array($seleccion_respuestas)){
                            ?>  
                            <div class="col-xs-4 text-center">                                  
                                <label class="radio-inline">
                                    <input type="radio" id="r<?php echo $id ?><?php echo $registro_respuestas[0]?>" name="opcion<?php echo $id ?>" value="<?php echo $registro_respuestas[0]?>" onclick="asignar(<?php echo $id ?>,<?php echo $registro_respuestas[0]?>)" />  <?php echo $registro_respuestas[1]?>
                                </label>
                            </div>                                    
                            <?php  
                            $cont ++;
                            }
                            ?>                               
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <input type="hidden" id="<?php echo $id ?>" value="0" class="cerear">
                                    &nbsp;
                                </div>
                            </div>
                            <?php
                            break;
                            }
                            ?>
                            <div class="row">    
                                <div class="col-xs-12">
                                    &nbsp;
                                </div> 
                            </div> 
                        </div>
                    <?php    
                    }     
                    ?>       
                </div>
            </div>    
        </form> 
    </div>
    
<script type="text/javascript">
    
    function asignar(id,valor){
        document.getElementById(id).value = valor;
    }
        
    function agrega_cruzado(i){

        if($("#c"+i).val()> 0 && $("#f"+i).val()> 0){
            
            var valores = ',' + $("#c"+i).val() + '-' + $("#f"+i).val();
            var textos  = $("#c"+ i +" option:selected").text()+' => '+$("#f"+ i +" option:selected").text();
             
            var valor = document.getElementById(i).value;
            if(valor == 0){ 
                document.getElementById(i).value = valores;
                document.getElementById('textarea'+ i).value = textos + ', ';
            }else{
                document.getElementById(i).value = document.getElementById(i).value + valores;
                document.getElementById('textarea'+ i).value = document.getElementById('textarea'+ i).value + textos + ', ';
            }
            $("#c"+i).val(0);
            $("#f"+i).val(0);          
            
        }  
    }
    
    function asignar_check(id,operacion,idSelect){   
        
        var aux = document.getElementById(idSelect).value.toString();
        
        var arreglo = aux.split(',');
               
        if(operacion == 1){         // Agrega valor            
            aux = '';            
            for(i=0; i < arreglo.length ; i++){ 
                if(arreglo[i] == 0){
                    ;
                }else{
                    aux = aux + ',' + arreglo[i] ;  
                }                                     
            }                        
            document.getElementById(idSelect).value = id + aux;            
        }else{                      // Quitar valores
            
            for(i=0; i < arreglo.length ; i++){                
                if(arreglo[i] == id){
                    arreglo.splice(i, 1);
                    break;
                }         
            }
            aux = arreglo.toString();
            var arreglo = aux.split(',');
            aux = '';
            
            for(i=0; i < arreglo.length ; i++){                
                if(arreglo[i] == 0){
                    ;
                }else{
                  aux = aux + ',' + arreglo[i] ;
                }           
            } 
                       
            if(i == 1){
                document.getElementById(idSelect).value = 0;
            }else{
                document.getElementById(idSelect).value = aux;
            }
            
        }        
        
    }
    
    function limpiar(){        
        
        ymz.jq_confirm({title:"Restablecer", text:"Seguro que limpia ?", no_btn:"No", yes_btn:"Confirma", 
            no_fn:function(){}, 
            yes_fn:function(){
                 
            $(':input','#encuesta').removeAttr('checked').removeAttr('selected').not(':button, :submit, :reset, :hidden, :checkbox, :radio, .informe').val('');
            $("input:text").val('-');
            $('input:checkbox:checked').prop('checked', false);
            $('input:radio:checked').prop('checked', false);
            $('.cerear').val(0);
            $('html,body').animate({scrollTop: $("#tabla_cuota").offset().top}, 500);
            }
        });        
    }
    
    function acerca(){
        
        var texto = 'cachoalbornoz@gmail.com / 0343 154 586951';
        ymz.jq_alert({title:"Guillermo Albornoz", text:texto, ok_btn:"Ok", close_fn:null});
        
    }
    
    
    function Guardar_Android(texto) {        
        
        var sexo = document.getElementById(2).value ;
        var edad = document.getElementById(3).value ;
        
        if(sexo == 1){  
            // VARON
            if(edad == 1){
                document.getElementById('tv16').value = parseFloat(document.getElementById('tv16').value) + 1;
            }else{
                if(edad == 2){
                    document.getElementById('tv20').value = parseFloat(document.getElementById('tv20').value) + 1;
                }else{
                    if(edad == 3){
                        document.getElementById('tv30').value = parseFloat(document.getElementById('tv30').value) + 1;
                    }else{
                        if(edad == 4){
                            document.getElementById('tv40').value = parseFloat(document.getElementById('tv40').value) + 1;
                        }else{
                            if(edad == 5){
                                document.getElementById('tv50').value = parseFloat(document.getElementById('tv50').value) + 1;
                            }else{
                                document.getElementById('tv60').value = parseFloat(document.getElementById('tv60').value) + 1;
                            }
                        }
                    }
                }
            }
            document.getElementById('totalv').value = parseFloat(document.getElementById('totalv').value) + 1;
        }else{ 
            // MUJER
            if(edad == 1){
                document.getElementById('tm16').value = parseFloat(document.getElementById('tm16').value) + 1;
            }else{
                if(edad == 2){
                    document.getElementById('tm20').value = parseFloat(document.getElementById('tm20').value) + 1;
                }else{
                    if(edad == 3){
                        document.getElementById('tm30').value = parseFloat(document.getElementById('tm30').value) + 1;
                    }else{
                        if(edad == 4){
                            document.getElementById('tm40').value = parseFloat(document.getElementById('tm40').value) + 1;
                        }else{
                            if(edad == 5){
                                document.getElementById('tm50').value = parseFloat(document.getElementById('tm50').value) + 1;
                            }else{
                                document.getElementById('tm60').value = parseFloat(document.getElementById('tm60').value) + 1;
                            }
                        }
                    }
                }
            }
            document.getElementById('totalm').value = parseFloat(document.getElementById('totalm').value) + 1;
        }       
        
        $(':input','#encuesta').removeAttr('checked').removeAttr('selected').not(':button, :submit, :reset, :hidden, :checkbox, :radio, .informe').val('');
        $("input:text").val('-');
        $('input:checkbox:checked').prop('checked', false);
        $('input:radio:checked').prop('checked', false);
        $('.cerear').val(0);
        $('html,body').animate({scrollTop: $("#tabla_cuota").offset().top}, 500);        

        Android.guardar(texto);      
    }
    
    function vaciar_lista(i){
        
        var text = "Pregunta " + i ;
        ymz.jq_confirm({title:text, text:"limpia respuestas ?", no_btn:"No", yes_btn:"Si", 
            no_fn:function(){}, 
            yes_fn:function(){
                
                document.getElementById(i).value = 0;
                document.getElementById('textarea'+ i).value = 0;
            }
        });     
    }
    
    
    function salida() {
        Android.salir();
    }
    
    function obtenerDatos(cant_preg) {
        var cadena = ''; 
        var id_encuesta = document.getElementById('id_encuesta').value;
        var nro_usuario = document.getElementById('usuario').value;

        for (i=1; i <= cant_preg ; i ++){
            var nro = document.getElementById(i);
            if(typeof nro !== 'undefined' && nro !== null) {

                var nro = document.getElementById(i).value ;

            }else{
                var sel_f 	= document.getElementById('F_' + i); // Buscar valores en filas
                var sel_c 	= document.getElementById('C_' + i); // Buscar valores en columnas

                texto = '';

                for(x=0; x < sel_f.children.length; x++){
                    var child_f = sel_f.children[x];
                    var child_c = sel_c.children[x];

                    if(child_f.value > 0){
                        var texto = texto + child_f.value + '_' + child_c.value + '.' ;
                    }
                }
                var texto = texto.substring(0, texto.length-1);
                var nro = texto;
            }		
            cadena = cadena + nro + ';' ;
        }	
        return id_encuesta + ';' + nro_usuario + ';' + cadena ;
    } 

    function no_vacio(cant_preg){
        
        var error = 0;
        for (i=1; i <= cant_preg ; i ++){
            var respuesta = document.getElementById(i);
            if(typeof respuesta !== 'undefined' && respuesta !== null) {
                if(document.getElementById(i).value == 0){
                    if(i < 5){
                        $('html,body').animate({scrollTop: $("#detalle_cuota").offset().top}, 500);
                    }else{
                          
                        $('html,body').animate({scrollTop: $("#div"+i).offset().top}, 500);
                        
                        var texto = "Complete Respuesta " + i;
                        ymz.jq_alert({title:"Incompleto", text:texto, ok_btn:"Ok", close_fn:null});                
                    }
                    
                    error = 1;
                    break;
                }
            }
        }
	
        if(error == 0){
            var datos = obtenerDatos(cant_preg);
            Guardar_Android(datos);
        }
    }  
</script>

    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <!-- ymz Alert -->
    
    <script src="ymz_box.min.js" type="text/javascript"></script>

</body>
</html>
<?php 
mysqli_close($con);
}else{
    
    echo    '
        
    <!DOCTYPE html>
    <html>
    <head>
        <title>SGE-v2.0 BootSt</title>
        <meta charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" /> 

        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>    
        <link href="ymz_box.css" rel="stylesheet" type="text/css"/>

        <style>
            body { padding-top: 70px; padding-bottom: 70px; font-size: 1.1em !important }
        </style>

    </head>

    <body>

        <div class="panel panel-info" id="vacio">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h5><span style="color: red" class="glyphicon glyphicon-info-sign"></span> No existe una encuesta ACTIVA / EN CURSO </h5>
                    </div>                       
                </div>
            </div>
            <div class="panel-body">
                <div class="row text-center">
                    <div class="col-xs-12">
                        <a href="#" onclick="window.history.back();"> <span class="glyphicon glyphicon-chevron-left"></span> Volver </a>
                    </div>
                </div>
            </div>
        </div>   
        
        <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- ymz Alert -->

        <script src="ymz_box.min.js" type="text/javascript"></script>
            
    </body>
    </html>';
    
}
