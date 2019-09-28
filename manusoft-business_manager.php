<?php
/*
 Plugin Name: ManuSoft - Business Manager
 Plugin URI: https://github.com/manusoft-es/manusoft-business_manager/tree/dev
 Description: Plugin para la gestión de negocios en WordPress
 Version: 1.0
 Author: ManuSoft.es
 Author URI: https://www.manusoft.es
 */
defined('ABSPATH') or die('No tienes permiso para hacer eso.');

// Método a ejecutar al activar el plugin
register_activation_hook( __FILE__, 'manusoft_bussman_activation' );
function manusoft_bussman_activation() {
    manusoft_bussman_create_table_config();
    manusoft_bussman_create_table_clientes();
    manusoft_bussman_create_table_estados_proyecto();
    manusoft_bussman_create_table_proyectos();
    manusoft_bussman_create_table_tipos_tarea();
    manusoft_bussman_create_table_estados_tarea();
    manusoft_bussman_create_table_prioridades_tarea();
    //manusoft_bussman_create_table_tareas();
    manusoft_bussman_create_table_comentarios_tarea();
    //manusoft_bussman_create_table_productos();
    //manusoft_bussman_create_table_presupuestos();
    //manusoft_bussman_create_table_facturas();
}

// Método a ejecutar al desactivar el plugin
register_deactivation_hook( __FILE__, 'manusoft_bussman_desactivation' );
function manusoft_bussman_desactivation() {
    manusoft_bussman_delete_table_config();
    manusoft_bussman_delete_table_comentarios_tarea();
    //manusoft_bussman_delete_table_tareas();
    manusoft_bussman_delete_table_prioridades_tarea();
    manusoft_bussman_delete_table_estados_tarea();
    manusoft_bussman_delete_table_tipos_tarea();
    manusoft_bussman_delete_table_proyectos();
    manusoft_bussman_delete_table_estados_proyecto();
    manusoft_bussman_delete_table_clientes();
    //manusoft_bussman_delete_table_productos();
    //manusoft_bussman_delete_table_presupuestos();
    //manusoft_bussman_delete_table_facturas();
}

