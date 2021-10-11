<?php 
	date_default_timezone_set("America/Mexico_City");
	include_once('../libs/CloudWS_DB_Classes.php');
	include_once('../libs/CloudWS_Mobile_Library.php');
	include_once('modal_alta_producto.php');
	if (!empty($_POST['id_perfil'])) {
		//viene del detalle de los perfiles para poder agregar
		/*zonas*/
		$query = "SELECT pk_zon, zon_nombre FROM gv_zona WHERE fk_suc = 1
		order by zon_nombre asc";
		$db->setQuery($query);
		$res_zon = $db->loadObjectList();
		/*tipo de perfiles*/
		$query = "SELECT * FROM gv_perfiles_broker WHERE id_perfil =:id and identificador = 1 and eliminado = 0
		order by id_zona asc";
		$db->setQuery($query);
		$db->bind(":id", $_POST['id_perfil']);
		$query_perfiles = $db->loadObjectList();

		/*tipo de perfiles*/
		$query = "SELECT * FROM gv_perfiles_broker WHERE id_perfil =:id and identificador = 1 and eliminado = 0
		group by id_zona order by id_zona asc";
		$db->setQuery($query);
		$db->bind(":id", $_POST['id_perfil']);
		$query_perfiles_group = $db->loadObjectList();


		$query = "SELECT * FROM gv_generic_catalog_details WHERE IdSimpleCatalog = 48 and Id = :id";
		$db->setQuery($query);
		$db->bind(":id", $_POST['id_perfil']);
		$lista_perfiles_catalago = $db->loadObject();

		//tipo de inmueble 
		$query = "SELECT pk_tip, tip_nombre FROM gv_tipo order by tip_nombre asc";
		$db->setQuery($query);
		$res_tip = $db->loadObjectList();
	}else{
		//viene del detalle del asesor 
		/*zonas*/
		$query = "SELECT pk_zon, zon_nombre FROM gv_zona WHERE fk_suc = 1
		order by zon_nombre asc";
		$db->setQuery($query);
		$res_zon = $db->loadObjectList();
		/*tipo de perfiles*/
		$query = "SELECT * FROM gv_perfiles_broker WHERE id_asesor =:id and identificador = 2 and eliminado = 0
		order by id_zona asc";
		$db->setQuery($query);
		$db->bind(":id", $_POST['id_asesor']);
		$query_perfiles = $db->loadObjectList();

		/*tipo de perfiles en grupo*/
		$query = "SELECT * FROM gv_perfiles_broker WHERE id_asesor =:id and identificador = 2 and eliminado = 0
		group by id_zona order by id_zona asc";
		$db->setQuery($query);
		$db->bind(":id", $_POST['id_asesor']);
		$query_perfiles_group = $db->loadObjectList();

		$query = "SELECT * FROM gv_perfiles_broker WHERE id_asesor =:id and identificador = 2 and eliminado = 0
		group by id_zona order by id_zona asc";
		$db->setQuery($query);
		$db->bind(":id", $_POST['id_asesor']);
		$saber_catalogo = $db->loadObject();

		
		$query = "SELECT * FROM gv_generic_catalog_details WHERE IdSimpleCatalog = 48 and Id = :id";
		$db->setQuery($query);
		$db->bind(":id", $saber_catalogo->id_perfil);
		$lista_perfiles_catalago = $db->loadObject();

		$query = "SELECT * FROM gv_asesor WHERE pk_ase = :id";
		$db->setQuery($query);
		$db->bind(":id", $_POST['id_asesor']);
		$asesor = $db->loadObject();

		//tipo de inmueble 
		$query = "SELECT pk_tip, tip_nombre FROM gv_tipo order by tip_nombre asc";
		$db->setQuery($query);
		$res_tip = $db->loadObjectList();
		
	}
	//rangos de precio de venta 
	$query = "SELECT * FROM gv_generic_catalog_details WHERE IdSimpleCatalog = 51";
	$db->setQuery($query);
	$lista_rangos_venta = $db->loadObjectList();
	//rangos de precio renta
	$query = "SELECT * FROM gv_generic_catalog_details WHERE IdSimpleCatalog = 52";
	$db->setQuery($query);
	$lista_rangos_renta = $db->loadObjectList();
	

 ?>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <?php if(!empty($_POST['id_perfil'])) { ?>
        	<li>
            	<i class="fa fa-home"></i>
            	<a href="javascript:;" onclick="load_conts('perfil_broker/index');">Perfiles Broker</a>
        	</li> /

        	<li>
            	<i class="fa fa-user"></i>
            	<span>Editar Perfil - <?php echo $lista_perfiles_catalago->Name_; ?></span>
        	</li>
        <?php } else { ?>
        	<li>
            	<i class="fa fa-home"></i>
            	<a href="javascript:;" onclick="load_conts('_ase_forma',{'idAse':<?php echo $asesor->pk_ase ?>});" onclick="load_conts('perfil_broker/index');">Regresar al detalle del asesor</a>
        	</li> /
	        <li>
	            <i class="fa fa-user"></i>
	            <span><?php echo $lista_perfiles_catalago->Name_; ?> - <?php echo $asesor->ase_nombre." ".$asesor->ase_apellido  ?></span>
	        </li>
        <?php } ?>

    </ul>
