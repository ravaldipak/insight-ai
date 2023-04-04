<?php


namespace App\baseClasses;

class INAIBase{

    public $plugin_url;
    public $pluginPrefix;

    public function __construct() {
        $this->plugin_url  = plugin_dir_url( dirname( __FILE__, 2 ) );
        $this->pluginPrefix  = INAI_PREFIX;

        add_action( 'admin_enqueue_scripts', array($this,'enqueueScripts'));
        add_action( 'admin_menu', array($this, 'INAI_admin_menu'));

        add_action( 'wp_enqueue_scripts', array($this,'enqueueFrontScripts'));

        add_action( 'wp_head', array($this,'appendToHeader') );
		add_action( 'admin_head', array($this,'appendToHeader') );

        add_shortcode('insight-ai-chat-gpt', [$this, 'insightAiChatGptCallBack']);
    }

    public function INAI_admin_menu(){
        $site_title = get_bloginfo('name');
		add_menu_page( __( $site_title ), 'InsightAI' , INAIGetPermission('dashboard') , 'dashboard/', [$this, 'adminDashboard'], 'dashicons-chart-area', 99);
    }

    public function enqueueFrontScripts(){
        wp_register_script( 'inai_front_js_bundle', $this->plugin_url . 'assets/js/front-app.min.js', ['jquery'], INAI_VERSION, true );
        // wp_register_style( 'inai_front_app_min_style', $this->plugin_url . 'assets/css/front-app.min.css', array(), INAI_VERSION,false );
    }

    
	public function appendToHeader () {
        $prefix = INAI_PREFIX;
        $upload_dir = wp_upload_dir();
        $dir_name = $prefix .'lang';
        $user_dirname = $upload_dir['baseurl'] . '/' . $dir_name;

        echo '<meta name="pluginBASEURL" content="' . $this->plugin_url .'" />';
        echo '<meta name="pluginPREFIX" content="' . $this->getPluginPrefix() .'" />';
        echo '<meta name="pluginMediaPath" content="' .$user_dirname .'" />';
	}

    public function enqueueScripts(){
        wp_enqueue_style( 'INAI_app_min_style', $this->plugin_url . 'assets/css/app.min.css' , array(), INAI_VERSION );
        wp_enqueue_script( 'INAI_js_bundle', $this->plugin_url . 'assets/js/app.min.js', ['jquery'], INAI_VERSION,true);
    }

    public function adminDashboard(){
        require_once(INAI_DIR . 'resources/views/INAI_dashboard.php');
    }

    public function getPluginPrefix() {
		return $this->pluginPrefix;
	}

    public function insightAiChatGptCallBack(){
        ob_start();
        echo "work";
        wp_enqueue_script('inai_front_js_bundle');
        echo "<div id='app' class='kivi-care-appointment-booking-container kivi-widget' >
                <insight-ai-chat-gpt-widget >
                </insight-ai-chat-gpt-widget>
            </div>";
        return ob_get_clean();
    }

}