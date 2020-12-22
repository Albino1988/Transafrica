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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'transafrica_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Ke%$ICBOX]P#t{h63pg~o*qV8f`L,=Ac~j8)PG{NFZ{#R&lI%0miXUt=6y0xP(oe' );
define( 'SECURE_AUTH_KEY',  '[#Bk.i[?$9b^gOutfbSYd}YyYD`dwp6iRbBq{:^kA[o -%u5^@G_z)f0%xd ;$6R' );
define( 'LOGGED_IN_KEY',    'rDeR5m.0VK01y-!0o&RkZ=Z|t/X7*w0uy{isgPfv0du6bPh`Sx(>g=e%7M.iVM0;' );
define( 'NONCE_KEY',        ' y>gCd#JhE1Zz|e|64ax*G}!C4piv$NNK9<6Ul@u{ptYcMy|),F@+C 30>rz)ksl' );
define( 'AUTH_SALT',        '?n<hsLDDM6J8s9z9aT^N:G)[B>AlL{|v+O{m[4(s9||?FW0_,voVRE@l@e-o>R,8' );
define( 'SECURE_AUTH_SALT', 'Og{-OReWcWm>E]<K6ci%.D_rUnHDfZnqLd+)3K`msNhj<w[a0oE:WAiA2LC0Tk@[' );
define( 'LOGGED_IN_SALT',   'Va*3R9;`saOnn(#_on-3,~s_14/o~lki1kg2;zq}~WuO=guSD/XbN:YX0Fj8<S<p' );
define( 'NONCE_SALT',       'HlQn>1E2xxx0G4l)MlcR8Xna=hD:A+*j;_i(1ix~Ov?2r~8GZ8GZ#u-/4UUEC!!b' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
