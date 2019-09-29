<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso');

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
}

class manusoft_bussman_clientes_list_table extends WP_List_Table {
    
    function get_columns() {
        $columns = array (
            'ID' => '<b>#</b>',
            'name' => '<b>Nombre</b>',
            'address' => '<b>Direccion</b>',
            'cif' => '<b>CIF/DNI</b>',
            'email' => '<b>Correo electrónico</b>',
            'phone' => '<b>Teléfono</b>'
        );
        return $columns;
    }
    
    function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $perPage = 5;
        $currentPage = $this->get_pagenum();
        $count_clientes = wp_count_posts('wpcf7_contact_form');
        $totalItems  = $count_clientes->publish;
        
        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ));

        $sortable = array();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = manusoft_cf2pdf_get_all_forms($perPage, $currentPage);
    }
    
    function column_default($item,$column_name) {
        switch ($column_name) {
            case 'manusoft_cf2pdf_form_name':
                return '<b><a href="?id='.$item['id'].'&page=manusoft-cf2pdf/inc/manusoft_cf2pdf_data_page.php">'.$item['name'].'</a></b>';
            case 'manusoft_cf2pdf_form_total':
                return $item['total'];
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }
}
?>