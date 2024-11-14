<?php declare( strict_types = 1 );

/**
 * Plugin Name: Asset Block
 * Plugin URI: https://github.com/PiotrPress/wordpress-asset-block
 * Description: This plugin adds an Asset Block for enqueueing registered scripts and styles in content, solving the issue of loading assets with patterns.
 * Version: 0.1.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Piotr Niewiadomski
 * Author URI: https://piotr.press
 * License: GPL v3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: piotrpress-asset-block
 * Domain Path: /languages
 * Update URI: false
 */

defined( 'ABSPATH' ) or exit;

add_action( 'enqueue_block_editor_assets', function() {
    wp_register_script( 'piotrpress-asset-block', plugins_url( 'block.js', __FILE__ ), [
        'wp-blocks',
        'wp-element',
        'wp-editor'
    ], null );
} );

add_action( 'init', function() {
    register_block_type( 'piotrpress/asset-block', [
        'api_version' => 3,
        'version' => '0.1.0',
        'icon' => 'editor-code',
        'title' => __( 'Asset', 'piotrpress-asset-block' ),
        'category' => 'text',
        'attributes' => [
            'type' => [ 'type' => 'string' ],
            'handle' => [ 'type' => 'string' ]
        ],
        'textdomain' => 'piotrpress-asset-block',
        'editor_script_handles' => [ 'piotrpress-asset-block' ],
        'render_callback' => function( $attributes ) {
            $function = 'wp_enqueue_' . $attributes[ 'type' ];
            $function( $attributes[ 'handle' ] );
        }
    ] );
} );