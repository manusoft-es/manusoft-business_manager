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

require_once plugin_dir_path(__FILE__).'inc/manusoft-bussman_functions.php';
require_once plugin_dir_path(__FILE__).'inc/tasks/class/manusoft-bussman_clientes_table.php';
require_once plugin_dir_path(__FILE__).'inc/tasks/functions/manusoft-bussman_clientes_functions.php';
require_once plugin_dir_path(__FILE__).'inc/tasks/class/manusoft-bussman_proyectos_table.php';
require_once plugin_dir_path(__FILE__).'inc/tasks/class/manusoft-bussman_tareas_table.php';
require_once plugin_dir_path(__FILE__).'inc/tasks/functions/manusoft-bussman_proyectos_functions.php';
require_once plugin_dir_path(__FILE__).'inc/tasks/functions/manusoft-bussman_tareas_functions.php';

// Insercción del fichero con CSS privado propio para la parte de tareas
function load_manusoft_bussman_tasks_style() {
    wp_register_style('manusoft-bussman_tasks_style', plugins_url('/css/manusoft-bussman_tasks_style.css', __FILE__));
    wp_enqueue_style('manusoft-bussman_tasks_style');
    wp_enqueue_style('thickbox');
}
add_action('admin_enqueue_scripts', 'load_manusoft_bussman_tasks_style');

// Insercción del fichero con CSS privado propio para la parte de presupuestos
function load_manusoft_bussman_budgets_style() {
    wp_register_style('manusoft-bussman_budgets_style', plugins_url('/css/manusoft-bussman_budgets_style.css', __FILE__));
    wp_enqueue_style('manusoft-bussman_budgets_style');
    wp_enqueue_style('thickbox');
}
add_action('admin_enqueue_scripts', 'load_manusoft_bussman_budgets_style');

// Insercción del fichero con CSS privado propio para la parte de facturas
function load_manusoft_bussman_invoices_style() {
    wp_register_style('manusoft-bussman_invoices_style', plugins_url('/css/manusoft-bussman_invoices_style.css', __FILE__));
    wp_enqueue_style('manusoft-bussman_invoices_style');
    wp_enqueue_style('thickbox');
}
add_action('admin_enqueue_scripts', 'load_manusoft_bussman_invoices_style');

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
    manusoft_bussman_create_table_tareas();
    manusoft_bussman_create_table_comentarios_tarea();
    //manusoft_bussman_create_table_productos();
    //manusoft_bussman_create_table_presupuestos();
    //manusoft_bussman_create_table_facturas();
    
    manusoft_bussman_insert_table_estados_proyecto();
    manusoft_bussman_insert_table_tipos_tarea();
    manusoft_bussman_insert_table_estados_tarea();
    manusoft_bussman_insert_table_prioridades_tarea();
}

