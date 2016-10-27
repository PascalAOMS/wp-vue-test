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



 // GET DOMAIN ENDING
 function endsWith($haystack, $needle) {
      return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
 }

  $SERVER_NAME = $_SERVER['SERVER_NAME'];

 // DEVELOPMENT
 if( endsWith($SERVER_NAME, 'localhost') || endsWith($SERVER_NAME, '.local') || endsWith($SERVER_NAME, '.dev')) {

     $DB_NAME = 'wp_vue_test';         // replace - with _
     $DB_USER = 'root';
     $DB_PASSWORD = 'root';
     $DB_HOST = 'localhost';
     $URL = 'http://wp-vue-test.local';    // /public in MAMP
 }

 // PRODUCTION
 else {

     $DB_NAME = 'XXXX';
     $DB_USER = 'XXXX';
     $DB_PASSWORD = 'XXXX';
     $DB_HOST = 'XXXX';
     $URL = '//' . $SERVER_NAME;
 }

 // DATABASE
 define('DB_NAME', $DB_NAME);
 define('DB_USER', $DB_USER);
 define('DB_PASSWORD', $DB_PASSWORD);
 define('DB_HOST', $DB_HOST);
 define('DB_CHARSET', 'utf8');
 define('DB_COLLATE', '');

 // FILE PATHS
 define('WP_CONTENT_DIR', dirname(__FILE__) . '/wp-content');
 define('WP_CONTENT_URL', $URL . '/wp-content');
 define('WP_SITEURL', $URL . '/wp');
 define('WP_HOME', $URL);

 // DEFAULT THEME
 define('WP_DEFAULT_THEME', 'wp-vue-test-theme');


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
 define('AUTH_KEY',         '4fXC4Hl4c8$nT+cL!*7w| vZ!~;vX~g73tf}GKjK6,+tW*ql^I(-l^-u,N@+NwOP');
 define('SECURE_AUTH_KEY',  '`6F+pCoKVs)SX*zTYCe6RD9FVmR,eb_h^W@}7&Em(ka!c1n[38bNi_?,%iqNf#H$');
 define('LOGGED_IN_KEY',    'W@+T/@e.Ciz8DQ6P|L<Z7MqwTzV>?PwxJMq|}-h?gFZu!Pe,eA1/ah@ZULv{qz(<');
 define('NONCE_KEY',        'c-&kJTY_F2+ixy7A|^HTJKy Kglf(cIp[NsAl[0D:h)[|9XHT5JmbCT5UdJ`OFgp');
 define('AUTH_SALT',        '(_AaA{scfe@-/S4dBBj$~1/%**miyyk2=@>E<q7Tw~S#3VYs0%2OZu;{BzR?PG*F');
 define('SECURE_AUTH_SALT', 'zCzL <ys~qs@joFC(J_}Y#&eFy];[O4C%F+,1~dU9vs,L5CFvZF;JUAjFw/#q=+?');
 define('LOGGED_IN_SALT',   's!K#-.at1TWFX#6Gn_5<QY 59iK$nd]->aTem<j[Uc5jh.[{twuzM]G_uR|p)/.;');
 define('NONCE_SALT',       'HW3>]GWF:uyl0^+E]}`g|eu3>JU_,vqQNB5z%e=GbDf:9[#K6#&_6zyi=wkmKLH,');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
