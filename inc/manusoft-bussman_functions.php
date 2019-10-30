<?php
defined('ABSPATH') or die('No tienes permiso para hacer eso.');

// Creación de los menús del plugin en el panel de administración de WordPress
add_action( 'admin_menu', 'manusoft_bussman_add_admin_links' );
function manusoft_bussman_add_admin_links() {
    add_menu_page(
        'ManuSoft Business Manager - Vistazo',                                      // Título de la p�gina
        'Business Manager',                                                         // Texto a mostrar como enlace en el menú de administración de WordPress
        'manage_options',                                                           // Permisos requeridos para mostrar el enlace
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_vistazo_page.php', // 'Slug' del fichero a mostrar cuando se haga click en el enlace
        '',
        'dashicons-list-view',                                                      // Icono en el menú
        30                                                                          // Posición en el menú
    );
    
    add_submenu_page(
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_vistazo_page.php', // 'Slug' del menú del que cuelga el submenú
        'ManuSoft Business Manager - Vistazo',                                      // Texto a mostrar en la etiqueta 'title' del enlace
        'Vistazo',                                                                  // Texto a mostrar como enlace en el menú de administración de WordPress
        'manage_options',                                                           // Permisos requeridos para mostrar el enlace
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_vistazo_page.php' // 'Slug' del fichero a mostrar cuando se haga click en el enlace del submenú
    );
    
    add_submenu_page(
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_vistazo_page.php',     // 'Slug' del menú del que cuelga el submenú
        'ManuSoft Business Manager - Clientes',                                         // Texto a mostrar en la etiqueta 'title' del enlace
        'Clientes',                                                                     // Texto a mostrar como enlace en el menú de administración de WordPress
        'manage_options',                                                               // Permisos requeridos para mostrar el enlace
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_clientes_page.php'     // 'Slug' del fichero a mostrar cuando se haga click en el enlace del submenú
    );
    
    add_submenu_page(
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_vistazo_page.php',     // 'Slug' del menú del que cuelga el submenú
        'ManuSoft Business Manager - Proyectos',                                        // Texto a mostrar en la etiqueta 'title' del enlace
        'Proyectos',                                                                    // Texto a mostrar como enlace en el menú de administración de WordPress
        'manage_options',                                                               // Permisos requeridos para mostrar el enlace
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_proyectos_page.php'    // 'Slug' del fichero a mostrar cuando se haga click en el enlace del submenú
    );
    
    add_submenu_page(
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_vistazo_page.php',     // 'Slug' del menú del que cuelga el submenú
        'ManuSoft Business Manager - Presupuestos',                                     // Texto a mostrar en la etiqueta 'title' del enlace
        'Presupuestos',                                                                 // Texto a mostrar como enlace en el menú de administración de WordPress
        'manage_options',                                                               // Permisos requeridos para mostrar el enlace
        plugin_dir_path(__FILE__).'/budgets/pages/manusoft-bussman_budgets_page.php'    // 'Slug' del fichero a mostrar cuando se haga click en el enlace del submenú
    );
    
    add_submenu_page(
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_vistazo_page.php',     // 'Slug' del menú del que cuelga el submenú
        'ManuSoft Business Manager - Facturas',                                         // Texto a mostrar en la etiqueta 'title' del enlace
        'Facturas',                                                                     // Texto a mostrar como enlace en el menú de administración de WordPress
        'manage_options',                                                               // Permisos requeridos para mostrar el enlace
        plugin_dir_path(__FILE__).'/invoices/pages/manusoft-bussman_invoices_page.php'  // 'Slug' del fichero a mostrar cuando se haga click en el enlace del submenú
    );
    
    add_submenu_page(
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_vistazo_page.php',     // 'Slug' del menú del que cuelga el submenú
        'ManuSoft Business Manager - Administración',                                  // Texto a mostrar en la etiqueta 'title' del enlace
        'Administración',                                                              // Texto a mostrar como enlace en el menú de administración de WordPress
        'manage_options',                                                               // Permisos requeridos para mostrar el enlace
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_admin_page.php'        // 'Slug' del fichero a mostrar cuando se haga click en el enlace del submenú
    );
    
    add_submenu_page(
        '',                                                                             // 'Slug' del menú del que cuelga el submenú
        'ManuSoft Business Manager - Clientes',                                         // Texto a mostrar en la etiqueta 'title' del enlace
        '',                                                                             // Texto a mostrar como enlace en el menú de administración de WordPress
        'manage_options',                                                               // Permisos requeridos para mostrar el enlace
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_clientes_new.php'      // 'Slug' del fichero a mostrar cuando se haga click en el enlace del submenú
        );
    
    add_submenu_page(
        '',                                                                             // 'Slug' del menú del que cuelga el submenú
        'ManuSoft Business Manager - Proyecto',                                         // Texto a mostrar en la etiqueta 'title' del enlace
        '',                                                                             // Texto a mostrar como enlace en el menú de administración de WordPress
        'manage_options',                                                               // Permisos requeridos para mostrar el enlace
        plugin_dir_path(__FILE__).'/tasks/pages/manusoft-bussman_proyectos_new.php'     // 'Slug' del fichero a mostrar cuando se haga click en el enlace del submenú
        );
}
?>