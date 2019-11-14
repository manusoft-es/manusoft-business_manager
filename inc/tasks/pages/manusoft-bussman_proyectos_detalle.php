<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso.');
if (!current_user_can('manage_options'))  {
    wp_die( __('No tienes suficientes permisos para acceder a esta página.') );
} else {
    $proyecto = manusoft_bussman_get_proyecto_detalle($_GET['proyecto_id']);
    $TareasListTable = new manusoft_bussman_tareas_list_table();
    if ($_POST['action'] == "Guardar") {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $id_proyecto = $_GET['proyecto_id'];
        $id_estado = $_POST['id_estado'];
        $id_prioridad = $_POST['id_prioridad'];
        $id_tipo = $_POST['id_tipo'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $planned_hours = $_POST['planned_hours'];
        $used_hours = $_POST['used_hours'];
        if (isset($_POST['tarea_id'])) {
            $id = $_POST['tarea_id'];
            $save_result = manusoft_bussman_edit_tarea($id,$name,$description,$id_proyecto,$id_estado,$id_prioridad,$id_tipo,$start_date,$end_date,$planned_hours,$used_hours);
            if ($save_result) {
                $message_result = "<div class='notice manusoft_bussman_updated'>La tarea se ha modificado correctamente.</div>";
            } else {
                $message_result = "<div class='notice manusoft_bussman_error'>Ha ocurrido un error al modificar la tarea. Inténtalo de nuevo más tarde.</div>";
            }
        } else {
            $save_result = manusoft_bussman_create_tarea($name,$description,$id_proyecto,$id_estado,$id_prioridad,$id_tipo,$start_date,$end_date,$planned_hours,$used_hours);
            if ($save_result) {
                $message_result = "<div class='notice manusoft_bussman_updated'>La tarea se ha creado correctamente.</div>";
            } else {
                $message_result = "<div class='notice manusoft_bussman_error'>Ha ocurrido un error al crear la tarea. Inténtalo de nuevo más tarde.</div>";
            }
        }
    } else if ($_GET['action'] == 'delete') {
        $ids = [];
        array_push($ids,$_GET['tarea_id']);
        $delete_result = manusoft_bussman_delete_tareas($ids);
        if ($delete_result) {
            $message_result = "<div class='notice manusoft_bussman_updated'>La tarea se ha eliminado correctamente.</div>";
        } else {
            $message_result = "<div class='notice manusoft_bussman_error'>Ha ocurrido un error eliminado la tarea. Inténtalo de nuevo más tarde.</div>";
        }
    } else if( 'delete_all' === $TareasListTable->current_action() ) {
        if (isset($_GET['tareas'])) {
            $delete_result = manusoft_bussman_delete_tareas($_GET['tareas']);
            if ($delete_result) {
                $message_result = "<div class='notice manusoft_bussman_updated'>Las tareas se han eliminado correctamente.</div>";
            } else {
                $message_result = "<div class='notice manusoft_bussman_error'>Ha ocurrido un error eliminado las tareas. Inténtalo de nuevo más tarde.</div>";
            }
        } else {
            $message_result = "<div class='notice manusoft_bussman_error'>No has seleccionado ninguna tarea para borrar.</div>";
        }
    }
    $TareasListTable->prepare_items();
?>
<div class="wrap">
	<h1 class="wp-heading-inline">ManuSoft Business Manager</h1>
    <hr class="wp-header-end">
	<div id="poststuff">
		<span><?php if (isset($message_result)) { echo $message_result; } ?></span>
		<div id="post-body" class="metabox-holder columns-1">
			<div id="post-body-content" style="position: relative;">
				<div class="postbox">
            		<div class="inside">
						<table class="form-table">
							<tr>
								<td>
									<h1><b><?php echo $proyecto['name']; ?></b></h1>
									<b>(<?php echo $proyecto['estado']; ?>)</b>
								</td>
								<td>
									<h3><?php echo $proyecto['cliente']; ?></h3>
								</td>
							</tr>
						</table>
            		</div>
        		</div>
			</div>
		</div>
	</div>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-1">
			<div id="post-body-content" style="position: relative;">
				<div class="postbox">
            		<div class="inside">
                		<a href="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_tareas_new.php&proyecto_id=<?php echo $_GET['proyecto_id']; ?>" class="page-title-action">Nueva tarea</a>
                		<form method="get">
                			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                			<?php $TareasListTable->search_box('Buscar', 'search_id'); ?>
                			<?php $TareasListTable->display(); ?>
                        </form>
            		</div>
        		</div>
			</div>
		</div>
	</div>
</div>
<?php
}
?>