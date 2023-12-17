<?php
define( 'WP_CACHE', true );




















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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'triotbdw_wp183' );

/** Database username */
define( 'DB_USER', 'triotbdw_wp183' );

/** Database password */
define( 'DB_PASSWORD', '1P-7Do]@q@p)7SEC' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'bnnmxewwxbhgbnc07fn7trso3f69qrb4oj0i9tld0ajxtbagicpzvexc5fxfmggm' );
define( 'SECURE_AUTH_KEY',  'rqcbnba4qfpzitk70tl8ol2iftlviioyszmt9wjdlfksgzuycrw708dky8b6nror' );
define( 'LOGGED_IN_KEY',    '0prrogl9xnx12yjingew1h4sr0pca4gdm4zt8bfwcqjwtdwlvrm7z8wb6aom6glw' );
define( 'NONCE_KEY',        'ssvbi0lbcwmjbqv8qjqpuhsrgouddglos20hy0zqtt7knw0qxzk7ecobiqb6ko6i' );
define( 'AUTH_SALT',        '1bhcxkley7ctfeitvfngpgaiumt6ds9df5hz9qbdzjxxqryhkaabjd1echptiypy' );
define( 'SECURE_AUTH_SALT', 'df65o9dezuwsyszzmw6munfrbdzboewfu2gegi8qjpho0z63vmdfdhzjnx2smz7k' );
define( 'LOGGED_IN_SALT',   'sahhqsizvpgaubpi3wpo2ldd8lewxgunar5i40yxgpkcrl3tjqzgy0zxdcyusf7j' );
define( 'NONCE_SALT',       'xeqk8dfuzjotpajp13jbj6leqt5j1wegaplu2kzivpciyr3zaff1kl2nhqckt6sd' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp1u_';

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
#define( 'WP_DEBUG', false );
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );



define( 'WP_AUTO_UPDATE_CORE', 'minor' );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
