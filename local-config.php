<?php
$server_name = 'tst-descente.magaseek.jp';
$cfDistributionId = 'E1JFSQ5IQ5N14K';
$dbEndpoint = 'localhost';
$dbPassword = 'RTnULUGLbO&&iUMi7W08sU(9Svi9QM--';
$dbTablename = 'tst_descente_magaseek_jp';
$dbUsername = 'wp_ci9g43l9073le';

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', $dbTablename);

/** MySQL database username */
define('DB_USER', $dbUsername);

/** MySQL database password */
define('DB_PASSWORD', $dbPassword);

/** MySQL hostname */
define('DB_HOST', $dbEndpoint);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**
 * For VaultPress
 */
define( 'VAULTPRESS_DISABLE_FIREWALL', true );
if ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
   $forwarded_ips = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
   $_SERVER['REMOTE_ADDR'] = $forwarded_ips[0];
   unset( $forwarded_ips );
}

/**
 * For Nginx Cache Controller
 */
define('IS_AMIMOTO', true);
define('NCC_CACHE_DIR', '/var/cache/nginx/proxy_cache');

/** Cache Key **/
define('WP_CACHE_KEY_SALT', DB_NAME);

/**
 * For C3 CloudFront Clear Cache
 **/
define('AMIMOTO_CDN_ID', $cfDistributionId);

/** disable wp-cron **/
define('DISABLE_WP_CRON', true);

/** disavle concatenate scripts **/
define('CONCATENATE_SCRIPTS', false);

/** site_url, home_url settings **/
if ( isset($_SERVER['HTTP_HOST']) ) {
    $server_name = $_SERVER['HTTP_HOST'];
}
$schema = isset($_SERVER['HTTPS']) ? 'https' : 'http';
if ( $schema === 'http' && isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) ) {
    $schema = $_SERVER['HTTP_X_FORWARDED_PROTO'];
}
if ( $schema === 'http' && isset( $_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] ) ) {
    $schema = $_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'];
}
define('WP_SITEURL', "{$schema}://{$server_name}");
define('WP_HOME',    "{$schema}://{$server_name}");
$_SERVER['HTTP_HOST'] = $server_name;
$_SERVER['SERVER_NAME'] = $server_name;
if ( $schema === 'https' ) {
    $_SERVER['HTTPS']='on';
}
unset($schema);
unset($server_name);

if( ! file_exists('/tmp/upgrade') ){
    mkdir('/tmp/upgrade', 0755);
};
