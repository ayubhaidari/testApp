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
    <style>
        #my-custom-form {
            max-width: 100%; 
            margin: 0 auto; 
            padding: 1em; 
            border: 1px solid #ccc; 
            border-radius: 5px;
        }

        #my-custom-form input[type="text"],
        #my-custom-form input[type="tel"],
        #my-custom-form input[type="date"] {
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            box-sizing: border-box; 
        }

        #my-custom-form button {
            background-color: #007bff; 
            color: white; 
            padding: 10px;
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-size: 16px; 
            transition: background-color 0.3s; 
            width: 100%; 
        }

        #my-custom-form button:hover {
            background-color: #0056b3; 
        }

        #form-response {
            margin-top: 10px; 
            font-size: 16px; 
        }
    </style>

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
    if (!check_ajax_referer('my_custom_form_nonce', 'my_custom_form_nonce_field', false)) {
        wp_send_json_error('Nonce verification failed');
        wp_die(); 
    }
    $name = sanitize_text_field($_POST['name']);
    $phone = sanitize_text_field($_POST['phone']);
    $dob = sanitize_text_field($_POST['dob']);

    global $wpdb;
    $table_name = $wpdb->prefix . 'my_custom_form_entries';
    $wpdb->insert($table_name, array(
        'name' => $name,
        'phone' => $phone,
        'dob' => $dob,
    ));
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

    echo '<h1>User Table </h1>';
    echo '<table style="width: 100%; border-collapse: collapse;">'; 
    echo '<tr style="background-color: #f1f1f1;">'; 
    echo '<th style="padding: 8px; border: 1px solid #ddd;">ID</th>';
    echo '<th style="padding: 8px; border: 1px solid #ddd;">Name</th>';
    echo '<th style="padding: 8px; border: 1px solid #ddd;">Phone</th>';
    echo '<th style="padding: 8px; border: 1px solid #ddd;">Date of Birth</th>';
    echo '</tr>';
    
    foreach ($entries as $entry) {
        echo '<tr>';
        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . $entry->id . '</td>';
        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . $entry->name . '</td>';
        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . $entry->phone . '</td>';
        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . $entry->dob . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

