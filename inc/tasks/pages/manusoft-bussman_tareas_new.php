<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso.');
if (!current_user_can('manage_options'))  {
    wp_die( __('No tienes suficientes permisos para acceder a esta página.') );
} else {
    $proyectos = manusoft_bussman_get_proyectos_tarea();
    $estados_tarea = manusoft_bussman_get_estados_tarea();
    $prioridades_tarea = manusoft_bussman_get_prioridades_tarea();
    $tipos_tareas = manusoft_bussman_get_tipos_tarea();
    if ($_GET['action'] == 'edit' && isset($_GET['tarea_id'])) {
        $nuevo_edit = "Editar";
        $crear_guardar = "Guardar";
        $tarea = manusoft_bussman_get_tarea($_GET['tarea_id']);
    } else {
        $nuevo_edit = "Nueva";
        $crear_guardar = "Crear";
    }
?>
	<div class="wrap">
		<h1 class="wp-heading-inline">ManuSoft Business Manager - <?php echo $nuevo_edit; ?> tarea</h1>
        <hr class="wp-header-end">
		<?php
		    if (isset($_GET['proyecto_id'])) {
        ?>
        <form class="manusoft_bussman_form" action="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_proyectos_detalle.php&proyecto_id=<?php echo $_GET['proyecto_id']; ?>&paged=<?php echo $_GET['paged']; ?>" method="post">
        <?php
		    } else {
	    ?>
        <form class="manusoft_bussman_form" action="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_tareas_page.php&paged=<?php echo $_GET['paged']; ?>" method="post">
	    <?php
		    }
	    ?>
        	<?php if ($_GET['action'] == 'edit' && isset($_GET['tarea_id'])) { ?>
        		<input type="hidden" name="tarea_id" value="<?php echo $_GET['tarea_id']; ?>" />
    		<?php } ?>
        	<div id="poststuff">
        		<div id="post-body" class="metabox-holder columns-2">
        			<div id="post-body-content" style="position: relative;">
        				<div id="titlediv">
        					<div id="titlewrap">
        						<input type="text" name="name" size="30" maxlength="100" value="<?php echo $tarea['name']; ?>" placeholder="Nombre de la tarea" id="title" spellcheck="true" autocomplete="off">
        					</div>
        				</div><br>
        				<div class="postbox">
                    		<h2>
                    			<span>Datos de la tarea</span>
                    		</h2>
                    		<div class="inside">
								<table class="form-table">
        							<tr>
        								<th scope="row">
        									<label for="manusoft_bussman_tipo">Tipo</label>
        								</th>
        								<td>
        									<select name="id_tipo">
        								<?php
        								    foreach ($tipos_tareas as $tipo_tarea) {
    								    ?>
            								    <option value="<?php echo $tipo_tarea['id']; ?>" <?php if ($tarea['id_tipo'] == $tipo_tarea['id']) { echo "selected"; } ?>><?php echo $tipo_tarea['name']; ?></option>
    								    <?php
            								}
        								?>
        									</select>
        									<span id="manusoft_bussman_tipo_messages"></span>
        								</td>
        								<th scope="row">
        									<label for="manusoft_bussman_proyecto">Proyecto</label>
        								</th>
        								<td>
        								<?php
        								    if (isset($_GET['proyecto_id'])) {
        								        $proyecto = manusoft_bussman_get_proyecto($_GET['proyecto_id']);
        								        echo $proyecto['name'];
    								        } else {
								        ?>
        									<select name="id_proyecto">
        								<?php
        								        foreach ($proyectos as $proyecto) {
    								    ?>
            								    <option value="<?php echo $proyecto['id']; ?>" <?php if ($tarea['id_estado'] == $proyecto['id']) { echo "selected"; } ?>><?php echo $proyecto['name']; ?></option>
    								    <?php
            								    }
        								?>
        									</select>
        								<?php
    								        }
								        ?>
        									<span id="manusoft_bussman_estado_messages"></span>
        								</td>
        							</tr>
									<tr>
										<th scope="row">
        									<label for="manusoft_bussman_description">Descripción</label>
        								</th>
        								<td colspan="3">
        									<textarea name="description" id="manusoft_bussman_description" rows="5"><?php echo $tarea['description']; ?></textarea>
        									<span id="manusoft_bussman_description_messages"></span>
        								</td>
        							</tr>
        							<tr>
        								<th scope="row">
        									<label for="manusoft_bussman_estado">Estado</label>
        								</th>
        								<td>
        									<select name="id_estado">
        								<?php
        								    foreach ($estados_tarea as $estado_tarea) {
    								    ?>
            								    <option value="<?php echo $estado_tarea['id']; ?>" <?php if ($tarea['id_estado'] == $estado_tarea['id']) { echo "selected"; } ?>><?php echo $estado_tarea['name']; ?></option>
    								    <?php
            								}
        								?>
        									</select>
        									<span id="manusoft_bussman_estado_messages"></span>
        								</td>
        								<th scope="row">
        									<label for="manusoft_bussman_prioridad">Prioridad</label>
        								</th>
        								<td>
        									<select name="id_prioridad">
        								<?php
        								    foreach ($prioridades_tarea as $prioridad_tarea) {
    								    ?>
            								    <option value="<?php echo $prioridad_tarea['id']; ?>" <?php if ($tarea['id_prioridad'] == $prioridad_tarea['id']) { echo "selected"; } ?>><?php echo $prioridad_tarea['name']; ?></option>
    								    <?php
            								}
        								?>
        									</select>
        									<span id="manusoft_bussman_prioridad_messages"></span>
        								</td>
        							</tr>
        							<tr>
        								<th scope="row">
        									<label for="manusoft_bussman_start_date">Fecha de inicio</label>
        								</th>
        								<td>
        									<input type="date" id="manusoft_bussman_start_date" name="start_date" value="<?php echo $tarea['start_date']; ?>" style="width:auto;" class="regular-text" />
        								</td>
        								<th scope="row">
        									<label for="manusoft_bussman_end_date">Fecha de fin</label>
        								</th>
        								<td>
        									<input type="date" id="manusoft_bussman_end_date" name="end_date" value="<?php echo $tarea['end_date']; ?>" style="width:auto;" class="regular-text" />
        								</td>
        							</tr>
        							<tr>
        								<th scope="row">
        									<label for="manusoft_bussman_planned_hours">Horas planificadas</label>
        								</th>
        								<td>
        									<input type="number" id="manusoft_bussman_planned_hours" name="planned_hours" min="0" step="0.5" value="<?php echo $tarea['planned_hours']; ?>" style="width:auto;" class="regular-text" />
        								</td>
        								<th scope="row">
        									<label for="manusoft_bussman_used_hours">Horas empleadas</label>
        								</th>
        								<td>
        									<input type="number" id="manusoft_bussman_used_hours" name="used_hours" min="0" step="0.5" value="<?php echo $tarea['used_hours']; ?>" style="width:auto;" class="regular-text" />
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
        								<?php
        								    if (isset($_GET['proyecto_id'])) {
								        ?>
								        	<a href="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_proyectos_detalle.php&proyecto_id=<?php echo $_GET['proyecto_id']; ?>&paged=<?php echo $_GET['paged']; ?>">
							        	<?php
        								    } else {
    								    ?>
                    				        <a href="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_tareas_page.php&paged=<?php echo $_GET['paged']; ?>">
                				        <?php
        								    }
                				        ?>
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