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
define('DB_NAME', 'tinhte');

/** MySQL database username */
define('DB_USER', 'admin');

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
define('AUTH_KEY',         'u}EC6~`S3#e)zwrf^eO(G4aYLK>O8oo<8tv[X}gt+/m#2S|LqO-:x/%HRCkoN@If');
define('SECURE_AUTH_KEY',  'mv02BYL?UtC$^GqYSRXJCa.[kb[UE`Q3*R@[y6S8;X|A^)M(eW%8-s,adi6ZD,i-');
define('LOGGED_IN_KEY',    'R,6IdUL-!s+i-bf<4Umfl&l}xvTYnPW]l@G$Boq!^xX}iNT(AN|sHs2}Cd4V=`z ');
define('NONCE_KEY',        'K|Q1$loTO.b[#k(}P+<r*`QqgmQP>u71!O@%wk>kJ+7=6NV8MbtWp8mP[d~X=y@j');
define('AUTH_SALT',        '97~J 4mi5e0J?E>z&Ga,[V#SVp?JZi[0f!0w8)dj1!wO.>=aVX:tcRs`!&Ah=w9E');
define('SECURE_AUTH_SALT', 'k:i^K-58A<LqPCxU=BY=)PCsaqv/sIUJRe:BTimsAlEy|CriI66rh?`^XHY*E#Ho');
define('LOGGED_IN_SALT',   '!(NFC5H?RC2PbW=O[5p,,MXPye,jM`eg*%nr}5q3S#Ni{iB|LI_B~f/(Z sB;]EA');
define('NONCE_SALT',       '<0^^NOkaF50[pkewRN zhx]O,=5R @snlWS#S;Z$-#yT{a<e!vZ,Sqly=A=G&~A!');

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
