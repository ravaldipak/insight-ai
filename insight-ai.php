<?php
/**
 * Plugin Name: Insight AI
 * Plugin URI: https://insixus.com
 * Description: Chat GPT
 * Version:1.0.0
 * Author: ArcFly
 * Text Domain: insight-ai
 * Domain Path: /languages
 * Author URI: https://insixus.com
 **/

use App\InsightAi\INAIActivate;
use App\InsightAi\INAIDeactivate;
use App\InsightAi\INAIBase;
use App\InsightAi\INAIAdmin;
defined( 'ABSPATH' ) or die( 'Something went wrong' );

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
} else {
	die( 'Something went wrong' );
}

if (!defined('INAI_DIR'))
{
	define('INAI_DIR', plugin_dir_path(__FILE__));
}

if (!defined('INAI_DIR_URI'))
{
	define('INAI_DIR_URI', plugin_dir_url(__FILE__));
}

if (!defined('INAI_BASE_NAME'))
{
    define('INAI_BASE_NAME', plugin_basename(__FILE__));
}

if (!defined('INAI_NAMESPACE'))
{
	define('INAI_NAMESPACE', "insight-ai");
}

if (!defined('INAI_PREFIX'))
{
	define('INAI_PREFIX', "insightAi_");
}

if (!defined('INAI_VERSION'))
{
    define('INAI_VERSION', "1.0.0");
}

/**
 * The code that runs during plugin activation
 */
register_activation_hook( __FILE__, [ INAIActivate::class, 'activate'] );

/**
 * The code that runs during plugin deactivation
 */
register_deactivation_hook( __FILE__, [INAIDeactivate::class, 'deActivate'] );

(new INAIBase());
// (new INAIAdmin());