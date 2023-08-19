<?php


namespace App\InsightAi;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly    

class INAIBase{

    public $plugin_url;
    public $pluginPrefix;

    public function __construct() {
        $this->plugin_url  = plugin_dir_url( dirname( __FILE__, 2 ) );
        $this->pluginPrefix  = INAI_PREFIX;

        $this->addAdministratorPermission();

        add_action( 'admin_init', array($this,'INAI_admin_init' ));
        
        add_action( 'admin_menu', array($this, 'INAI_admin_menu'));
        add_action( 'admin_enqueue_scripts', array($this,'enqueueScripts'));

        add_action( 'wp_enqueue_scripts', array($this,'enqueueFrontScripts'));

        add_action( 'wp_head', array($this,'appendToHeader') );
		add_action( 'admin_head', array($this,'appendToHeader') );

        add_shortcode('insight-ai-chat-gpt', [$this, 'insightAiChatGptCallBack']);
    }

    public function INAI_admin_init(){

        if (false == get_option('insight-ai-settings')) {
            add_option('insight-ai-settings');
        }
        
        register_setting('insight-ai-settings', 'insight-ai-settings');

    }

    public function addAdministratorPermission () {
		$admin_permissions = INAIGetAdminPermissions()->pluck('name')->toArray();
        
		if (count($admin_permissions)) {
			$admin_role = get_role( 'administrator' );
			foreach ($admin_permissions as $permission) {
				$admin_role->add_cap( $permission, true );
			}
		}
	}

    public function INAI_admin_menu(){
        $site_title = get_bloginfo('name');

        // echo $site_title;
        // print_r(INAIGetPermission('dashboard'));
        // die();
		add_menu_page( __($site_title),'insight-ai', 'InsightAI' , INAIGetPermission('dashboard') , 'dashboard/', [$this, 'adminDashboard'],  $this->plugin_url . 'assets/images/dashboard-icon.png' , 99);
    }

    public function enqueueFrontScripts(){
        wp_register_script( 'inai_front_js_bundle', $this->plugin_url . 'assets/js/front-app.min.js', ['jquery'], INAI_VERSION, true );
        wp_enqueue_style( 'inai_front_app_min_style', $this->plugin_url . 'assets/css/front-app.min.css', array(), INAI_VERSION,false );
        $tempArray = array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce('ajax_post'),
            'InsightAiPluginURL' => $this->plugin_url,
        );
        $key = $this->get_chat_gpt_key();
        if(!empty($key)){ $tempArray["api_key"] = $key; }
        wp_localize_script( 'inai_front_js_bundle', 'ajaxData', $tempArray);
    }

    
	public function appendToHeader () {
        $prefix = INAI_PREFIX;
        $upload_dir = wp_upload_dir();
        $dir_name = $prefix .'lang';
        $user_dirname = $upload_dir['baseurl'] . '/' . $dir_name;

        echo esc_html('<meta name="pluginBASEURL" content="' . $this->plugin_url .'" />','insight-ai');
        echo esc_html('<meta name="pluginPREFIX" content="' . $this->getPluginPrefix() .'" />,','insight-ai');
        echo esc_html('<meta name="pluginMediaPath" content="' .$user_dirname  .'" />','insight-ai');
	}

    public function enqueueScripts(){

        $tempArray = array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce('ajax_post'),
            'InsightAiPluginURL' => $this->plugin_url,
        );
        $key = $this->get_chat_gpt_key();
        if(!empty($key)){ $tempArray["api_key"] = $key; }

        wp_enqueue_style( 'INAI_app_min_style', $this->plugin_url . 'assets/css/app.min.css' , array(), INAI_VERSION );
        // wp_register_script( 'inai_js_bundle', $this->plugin_url . 'assets/js/app.min.js', ['jquery'], INAI_VERSION, true );
        wp_enqueue_script( 'INAI_js_bundle', $this->plugin_url . 'assets/js/app.min.js', ['jquery'], INAI_VERSION,true);
        wp_localize_script( 'INAI_js_bundle', 'ajaxData', $tempArray);
    }

    public function adminDashboard(){
        $options = get_option("insight-ai-settings");
        require_once(INAI_DIR . 'resources/views/INAI_dashboard.php');
    }

    public function getPluginPrefix() {
		return $this->pluginPrefix;
	}

    public function get_chat_gpt_key(){
        $options = get_option("insight-ai-settings");
        if(!empty($options["chat-gpt"]["key"])){
            return $options["chat-gpt"]["key"];
        }
        return "";
    }

    public function insightAiChatGptCallBack(){
        ob_start();
        wp_enqueue_script('inai_front_js_bundle');
        echo "<div id='app' class='kivi-care-appointment-booking-container kivi-widget' >
                <insight-ai-chat-gpt-widget >
                </insight-ai-chat-gpt-widget>
            </div>";
        return ob_get_clean();
    }

}