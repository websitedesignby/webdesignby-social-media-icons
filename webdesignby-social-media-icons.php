<?php

/*
Plugin Name: Webdesignby Social Media Icons Widget
Plugin URI: http://www.webdesignby.com/wordpress/plugins/social-media-icons
Description: Displays social media icons
Author: webdesignby.com
Version: 1.0
Author URI: http://www.webdesignby.com/
*/

class webdesignby_social_media_icons extends WP_Widget {

    const widget_name = "Social Media Icons";
    const PLUGIN_KEY = "webdesignby_social_media_icons";
    
    private $widget_args = array();
    private $social_media_sites = array();
    
    // constructor
    function __construct(){
        $this->set_description( __('Display social media icons.', self::PLUGIN_KEY) );
         parent::__construct(false, __(self::widget_name, self::PLUGIN_KEY), $this->widget_args );
    }
    
    private function set_description($description = ""){
        if( ! empty($description) ){
            $this->widget_args['description'] = $description;
        }
    }
    
    /* 
     * get a unique id to use in the form! 
     */
    
    private function get_instance_number(){
        return $this->id;
    }

    // widget form creation
    function form($instance) {	
        
        $id = $this->get_instance_number();
        
        $title = $sites =  $urls = $template = $color = '';

        // Check values
        if( $instance) {
            if( isset($instance['title']) )
                $title = esc_attr($instance['title']);
            if( isset( $instance['sites'] ) )
                $sites = $instance['sites'];
            if( isset( $instance['urls'] ) ) 
                $urls = $instance['urls'];
            if( isset( $instance['template'] ) ) 
                $template = $instance['template'];
            if( isset( $instance['color'] ) ) 
                $color = $instance['color'];
            if( isset( $instance['size'] ) )
                $size = $instance['size'];
        }
        
        
        // form HTML
        ?>
        <div id="<?php echo $id; ?>">
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wp_widget_plugin'); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <?php
            if( isset($sites) && !empty($sites) && is_array($sites) ):
                $i = 0;
                foreach($sites as $site):
                    if( isset($urls[$i]) && ! empty($urls[$i]) ):
                ?>
            <div id="site-container-<?php echo $i; ?>" class="social-media-icon">
                <p>
                    <label for="<?php echo $this->get_field_id('sites'); ?>"><?php echo __('Site', 'webdesignby'); ?>:</label>
                    <select name="<?php echo $this->get_field_name('sites'); ?>[]" id="<?php echo $this->get_field_id("sites") . "-" . $i; ?>"></select>
                    <script>
                        webdesignby_populate_social_media_icon_options("<?php echo $this->get_field_id("sites") . "-" . $i; ?>", "<?php echo $site; ?>"); 
                    </script>
                    <br />
                    <label for="<?php echo $this->get_field_id("urls"); ?>[]"><?php echo __('URL', 'webdesignby'); ?>:</label>
                    <input type="text" class="widefat" id="<?php echo $this->get_field_id('urls'); ?>" name="<?php echo $this->get_field_name('urls'); ?>[]" value="<?php echo $urls[$i]; ?>" />
                    <br />
                    <a href="javascript:;" onclick="webdesignby_remove_social_media_icon('site-container-<?php echo $i; ?>');"><?php echo __("Remove", 'webdesignby'); ?></a>
                </p>
            </div>
            <?php endif; $i++; endforeach; endif; ?>
            <div class="webdesignby-social-media-icons-add-icon"></div>
            <p>
                <button type="button" id="add-sm-icon" onclick="webdesignby_add_social_media_icon('<?php echo $id; ?>', '<?php echo $this->id_base; ?>', '<?php echo $this->number; ?>');">+ Add a Social Media Icon</button>
            </p>
        </div>
        
        <p>
            <label for="<?php echo $this->get_field_id('template'); ?>"><?php echo __('Template', 'webdesignby'); ?>:</label><br />
            <input id="<?php echo $this->get_field_id('template'); ?>-1" name="<?php echo $this->get_field_name('template'); ?>" type="radio" value="circle" <?php if( ( isset($template) && ($template == "circle") ) || ( empty($template)) ){?> checked="checked"<?php } ?> /> <?php echo __('Circle', 'webdesignby'); ?><br />
            <input id="<?php echo $this->get_field_id('template'); ?>-2" name="<?php echo $this->get_field_name('template'); ?>" type="radio" value="square" <?php if( isset($template) && ($template == "square") ){?> checked="checked"<?php } ?> /> <?php echo __('Square', 'webdesignby'); ?><br />
            <input id="<?php echo $this->get_field_id('template'); ?>-3" name="<?php echo $this->get_field_name('template'); ?>" type="radio" value="rounded" <?php if( isset($template) && ($template == "rounded") ){?> checked="checked"<?php } ?> /> <?php echo __('Rounded', 'webdesignby'); ?><br />
            <input id="<?php echo $this->get_field_id('template'); ?>-4" name="<?php echo $this->get_field_name('template'); ?>" type="radio" value="custom" <?php if( isset($template) && ($template == "custom") ){?> checked="checked"<?php } ?> /> <?php echo __('Custom', 'webdesignby'); ?>
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('size'); ?>"><?php echo __('Size', 'webdesignby'); ?>:</label><br />
            <input id="<?php echo $this->get_field_id('size'); ?>-1" name="<?php echo $this->get_field_name('size'); ?>" type="radio" value="20" <?php if( ( isset($size) && ($size == 20) ) ){?> checked="checked"<?php } ?> /> <?php echo __('tiny (20px)', 'webdesignby'); ?><br />
            <input id="<?php echo $this->get_field_id('size'); ?>-2" name="<?php echo $this->get_field_name('size'); ?>" type="radio" value="40" <?php if( isset($size) && ($size == 40) || ( empty($size) ) ){?> checked="checked"<?php } ?> /> <?php echo __('small (40px)', 'webdesignby'); ?>
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('color'); ?>"><?php echo __('Color', 'webdesignby'); ?>:</label><br />
            <input id="<?php echo $this->get_field_id('color'); ?>-1" name="<?php echo $this->get_field_name('color'); ?>" type="radio" value="light" <?php if( ( isset($color) && ($color == "light") ) || ( empty($color)) ){?> checked="checked"<?php } ?> /> <?php echo __('Light', 'webdesignby'); ?><br />
            <input id="<?php echo $this->get_field_id('color'); ?>-2" name="<?php echo $this->get_field_name('color'); ?>" type="radio" value="dark" <?php if( isset($color) && ($color == "dark") ){?> checked="checked"<?php } ?> /> <?php echo __('Dark', 'webdesignby'); ?>
        </p>
        
        <?php
        /* 
         * Debug
         */
        /*
        var_dump($sites);
        var_dump($urls);
        var_dump($template);
         * 
         */
    }