// Creación de la tabla CONFIG
function manusoft_bussman_create_table_config() {
    global $wpdb;
    $sql = "CREATE TABLE `".$wpdb->prefix."manusoft_bussman_config` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name` varchar(255) COLLATE 'utf8_spanish_ci' NOT NULL,
                `address` text COLLATE 'utf8_spanish_ci' DEFAULT NULL,
                `cif` varchar(9) COLLATE 'utf8_spanish_ci' DEFAULT NULL,
                `email` varchar(255) COLLATE 'utf8_spanish_ci' DEFAULT NULL,
                `phone` int(9) unsigned DEFAULT NULL,
                `web` varchar(255) COLLATE 'utf8_spanish_ci' DEFAULT NULL,
                `iban` varchar(24) COLLATE 'utf8_spanish_ci' DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;";
    require_once( ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
}

// Creación de la tabla CLIENTES
function manusoft_bussman_create_table_clientes() {
    global $wpdb;
    $sql = "CREATE TABLE `".$wpdb->prefix."manusoft_bussman_clientes` (
                `ID` bigint(20) unsigned NOT NULL,
                `name` varchar(255) COLLATE 'utf8_spanish_ci' NOT NULL,
                `address` text COLLATE 'utf8_spanish_ci' NULL,
                `cif` varchar(9) COLLATE 'utf8_spanish_ci' NULL,
                `email` varchar(255) COLLATE 'utf8_spanish_ci' NULL,
                `phone` int(9) unsigned NULL,
                FOREIGN KEY (`ID`) REFERENCES `".$wpdb->prefix."users` (`ID`) ON DELETE RESTRICT
            ) ENGINE='InnoDB' COLLATE 'utf8_spanish_ci';";
    require_once( ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
}

// Creación de la tabla PROYECTOS
function manusoft_bussman_create_table_proyectos() {
    global $wpdb;
    $sql = "CREATE TABLE `".$wpdb->prefix."manusoft_bussman_proyectos` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name` varchar(255) COLLATE 'utf8_spanish_ci' NOT NULL,
                `id_cliente` bigint(20) unsigned NOT NULL,
                `id_estado` bigint(20) unsigned NOT NULL,
                FOREIGN KEY (`id_cliente`) REFERENCES `".$wpdb->prefix."manusoft_bussman_clientes` (`ID`) ON DELETE RESTRICT,
                FOREIGN KEY (`id_estado`) REFERENCES `".$wpdb->prefix."manusoft_bussman_estados_proyecto` (`id`) ON DELETE RESTRICT
            ) ENGINE='InnoDB' COLLATE 'utf8_spanish_ci';";
    require_once( ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
}

// Creación de la tabla ESTADOS_PROYECTO
function manusoft_bussman_create_table_estados_proyecto() {
    global $wpdb;
    $sql = "CREATE TABLE `".$wpdb->prefix."manusoft_bussman_estados_proyecto` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name` varchar(255) COLLATE 'utf8_spanish_ci' NOT NULL,
                `id_next` bigint(20) unsigned NOT NULL,
                `id_previous` bigint(20) unsigned NOT NULL
            ) ENGINE='InnoDB' COLLATE 'utf8_spanish_ci';";
    require_once( ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
}

// Creación de la tabla TAREAS
function manusoft_bussman_create_table_tareas() {
    
}

// Creación de la tabla ESTADOS_TAREA
function manusoft_bussman_create_table_estados_tarea() {
    global $wpdb;
    $sql = "CREATE TABLE `".$wpdb->prefix."manusoft_bussman_estados_tarea` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name` varchar(255) COLLATE 'utf8_spanish_ci' NOT NULL,
                `id_next` bigint(20) unsigned NOT NULL,
                `id_previous` bigint(20) unsigned NOT NULL
            ) ENGINE='InnoDB' COLLATE 'utf8_spanish_ci';";
    require_once( ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
}

// Creación de la tabla TIPOS_TAREA
function manusoft_bussman_create_table_tipos_tarea() {
    global $wpdb;
    $sql = "CREATE TABLE `".$wpdb->prefix."manusoft_bussman_tipos_tarea` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name` varchar(255) COLLATE 'utf8_spanish_ci' NOT NULL
            ) ENGINE='InnoDB' COLLATE 'utf8_spanish_ci';";
    require_once( ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
}

function manusoft_bussman_create_table_prioridades_tarea() {
    global $wpdb;
    $sql = "CREATE TABLE `".$wpdb->prefix."manusoft_bussman_prioridades_tarea` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name` varchar(255) COLLATE 'utf8_spanish_ci' NOT NULL
            ) ENGINE='InnoDB' COLLATE 'utf8_spanish_ci';";
    require_once( ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
}

// Creación de la tabla COMENTARIOS_TAREA
function manusoft_bussman_create_table_comentarios_tarea() {
    
}

// Creación de la tabla PRODUCTOS
function manusoft_bussman_create_table_productos() {
    
}

// Creación de la tabla PRESUPUESTOS
function manusoft_bussman_create_table_presupuestos() {
    
}

// Creación de la tabla FACTURAS
function manusoft_bussman_create_table_facturas() {
    
}

// Borrado de la tabla CONFIG
function manusoft_bussman_delete_table_config() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_config;";
    $wpdb->get_var($query);
}

// Borrado de la tabla CLIENTES
function manusoft_bussman_delete_table_clientes() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_clientes;";
    $wpdb->get_var($query);
}

// Borrado de la tabla PROYECTOS
function manusoft_bussman_delete_table_proyectos() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_proyectos;";
    $wpdb->get_var($query);
}

// Borrado de la tabla ESTADOS_PROYECTO
function manusoft_bussman_delete_table_estados_proyecto() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_estados_proyecto;";
    $wpdb->get_var($query);
}

// Borrado de la tabla TAREAS
function manusoft_bussman_delete_table_tareas() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_tareas;";
    $wpdb->get_var($query);
}

// Borrado de la tabla ESTADOS_TAREA
function manusoft_bussman_delete_table_estados_tarea() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_estados_tarea;";
    $wpdb->get_var($query);
}

// Borrado de la tabla TIPOS_TAREA
function manusoft_bussman_delete_table_tipos_tarea() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_tipos_tarea;";
    $wpdb->get_var($query);
}

// Borrado de la tabla TIPOS_TAREA
function manusoft_bussman_delete_table_prioridades_tarea() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_prioridades_tarea;";
    $wpdb->get_var($query);
}

// Borrado de la tabla COMENTARIOS_TAREA
function manusoft_bussman_delete_table_comentarios_tarea() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_comentarios_tarea;";
    $wpdb->get_var($query);
}

// Borrado de la tabla PRODUCTOS
function manusoft_bussman_delete_table_productos() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_productos;";
    $wpdb->get_var($query);
}

// Borrado de la tabla PRESUPUESTOS
function manusoft_bussman_delete_table_presupuestos() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_presupuestos;";
    $wpdb->get_var($query);
}

// Borrado de la tabla FACTURAS
function manusoft_bussman_delete_table_facturas() {
    global $wpdb;
    $query = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_facturas;";
    $wpdb->get_var($query);
}
?>