// Método a ejecutar al desactivar el plugin
register_deactivation_hook( __FILE__, 'manusoft_bussman_desactivation' );
function manusoft_bussman_desactivation() {
    manusoft_bussman_delete_table_config();
    manusoft_bussman_delete_table_comentarios_tarea();
    manusoft_bussman_delete_table_tareas();
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
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name` varchar(255) COLLATE 'utf8_spanish_ci' NOT NULL,
                `address` text COLLATE 'utf8_spanish_ci' NULL,
                `cif` varchar(9) COLLATE 'utf8_spanish_ci' NULL,
                `email` varchar(255) COLLATE 'utf8_spanish_ci' NULL,
                `phone` int(9) unsigned NULL
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

// Población de la tabla ESTADOS_PROYECTO
function manusoft_bussman_insert_table_estados_proyecto() {
    global $wpdb;
    $sql = "INSERT INTO `".$wpdb->prefix."manusoft_bussman_estados_proyecto` (`name`, `id_next`, `id_previous`) VALUES
                ('Nuevo', 2, 0),
                ('Pendiente de presupuesto', 3, 1),
                ('En proceso', 4, 2),
                ('Finalizado', 0, 3),
                ('Rechazado', 0, 2);";
    require_once( ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
}

// Creación de la tabla TAREAS
function manusoft_bussman_create_table_tareas() {
    global $wpdb;
    $sql = "CREATE TABLE `".$wpdb->prefix."manusoft_bussman_tareas` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `id_proyecto` bigint(20) unsigned NOT NULL,
                `name` varchar(255) COLLATE 'utf8_spanish_ci' NOT NULL,
                `description` text COLLATE 'utf8_spanish_ci' NULL,
                `id_estado` bigint(20) unsigned NOT NULL,
                `id_prioridad` bigint(20) unsigned NOT NULL,
                `id_tipo` bigint(20) unsigned NOT NULL,
                `start_date` date NULL,
                `end_date` date NULL,
                `planned_hours` decimal(2,1) unsigned NULL,
                `used_hours` decimal(2,1) unsigned NULL,
                FOREIGN KEY (`id_proyecto`) REFERENCES `".$wpdb->prefix."manusoft_bussman_proyectos` (`id`) ON DELETE CASCADE,
                FOREIGN KEY (`id_estado`) REFERENCES `".$wpdb->prefix."manusoft_bussman_estados_tarea` (`id`) ON DELETE RESTRICT,
                FOREIGN KEY (`id_prioridad`) REFERENCES `".$wpdb->prefix."manusoft_bussman_prioridades_tarea` (`id`) ON DELETE RESTRICT,
                FOREIGN KEY (`id_tipo`) REFERENCES `".$wpdb->prefix."manusoft_bussman_tipos_tarea` (`id`) ON DELETE RESTRICT
            ) ENGINE='InnoDB' COLLATE 'utf8_spanish_ci';";
    require_once( ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
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

// Población de la tabla ESTADOS_TAREA
function manusoft_bussman_insert_table_estados_tarea() {
    global $wpdb;
    $sql = "INSERT INTO `".$wpdb->prefix."manusoft_bussman_estados_tarea` (`name`, `id_next`, `id_previous`) VALUES
                ('Nuevo', 2, 0),
                ('En proceso', 3, 1),
                ('En revisión', 4, 2),
                ('Finalizada', 0, 3),
                ('Rechazada', 2, 3);";
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

// Población de la tabla TIPOS_TAREA
function manusoft_bussman_insert_table_tipos_tarea() {
    global $wpdb;
    $sql = "INSERT INTO `".$wpdb->prefix."manusoft_bussman_tipos_tarea` (`name`) VALUES
                ('Soporte'),
                ('Desarrollo'),
                ('Mantenimiento'),
                ('Análisis'),
                ('Diseño');";
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

function manusoft_bussman_insert_table_prioridades_tarea() {
    global $wpdb;
    $sql = "INSERT INTO `".$wpdb->prefix."manusoft_bussman_prioridades_tarea` (`name`) VALUES
                ('Muy baja'),
                ('Baja'),
                ('Media'),
                ('Alta'),
                ('Muy alta'),
                ('Urgente'),
                ('Inmediata');";
    require_once( ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
}

// Creación de la tabla COMENTARIOS_TAREA
function manusoft_bussman_create_table_comentarios_tarea() {
    global $wpdb;
    $sql = "CREATE TABLE `".$wpdb->prefix."manusoft_bussman_comentarios_tarea` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `id_tarea` bigint(20) unsigned NOT NULL,
                `moment` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
                `comentario` text COLLATE 'utf8_swedish_ci' NOT NULL,
                FOREIGN KEY (`id_tarea`) REFERENCES `".$wpdb->prefix."manusoft_bussman_tareas` (`id`) ON DELETE CASCADE
            ) ENGINE='InnoDB' COLLATE 'utf8_spanish_ci';";
    require_once( ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
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
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_config;";
    $wpdb->get_var($sql);
}

// Borrado de la tabla CLIENTES
function manusoft_bussman_delete_table_clientes() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_clientes;";
    $wpdb->get_var($sql);
}

// Borrado de la tabla PROYECTOS
function manusoft_bussman_delete_table_proyectos() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_proyectos;";
    $wpdb->get_var($sql);
}

// Borrado de la tabla ESTADOS_PROYECTO
function manusoft_bussman_delete_table_estados_proyecto() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_estados_proyecto;";
    $wpdb->get_var($sql);
}

// Borrado de la tabla TAREAS
function manusoft_bussman_delete_table_tareas() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_tareas;";
    $wpdb->get_var($sql);
}

// Borrado de la tabla ESTADOS_TAREA
function manusoft_bussman_delete_table_estados_tarea() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_estados_tarea;";
    $wpdb->get_var($sql);
}

// Borrado de la tabla TIPOS_TAREA
function manusoft_bussman_delete_table_tipos_tarea() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_tipos_tarea;";
    $wpdb->get_var($sql);
}

// Borrado de la tabla TIPOS_TAREA
function manusoft_bussman_delete_table_prioridades_tarea() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_prioridades_tarea;";
    $wpdb->get_var($sql);
}

// Borrado de la tabla COMENTARIOS_TAREA
function manusoft_bussman_delete_table_comentarios_tarea() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_comentarios_tarea;";
    $wpdb->get_var($sql);
}

// Borrado de la tabla PRODUCTOS
function manusoft_bussman_delete_table_productos() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_productos;";
    $wpdb->get_var($sql);
}

// Borrado de la tabla PRESUPUESTOS
function manusoft_bussman_delete_table_presupuestos() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_presupuestos;";
    $wpdb->get_var($sql);
}

// Borrado de la tabla FACTURAS
function manusoft_bussman_delete_table_facturas() {
    global $wpdb;
    $sql = "DROP TABLE IF EXISTS ".$wpdb->prefix."manusoft_bussman_facturas;";
    $wpdb->get_var($sql);
}
?>