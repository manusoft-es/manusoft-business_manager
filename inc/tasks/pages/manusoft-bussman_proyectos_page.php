<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso.');
if (!current_user_can('manage_options'))  {
    wp_die( __('No tienes suficientes permisos para acceder a esta página.') );
} else {
    $ProyectosListTable = new manusoft_bussman_proyectos_list_table();
    
    if (isset($_POST['action']) && $_POST['action'] == "Guardar") {
        if (isset($_POST['name']) && isset($_POST['id_estado']) && isset($_POST['id_cliente'])) {
            $create_result = manusoft_bussman_create_proyecto($_POST['name'],$_POST['id_cliente'],$_POST['id_estado']);
            if ($create_result) {
                $message_result = "<div class='notice manusoft_bussman_updated'>El proyecto se ha creado correctamente.</div>";
            } else {
                $message_result = "<div class='notice manusoft_bussman_error'>Ha ocurrido un error al crear el proyecto. Inténtalo de nuevo más tarde.</div>";
            }
        } else {
            $message_result = "<div class='notice manusoft_bussman_error'>Tienes que rellenar todos los campos.</div>";
        }
    } else if (isset($_GET['action']) && $_GET['action'] == "delete") {
        if (isset($_GET['id'])) {
            $ids = [];
            array_push($ids,$_GET['id']);
            $delete_result = manusoft_bussman_delete_proyecto($ids);
            if ($delete_result) {
                $message_result = "<div class='notice manusoft_bussman_updated'>El proyecto se ha eliminado correctamente.</div>";
            } else {
                $message_result = "<div class='notice manusoft_bussman_error'>Ha ocurrido un error al eliminar el proyecto. Inténtalo de nuevo más tarde.</div>";
            }
        } else {
            $message_result = "<div class='notice manusoft_bussman_error'>No has seleccionado ningún proyecto para borrar.</div>";
        }
    } else if( $ProyectosListTable->current_action() === 'delete_all' ) {
        if (isset($_GET['proyectos'])) {
            $delete_result = manusoft_bussman_delete_proyecto($_GET['proyectos']);
            
            if ($delete_result) {
                $message_result = "<div class='notice manusoft_bussman_updated'>El proyecto se ha eliminado correctamente.</div>";
            } else {
                $message_result = "<div class='notice manusoft_bussman_error'>Ha ocurrido un error al eliminar el proyecto. Inténtalo de nuevo más tarde.</div>";
            }
        } else {
            $message_result = "<div class='notice manusoft_bussman_error'>No has seleccionado ningún proyecto para borrar.</div>";
        }
    }
    
    $estados_proyecto = manusoft_bussman_get_estados();
    $clientes = manusoft_bussman_get_id_name_clientes();
    
    $ProyectosListTable->prepare_items();
?>
<div class="wrap">
	<h1 class="wp-heading-inline">ManuSoft Business Manager - Proyectos</h1>
	<hr class="wp-header-end">
	<div id="poststuff">
		<span><?php if (isset($message_result)) { echo $message_result; } ?></span>
		<div id="post-body" class="metabox-holder columns-1">
			<div id="post-body-content" style="position: relative;">
				<div class="postbox">
					<h2><span>Nuevo proyecto</span></h2>
					<div class="inside">
						<form class="manusoft_bussman_form" action="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_proyectos_page.php&paged=<?php echo $_GET['paged']; ?>" method="post">
							<table>
								<tbody>
									<tr>
										<td>
											<input type="text" name="name" placeholder="Nombre del proyecto" />
										</td>
										<td>
                							<select name="id_estado">
                								<option value="NULL" disabled selected>Estado del proyecto</option>
        								<?php
            								foreach ($estados_proyecto as $estado_proyecto) {
    								    ?>
            								    <option value="<?php echo $estado_proyecto['id']; ?>"><?php echo $estado_proyecto['name']; ?></option>
    								    <?php
            								}
        								?>
                							</select>
										</td>
										<td>
											<select name="id_cliente">
                								<option value="NULL" disabled selected>Cliente del proyecto</option>
        								<?php
        								foreach ($clientes as $cliente) {
    								    ?>
            								    <option value="<?php echo $cliente['id']; ?>"><?php echo $cliente['name']; ?></option>
    								    <?php
            								}
        								?>
                							</select>
										</td>
										<td>
											<input type="submit" name="action" id="guardar" class="button button-primary button-large manusoft_bussman_save_buttons" value="Guardar">
										</td>
									</tr>
								</tbody>
							</table>
						</form>
            		</div>
        		</div>
			</div>
		</div>
	</div>
	<div id="poststuff">
		<form method="get">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php $ProyectosListTable->search_box('Buscar', 'search_id'); ?>
			<?php $ProyectosListTable->display(); ?>
        </form>
	</div>
</div>
<?php
}
?>