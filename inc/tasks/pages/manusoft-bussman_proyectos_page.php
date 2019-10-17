<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso.');
if (!current_user_can('manage_options'))  {
    wp_die( __('No tienes suficientes permisos para acceder a esta página.') );
} else {
    $ProyectosListTable = new manusoft_bussman_proyectos_list_table();
    $ProyectosListTable->prepare_items();
?>
<div class="wrap">
	<h1 class="wp-heading-inline">ManuSoft Business Manager - Proyectos</h1>
	<hr class="wp-header-end">
	<span><?php if (isset($message_result)) { echo $message_result; } ?></span>
	<form class="manusoft_bussman_form" action="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_proyectos_page.php&paged=<?php echo $_GET['paged']; ?>" method="post">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-1">
				<div id="post-body-content" style="position: relative;">
					<div class="postbox">
						<h2><span>Nuevo proyecto</span></h2>
						<div class="inside">
							<input type="text" name="name" placeholder="Nombre del proyecto" />
							<select name="id_estado">
								<option value="NULL" disabled selected>Estado del proyecto</option>
								<option value="1">Estado 1</option>
								<option value="2">Estado 2</option>
							</select>
							<select name="id_cliente">
								<option value="NULL" disabled selected>Cliente del proyecto</option>
								<option value="1">Cliente 1</option>
								<option value="2">Cliente 2</option>
							</select>
                		</div>
            		</div>
				</div>
			</div>
		</div>
	</form>
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