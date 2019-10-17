<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso.');
if (!current_user_can('manage_options'))  {
    wp_die( __('No tienes suficientes permisos para acceder a esta página.') );
} else {
    if ($_GET['action'] == 'edit' && isset($_GET['id'])) {
        $nuevo_edit = "Editar";
        $crear_guardar = "Guardar";
        $cliente = manusoft_bussman_get_proyecto($_GET['id']);
    } else {
        $nuevo_edit = "Nuevo";
        $crear_guardar = "Crear";
    }
    ?>
	<div class="wrap">
		<h1 class="wp-heading-inline">ManuSoft Business Manager - <?php echo $nuevo_edit; ?> proyecto</h1>
        <hr class="wp-header-end">
        <form class="manusoft_bussman_form" action="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_proyectos_page.php&paged=<?php echo $_GET['paged']; ?>" method="post">
        	<?php if ($_GET['action'] == 'edit' && isset($_GET['id'])) { ?>
        		<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
    		<?php } ?>
        	<div id="poststuff">
        		<div id="post-body" class="metabox-holder columns-2">
        			<div id="post-body-content" style="position: relative;">
        				<div id="titlediv">
        					<div id="titlewrap">
        						<input type="text" name="name" size="30" maxlength="100" value="<?php echo $cliente['name']; ?>" placeholder="Nombre del proyecto" id="title" spellcheck="true" autocomplete="off">
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
        										<option value="1">Estado 1</option>
        										<option value="2">Estado 2</option>
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
        										<option value="1">Cliente 1</option>
        										<option value="2">Cliente 2</option>
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