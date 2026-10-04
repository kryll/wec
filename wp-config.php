<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_b9fam' );

/** Database username */
define( 'DB_USER', 'wp_niugm' );

/** Database password */
define( 'DB_PASSWORD', 'm8@w36t3R' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define('AUTH_KEY', 'Hcmw~~JmB6n2ZXcEKu[wVHQiZLZP+D:Ekkby#]Akz1B/~:33i/ADy1ZyxovT)oAn');
define('SECURE_AUTH_KEY', 'g#v3Ty[1H@bLNNF)sbcs05b(#Cei1XSTnJ7#~cZ)O!l~reOHtIuy2@~E(JLBwo&F');
define('LOGGED_IN_KEY', '%M@pqC5ch&FMvNOztt|;nU~fwTqrXW_9ryg8C5t*yMZ7uORX]|(xeeo&*(gz1FNO');
define('NONCE_KEY', 'mf3id9wQkRNn]x76KsUZpPBlOBOu|bK7_o2:j3e:WK*gcr+DqJvKuU33[W2h5KRI');
define('AUTH_SALT', '5wSmtpftgV6+NdUJ*D(]#1+1Vq8TpPXEIXdELK;*(U4151CxHHLXmku3O9@@Tj#S');
define('SECURE_AUTH_SALT', 'zF&d!*AFP*OsxKjfsUry&t4BM9GOjnFGWRkWbix(@6(l6bXt(S:jWE%d0@IpY8NN');
define('LOGGED_IN_SALT', 'hhQpMQQfAZzCA3P~R7Q!|_Wh|-K8]QYF9|Vdw-pk0St6]qn*(H&p%yWW22:fZM4P');
define('NONCE_SALT', '[tBG#Fh1zwzN[W&q0t/iWxVEEJuVbe%!bJ7NZNX!H1pleFQoyvXK:z7GZintPO(0');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'yG0JR_';

/* Add any custom values between this line and the "stop editing" line. */

define('WP_ALLOW_MULTISITE', true);
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'DISABLE_WP_CRON', true );
define( 'DISALLOW_FILE_EDIT', true );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
