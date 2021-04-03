=== 우커머스 한국형 주소, Korea Address ===
Contributors: dgner
Tags: all in one, woocommerce, korea, korean, postcode, address, search, designer, dgner, daum, kakao, 올인원, 우커머스, 한국, 한국형, 우편번호, 주소, 검색, 디자이너, 디지앤이알, 다음, 카카오
Requires at least: 5.5
Tested up to: 5.7
Stable tag: 1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

설치 즉시 적용되는 5kb 우커머스 한국형 주소

== Description ==

• The plug-in uses the postal code open source api, which is provided by 'daum.net(Kakao Corp.)'
• The link to the postal code open source api is as follows :  '//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js'
• The services’ a terms of use and/or privacy policies are as follows : https://postcode.map.daum.net/guide
• Developer has no take responsibility for management. This plugin user has responsibility for all problems.

※ 주의사항을 포함한 플러그인 기능 설명입니다. 반드시 읽어주세요! ※
* 별도의 설정 없이 설치 즉시 적용되며, 5kb 이하로 매우 가벼운 스니펫
* 카카오(다음) 우편번호 서비스 JS API를 활용한 우편번호 검색 버튼 생성
* JS를 특정 페이지(Checkout & My Account)에서만 불러오도록 설정
* 우커머스 Billing & Shipping 필드를 한국인들이 선호하는 순서로 변경
* 일부 필수 항목을 선택 항목으로 변경(필요시 CSS로 숨김 처리 가능)
* 이메일을 변경할 수 없도록 만듬(필요시 CSS로 연하게 처리 가능)
* 배송이 필요 없는 상품이 장바구니에 포함된 경우 주문 간소화
* 워드프레스 혹은 우커머스 버전 업데이트에 의한 영향 최소화
* 주소 필드만 변경하는 단순한 스니펫으로 function.php에 적용 가능
* 주소 필드를 변경하는 다른 플러그인(결제와는 무관)과 혼용 불가

우커머스 한국형 주소와 우편번호 검색 기능을 찾으시는 분들을 위해 올인원 플러그인으로 배포합니다. 기존 한국형 주소 혹은 우편번호에 대한 웹상의 정보나 플러그인은 잘못되거나 기능이 과도하여, 정말 필요하다고 판단되는(주소 필드를 제외한 다른 플러그인에 간섭하지 않는) 기능들만 적용하였습니다. 본 플러그인은 단순한 스니펫이라서 워드프레스의 버전 업데이트에만 대응합니다. 본 플러그인의 버전별 원본은 Github에(https://github.com/dgnercom) 그대로 공유됩니다. 커스터마이징을 원하신다면 플러그인 설치보다는 function.php에 직접 적용하시기를 추천드립니다. 공유는 100% 자유이며 응용시 출저(https://github.com/dgnercom) 표기만 부탁드립니다 :)

국가 필드와 같은 선택 항목은 CSS로 숨김 처리가 가능합니다.
예시 : #billing_country_field {display:none !important;}
선택 항목 : #billing_postcode_search_field, #billing_country_field, #billing_phone_field, #shipping_postcode_search_field, #shipping_country_field

읽기 전용으로 변경된 이메일 주소의 경우 CSS로 연하게 처리하세요.
예시 : #billing_email {pointer-events:none !important; background:#eeeeee !important; color:#aaaaaa !important;}

우편번호 버튼의 경우 CSS로 디자인 변경이 가능합니다.
예시 : .postcode-button {color:#ffffff !important; background:#444444 !important;}

혹시 유용하셨나요? 제 카카오페이 QR 링크로 커피 한잔 부탁드려요 :)
QR 링크 : https://dgner.com/wp-content/uploads/coffee.png

== Installation ==

1. Upload 'k-woocommerce' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.



== Frequently Asked Questions ==

one@dgner.com



== Screenshots ==

1. 설치 즉시 적용되는 5kb 우커머스 한국형 주소


== Changelog ==

= 1.0 =
* First version


