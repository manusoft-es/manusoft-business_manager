<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso.');
if (!current_user_can('manage_options'))  {
    wp_die( __('No tienes suficientes permisos para acceder a esta página.') );
} else {
    $cliente = manusoft_bussman_get_cliente($_GET['cliente_id']);
    $ProyectosListTable = new manusoft_bussman_proyectos_list_table();
    $TareasListTable = new manusoft_bussman_tareas_list_table();
    
    $ProyectosListTable->prepare_items();
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
								<td colspan="2">
									<h1><b><?php echo $cliente['name']; ?></b></h1>
								</td>
							</tr>
							<tr>
								<td>
									<b>CIF:</b> <?php echo $cliente['cif']?>
								</td>
								<td>
									<b>Dirección:</b> <?php echo $cliente['address']?>
								</td>
							</tr>
							<tr>
								<td>
									<b>Email:</b> <?php echo $cliente['email']?>
								</td>
								<td>
									<b>Teléfono:</b> <?php echo $cliente['phone']?>
								</td>
							</tr>
						</table>
            		</div>
        		</div>
			</div>
		</div>
	</div>
	<h3>Proyectos</h3>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-1">
			<div id="post-body-content" style="position: relative;">
				<div class="postbox">
            		<div class="inside">
                		<form method="get">
                			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                			<?php $ProyectosListTable->display(); ?>
                        </form>
            		</div>
        		</div>
			</div>
		</div>
	</div>
	<h3>Tareas</h3>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-1">
			<div id="post-body-content" style="position: relative;">
				<div class="postbox">
            		<div class="inside">
                		<form method="get">
                			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
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