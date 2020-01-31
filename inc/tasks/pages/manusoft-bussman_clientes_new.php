<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso.');
if (!current_user_can('manage_options'))  {
    wp_die( __('No tienes suficientes permisos para acceder a esta página.') );
} else {    
    if ($_GET['action'] == 'edit' && isset($_GET['cliente_id'])) {
        $nuevo_edit = "Editar";
        $crear_guardar = "Guardar";
        $cliente = manusoft_bussman_get_cliente($_GET['cliente_id']);
    } else {
        $nuevo_edit = "Nuevo";
        $crear_guardar = "Crear";
    }
?>
	<div class="wrap">
		<h1 class="wp-heading-inline">ManuSoft Business Manager - <?php echo $nuevo_edit; ?> cliente</h1>
        <hr class="wp-header-end">
        <form class="manusoft_bussman_form" action="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_clientes_page.php&paged=<?php echo $_GET['paged']; ?>" method="post">
        	<?php if ($_GET['action'] == 'edit' && isset($_GET['cliente_id'])) { ?>
        		<input type="hidden" name="cliente_id" value="<?php echo $_GET['cliente_id']; ?>" />
    		<?php } ?>
        	<div id="poststuff">
        		<div id="post-body" class="metabox-holder columns-2">
        			<div id="post-body-content" style="position: relative;">
        				<div id="titlediv">
        					<div id="titlewrap">
        						<input type="text" name="name" size="30" maxlength="100" value="<?php echo $cliente['name']; ?>" placeholder="Nombre del cliente" id="title" spellcheck="true" autocomplete="off">
        					</div>
        				</div><br>
        				<div class="postbox">
                    		<h2>
                    			<span>Datos del cliente</span>
                    		</h2>
                    		<div class="inside">
								<table class="form-table">
									<tr>
										<th scope="row">
        									<label for="manusoft_bussman_address">Dirección</label>
        								</th>
        								<td>
        									<textarea name="address" id="manusoft_bussman_address" rows="3"><?php echo $cliente['address']; ?></textarea>
        									<span id="manusoft_bussman_address_messages"></span>
        								</td>
        							</tr>
        							<tr>
        								<th scope="row">
        									<label for="manusoft_bussman_cif">NIF/CIF</label>
        								</th>
        								<td>
        									<input type="text" id="manusoft_bussman_cif" name="cif" maxlength="9" value="<?php echo $cliente['cif']; ?>" size="9" style="width:auto;" class="regular-text" />
        									<span id="manusoft_bussman_cif_messages"></span>
        								</td>
        							</tr>
        							<tr>
        								<th scope="row">
        									<label for="manusoft_bussman_email">Email</label>
        								</th>
        								<td>
        									<input type="email" id="manusoft_bussman_email" name="email" value="<?php echo $cliente['email']; ?>" class="regular-text ltr" />
        									<span id="manusoft_bussman_email_messages"></span>
        								</td>
        							</tr>
        							<tr>
        								<th scope="row">
        									<label for="manusoft_bussman_phone">Teléfono</label>
        								</th>
        								<td>
        									<input type="text" id="manusoft_bussman_phone" name="phone" maxlength="9" value="<?php echo $cliente['phone']; ?>" size="9" style="width:auto;" class="regular-text" />
        									<span id="manusoft_bussman_phone_messages"></span>
        								</td>
        							</tr>
        						</table>
                    		</div>
                		</div>
        			</div>
                    <div id="postbox-container-1" class="postbox-container">
    					<div id="side-sortables" class="meta-box-sortables ui-sortable fw-force-xs" style="">
    						<div id="submitdiv" class="postbox" style="height:95px;">
    							<h2 class="alumni_lc_hndle ui-sortable-handle"><span><?php echo $crear_guardar; ?> cliente</span></h2>
    							<div class="inside">
                                	 <div class="alumni_lc_formulario_buttons">
                                		<input type="submit" name="action" id="guardar" class="button button-primary button-large manusoft_bussman_save_buttons" value="Guardar">
                        				<a href="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_clientes_page.php&paged=<?php echo $_GET['paged']; ?>">
                        					<input type="button" id="cancelar" class="button button-large manusoft_bussman_save_buttons" value="Cancelar">
                    					</a>
                                	</div>
    							</div>
    						</div>
    					</div>
    				</div>
        		</div>
        	</div>
        </form>
    </div>
<?php
}
?>