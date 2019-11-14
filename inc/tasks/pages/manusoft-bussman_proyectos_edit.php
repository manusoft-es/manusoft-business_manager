<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso.');
if (!current_user_can('manage_options'))  {
    wp_die( __('No tienes suficientes permisos para acceder a esta página.') );
} else {
    $estados_proyecto = manusoft_bussman_get_estados();
    $clientes = manusoft_bussman_get_id_name_clientes();
    
    if ($_GET['action'] == 'edit' && isset($_GET['proyecto_id'])) {
        $nuevo_edit = "Editar";
        $crear_guardar = "Guardar";
        $proyecto = manusoft_bussman_get_proyecto($_GET['proyecto_id']);
    }
    ?>
	<div class="wrap">
		<h1 class="wp-heading-inline">ManuSoft Business Manager - <?php echo $nuevo_edit; ?> proyecto</h1>
        <hr class="wp-header-end">
        <form class="manusoft_bussman_form" action="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_proyectos_page.php&paged=<?php echo $_GET['paged']; ?>" method="post">
        	<?php if ($_GET['action'] == 'edit' && isset($_GET['proyecto_id'])) { ?>
        		<input type="hidden" name="proyecto_id" value="<?php echo $_GET['proyecto_id']; ?>" />
    		<?php } ?>
        	<div id="poststuff">
        		<div id="post-body" class="metabox-holder columns-2">
        			<div id="post-body-content" style="position: relative;">
        				<div id="titlediv">
        					<div id="titlewrap">
        						<input type="text" name="name" size="30" maxlength="100" value="<?php echo $proyecto['name']; ?>" placeholder="Nombre del proyecto" id="title" spellcheck="true" autocomplete="off">
        					</div>
        				</div><br>
        				<div class="postbox">
                    		<h2>
                    			<span>Datos del proyecto</span>
                    		</h2>
                    		<div class="inside">
								<table class="form-table">
									<tr>
										<th scope="row">
        									<label for="manusoft_bussman_estado">Estado</label>
        								</th>
        								<td>
        									<select name="id_estado">
        								<?php
            								foreach ($estados_proyecto as $estado_proyecto) {
    								    ?>
            								    <option value="<?php echo $estado_proyecto['id']; ?>" <?php if ($proyecto['id_estado'] == $estado_proyecto['id']) { echo "selected"; } ?>><?php echo $estado_proyecto['name']; ?></option>
    								    <?php
            								}
        								?>
        									</select>
        									<span id="manusoft_bussman_estado_messages"></span>
        								</td>
        							</tr>
        							<tr>
        								<th scope="row">
        									<label for="manusoft_bussman_cliente">Cliente</label>
        								</th>
        								<td>
        									<select name="id_cliente">
        								<?php
        								foreach ($clientes as $cliente) {
    								    ?>
            								    <option value="<?php echo $cliente['id']; ?>" <?php if ($proyecto['id_cliente'] == $cliente['id']) { echo "selected"; } ?>><?php echo $cliente['name']; ?></option>
    								    <?php
            								}
        								?>
        									</select>
        									<span id="manusoft_bussman_cliente_messages"></span>
        								</td>
        							</tr>
        						</table>
                    		</div>
                		</div>
        			</div>
                    <div id="postbox-container-1" class="postbox-container">
    					<div id="side-sortables" class="meta-box-sortables ui-sortable fw-force-xs" style="">
    						<div id="submitdiv" class="postbox" style="height:95px;">
    							<h2 class="alumni_lc_hndle ui-sortable-handle"><span><?php echo $crear_guardar; ?> proyeto</span></h2>
    							<div class="inside">
                                	 <div class="alumni_lc_formulario_buttons">
                                		<input type="submit" name="action" id="guardar" class="button button-primary button-large manusoft_bussman_save_buttons" value="Guardar">
                        				<a href="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_proyectos_page.php&paged=<?php echo $_GET['paged']; ?>">
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