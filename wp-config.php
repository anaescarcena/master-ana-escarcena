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
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         'hkQRSXvDr4mwamcgU7nWqJ761FEd7utN71mN7hHurwzQjmm6LX12S3eaNB6Yf9Ts' );
define( 'SECURE_AUTH_KEY',  'MaoVVjZFVVOYUGum2lj99xD4dFc9Xqlj1zyEgQ1d7mJFfDNyR0KLXiPciMY8g4BJ' );
define( 'LOGGED_IN_KEY',    'JIAt68e8zZTTK519iiobfu5NsjDdbbgn9ZELfFnmX4v2GyAn6A6zaQ0QWGcTPmsZ' );
define( 'NONCE_KEY',        'A9Y4LS1JV56QjMp8WZICSXfNbrNXwS8FnmAM7vDyznJQRLDlvWdk7vjqiM5rr745' );
define( 'AUTH_SALT',        'H2qh3sneL4O0OtTJFl1oPgHuoOYVWnZuk6lrwNCPcVDNNQynlWbmgpEcRLx7dl9N' );
define( 'SECURE_AUTH_SALT', 'Ag0V8SZ4bNpG0pwmLrScAAslh5VgJgvuYWtYLz59OBnbnPusG9YB7qu9si3rwO9u' );
define( 'LOGGED_IN_SALT',   'Do5v6KIFutdFPEBNJWEyRf5yuqA2eojsGDMA6RkrhyTrOrAAE59i6povOJBX1lHK' );
define( 'NONCE_SALT',       'hJyaQdtx8CUUt3E7Q0f8ew2Dw17fPTsY12stfW5bJSEgO7i0pXRNcGlhZz8bytgQ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