</div>

<div class="">
    <div class="portlet-title">
        <div class="caption">
        	
        </div>
    </div>
    <div class="portlet-body" style="font-size: 1.1em;">
    	<div class="alert messagereponse" role="alert" style="display: none;">
		  <span class="msg">Message alert</span>
		</div>
	  	<div class="row center-block">
	  		<!-- BOTON PARA AGREGAR ZONA--->
	  		<div class="col-md-12 text-right">
	  			<p>
				  <a class="btn btn-primary" onclick="abrilModalPerfil('');">
				    Agregar zona
				  </a>
				</p>
	  		</div><p style="color: transparent;">sdfsd</p>
	    	

				  	
	  		<?php if (!empty($query_perfiles_group)) { foreach ($query_perfiles_group as $key => $group) { $id_zona = !empty($group->id_zona)?$group->id_zona:"''";?>
	  			
	  		
  			<div class="portlet-body col-md-12" style="margin-bottom: 15px; border: 2px solid #ddd; padding: 15px;">
  				<p class="text-right"><button style="margin-bottom: .5em"value="<?php echo $group->id_zona ?>" data-id="<?php echo $group->id ?>" type="button" class="btn btn-primary btn-sm text-right " onclick="abrilModalPerfil(<?=$id_zona?>);"> Agregar producto </button>
  				<button style="margin-bottom: .5em"value="<?php echo $group->id_zona ?>" data-id="<?php echo $group->id ?>" type="button" class="btn btn-danger text-right btn-sm btneliminar"> <span aria-hidden="true">&times;</span></button></p>
  				<p class="bg-blue text-left"style="padding: 5px 20px 5px 20px; font-weight: bold; font-size: 1.5rem;">ZONA</p>
					<?php 

	                    $query = "SELECT pk_zon, zon_nombre FROM gv_zona WHERE fk_suc = 1 and pk_zon = :id  
						order by zon_nombre asc";
						$db->setQuery($query);
						$db->bind(":id", $group->id_zona);
						$nombre_zona = $db->loadObject();

					?>
					   
               		<input type="text" data-campo="id_zona" data-id="<?php echo $group->id ?>" data-id_zona="<?php echo $group->id_zona ?>" placeholder="<?php echo $nombre_zona->zon_nombre?>" name="id_zona" class="form-control campogpo" readOnly="true" value="<?php echo $group->pk_zon ?>">
                        		
                      
              
                
                <p style="color: transparent;">sdfsd</p>
                <div class="table-responsive">
	  				<table class="table detalles table-bordered">
					  	<thead class="bg-blue">
					    	<tr>
					      		
					      		<th scope="col">Producto</th>
					      		<th scope="col"><p style="color: transparent;">productocostoasassas</p></th>
					      		<th scope="col"><p style="color: transparent;">productocostoasassas</p></th>
					      		<th scope="col">VPN V$ <p style="color: transparent;">productocostoasassas</p></th>   
					      		<th scope="col">VPN R$ <p style="color: transparent;">productocostoasassas</p></th>   
					      		<th scope="col">VPN V# <p style="color: transparent;">productocostoasassas</p></th>   
					      		<th scope="col">VPN R# <p style="color: transparent;">productocostoasassas</p></th> 
					      		<th scope="col"></th> 
	 
					    	</tr>
				  		</thead>
					  	<tbody>

					  		<?php foreach($query_perfiles as $key => $lista_zonas) { 
					  			if($lista_zonas->id_zona != $group->id_zona ){
					  				continue;
					  			} 
					  		?>
						    <tr>

						      	<td >
				        			<!-- select para productos -->
				        			<?php 

					                    $query = "SELECT pk_tip, tip_nombre FROM gv_tipo WHERE  pk_tip = :id";
										$db->setQuery($query);
										$db->bind(":id", $lista_zonas->id_tipo_producto);
										$nombre_producto = $db->loadObject();

									?>
									<label class="text-left"><?php echo $nombre_producto->tip_nombre?></label>
									<input type="hidden" id="checktipoinm" name="checktipoinm" class="form-control campo" data-campo="id_tipo_producto" data-id="<?php echo $lista_zonas->id ?>" placeholder="<?php echo $nombre_producto->tip_nombre?>" readOnly="true" value="<?php echo $lista_zonas->id_tipo_producto ?>">
							      	
						      	</td>
						      	<td>
					    			<div class="row">
						      			<div class="form-group">
							        		<div class="col-md-12 text-center">
							            		<label>
							                		<input name="proTransaccion<?php echo $lista_zonas->id?>"
								                	<?php echo $lista_zonas->id_venta == 1 ? "checked" : null; ?>
								                       value="<?php echo $lista_zonas->id_venta?>" type="checkbox" class="campo"
								                       data-id="<?php echo $lista_zonas->id ?>"
								                       data-campo="id_venta">
								                	Venta
								            	</label>&nbsp;&nbsp;&nbsp;&nbsp;
								            	
							        		</div>
						    			</div>
						    			<!-- SELECT PARA LA LISTA DE RANGOS DE PRECIOS-->
						    			<div class="form-group">
						    				<div class="col-md-12">
						    					<select name="rango_select_venta" id="rango_select_venta" class="form-control input-sm select2me" data-id="<?php echo $lista_zonas->id ?>">
								                    <option value="">----- Selecciona Precio -----</option>
								                    <?php foreach ($lista_rangos_venta as $key => $value) { ?>
								                        <option data-desde="<?=$value->Name_?>" data-hasta="<?=$value->Description?>" value="<?=$value->Id?>"> <?=$value->Name_?> -  <?=$value->Description?></option>
								                    <?php } ?>
								                </select>
						    				</div>
						    			</div>
						            	<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 form-group">Desde: 
						                    <div class="input-group">
						                            <span class="input-group-addon">
						                                <strong>$</strong>
						                            </span>
						                        <input name="proPreciode"
						                        	   data-campo="rango_desde_venta"
						                        	   data-id="<?php echo $lista_zonas->id ?>"
						                               class="form-control campo v-precio rango_desde_venta_<?=$lista_zonas->id?>"
						                               maxlength="14"
						                               <?php echo $lista_zonas->id_venta == 1 ? '' : 'disabled = "true"'; ?>
						                               value="<?php echo $lista_zonas->id_venta == 1 ? number_format($lista_zonas->rango_desde_venta) : 0; ?>"
						                        >
						                    </div>
							            </div>
						            	<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 form-group">Hasta:
						                    <div class="input-group">
						                            <span class="input-group-addon">
						                                <strong>$</strong>
						                            </span>
						                        <input name="proPreciohasta"
						                        	   data-campo="rango_hasta_venta"
						                        	   data-id="<?php echo $lista_zonas->id ?>"
						                               class="form-control campo v-precio rango_hasta_venta_<?=$lista_zonas->id?>"
						                               maxlength="14"
						                               <?php echo $lista_zonas->id_venta == 1 ? '' : 'disabled = "true"'; ?>
						                               value="<?php echo $lista_zonas->id_venta == 1 ? number_format($lista_zonas->rango_hasta_venta) : 0; ?>"
						                        >
						                    </div>
							            </div>
						      		
						      		</div>
						     	</td>
						      	<td>
						      		<div class="row">
						      			<div class="col-md-12 text-center">
						      				<label>
							                	<input name="proTransaccion<?php echo $lista_zonas->id?>"
							                	<?php echo $lista_zonas->id_renta == 1 ? "checked" : null; ?>
							                       value="<?php echo $lista_zonas->id_renta?>" type="checkbox" class="campo"
							                       data-id="<?php echo $lista_zonas->id ?>"
							                       data-campo="id_renta">
							                	Renta
							            	</label>
						      			</div>
						      			<!-- SELECT PARA LA LISTA DE RANGOS DE PRECIOS-->
						    			<div class="form-group">
						    				<div class="col-md-12">
						    					<select name="rango_select_renta" id="rango_select_renta" class="form-control input-sm select2me" data-id="<?php echo $lista_zonas->id ?>">
								                    <option value="">----- Selecciona Precio -----</option>
								                    <?php foreach ($lista_rangos_renta as $key => $value) { ?>
								                        <option data-desde="<?=$value->Name_?>" data-hasta="<?=$value->Description?>" value="<?=$value->Id?>"> <?=$value->Name_?> -  <?=$value->Description?></option>
								                    <?php } ?>
								                </select>
						    				</div>
						    			</div>
						            	<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 form-group">Desde: 
						                    <div class="input-group">
						                            <span class="input-group-addon">
						                                <strong>$</strong>
						                            </span>
						                        <input name="proPreciode"
						                        	   data-campo="rango_desde_renta"
						                        	   data-id="<?php echo $lista_zonas->id ?>"
						                               class="form-control campo v-precio rango_desde_renta_<?=$lista_zonas->id?>"
						                               maxlength="14"
						                               <?php echo $lista_zonas->id_renta == 1 ? '' : 'disabled = "true"'; ?>
						                               value="<?php echo $lista_zonas->id_renta == 1 ? number_format($lista_zonas->rango_desde_renta) : 0; ?>"
						                               
						                        >
						                    </div>
							            </div>
						            	<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 form-group">Hasta:
						                    <div class="input-group">
						                            <span class="input-group-addon">
						                                <strong>$</strong>
						                            </span>
						                        <input name="proPreciohasta"
						                        	   data-campo="rango_hasta_renta"
						                        	   data-id="<?php echo $lista_zonas->id ?>"
						                               class="form-control campo v-precio rango_hasta_renta_<?=$lista_zonas->id?>"
						                               maxlength="14"
						                               <?php echo $lista_zonas->id_renta == 1 ? '' : 'disabled = "true"'; ?>
						                               value="<?php echo $lista_zonas->id_renta == 1 ? number_format($lista_zonas->rango_hasta_renta) : 0; ?>"
						                        >
						                    </div>
							            </div>
						      		</div>
						      	</td>
						      	<td>
						      		<label></label>
						      		<div class="input-group">
				                            <span class="input-group-addon">
				                                <strong>$</strong>
				                            </span>
				                        <input name="vpn_precio_venta"
				                        	   data-campo="vpn_precio_venta"
				                        	   data-id="<?php echo $lista_zonas->id ?>"
				                               class="form-control campo v-precio"
				                               maxlength="14"
				                               <?php echo $lista_zonas->id_venta == 1 ? '' : 'disabled = "true"'; ?>
				                               value="<?php echo $lista_zonas->id_venta == 1 ? number_format($lista_zonas->vpn_precio_venta) : 0; ?>"
				                        >
				                    </div>
						      	</td>
						      	<td>
						      			<label></label>

						      		<div class="input-group">
				                            <span class="input-group-addon">
				                                <strong>$</strong>
				                            </span>
				                        <input name="vpn_precio_renta"
				                        	   data-campo="vpn_precio_renta"
				                        	   data-id="<?php echo $lista_zonas->id ?>"
				                               class="form-control campo v-precio"
				                               maxlength="14"
				                               <?php echo $lista_zonas->id_renta == 1 ? '' : 'disabled = "true"'; ?>
				                              value="<?php echo $lista_zonas->id_renta == 1 ? number_format($lista_zonas->vpn_precio_renta) : 0; ?>"
				                        >
				                    </div>
						      	</td>
						      	<td>
						      			<label></label>

						      		<div class="input-group">
				                            <span class="input-group-addon">
				                                <strong>#</strong>
				                            </span>
				                        <input name="vpn_total_venta"
				                        	   data-campo="vpn_total_venta"
				                        	   data-id="<?php echo $lista_zonas->id ?>"
				                               class="form-control campo v-precio"
				                               maxlength="14"
				                         
				                               <?php echo $lista_zonas->id_venta == 1 ? '' : 'disabled = "true"'; ?>
				                               value="<?php echo $lista_zonas->id_venta == 1 ? $lista_zonas->vpn_total_venta : 0; ?>"
				                        >
				                    </div>
						      	</td>
						      	<td>
						      			<label></label>
						      			

						      		<div class="input-group">
				                            <span class="input-group-addon">
				                                <strong>#</strong>
				                            </span>
				                        <input name="vpn_total_renta"
				                        	   data-campo="vpn_total_renta"
				                        	   data-id="<?php echo $lista_zonas->id ?>"
				                               class="form-control campo v-precio"
				                               maxlength="14"
				                               
				                               <?php echo $lista_zonas->id_renta == 1 ? '' : 'disabled = "true"'; ?>
				                               value="<?php echo $lista_zonas->id_renta == 1 ? $lista_zonas->vpn_total_renta : 0; ?>"
				                        >
				                    </div>
						      	</td>
						      	<td>
						      		<button value="<?php echo $lista_zonas->id ?>" type="button" class="btn btn-danger text-right btn-sm btneliminarproducto"> <span aria-hidden="true">&times;</span></button>
						      	</td>
						      	
						    </tr>
					   		<?php } ?>
					  	</tbody>
					</table>
                </div>
  			</div>
  			<?php } }?>
		</div>
    </div>
