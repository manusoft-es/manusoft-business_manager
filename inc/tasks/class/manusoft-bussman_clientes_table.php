<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso');

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
}

class manusoft_bussman_clientes_list_table extends WP_List_Table {
    
    function get_columns() {
        $columns = array (
            'cb' => '<input type="checkbox" />',
            'id' => '<b>#</b>',
            'name' => '<b>Nombre</b>',
            'address' => '<b>Direccion</b>',
            'cif' => '<b>CIF/DNI</b>',
            'email' => '<b>Correo electrónico</b>',
            'phone' => '<b>Teléfono</b>'
        );
        return $columns;
    }
    
    function get_sortable_columns() {
        $sortable_columns = array(
            'id' => array('id',false),
            'name'  => array('name',false)
        );
        return $sortable_columns;
    }
    
    function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $perPage = 5;
        $currentPage = $this->get_pagenum();
        $count_clientes = manusoft_bussman_count_clientes($_GET['s']);
        $totalItems  = $count_clientes;
        
        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ));

        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = manusoft_bussman_get_clientes($perPage, $currentPage, $_GET['orderby'], $_GET['order'], $_GET['s']);
        $this->process_bulk_action();
        
        $_SERVER['REQUEST_URI'] = remove_query_arg( '_wp_http_referer', $_SERVER['REQUEST_URI'] );
    }
    
    function get_bulk_actions() {
        $actions = array(
            'delete_all' => 'Eliminar'
        );
        return $actions;
    }
    
    function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        
    }
    
    function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="clientes[]" value="%s" />',
            $item['id']
            );
    }
    
    function column_name($item) {
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&cliente_id=%s&paged=%s">Editar</a>','manusoft-business_manager/inc/tasks/pages/manusoft-bussman_clientes_new.php','edit',$item['id'],$this->get_pagenum()),
            'delete'    => sprintf('<a href="?page=%s&action=%s&cliente_id=%s&paged=%s">Eliminar</a>',$_REQUEST['page'],'delete',$item['id'],$this->get_pagenum()),
        );
        return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions) );
    }
    
    function column_default($item,$column_name) {
        switch ($column_name) {
            case 'id':
            case 'name':
            case 'address':
            case 'cif':
            case 'email':
            case 'phone':
                return $item[$column_name];
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }
}
?>