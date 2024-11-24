<?php
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
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
define( 'DB_NAME', 'amazing_new_blog' );

/** Database username */
define( 'DB_USER', 'owoje' );

/** Database password */
define( 'DB_PASSWORD', 'Egobeta@1989' );

/** Database hostname */
define( 'DB_HOST', '62.84.179.45' );

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
define( 'AUTH_KEY',         'VQr,m!V3Q=V]`K;4#[.!U.DoAUC-;W)o#wR@/<vj@&GD[ 45E@az|4RddvO351j#' );
define( 'SECURE_AUTH_KEY',  '$BK#poQOiCoJ(AMrx`MrQ{2d9%/~yN_r!$&Ps/3<-}*7C Z$3W`#]h/,RzltG=df' );
define( 'LOGGED_IN_KEY',    'BwtZ1H=&@5F`#=<7(t3. %(QchFh(;q7|b[rt!<kx%Z9!KQoE |=Rf1E%{i*Y0lN' );
define( 'NONCE_KEY',        'S4}}R>vWJyNAU8GtA0T)M:_jilh30uq_0d@<f6mtcjN7K)*~5G6Uysy~NWq{~5L<' );
define( 'AUTH_SALT',        '?ylr6dP4nl^%!*6F9-9*&ww2Zm%?D-#maC]uZiJZO[a]Q_:viUZcf .Gi:1qS<x_' );
define( 'SECURE_AUTH_SALT', '8l*/rW)[,JiA!w?d3L+]bR1jy~sv;bKbxA$BSSp3kK%v=Abb<}S`j]db^`]4dG:+' );
define( 'LOGGED_IN_SALT',   '}f2o=,;5 SKLWb1.Tisew3P~$4K>4xX;%xB(g:]09C#`!3;zO8{&}#Hs@4}Y(QQz' );
define( 'NONCE_SALT',       '=zb7gk&CLc?Q8:[uG1bmHmu7M6/Gmwbm_l]Eq`Wg?79^K{s%%>muk_1OEz=#nw@e' );

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
