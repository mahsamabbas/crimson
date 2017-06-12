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
define('DB_NAME', 'akrama65_crimson');


/** MySQL database username */
define('DB_USER', 'akrama65_crimson');


/** MySQL database password */
define('DB_PASSWORD', 'o69#T)yQ[w7E');

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
define('AUTH_KEY',         'FEwi ~NrY^,O6!$6Mb*GpZ44VM05Gwu2=Du{+y#?2-v+]XB:M]aF=:QBwUjeX;zF');
define('SECURE_AUTH_KEY',  'XO7X[IGR9D(xqiOZSkOWB`WqKv5kgx^Oa<ot{x=30e[bK+Yhr/ism}*%`~,hw|AK');
define('LOGGED_IN_KEY',    'OI?iqRP)/4r]@=]!^Gg9t]3xb+WA^Z@fN*%gNra^mU$J>Fy?0Ol:o!u#LiWKs$ a');
define('NONCE_KEY',        'OkB*l7 3p,k@-tzW`g T5`!.5BC>craVsky^f9QXFSv{HgF@D&?>Y}IeH.9T.xKW');
define('AUTH_SALT',        'ixZUtAPd45mFH,EsB;m~W`?Tr/+M6>5Nc.RyqQ6vLkxLSN@5;>#!7VC;^029 |#/');
define('SECURE_AUTH_SALT', '|iA4IT^j`:9k#e9:sZ>0Ezh(IV32?BwH+AwYSY*>^<E(>sB~.%)0#_&vLrj1;Uq8');
define('LOGGED_IN_SALT',   'j*/Cg03|)Yb]jApoW$vrTpa ph4oGNVN`U,X/k^R{&wSG]O?.w#t,6C32oB|$8(P');
define('NONCE_SALT',       '$PaQ@f%EF}:Xf(rM}gM8QJ$63O~=M6Tn04B:&DaBYful*DL6m,)CUYZ7BC@$,ZwR');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'crimson_';

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
