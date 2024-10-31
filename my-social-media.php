<?php
/**
 * My Social Media plugin that allows to add more admin information.
 *
 * @package           My Social Media
 * @author            Abdul Hadi <abdul.hadi.aust@gmail.com>
 * @copyright         2021 Abdul Hadi
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       My Social Media
 * Plugin URI:        https://github.com/abdulhadicse/my-social-media
 * Description:       This is a social media plugin that allows to display the administrator information where admin enter their social media information like Facebook, Twitter, LinkedIn, YouTube and more.
 * Version:           1.0.0
 * Requires at least: 4.1
 * Requires PHP:      5.6
 * Author:            Abdul Hadi
 * Author URI:        http://abdulhadi.info
 * Text Domain:       my-social-media
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
 * Copyright (c) 2021 Abdul Hadi (email: abdul.hadi.aust@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

 // don't call the file directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Main Class
 */
final class My_Social_Media{
    /**
     * Plugin version
     */
    const version = '1.0.0';
   
    /**
     * save form error data
     *
     * @var array
     */
    public $errors = [];

    /**
     * Retrive user data from db
     *
     * @var array
     */
    public $form_info = [];


    /**
     * set true or false after
     * submit successful or not
     *
     * @bool
     */
    public $is_submit;
   
    /**
     * our constructor 
     * call initial hook
     *
     * @return void
     */
    private function __construct() {
        $this-> define_constant();
        register_activation_hook( __FILE__, [$this, 'msm_active'] );
        add_action( 'plugins_loaded', [$this, 'init_plugins'] );
       
    }

    /**
     * Call Initial Plugin
     *
     * @return void
     */
    public function init_plugins() {
        add_action( 'wp_enqueue_scripts', [$this,'add_enqueue_script']);
        
        if( is_admin() ){
            add_action( 'admin_menu', [$this, 'register_my_social_media_menu'] );
            add_action( 'admin_init', [ $this, 'form_handler' ] );
            add_action( 'admin_init', [$this, 'show_msm_form_info'] );
        }
        add_action( 'the_content', [$this, 'msm_my_social_media'] );
    }

    /**
     * Add social media box with content
     *
     * @param String $content
     * @return String Content
     */
    public function msm_my_social_media( $content ) {
        global $post;

        $author   = get_user_by( 'id', $post->post_author );
        $data = unserialize( get_option( 'msm_my_social_media_info' ) );

        //eheck user input data empty or not
        if( ! empty($data) ) {
            ob_start();
            include __DIR__ . '/assets/views/admin-view.php'; 
            $bio_content = ob_get_clean();

            return $content . $bio_content;
        }
        return $content; 
    }

    /**
     * Enqueue CSS Style
     *
     * @return void
     */
    public function add_enqueue_script() {
        wp_enqueue_style( 'my-social-media-css', plugins_url( '/assets/css/my-social-media.css', __FILE__ ) , null, time() );
    }

    /**
     * Register a sub menu
     *
     * @return void
     */
    public function register_my_social_media_menu() {
        add_menu_page( __('My Social Media', 'my-social-media'), __('My Social Media', 'my-social-media'), 'manage_options', 'my-social-media', [$this,'add_my_social_media_info'], 'dashicons-id' );
    }

    /**
     * HTML form Markup
     *
     * @return void
     */
    public function add_my_social_media_info() {
        include __DIR__ . '/assets/views/admin-info.php';  
    }

    /**
     * Retrive user data from option table
     *
     * @return void
     */
    public function show_msm_form_info() {
        $this->form_info = unserialize( get_option( 'msm_my_social_media_info' ) ); 
    }

    /**
     * Handle Input form 
     * save user data into option table
     *
     * @return $data User data
     */
    public function form_handler() {
        //eheck submit button click or not
        if( ! isset( $_POST['submit_media_info'] ) ) {
            return;
        }
         //eheck current user do that or not
        if( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you cheating?' );
        }
        // check verify nonce
        if( ! wp_verify_nonce( $_POST['_wpnonce'], 'my-social-media' ) ) {
            wp_die( 'Are you cheating?' );
        }

        //collect input field data
        $name       = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
        $bio        = isset( $_POST['bio'] ) ? sanitize_textarea_field( wp_unslash( $_POST['bio'] ) ) : '';
        $phone      = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
        $email      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
        $linkedin   = isset( $_POST['linkedin'] ) ? sanitize_text_field( wp_unslash( $_POST['linkedin'] ) ) : '';
        $youtube    = isset( $_POST['youtube'] ) ? sanitize_text_field( wp_unslash( $_POST['youtube'] ) ) : '';
        $facebook   = isset( $_POST['facebook'] ) ? sanitize_text_field( wp_unslash( $_POST['facebook'] ) ) : '';
        $twitter    = isset( $_POST['twitter'] ) ? sanitize_text_field( wp_unslash( $_POST['twitter'] ) ) : '';
        
        // name input field empty or not
        if ( empty( $name ) ) {
            $this->errors['name'] = __(' You must provide a name.', 'my-social-media' );
            $this->is_submit = '2';
        }
        // bio input field empty or not
        if ( empty( $bio ) ) {
            $this->errors['bio'] = __(' You must provide a short description about yourself.', 'my-social-media' );
            $this->is_submit = '2';
        }
        // email input field empty or not
        if ( empty( $email ) ) {
            $this->errors['email'] = __(' You must provide an email.', 'my-social-media' );
            $this->is_submit = '2';
        }

        if ( ! empty( $this->errors ) ) {
            return;
        }

        $user_data = [
            "name"      => $name,
            "bio"       => $bio,
            "phone"     => $phone,
            "email"     => $email,
            "linkedin"  => $linkedin,
            "youtube"   => $youtube,
            "facebook"  => $facebook,
            "twitter"   => $twitter 
        ];
        //serialize user submit data
        $data = serialize( $user_data );
        //insert data into db
        update_option( 'msm_my_social_media_info', $data );
        $this->is_submit = '1';
    }
    /**
     * Store Info Install Plugin
     *
     * @return void
     */
    public function msm_active() {
        $install = get_option( 'msm_my_social_media_install' );
        if( ! $install ) {
            update_option( 'msm_my_social_media_install', time() );
        }
        update_option( 'msm_my_social_media_version', MSM_VERSION );
    }
    /**
     * Create a signleton instance
     * of our main class
     *
     * @return \My_Social_Media
     */
    public static function init() {
        static $instance = false;
        if( ! $instance ) {
            $instance = new self();
        }
        return $instance;
    }
    /**
     * Define require plugin constant
     *
     * @return void
     */
    public function define_constant() {
        define( 'MSM_VERSION', self::version );
        define( 'MSM_FILE', __FILE__ );
        define( 'MSM_PATH', __DIR__ );
        define( 'MSM_URL', plugins_url( '', MSM_FILE ) );
        define( 'MSM_ASSETS', MSM_URL . '/assets' );
    }

    /**
     * Check data update or not
     * show error message notification
     *
     * @param int $is_submit
     * @return Array
     */
    public function is_show_error_notice( $is_submit ){
        $error_notice = [];
        
        if ( !empty( $is_submit ) && '1' === $is_submit) {
            $error_notice = [
                "status" => "success",
                "message" => "Update Successfully"
            ];
        }

        if ( !empty( $is_submit ) && '2' === $is_submit) {
            $error_notice = [
                "status" => "error",
                "message" => "Failed"
            ];
        }

        return $error_notice;
    }
}
/**
 * Call main class
 *
 * @return \My_Social_Media
 */
function my_social_media() {
    return My_Social_Media::init();
}
//kick-of
my_social_media();