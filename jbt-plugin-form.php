<?php
/**
 * Plugin Name: JBT Pluguin Form
 * Description: Formulario personalizado utilizando un shortcode [jbt-plugin-form]
 * Author: Jonathan Beltrán
 * Version: 1.0 
 * Author URI: https://beltor.cf
 * PHP Version: 5.6
 *
 * @category Form
 * @package  JBT
 * @author   Jonathan Beltrán <beltorj@gmail.com>
 * @license  GPLv2 http://www.gnu.org/licenses/gpl-2.0.txt
 * @link     https://beltor.cf
 */

// Cuando el plugin se active se crea la tabla del mismo si no existe
register_activation_hook(__FILE__, 'Jbt_Aspirante_init');

/**
 * Realiza las acciones necesarias para configurar el plugin cuando se activa
 *
 * @return void
 */
function Jbt_Aspirante_init()
{
    global $wpdb; // Este objeto global nos permite trabajar con la BD de WP
    // Crea la tabla si no existe
    $tabla_aspirante = $wpdb->prefix . 'aspirante';
    $charset_collate = $wpdb->get_charset_collate();
    //Prepara la consulta que vamos a lanzar para crear la tabal
    $query = "CREATE TABLE IF NOT EXISTS $tabla_aspirante (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nombre varchar(40) NOT NULL,
        apellido varchar(40) NOT NULL,
        zona varchar(40) NOT NULL, 
        cantidad tinyint (2) NOT NULL,
        kit varchar text NOT NULL, 
        aceptacion smallint(4) NOT NULL,
        ip varchar(300),
        created_at datetime NOT NULL,
        UNIQUE (id)
        ) $charset_collate;";
    // La función dbDelta que nos permite crear tablas de manera segura se
    // define en el fichero upgrade.php que se incluye a continuación
    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($query);
}


// Define el shortcode y lo asocia a una función
add_shortcode('jbt_aspirante_form', 'Jbt_aspirante_form');
 
/** 
 * Define la función que ejecutará el shortcode
 * De momento sólo pinta un formulario que no hace nada
 * 
 * @return string
 */
function jbt_aspirante_form() 
{
    // Esta función de PHP activa el almacenamiento en búfer de salida (output buffer)
    // Cuando termine el formulario lo imprime con la función ob_get_clean

    // Carga esta hoja de estilo para poner más bonito el formulario
    wp_enqueue_style('css_aspirante', plugins_url('style.css', __FILE__));
 
    // Esta función de PHP activa el almacenamiento en búfer de salida (output buffer)
    // Cuando termine el formulario lo imprime con la función ob_get_clean

    ob_start();
    ?>
    <form action="<?php get_the_permalink();?>" method="post" id="form_aspirante"
        class="cuestionario">
        <?php wp_nonce_field('graba_aspirante', 'aspirante_nonce');?>
        <div class="form-input">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div class="form-input">
            <label for='correo'>Correo</label>
            <input type="email" name="correo" id="correo" required>
        </div>
        <div class="form-input">
            <label for="nivel_html">¿Cuál es tu nivel de HTML?</label>
            <input type="radio" name="nivel_html" value="1" required> Nada
            <br><input type="radio" name="nivel_html" value="2" required> Estoy
                aprendiendo
            <br><input type="radio" name="nivel_html" value="3" required> Tengo
                experiencia
            <br><input type="radio" name="nivel_html" value="4" required> Lo
                domino al dedillo
        </div>
        <div class="form-input">
            <label for="nivel_css">¿Cuál es tu nivel de CSS?</label>
            <input type="radio" name="nivel_css" value="1" required> Nada
            <br><input type="radio" name="nivel_css" value="2" required> Estoy
                aprendiendo
            <br><input type="radio" name="nivel_css" value="3" required> Tengo
                experiencia
            <br><input type="radio" name="nivel_css" value="4" required> Lo
                domino al dedillo
        </div>
        <div class="form-input">
            <label for="nivel_js">¿Cuál es tu nivel de JavaScript?</label>
            <input type="radio" name="nivel_js" value="1" required> Nada
            <br><input type="radio" name="nivel_js" value="2" required> Estoy
                aprendiendo
            <br><input type="radio" name="nivel_js" value="3" required> Tengo
                experiencia
            <br><input type="radio" name="nivel_js" value="4" required> Lo domino al
            dedillo
        </div>
        <div class="form-input">
            <label for="nivel_php">¿Cuál es tu nivel de PHP?</label>
            <input type="radio" name="nivel_php" value="1" required> Nada
            <br><input type="radio" name="nivel_php" value="2" required> Estoy
                aprendiendo
            <br><input type="radio" name="nivel_php" value="3" required> Tengo
                experiencia
            <br><input type="radio" name="nivel_php" value="4" required> Lo domino
                al dedillo
        </div>
        <div class="form-input">
            <label for="nivel_wp">¿Cuál es tu nivel de WordPress?</label>
            <input type="radio" name="nivel_wp" value="1" required> Nada
            <br><input type="radio" name="nivel_wp" value="2" required> Estoy
            aprendiendo
            <br><input type="radio" name="nivel_wp" value="3" required> Tengo
                experiencia
            <br><input type="radio" name="nivel_wp" value="4" required> Lo domino
                al dedillo
        </div>
        <div class="form-input">
            <label for="motivacion">¿Porqué quieres aprender a programar en
                    WordPress?</label>
            <textarea name="motivacion" id="motivacion" required></textarea>
        </div>
        <div class="form-input">
            <label for="aceptacion">Mi nombre es Fulano de Tal y Cual y me
                comprometo a custodiar de manera responsable los datos que vas
                a enviar. Su única finalidad es la de participar en el proceso
                explicado más arriba.
                En cualquier momento puedes solicitar el acceso, la rectificación
                o la eliminación de tus datos desde esta página web.</label>
            <input type="checkbox" id="aceptacion" name="aceptacion" value="1"
            required> Entiendo y acepto las condiciones
        </div>
        <div class="form-input">
            <input type="submit" value="Enviar">
        </div>
    </form>
    <?php
     
    // Devuelve el contenido del buffer de salida
    return ob_get_clean();
}