    // widget update
    function update($new_instance, $old_instance) {

        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['sites'] = $new_instance['sites'];
        $instance['urls'] = $new_instance['urls'];
        $instance['template'] = strip_tags($new_instance['template']);
        $instance['color'] = strip_tags($new_instance['color']);
        $instance['size'] = strip_tags($new_instance['size']);
        return $instance;

    }

    // widget display
    function widget($args, $instance) {
        
        extract( $args );
        
        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        $sites = $instance['sites'];
        $urls = $instance['urls'];
        $template = $instance['template'];
        $color = $instance['color'];
        $size = $instance['size'];
        
        $id = $this->get_instance_number();
        
        echo $before_widget;
        
        $plugin_dir = plugin_dir_path( __FILE__ );
        
        if( $template == "custom" ){
            $theme_dir = get_template_directory();
            if( file_exists($theme_dir . "/webdesignby-social-media-icons/custom.php") ){
                include( $theme_dir . "/webdesignby-social-media-icons/custom.php" );
            }else{
                include( $plugin_dir . "/views/custom.php" );
            }
        }else{
            $template_path = $plugin_dir . "/views/" . $template . ".php";
            include( $template_path );
        }
        
        echo $after_widget;
    }
}

add_action( 'widgets_init', function(){
	register_widget( 'webdesignby_social_media_icons' );
});

// enqueue javascript
function webdesignby_social_media_icons_enqueue($hook) {
    if ( 'widgets.php' != $hook ) {
        return;
    }

    wp_enqueue_script( 'webdesignby_social_media_icons_enqueue', plugin_dir_url( __FILE__ ) . 'js/widget_form.js', array('jquery'), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'webdesignby_social_media_icons_enqueue' );

function webdesignby_social_media_icons_enqueue_styles() {
    wp_enqueue_style( 'webdesignby-social-media-icons', plugin_dir_url( __FILE__ ) . 'css/styles.css');
}

add_action( 'wp_enqueue_scripts', 'webdesignby_social_media_icons_enqueue_styles' );