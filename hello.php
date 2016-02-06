<?php
/**
 * @package Hello_Dolly WP API
 * @version 1.0
 */
/*
Plugin Name: Hello Dolly WP API
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Matt Mullenweg
Version: 1.6
Author URI: http://ma.tt/
*/

function hello_dolly_get_lyric( $request  ) {
	/** These are the lyrics to Hello Dolly */
	$lyrics = "Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
We feel the room swayin'
While the band's playin'
One of your old favourite songs from way back when
So, take her wrap, fellas
Find her an empty lap, fellas
Dolly'll never go away again
Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
We feel the room swayin'
While the band's playin'
One of your old favourite songs from way back when
Golly, gee, fellas
Find her a vacant knee, fellas
Dolly'll never go away
Dolly'll never go away
Dolly'll never go away again";

	// Here we split it into lines
	$lyrics = explode( "\n", $lyrics );

	if ( ! isset( $request['id'] ) ) {
		return array_map( function( $line ) { return array( 'line' => $line ); }, $lyrics );
	}
	// And then randomly choose a line
	return wptexturize( $lyrics[ (int) $request['id']  ] );
}

// We need some CSS to position the paragraph
function dolly_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#dolly {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;		
		margin: 0;
		font-size: 11px;
	}
	</style>
	";
}

add_action( 'admin_head', 'dolly_css' );

// register endpoint
function dolly_rest_endpoint() {
	register_rest_route( 'wp/v2', '/hello', array(
		'methods' => 'GET',
		'callback' => 'hello_dolly_get_lyric',
	));

	register_rest_route( 'wp/v2', '/hello' . '/(?P<id>[\d]+)', array(
		'methods' => 'GET',
		'callback' => 'hello_dolly_get_lyric',
	));
}

// Enqueue our JavaScript
function dolly_enqueue_scripts() {
	wp_enqueue_script( 'hellodolly', plugins_url( '/hello.js' , __FILE__ ), array( 'wp-api' ) );
}

add_action( 'rest_api_init', 'dolly_rest_endpoint' );
add_action( 'admin_notices', 'dolly_enqueue_scripts' );
