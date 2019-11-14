<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso');

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
}

class manusoft_bussman_proyectos_list_table extends WP_List_Table {
    
    function get_columns() {
        $columns = array (
            'cb' => '<input type="checkbox" />',
            'id' => '<b>#</b>',
            'name' => '<b>Nombre</b>',
            'estado' => '<b>Estado</b>',
            'cliente' => '<b>Cliente</b>'
        );
        return $columns;
    }
    
    function get_sortable_columns() {
        $sortable_columns = array(
            'id' => array('id',false),
            'name'  => array('name',false),
            'estado'  => array('estado',false),
            'cliente'  => array('cliente',false)
        );
        return $sortable_columns;
    }
    
    function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $perPage = 5;
        $currentPage = $this->get_pagenum();
        $count_proyectos = manusoft_bussman_count_proyectos($_GET['s']);
        $totalItems  = $count_proyectos;
        
        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ));

        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = manusoft_bussman_get_proyectos($perPage, $currentPage, $_GET['orderby'], $_GET['order'], $_GET['s']);
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
            '<input type="checkbox" name="proyectos[]" value="%s" />',
            $item['id']
            );
    }
    
    function column_name($item) {
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&proyecto_id=%s&paged=%s">Editar</a>','manusoft-business_manager/inc/tasks/pages/manusoft-bussman_proyectos_edit.php','edit',$item['id'],$this->get_pagenum()),
            'delete'    => sprintf('<a href="?page=%s&action=%s&proyecto_id=%s&paged=%s">Eliminar</a>',$_REQUEST['page'],'delete',$item['id'],$this->get_pagenum()),
        );
        return sprintf('%1$s %2$s', sprintf('<b><a href="?page=%s&proyecto_id=%s&paged=%s">'.$item['name'].'</a></b>','manusoft-business_manager/inc/tasks/pages/manusoft-bussman_proyectos_detalle.php',$item['id'],$this->get_pagenum()), $this->row_actions($actions) );
    }
    
    function column_default($item,$column_name) {
        switch ($column_name) {
            case 'id':
            case 'name':
            case 'estado':
            case 'cliente':
                return $item[$column_name];
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }
}
?>