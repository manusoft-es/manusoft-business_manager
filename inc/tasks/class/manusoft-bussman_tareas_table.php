<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso');

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
}

class manusoft_bussman_tareas_list_table extends WP_List_Table {
    
    function get_columns() {
        if (isset($_GET['proyecto_id'])) {
            $columns = array (
                'cb' => '<input type="checkbox" />',
                'id' => '<b>#</b>',
                'name' => '<b>Nombre</b>',
                'id_proyecto' => '<b>Proyecto</b>',
                'id_estado' => '<b>Estado</b>',
                'id_prioridad' => '<b>Prioridad</b>',
                'id_tipo' => '<b>Tipo</b>',
                'start_date' => '<b>Fecha de inicio</b>',
                'end_date' => '<b>Fecha de fin</b>',
                'planned_hours' => '<b>Horas planificadas</b>',
                'used_hours' => '<b>Horas realizadas</b>'
            );
        } else {
            $columns = array (
                'id' => '<b>#</b>',
                'name' => '<b>Nombre</b>',
                'id_proyecto' => '<b>Proyecto</b>',
                'id_estado' => '<b>Estado</b>',
                'id_prioridad' => '<b>Prioridad</b>',
                'id_tipo' => '<b>Tipo</b>',
                'start_date' => '<b>Fecha de inicio</b>',
                'end_date' => '<b>Fecha de fin</b>',
                'planned_hours' => '<b>Horas planificadas</b>',
                'used_hours' => '<b>Horas realizadas</b>'
            );
        }
        return $columns;
    }
    
    function get_sortable_columns() {
        $sortable_columns = array(
            'id' => array('id',false),
            'name'  => array('name',false),
            'id_proyecto' => array('id_proyecto',false),
            'id_estado'  => array('id_estado',false),
            'id_prioridad'  => array('id_prioridad',false),
            'id_tipo'  => array('id_tipo',false),
            'start_date'  => array('start_date',false),
            'end_date'  => array('end_date',false),
            'planned_hours'  => array('planned_hours',false),
            'used_hours'  => array('used_hours',false)
        );
        return $sortable_columns;
    }
    
    function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $perPage = 5;
        $currentPage = $this->get_pagenum();
        $count_clientes = manusoft_bussman_count_tareas($_GET['s'], $_GET['proyecto_id']);
        $totalItems  = $count_clientes;
        
        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ));

        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = manusoft_bussman_get_tareas($perPage, $currentPage, $_GET['orderby'], $_GET['order'], $_GET['s'], $_GET['proyecto_id']);
        if (!isset($_GET['proyecto_id'])) {
            $this->process_bulk_action();
        }
        
        $_SERVER['REQUEST_URI'] = remove_query_arg( '_wp_http_referer', $_SERVER['REQUEST_URI'] );
    }
    
    function get_bulk_actions() {
        if (!isset($_GET['proyecto_id'])) {
            $actions = array(
                'delete_all' => 'Eliminar'
            );
        }
        return $actions;
    }
    
    function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        
    }
    
    function column_cb($item) {
        if (!isset($_GET['proyecto_id'])) {
            return sprintf(
                '<input type="checkbox" name="tareas[]" value="%s" />',
                $item['id']
                );
        }
    }
    
    function column_name($item) {
        if (isset($_GET['proyecto_id'])) {
            $actions = array(
                'edit'      => sprintf('<a href="?page=%s&action=%s&tarea_id=%s&proyecto_id=%s&paged=%s">Editar</a>','manusoft-business_manager/inc/tasks/pages/manusoft-bussman_tareas_new.php','edit',$item['id'],$_GET['proyecto_id'],$this->get_pagenum()),
                'delete'    => sprintf('<a href="?page=%s&action=%s&tarea_id=%s&proyecto_id=%s&paged=%s">Eliminar</a>',$_REQUEST['page'],'delete',$item['id'],$_GET['proyecto_id'],$this->get_pagenum()),
            );
        } else {
            $actions = array(
                'edit'      => sprintf('<a href="?page=%s&action=%s&tarea_id=%s&paged=%s">Editar</a>','manusoft-business_manager/inc/tasks/pages/manusoft-bussman_tareas_new.php','edit',$item['id'],$this->get_pagenum()),
                'delete'    => sprintf('<a href="?page=%s&action=%s&tarea_id=%s&paged=%s">Eliminar</a>',$_REQUEST['page'],'delete',$item['id'],$this->get_pagenum()),
            );
        }
        return sprintf('%1$s %2$s', sprintf('<b><a href="?page=%s&action=%s&tarea_id=%s&paged=%s">'.$item['name'].'</a></b>','manusoft-business_manager/inc/tasks/pages/manusoft-bussman_tareas_new.php','edit',$item['id'],$this->get_pagenum()), $this->row_actions($actions) );
        //return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions) );
    }
    
    function column_id_proyecto($item) {
        return sprintf('%1$s', sprintf('<b><a href="?page=%s&proyecto_id=%s&paged=%s">'.manusoft_bussman_get_proyecto_name_tarea($item['id_proyecto']).'</a></b>','manusoft-business_manager/inc/tasks/pages/manusoft-bussman_proyectos_detalle.php',$item['id_proyecto'],$this->get_pagenum()));
    }
    
    function column_default($item,$column_name) {
        switch ($column_name) {
            case 'id_estado':
                return manusoft_bussman_get_estado_name_tarea($item[$column_name]);
            case 'id_prioridad':
                return manusoft_bussman_get_prioridad_name_tarea($item[$column_name]);
            case 'id_tipo':
                return manusoft_bussman_get_tipo_name_tarea($item[$column_name]);
            case 'id':
            case 'name':
            case 'id_proyecto':
            case 'start_date':
            case 'end_date':
            case 'planned_hours':
            case 'used_hours':
                return $item[$column_name];
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }
}
?>