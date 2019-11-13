<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso');

// Método para obtener el total de proyectos registrados en el sistema
function manusoft_bussman_count_proyectos($search = "") {
    global $wpdb;
    $sql = "SELECT COUNT(1)
            FROM ".$wpdb->prefix."manusoft_bussman_proyectos p
            INNER JOIN ".$wpdb->prefix."manusoft_bussman_clientes c ON (c.id = p.id_cliente)
            INNER JOIN ".$wpdb->prefix."manusoft_bussman_estados_proyecto ep ON (ep.id = p.id_estado)
            WHERE p.name LIKE '%".$search."%' OR c.name LIKE '%".$search."%' OR ep.name LIKE '%".$search."%'";
    $res = $wpdb->get_var($sql);
    return $res;
}

// Método para obtener todos los datos de todos los proyectos registrados en el sistema
function manusoft_bussman_get_proyectos($per_page = 5, $page_number = 1, $order_by, $order, $search) {
    global $wpdb;
    $sql = "SELECT p.id AS id, p.name AS name, ep.name AS estado, c.name AS cliente
            FROM ".$wpdb->prefix."manusoft_bussman_proyectos p
            INNER JOIN ".$wpdb->prefix."manusoft_bussman_clientes c ON (c.id = p.id_cliente)
            INNER JOIN ".$wpdb->prefix."manusoft_bussman_estados_proyecto ep ON (ep.id = p.id_estado)
            WHERE p.name LIKE '%".$search."%' OR c.name LIKE '%".$search."%' OR ep.name LIKE '%".$search."%' ";
    if ($order_by != "" && $order != "") {
        $sql .= "ORDER BY ".$order_by." ".$order." ";
    }
    $sql .= "LIMIT ".$per_page." "."
            OFFSET ".($page_number-1)*$per_page;
    $res = $wpdb->get_results($sql, "ARRAY_A");
    return $res;
}

// Método para obtener el proyecto cuyo ID se pasa como parámetro
function manusoft_bussman_get_proyecto($id) {
    global $wpdb;
    $res = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."manusoft_bussman_proyectos WHERE id = %d",$id),"ARRAY_A");
    return $res;
}

// Método para obtener el proyecto cuyo ID se pasa como parámetro
function manusoft_bussman_get_proyecto_detalle($id) {
    global $wpdb;
    $sql = "SELECT
                p.name AS name,
                c.name AS cliente,
                ep.name AS estado
            FROM ".$wpdb->prefix."manusoft_bussman_proyectos p
            INNER JOIN ".$wpdb->prefix."manusoft_bussman_clientes c ON (c.id = p.id_cliente)
            INNER JOIN ".$wpdb->prefix."manusoft_bussman_estados_proyecto ep ON (ep.id = p.id_estado)
            WHERE p.id = %d";
    $res = $wpdb->get_row($wpdb->prepare($sql,$id),"ARRAY_A");
    return $res;
}

// Método para obtener los estados de proyecto
function manusoft_bussman_get_estados() {
    global $wpdb;
    $sql = "SELECT * FROM ".$wpdb->prefix."manusoft_bussman_estados_proyecto";
    $res = $wpdb->get_results($sql,"ARRAY_A");
    return $res;
}

// Método para crear un proyecto
function manusoft_bussman_create_proyecto($name, $id_cliente, $id_estado) {
    global $wpdb;
    $table = $wpdb->prefix.'manusoft_bussman_proyectos';
    $data = array(
        'name' => $name,
        'id_cliente' => $id_cliente,
        'id_estado' => $id_estado
    );
    $wpdb->insert($table,$data);
    $insert_result = $wpdb->insert_id;

    if ($insert_result === false) {
        return false;
    } else {
        return true;
    }
}

// Método para editar un proyecto
function manusoft_bussman_edit_proyecto($id, $name, $id_cliente, $id_estado) {
    global $wpdb;
    $table = $wpdb->prefix.'manusoft_bussman_proyectos';
    $data = array(
        'name' => $name,
        'id_cliente' => $id_cliente,
        'id_estado' => $id_estado
    );
    $where = array(
        'id' => $id
    );
    $format = array(
        '%s',
        '%d',
        '%d'
    );
    $where_format = array(
        '%d'
    );
    $update_result = $wpdb->update($table,$data,$where,$format,$where_format);
    
    if ($update_result === false) {
        return false;
    } else {
        return true;
    }
}

function manusoft_bussman_delete_proyecto($ids) {
    global $wpdb;
    $table = $wpdb->prefix.'manusoft_bussman_proyectos';
    $res = $wpdb->query("DELETE FROM ".$table." WHERE id IN (".implode(",",$ids).")");

    if ($res == 0) {
        return false;
    } else {
        return true;
    }
}

?>