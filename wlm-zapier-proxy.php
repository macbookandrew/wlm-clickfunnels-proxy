<?php
/*
 * Plugin Name: Zapier Proxy for WishList Member
 * Version: 1.0.0
 * Description: Integrates Zapier with WishList Member generic shopping cart
 * Author: AndrewRMinion Design
 * Author URI: https://andrewrminion.com
 * Plugin URI: https://andrewrminion.com/2017/06/wlm-zapier-proxy
 * License: GPL2
 */

/*
 * Prevent this file from being accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get WishList Member’s generic secret key
 * @return string secret key
 */
function wlmcf_get_hash() {
    global $wpdb;
    $genericsecret = $wpdb->get_col( $wpdb->prepare( 'SELECT option_value FROM %1$swlm_options WHERE option_name LIKE "genericsecret";', $wpdb->prefix ) );
    return $genericsecret[0];
}

/**
 * Get WishList Member’s generic POST to URL
 * @return string POST to URL
 */
function wlmcf_get_post_url() {
    global $wpdb;
    $genericthankyou = $wpdb->get_col( $wpdb->prepare( 'SELECT option_value FROM %1$swlm_options WHERE option_name LIKE "genericthankyou";', $wpdb->prefix ) );
    return $genericthankyou[0];
}

/**
 * Post the data to WishList Member API
 * @param  array  $data customer data to add
 * @return object curl object with response from WishList Member API
 */
function wlmcf_post_to_wlm( $data ) {
    // get authentication info
    $postURL = get_home_url( NULL, '/index.php/register/' . wlmcf_get_post_url() );
    $secretKey = wlmcf_get_hash();

    // generate the hash
    $delimiteddata = strtoupper( implode( '|', $data ) );
    $hash = md5( $data['cmd'] . '__' . $secretKey . '__' . $delimiteddata );

    // include the hash in the data to be sent
    $data['hash'] = $hash;

    // post the data to WishList Member
    $ch = curl_init ( $postURL );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $returnValue = curl_exec( $ch );

    return $returnValue;
}

/**
 * Create new account
 */
function wlmcf_create_account() {
    // sanitize and prepare the data
    $data = array(
        'cmd'               => 'CREATE',
        'transaction_id'    => esc_attr( $_POST['transaction_id'] ),
        'lastname'          => esc_attr( $_POST['lastname'] ),
        'firstname'         => esc_attr( $_POST['firstname'] ),
        'email'             => esc_attr( $_POST['email'] ),
        'level'             => esc_attr( $_POST['level'] ),
    );

    $returnValue = wlmcf_post_to_wlm( $data );

    // process return value
    list( $cmd, $url ) = explode( "\n", $returnValue );

    // check if the returned command is the same as what we passed
    if ( $cmd == 'CREATE' ) {
        header ( 'Location:' . $url );
        exit;
    } else {
        die ( 'Error' );
    }
}
add_action( 'admin_post_nopriv_wlm_zapier_create_account', 'wlmcf_create_account' );
add_action( 'admin_post_wlm_zapier_create_account', 'wlmcf_create_account' );
