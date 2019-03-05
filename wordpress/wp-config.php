<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'tinhte-wp');

/** MySQL database username */
define('DB_USER', 'tinhte');

/** MySQL database password */
define('DB_PASSWORD', '12345');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '(qewYi}I[Rj`t3H5MOGadgN]0TYQC b<;CTKQrJGsg#Zh{j>-qD:r|5mG>jmiA|7');
define('SECURE_AUTH_KEY',  '#ss787[VU66awvx/6EG.`3F&]:HjA6?07bh5M.SxWMFsJF5uPtq,R%pa<|Hr9$DY');
define('LOGGED_IN_KEY',    'H<:.h)%cG;dw6+x?x`BZ2%I4V{E/i:t>{`4|JUv<qila9`j_45Z/#3Q=q^1K&#u/');
define('NONCE_KEY',        ':SrYYCB+4eG5G#`^TioA,qS+/_B]qS2N+}t[o ?~/N!plVNZ/6O 5zWRqWA<=MZi');
define('AUTH_SALT',        '@Dfhk>~xOm+S6@q#SuhwnA$+<Qg:,WS_G<u?Vd$[|^ECx`f#9f~|E /CQ~ZU;Ubb');
define('SECURE_AUTH_SALT', 'BcY:{P0u^PH&1x[V;1q<wyLR-6)L5:-L7H=a1~)2HeR{>,SNV?[]3Th[KQaN75}I');
define('LOGGED_IN_SALT',   'AKo1?N~-39pjB,zZ9PoyN~5C9b0)L]PvtK^+K*Xtr|W/iZsde>skV<T``A[yv`[|');
define('NONCE_SALT',       'a2@7J+1gI0o gyuw9P>8hHI^9k{Hhq!;&i%Y3uAyz_x8_e!@wcDA23Dyp}X[;{N|');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tt_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
