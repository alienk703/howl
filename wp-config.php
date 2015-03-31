<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'reviewpanda');

/** MySQL database username */
define('DB_USER', 'admin');

/** MySQL database password */
define('DB_PASSWORD', 'Password@123@');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '3i`QFUO+m*+Ua1%P) -VjvPK7#x5_U(Rd[,%TZmAYR]cgkA3(!R_RNGn&|,E4NX/');
define('SECURE_AUTH_KEY',  ' T2dhJl*4G[ri7d={))| 7jy.y{~NcjHW(P#D RY~+L,9;Ef|)pLzyrL$Ut8;Ac{');
define('LOGGED_IN_KEY',    'MtG(AEvb570><sLeEDw7c-Y<+DZD!0=KQ$}o4lC,1ONHQKf/{Sc`*NekyZp-&?RF');
define('NONCE_KEY',        'LfV?c87,49fC~DK!+aRiN]Uj Pm|eDeG]ukO&2}@X#5hO~u,7AB:|A[TkfIYOGo-');
define('AUTH_SALT',        '{%0<k%=y#rB{s61/CV-FyIlZK.GlauaA3[qk5k[9|4-FF8R$2I2;l`T+MpX5x7r0');
define('SECURE_AUTH_SALT', 'A n#Z09B~a =}@ CiS]zX$R!TvJZBLX_N6MW;i=C5wV9j7#i38IJ3>mzE5,1yhIm');
define('LOGGED_IN_SALT',   'Gn-Dt3AnF/&q_4_wv-PM>0Z[gR|93=~Lx15=;z?sT,b-#c,MwK:L0OHY6`t|rm7V');
define('NONCE_SALT',       ';?JA*J?pNK]qQceHZ{1!PS1:&VFGuHHC{Bj!B$n3 ^`J_<S0Bdcp4bc@6F<[rtOx');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