</div>
<script type="text/javascript">
	$('.select2me').select2();

	jQuery(document).ready(function () 
		{
		    $('.v-precio').priceFormat({
		        clearPrefix: true,
		        prefix: '',
		        centsLimit: 0
		    });

		    $('.v-numeros').numeric();
		    $('.v-numeros1d').numeric({decimalPlaces: 1});
		    $('.v-numeros2d').numeric({decimalPlaces: 2});
	    //        $('.v-numeros2d').inputmask("decimal", { digits: 2 });
	    });
	$( document ).ready(function() {
	    
	    /*EDITAR LOS CAMPOS*/
	    
	    $('.campo').change(function(){
			//
			var input = $(this);
			var campo = $(this).data('campo');
			var id = $(this).data('id');
			var valor = $(this).val();
			if (campo == 'id_venta' || campo == 'id_renta') {
				
				if($(this).val() == 1){
		    		valor = 0 ;
					//$(input).val(0);
		    	}else{
		    		valor = 1 ;
					//$(input).val(1);
		    	}
			}
	        //
	        $.ajax({
		        type: "post",
		        dataType: 'json',
		        url: "perfil_broker/PerfilBrokerController.php",
		        delay:250,
		        data:{
		            op:"editar_campo",
		            campo:campo,
		            valor:valor,
		            id:id,
		            idperfil:$('.idperfil').val()

		        },
		        success: function (result){
		            if(result.requestresult == 'ok'){
		            	
		            	$('.msg').empty().append(result.message);
		            	$('.messagereponse').addClass('alert-info');
		            	
		            	
		            	$('.messagereponse').show();
		            	
		            	//setTimeout($('.messagereponse').hide(),2000);
		 
	                    <?php if(!empty($_POST['id_perfil'])) { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_perfil:<?=$_POST['id_perfil']?>})",1000);
	                    <?php } else { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_asesor:<?=$_POST['id_asesor']?>})",1000);
	                    <?php } ?>
		                
		            }else if(result.requestresult == 'fail'){
		            	$('.msg').empty().append(result.message);
		            	$('.messagereponse').addClass('alert-danger');
		            	$('.messagereponse').show();
	                    <?php if(!empty($_POST['id_perfil'])) { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_perfil:<?=$_POST['id_perfil']?>})",1000);
	                    <?php } else { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_asesor:<?=$_POST['id_asesor']?>})",1000);
	                    <?php } ?>

		            }
		            Metronic.unblockUI();
		        },
		        error:function(){
		            Metronic.unblockUI();
		            alert("OCURRIO UN ERROR");     
		        }
		    }); 
	    });
	    /*Editar para todos la zona */
	    $('.campogpo').change(function(){
			//
			var input = $(this);
			var campo = $(this).data('campo');
			var id = $(this).data('id');
			var id_zona = $(this).data('id_zona');
			var valor = $(this).val();

	        //
	        $.ajax({
		        type: "post",
		        dataType: 'json',
		        url: "perfil_broker/PerfilBrokerController.php",
		        delay:250,
		        data:{
		            op:"editar_campo_grupo",
		            campo:campo,
		            valor:valor,
		            id:id,
		            idperfil:$('.idperfil').val(),
		            id_zona:id_zona

		        },
		        success: function (result){
		            if(result.requestresult == 'ok'){
		            	
		            	$('.msg').empty().append(result.message);
		            	$('.messagereponse').addClass('alert-info');
		            	
		            	
		            	$('.messagereponse').show();
		            	
		            	//setTimeout($('.messagereponse').hide(),2000);
		 
	                    <?php if(!empty($_POST['id_perfil'])) { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_perfil:<?=$_POST['id_perfil']?>})",1000);
	                    <?php } else { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_asesor:<?=$_POST['id_asesor']?>})",1000);
	                    <?php } ?>
		                
		            }else if(result.requestresult == 'fail'){
		            	$('.msg').empty().append(result.message);
		            	$('.messagereponse').addClass('alert-danger');
		            	$('.messagereponse').show();
	                    <?php if(!empty($_POST['id_perfil'])) { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_perfil:<?=$_POST['id_perfil']?>})",1000);
	                    <?php } else { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_asesor:<?=$_POST['id_asesor']?>})",1000);
	                    <?php } ?>

		            }
		            Metronic.unblockUI();
		        },
		        error:function(){
		            Metronic.unblockUI();
		            alert("OCURRIO UN ERROR");     
		        }
		    }); 
	    });
	    $('#rango_select_venta').change(function(){
	    	var desde = $('option:selected', this).data("desde");
	    	var hasta = $('option:selected', this).data("hasta");
	    	var id = $(this).data('id');
	    	$('.rango_desde_venta_'+id).val(desde).change();
	    	$('.rango_hasta_venta_'+id).val(hasta).change();
	    	console.log(desde);
	    	console.log(hasta);
	    	console.log(id);

	    	
	    });
	    $('#rango_select_renta').change(function(){
	    	var desde = $('option:selected', this).data("desde");
	    	var hasta = $('option:selected', this).data("hasta");
	    	var id = $(this).data('id');
	    	$('.rango_desde_renta_'+id).val(desde).change();
	    	$('.rango_hasta_renta_'+id).val(hasta).change();
	    });
	    $('.btneliminar').click(function(){
	        //
	        $.ajax({
		        type: "post",
		        dataType: 'json',
		        url: "perfil_broker/PerfilBrokerController.php",
		        delay:250,
		        data:{
		            op:"eliminar_zona",
		            id_zona:$(this).val()

		        },
		        success: function (result){
		            if(result.requestresult == 'ok'){
		            	
		            	$('.msg').empty().append(result.message);
		            	$('.messagereponse').addClass('alert-info');
		            	
		            	
		            	$('.messagereponse').show();
		            	
		            	//setTimeout($('.messagereponse').hide(),2000);
		 
	                    <?php if(!empty($_POST['id_perfil'])) { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_perfil:<?=$_POST['id_perfil']?>})",1000);
	                    <?php } else { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_asesor:<?=$_POST['id_asesor']?>})",1000);
	                    <?php } ?>
		                
		            }else if(result.requestresult == 'fail'){
		            	$('.msg').empty().append(result.message);
		            	$('.messagereponse').addClass('alert-danger');
		            	$('.messagereponse').show();
	                    <?php if(!empty($_POST['id_perfil'])) { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_perfil:<?=$_POST['id_perfil']?>})",1000);
	                    <?php } else { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_asesor:<?=$_POST['id_asesor']?>})",1000);
	                    <?php } ?>

		            }
		            Metronic.unblockUI();
		        },
		        error:function(){
		            Metronic.unblockUI();
		            alert("OCURRIO UN ERROR");     
		        }
		    }); 
	    });
	    $('.btneliminarproducto').click(function(){
	        //
	        $.ajax({
		        type: "post",
		        dataType: 'json',
		        url: "perfil_broker/PerfilBrokerController.php",
		        delay:250,
		        data:{
		            op:"eliminar_producto",
		            id_producto:$(this).val()

		        },
		        success: function (result){
		            if(result.requestresult == 'ok'){
		            	
		            	$('.msg').empty().append(result.message);
		            	$('.messagereponse').addClass('alert-info');
		            	
		            	
		            	$('.messagereponse').show();
		            	
		            	//setTimeout($('.messagereponse').hide(),2000);
		 
	                    <?php if(!empty($_POST['id_perfil'])) { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_perfil:<?=$_POST['id_perfil']?>})",1000);
	                    <?php } else { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_asesor:<?=$_POST['id_asesor']?>})",1000);
	                    <?php } ?>
		                
		            }else if(result.requestresult == 'fail'){
		            	$('.msg').empty().append(result.message);
		            	$('.messagereponse').addClass('alert-danger');
		            	$('.messagereponse').show();
	                    <?php if(!empty($_POST['id_perfil'])) { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_perfil:<?=$_POST['id_perfil']?>})",1000);
	                    <?php } else { ?>
	                    	setTimeout("load_conts('perfil_broker/detalle_perfil_broker',{id_asesor:<?=$_POST['id_asesor']?>})",1000);
	                    <?php } ?>

		            }
		            Metronic.unblockUI();
		        },
		        error:function(){
		            Metronic.unblockUI();
		            alert("OCURRIO UN ERROR");     
		        }
		    }); 
	    });
	});
</script>
<style type="text/css">
	.agregartable td{
		vertical-align: middle;

	}
	.form-group{
		margin-bottom: 0px!important;
	}
	.detalles td{
		vertical-align: bottom!important;

	}
</style>
