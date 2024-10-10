<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'testApp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'iLPv87geKAkQyZ3sHf3QdNQ0QYgTm82PIMOHNw3MUT6KkUQmkJZSBBVjZpFT9T8e' );
define( 'SECURE_AUTH_KEY',  'HszBHohqWtTk4DcMddcrq67nxswulZOyKhQsO6eykmF11syYBPxAqYmgcMeOcfzi' );
define( 'LOGGED_IN_KEY',    'ATQzTkOghRagdME8vFv8gpVUzKjO5CVGa2CYuCloI6V82LeFRkHHExMxueS6i2Rj' );
define( 'NONCE_KEY',        'w0tCvUaiFUPN00j6gwnagAljLbRIfrIw1eBZz7El7bHOrQNt5GwhNtTa28094xwX' );
define( 'AUTH_SALT',        'Rio6OksxauKdomY7HHPHy56BO9xdkTTdDPhK7UOBFNAtXOPwtrhr0j25ri83GHWY' );
define( 'SECURE_AUTH_SALT', 'URnp1ucqMaY9pBzzfcUd9KRqG8dqjwlX8Z5QL9T45krs3XTOqcGVXHT8XURgc708' );
define( 'LOGGED_IN_SALT',   '4VoWoBtWxNoQJuST0UDRa4pN4vfoFMNTQBttBbyRsVR9ooAscv3PtaPecPsRMFwa' );
define( 'NONCE_SALT',       'c2yaH1KndNopQchnxjKXRdd5Dllt8e7wFtjcDIfApcrdEnFP4d2Gkujla0dFqr4j' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
