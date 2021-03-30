<?php
/**
 * Plugin Name: 우커머스 한국형 주소, Korea Address
 * Plugin URI: https://github.com/dgnercom
 * Description: 설치 즉시 적용되는 5kb 우커머스 한국형 주소
 * Version: 1.0
 * Author: dgner
 * Author URI: https://dgner.com
 * License: GPL3
 */
function dgner_settings_link( $links ) {        
    $donate_link = __( '<a target="_blank" style="color:#a050c8;font-weight:bold;" href="https://dgner.com/wp-content/uploads/dgner-korea-donation-link-designer-community-for-design-news-design-education-design-events-design-influencers-design-tools-design-forum-and-social-network.png">커피 한잔</a>', 'k-woocommerce' );
    array_unshift($links, $donate_link);
    return $links;
}
$dgner_plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$dgner_plugin", 'dgner_settings_link' );
add_action( 'wp_enqueue_scripts', 'dgner_wp_enqueue_scripts' );
function dgner_wp_enqueue_scripts() {        
    if ( ! is_account_page() && ! is_checkout() ) {
        return;
    }
    wp_enqueue_script( 'woocommerce-korea-postcode', '//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js', array(), null, true );
?>
    <script type="text/javascript">
        function billingPostcodeSearch() {        
            new daum.Postcode({
                oncomplete: function(data) {
                    document.getElementById('billing_postcode').value = data.zonecode;
                    document.getElementById('billing_address_1').value = data.address;
                    document.getElementById('billing_address_2').focus();
                }
            }).open();
        }
        function shippingPostcodeSearch() {        
            new daum.Postcode({
                oncomplete: function(data) {
                    document.getElementById('shipping_postcode').value = data.zonecode;
                    document.getElementById('shipping_address_1').value = data.address;
                    document.getElementById('shipping_address_2').focus();
                }
            }).open();
        }
    </script>
<?php
}
add_filter('woocommerce_form_field_text', 'dgner_woocommerce_form_field_text', 20, 2);
function dgner_woocommerce_form_field_text( $fields, $key ) {        
    $postcode_search_button = __( '우편번호 찾기', 'k-woocommerce' );
    if ($key === 'billing_postcode_search') {
        $fields = '<p class="form-row form-row-button" data-priority="65"><input type="button" class="postcode-button" style="width:100%; height:40px;" onclick="billingPostcodeSearch()" name="billingpostcodesearch" value="'.$postcode_search_button.'"></p>';
    }
    if ($key === 'shipping_postcode_search') {
        $fields = '<p class="form-row form-row-button" data-priority="65"><input type="button" class="postcode-button" style="width:100%; height:40px;" onclick="shippingPostcodeSearch()" name="shippingpostcodesearch" value="'.$postcode_search_button.'"></p>';
    }
    return $fields;
}
add_filter ( 'woocommerce_default_address_fields' , 'dgner_woocommerce_default_address_fields' );
function dgner_woocommerce_default_address_fields( $fields ) {        
    unset($fields['last_name']);
    unset($fields['company']);
    unset($fields['state']);
    unset($fields['city']);
	unset($fields['country']);
    $fields['first_name']['priority'] = 50;
    $fields['postcode']['priority'] = 60;
    $fields['address_1']['priority'] = 70;
    $fields['address_2']['priority'] = 80;
    return $fields;
}
add_filter( 'woocommerce_billing_fields', 'dgner_woocommerce_billing_fields' );
function dgner_woocommerce_billing_fields( $fields ) {        
    $fields['billing_postcode_search'] = array( 'priority' => 65 );
    $fields['billing_first_name']['label'] = 'Name';
    $fields['billing_email']['custom_attributes'] = array( 'readonly' => true );
    return $fields;
}
add_filter( 'woocommerce_shipping_fields', 'dgner_woocommerce_shipping_fields' );
function dgner_woocommerce_shipping_fields( $fields ) {        
    $fields['shipping_postcode_search'] = array( 'priority' => 65 );
    $fields['shipping_first_name']['label'] = 'Name';
    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'dgner_woocommerce_checkout_fields' );
function dgner_woocommerce_checkout_fields( $fields ) {        
    $only_virtual = true;
    foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        if ( ! $cart_item['data']->is_virtual() ) $only_virtual = false;
    }
    if( $only_virtual ) {
        unset($fields['billing']['billing_address_1']);
        unset($fields['billing']['billing_address_2']);
        unset($fields['billing']['billing_postcode']);
        unset($fields['billing']['billing_postcode_search']);
    }
    else {
    }
    return $fields;
}
?>