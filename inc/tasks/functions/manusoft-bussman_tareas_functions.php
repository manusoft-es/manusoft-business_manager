<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso');

// Método para obtener el total de tareas registradas en el sistema
function manusoft_bussman_count_tareas($search = "", $project_id = "") {
    global $wpdb;
    $sql = "SELECT COUNT(*) FROM ".$wpdb->prefix."manusoft_bussman_tareas WHERE name LIKE '%".$search."%'";
    if ($project_id != "") {
        $sql .= "WHERE id_proyecto = ".$project_id.";";
    } else {
        $sql .= ";";
    }
    $res = $wpdb->get_var($sql);
    return $res;
}

// Método para obtener todos los datos de todos los tareas registradas en el sistema
function manusoft_bussman_get_tareas($per_page = 5, $page_number = 1, $order_by, $order, $search, $project_id = "") {
    global $wpdb;
    $sql = "SELECT * FROM ".$wpdb->prefix."manusoft_bussman_tareas WHERE name LIKE '%".$search."%' ";
    if ($project_id != "") {
        $sql .= "AND id_proyecto = ".$project_id." ";
    }
    if ($order_by != "" && $order != "") {
        $sql .= "ORDER BY ".$order_by." ".$order." ";
    }
    $sql .= "LIMIT ".$per_page." "."
            OFFSET ".($page_number-1)*$per_page;
    $res = $wpdb->get_results($sql, "ARRAY_A");
    return $res;
}

function manusoft_bussman_get_tarea($id) {
    global $wpdb;
    $sql = "SELECT * FROM ".$wpdb->prefix."manusoft_bussman_tareas WHERE id = ".$id.";";
    $res = $wpdb->get_row($sql, "ARRAY_A");
    return $res;
}

// Método para obtener los proyectos del sistema
function manusoft_bussman_get_proyectos_tarea() {
    global $wpdb;
    $sql = "SELECT * FROM ".$wpdb->prefix."manusoft_bussman_proyectos";
    $res = $wpdb->get_results($sql,"ARRAY_A");
    return $res;
}

// Método para obtener el nombre del proyecto cuyo ID se pasa como parámetro
function manusoft_bussman_get_proyecto_name_tarea($id) {
    global $wpdb;
    $sql = "SELECT name FROM ".$wpdb->prefix."manusoft_bussman_proyectos WHERE id = ".$id.";";
    $res = $wpdb->get_var($sql);
    return $res;
}

// Método para obtener los estados de tarea
function manusoft_bussman_get_estados_tarea() {
    global $wpdb;
    $sql = "SELECT * FROM ".$wpdb->prefix."manusoft_bussman_estados_tarea";
    $res = $wpdb->get_results($sql,"ARRAY_A");
    return $res;
}

// Método para obtener el nombre del estado de tarea cuyo ID se pasa como parámetro
function manusoft_bussman_get_estado_name_tarea($id) {
    global $wpdb;
    $sql = "SELECT name FROM ".$wpdb->prefix."manusoft_bussman_estados_tarea WHERE id = ".$id.";";
    $res = $wpdb->get_var($sql);
    return $res;
}

// Método para obtener las prioridades de tarea
function manusoft_bussman_get_prioridades_tarea() {
    global $wpdb;
    $sql = "SELECT * FROM ".$wpdb->prefix."manusoft_bussman_prioridades_tarea";
    $res = $wpdb->get_results($sql,"ARRAY_A");
    return $res;
}

// Método para obtener el nombre de la prioridad de tarea cuyo ID se pasa como parámetro
function manusoft_bussman_get_prioridad_name_tarea($id) {
    global $wpdb;
    $sql = "SELECT name FROM ".$wpdb->prefix."manusoft_bussman_prioridades_tarea WHERE id = ".$id.";";
    $res = $wpdb->get_var($sql);
    return $res;
}

// Método para obtener los tipos de tarea
function manusoft_bussman_get_tipos_tarea() {
    global $wpdb;
    $sql = "SELECT * FROM ".$wpdb->prefix."manusoft_bussman_tipos_tarea";
    $res = $wpdb->get_results($sql,"ARRAY_A");
    return $res;
}

// Método para obtener el nombre del tipo de tarea cuyo ID se pasa como parámetro
function manusoft_bussman_get_tipo_name_tarea($id) {
    global $wpdb;
    $sql = "SELECT name FROM ".$wpdb->prefix."manusoft_bussman_tipos_tarea WHERE id = ".$id.";";
    $res = $wpdb->get_var($sql);
    return $res;
}

// Método para crear una nueva tarea
function manusoft_bussman_create_tarea($name,$description,$id_proyecto,$id_estado,$id_prioridad,$id_tipo,$start_date,$end_date,$planned_hours,$used_hours) {
    global $wpdb;
    $table = $wpdb->prefix.'manusoft_bussman_tareas';
    $data = array(
        'name' => $name,
        'description' => $description,
        'id_proyecto' => $id_proyecto,
        'id_estado' => $id_estado,
        'id_prioridad' => $id_prioridad,
        'id_tipo' => $id_tipo,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'planned_hours' => $planned_hours,
        'used_hours' => $used_hours
    );
    $wpdb->insert($table,$data);
    $insert_result = $wpdb->insert_id;
    
    if ($insert_result === false) {
        return false;
    } else {
        return true;
    }
}

// Método para editar una tarea
function manusoft_bussman_edit_tarea($id,$name,$description,$id_proyecto,$id_estado,$id_prioridad,$id_tipo,$start_date,$end_date,$planned_hours,$used_hours) {
    global $wpdb;
    $table = $wpdb->prefix.'manusoft_bussman_tareas';
    $data = array(
        'name' => $name,
        'description' => $description,
        'id_proyecto' => $id_proyecto,
        'id_estado' => $id_estado,
        'id_prioridad' => $id_prioridad,
        'id_tipo' => $id_tipo,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'planned_hours' => $planned_hours,
        'used_hours' => $used_hours
    );
    $where = array(
        'id' => $id
    );
    $format = array(
        '%s',
        '%s',
        '%d',
        '%d',
        '%d',
        '%s',
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

// Método para eliminar una o varias tareas
function manusoft_bussman_delete_tareas($ids) {
    global $wpdb;
    $table = $wpdb->prefix.'manusoft_bussman_tareas';
    $res = $wpdb->query("DELETE FROM ".$table." WHERE id IN (".implode(",",$ids).")");
    
    if ($res == 0) {
        return false;
    } else {
        return true;
    }
}
?>