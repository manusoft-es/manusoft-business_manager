<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso');

// Método para obtener el total de clientes registrados en el sistema
function manusoft_bussman_count_clientes($search) {
    global $wpdb;
    $sql = "SELECT COUNT(*) FROM ".$wpdb->prefix."manusoft_bussman_clientes WHERE name LIKE '%".$search."%';";
    $res = $wpdb->get_var($sql);
    return $res;
}

// Método para obtener todos los datos de todos los clientes registrados en el sistema
function manusoft_bussman_get_clientes($per_page = 5, $page_number = 1, $order_by, $order, $search) {
    global $wpdb;
    $sql = "SELECT * FROM ".$wpdb->prefix."manusoft_bussman_clientes WHERE name LIKE '%".$search."%' ";
    if ($order_by != "" && $order != "") {
        $sql .= "ORDER BY ".$order_by." ".$order." ";
    }
    $sql .= "LIMIT ".$per_page." "."
            OFFSET ".($page_number-1)*$per_page;
    $res = $wpdb->get_results($sql, "ARRAY_A");
    return $res;
}

// Método para obtener el cliente cuyo ID se pasa como parámetro
function manusoft_bussman_get_cliente($id) {
    global $wpdb;
    $res = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."manusoft_bussman_clientes WHERE id = %d",$id),"ARRAY_A");
    return $res;
}

// Método para comprobar que los datos del cliente son correctos
function manusoft_bussman_check_data_cliente($name,$address,$cif,$email,$phone) {
    $check_data = true;
    $data_error = array();
    $res = array();
    
    if (strlen($name) > 0) {
        $name = sanitize_text_field($name);
    } else {
        $check_data = false;
        array_push($data_error,"name");
    }
    
    if (strlen($address) == 0) {
        $address = NULL;
    } else {
        $address = sanitize_text_field($address);
    }
    
    if (strlen($cif) == 0) {
        $cif = NULL;
    } else if (preg_match('/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/', $cif)) {
        $cif = sanitize_text_field($cif);
    } else if (preg_match('/^(\d{8})([ABCDEFGHJKLMNPQRSTVWXYZ])$/', $cif)) {
        $cif = sanitize_text_field($cif);
    } else {
        $check_data = false;
        array_push($data_error,"cif");
    }
    
    if (strlen($email) == 0) {
        $email = NULL;
    } else if (preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email)) {
        $email = sanitize_text_field($email);
    } else {
        $check_data = false;
        array_push($data_error,"email");
    }
    
    if (strlen($phone) == 0) {
        $phone = NULL;
    } else if (strlen($phone) == 9) {
        $phone = sanitize_text_field($phone);
    } else {
        $check_data = false;
        array_push($data_error,"phone");
    }
    
    array_push($res,$check_data);
    array_push($res,$data_error);
    return $res;
}

// Método para crear un nuevo cliente
function manusoft_bussman_create_cliente($name,$address,$cif,$email,$phone) {
    global $wpdb;
    $check_data = manusoft_bussman_check_data_cliente($name,$address,$cif,$email,$phone);
    if ($check_data[0] === true) {
        $table = $wpdb->prefix.'manusoft_bussman_clientes';
        $data = array(
            'name' => $name,
            'address' => $address,
            'cif' => $cif,
            'email' => $email,
            'phone' => $phone
        );
        $wpdb->insert($table,$data);
        $insert_result = $wpdb->insert_id;
        
        if ($insert_result === false) {
            return false;
        } else {
            return true;
        }
    } else {
        return $check_data[1];
    }
}

// Método para editar un cliente
function manusoft_bussman_edit_cliente($id,$name,$address,$cif,$email,$phone) {
    global $wpdb;
    $check_data = manusoft_bussman_check_data_cliente($name,$address,$cif,$email,$phone);
    if ($check_data[0] === true) {
        $table = $wpdb->prefix.'manusoft_bussman_clientes';
        $data = array(
            'name' => $name,
            'address' => $address,
            'cif' => $cif,
            'email' => $email,
            'phone' => $phone
        );
        $where = array(
            'id' => $id
        );
        $format = array(
            '%s',
            '%s',
            '%s',
            '%s',
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
    } else {
        return $check_data[1];
    }
}

// Método para eliminar un cliente
function manusoft_bussman_delete_cliente($id) {
    global $wpdb;
    $table = $wpdb->prefix.'manusoft_bussman_clientes';
    $res = $wpdb->delete($table, array('id' => $id));
    
    if ($res == 0) {
        return false;
    } else {
        return true;
    }
}
?>