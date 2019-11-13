<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso.');
if (!current_user_can('manage_options'))  {
    wp_die( __('No tienes suficientes permisos para acceder a esta página.') );
} else {
    $proyecto = manusoft_bussman_get_proyecto_detalle($_GET['id']);
    $TareasListTable = new manusoft_bussman_tareas_list_table();
    $TareasListTable->prepare_items();
?>
<div class="wrap">
	<h1 class="wp-heading-inline">ManuSoft Business Manager</h1>
    <hr class="wp-header-end">
	<div id="poststuff">
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
                		<a href="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_tareas_new.php" class="page-title-action">Nueva tarea</a>
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