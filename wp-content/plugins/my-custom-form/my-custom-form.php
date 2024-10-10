<?php
/*
Plugin Name: My Custom Form
Description: A plugin to showcase a custom form using a shortcode.
Version: 1.0
Author: Ayub Haidari
*/

add_shortcode('my_custom_form', 'my_custom_form_shortcode');

function my_custom_form_shortcode() {
    ob_start(); 
    ?>
    <form id="my-custom-form">
        <input type="text" name="name" placeholder="Name" required>
        <input type="tel" name="phone" placeholder="Phone" required>
        <input type="date" name="dob" placeholder="Date of Birth" required>
        <input type="hidden" name="action" value="my_custom_form_submit">
        <?php wp_nonce_field('my_custom_form_nonce', 'my_custom_form_nonce_field'); ?>
        <button type="submit">Submit</button>
    </form>
    <div id="form-response"></div>
    <?php
    return ob_get_clean(); 
}

add_action('wp_enqueue_scripts', 'my_custom_form_enqueue_scripts');

function my_custom_form_enqueue_scripts() {
    wp_enqueue_script('jquery'); 
    wp_enqueue_script('my-custom-form-script', plugin_dir_url(__FILE__) . 'js/my-custom-form.js', array('jquery'), null, true);
    wp_localize_script('my-custom-form-script', 'my_custom_form_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('my_custom_form_nonce'),
    ));
}

add_action('wp_ajax_my_custom_form_submit', 'my_custom_form_submit');
add_action('wp_ajax_nopriv_my_custom_form_submit', 'my_custom_form_submit'); 

function my_custom_form_submit() {
    check_ajax_referer('my_custom_form_nonce', 'my_custom_form_nonce_field'); 
    $name = sanitize_text_field($_POST['name']);
    $phone = sanitize_text_field($_POST['phone']);
    $dob = sanitize_text_field($_POST['dob']);

    // Store data in the database
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_custom_form_entries'; 
    $wpdb->insert($table_name, array(
        'name' => $name,
        'phone' => $phone,
        'dob' => $dob,
    ));

    // Send a response back
    wp_send_json_success('Data submitted successfully');
}

register_activation_hook(__FILE__, 'my_custom_form_create_table');

function my_custom_form_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_custom_form_entries';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        phone tinytext NOT NULL,
        dob date NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action('admin_menu', 'my_custom_form_admin_menu');

function my_custom_form_admin_menu() {
    add_menu_page('Form Entries', 'Form Entries', 'manage_options', 'my-custom-form-entries', 'my_custom_form_entries_page');
}

function my_custom_form_entries_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_custom_form_entries';
    $entries = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<h1>Form Entries</h1>';
    echo '<table><tr><th>ID</th><th>Name</th><th>Phone</th><th>Date of Birth</th></tr>';
    foreach ($entries as $entry) {
        echo '<tr><td>' . $entry->id . '</td><td>' . $entry->name . '</td><td>' . $entry->phone . '</td><td>' . $entry->dob . '</td></tr>';
    }
    echo '</table>';
}
