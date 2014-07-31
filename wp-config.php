<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
 if (isset($_SERVER["DATABASE_URL"])) {
 $db = parse_url($_SERVER["DATABASE_URL"]);
 define("DB_NAME", trim($db["path"],"/"));
 define("DB_USER", $db["user"]);
 define("DB_PASSWORD", $db["pass"]);
 define("DB_HOST", $db["host"]);
}
else {
 die("Your heroku DATABASE_URL does not appear to be correctly specified.");
}


define('WP_SITEURL', "http://' . $_SERVER['SERVER_NAME'] );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '|RX[G%d9E*I*n~xZZn5s)=o=SOV,1*n|<Qf  ?f,7ARc:!|R4@8{sj$neU=yh~n(');
define('SECURE_AUTH_KEY',  'tbYhOtsWAA~Z+^lq%).HXiy1OxFg>d=CJ2Hpl~Fyz?1C|8q2?wZxG }oJ*P%<&q6');
define('LOGGED_IN_KEY',    'Y-+H}83yN9]jS<@;KH!Elg-=|x9.Hn+D5a/tYEfZ.s5*U{xP=AAiC`+q4Nj`5`|o');
define('NONCE_KEY',        'IYn4(Yp=<T=|bJ(zlr%Yw-KOlCPJJXmMN|C|d.+()<)k-Mc?%&Hrb~R)|`t|OoIH');
define('AUTH_SALT',        '6s.2LfO},>CNZ!{^EQaMSDt84skis|sQK9Y>47aQs=GnYx}Y2^(E| Ct3/g@`=V3');
define('SECURE_AUTH_SALT', 'FBZd`H=^A~~so~:usH/^t&BPQcvPQ+!+D:t@]+vNfEpa-qZ,[N;-c{p|Kt1*-pl9');
define('LOGGED_IN_SALT',   'u2um4<(ZiOoXQH+J-eDU`#z_,)<)gy!hrgo`F!Mw)7=e1mqB%Out]{qz|YffMuDe');
define('NONCE_SALT',       'hJhzT2nfb=q!ZkGs6`1AwN!#7J?|*3 blNfSw@Zh0o$.U8cZuCeJjPH@ET}?Bu]M');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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


