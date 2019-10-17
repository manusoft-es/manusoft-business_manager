<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso.');
if (!current_user_can('manage_options'))  {
    wp_die( __('No tienes suficientes permisos para acceder a esta página.') );
} else {
    $ClientesListTable = new manusoft_bussman_clientes_list_table();
    if ($_POST['action'] == "Guardar") {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $cif = $_POST['cif'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $save_result = manusoft_bussman_edit_cliente($id,$name,$address,$cif,$email,$phone);
            if ($save_result) {
                $message_result = "<div class='notice manusoft_bussman_updated'>El cliente se ha modificado correctamente.</div>";
            } else {
                $message_result = "<div class='notice manusoft_bussman_error'>Ha ocurrido un error al modificar el cliente. Inténtalo de nuevo más tarde.</div>";
            }
        } else {
            $save_result = manusoft_bussman_create_cliente($name,$address,$cif,$email,$phone);
            if ($save_result) {
                $message_result = "<div class='notice manusoft_bussman_updated'>El cliente se ha creado correctamente.</div>";
            } else {
                $message_result = "<div class='notice manusoft_bussman_error'>Ha ocurrido un error al crear el cliente. Inténtalo de nuevo más tarde.</div>";
            }
        }
    } else if ($_GET['action'] == 'delete') {
        $ids = [];
        array_push($ids,$_GET['id']);
        $delete_result = manusoft_bussman_delete_cliente($ids);
        if ($delete_result) {
            $message_result = "<div class='notice manusoft_bussman_updated'>El cliente se ha eliminado correctamente.</div>";
        } else {
            $message_result = "<div class='notice manusoft_bussman_error'>Ha ocurrido un error eliminado el cliente. Inténtalo de nuevo más tarde.</div>";
        }
    } else if( 'delete_all' === $ClientesListTable->current_action() ) {
        $delete_result = manusoft_bussman_delete_cliente($_GET['clientes']);
        
        if ($delete_result) {
            $message_result = "<div class='notice manusoft_bussman_updated'>El cliente se ha eliminado correctamente.</div>";
        } else {
            $message_result = "<div class='notice manusoft_bussman_error'>Ha ocurrido un error eliminado el cliente. Inténtalo de nuevo más tarde.</div>";
        }
    }
    $ClientesListTable->prepare_items();
?>
<div class="wrap">
	<h1 class="wp-heading-inline">ManuSoft Business Manager - Clientes</h1>
	<hr class="wp-header-end">
	<div id="poststuff">
		<span><?php if (isset($message_result)) { echo $message_result; } ?></span>
		<a href="admin.php?page=manusoft-business_manager/inc/tasks/pages/manusoft-bussman_clientes_new.php" class="page-title-action">Nuevo cliente</a>
		<form method="get">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php $ClientesListTable->search_box('Buscar', 'search_id'); ?>
			<?php $ClientesListTable->display(); ?>
        </form>
	</div>
</div>
<?php
}
?>