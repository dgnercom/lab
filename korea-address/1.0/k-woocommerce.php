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
add_action( 'wp_enqueue_scripts', 'dgner_wp_enqueue_scripts' ); // function.php 파일에 직접 붙여넣을 경우 Start Point. 카카오(다음) 우편번호 JS API를 특정 페이지에만 불러옵니다. 
function dgner_wp_enqueue_scripts() {        
    if ( ! is_account_page() && ! is_checkout() ) {
        return;
    }
    wp_enqueue_script( 'k-woocommerce-postcode', '//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js', array(), null, true );
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
add_filter( 'woocommerce_form_field_text', 'dgner_woocommerce_form_field_text', 20, 2 ); // 우편번호 찾기 버튼의 구성을 설정합니다.
function dgner_woocommerce_form_field_text( $fields, $key ) {        
    $postcode_search_button = __( '우편번호 찾기', 'k-woocommerce' );
    if ($key === 'billing_postcode_search') {
        $fields = '<p class="form-row form-row-button" id="billing_postcode_search_field" data-priority="65"><input type="button" class="postcode-button" style="width:100%; height:40px;" onclick="billingPostcodeSearch()" name="billingpostcodesearch" value="'.$postcode_search_button.'"></p>';
    }
    if ($key === 'shipping_postcode_search') {
        $fields = '<p class="form-row form-row-button" id="shipping_postcode_search_field" data-priority="65"><input type="button" class="postcode-button" style="width:100%; height:40px;" onclick="shippingPostcodeSearch()" name="shippingpostcodesearch" value="'.$postcode_search_button.'"></p>';
    }
    return $fields;
}
add_filter ( 'woocommerce_default_address_fields' , 'dgner_woocommerce_default_address_fields' ); // 한국형 주소로 바꾸기 위해 필요없는 필드를 제외하고 우선순위를 변경합니다. 
function dgner_woocommerce_default_address_fields( $fields ) {        
    unset($fields['last_name']);
    unset($fields['company']);
    unset($fields['state']);
    unset($fields['city']);
    $fields['first_name']['priority'] = 50;
    $fields['postcode']['priority'] = 60;
    $fields['address_1']['priority'] = 70;
    $fields['address_2']['priority'] = 80;
    $fields['country'] = array( 'priority' => 90, 'required' => false, 'type' => 'country' );
    return $fields;
}
add_filter( 'woocommerce_billing_fields', 'dgner_woocommerce_billing_fields' ); // Billing 우편번호 찾기 버튼의 필드를 생성합니다. 성과 이름을 하나로(이름 필드는 상단에서 제외) 합칩니다. 이메일 필드를 읽기 전용(유저가 직접 수정을 못하도록)으로 만듭니다.
function dgner_woocommerce_billing_fields( $fields ) {        
    $fields['billing_postcode_search'] = array( 'priority' => 65 );
    $fields['billing_first_name']['label'] = '이름';
    $fields['billing_email']['custom_attributes'] = array( 'readonly' => true );
    return $fields;
}
add_filter( 'woocommerce_shipping_fields', 'dgner_woocommerce_shipping_fields' ); // Shipping 우편번호 찾기 버튼의 필드를 생성합니다. 성과 이름을 하나로(이름 필드는 상단에서 제외) 합칩니다.
function dgner_woocommerce_shipping_fields( $fields ) {        
    $fields['shipping_postcode_search'] = array( 'priority' => 65 );
    $fields['shipping_first_name']['label'] = '이름';
    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'dgner_woocommerce_checkout_fields' ); // 장바구니에 배송이 필요없는 가상 상품만 있는 경우, 일부 주소 필드를 자동으로 비활성화 합니다. 
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
}  // function.php 파일에 직접 붙여넣을 경우 End Point.
?>
