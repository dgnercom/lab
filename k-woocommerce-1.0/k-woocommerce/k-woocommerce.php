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
function dgner_settings_link( $links ) {  // 플러그인 전용 도네이션 링크이므로 function.php에 포함하지 마세요. 간단한 스니펫이라 응용 및 공유는 100% 자유로우며 상단 Plugin URI에 기입된 출저 표기만 해주시기 바랍니다.
    $donate_link = __( '<a target="_blank" style="color:#a050c8;font-weight:bold;" href="https://dgner.com/wp-content/uploads/dgner-korea-donation-link-designer-community-for-design-news-design-education-design-events-design-influencers-design-tools-design-forum-and-social-network.png">커피 한잔</a>', 'k-woocommerce' );
    array_unshift($links, $donate_link);
    return $links;
}
$dgner_plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$dgner_plugin", 'dgner_settings_link' );
add_action( 'wp_enqueue_scripts', 'dgner_wp_enqueue_scripts' ); // function.php에 직접 기입하는 경우, 18번째 줄이 Start Point 입니다. 카카오(다음) 우편번호 서비스 JS API를 특정 페이지에만 불러옵니다.
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
add_filter('woocommerce_form_field_text', 'dgner_woocommerce_form_field_text', 20, 2); // 우편번호 찾기 버튼의 구조를 생성하고 API와 연결합니다.
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
add_filter ( 'woocommerce_default_address_fields' , 'dgner_woocommerce_default_address_fields' ); // 불필요한 필드를 제거하고 우선순위를 변경합니다.
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
add_filter( 'woocommerce_billing_fields', 'dgner_woocommerce_billing_fields' ); // 청구주소 우편번호 찾기 버튼의 필드를 생성합니다. 청구주소 성과 이름 필드를 하나로(last_name 필드는 woocommerce_default_address_fields에서 제외됨) 합칩니다. 청구주소 이메일을 읽기 전용으로 만들어 변경할 수 없도록 합니다.
function dgner_woocommerce_billing_fields( $fields ) {        
    $fields['billing_postcode_search'] = array( 'priority' => 65 );
    $fields['billing_first_name']['label'] = 'Name';
    $fields['billing_email']['custom_attributes'] = array( 'readonly' => true );
    return $fields;
}
add_filter( 'woocommerce_shipping_fields', 'dgner_woocommerce_shipping_fields' ); // 배송주소 우편번호 찾기 버튼의 필드를 생성합니다. 배송주소 성과 이름 필드를 하나로(last_name 필드는 woocommerce_default_address_fields에서 제외됨) 합칩니다.
function dgner_woocommerce_shipping_fields( $fields ) {        
    $fields['shipping_postcode_search'] = array( 'priority' => 65 );
    $fields['shipping_first_name']['label'] = 'Name';
    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'dgner_woocommerce_checkout_fields' ); // 배송이 필요없는 가상 상품인 경우 주소 필드를 숨깁니다. 장바구니에 일반 상품이 포함된 경우 활성화 되지 않습니다.
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
}                    // function.php에 직접 기입하는 경우, 99번째 줄이 End Point 입니다.
?>
