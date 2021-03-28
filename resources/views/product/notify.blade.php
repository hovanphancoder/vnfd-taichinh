<?php
use App\Coupon;
$coupon = Coupon::find($order['coupon_id']);
$discount_price = 0;
// dd($coupon->toArray());
// echo session()->get('id_don_hang');
// exit;
//echo "<pre>";
//print_r($listProduct);
//echo "</pre>";
// exit;
// dd($order->toArray());
?>
@extends('master')
@section('title','Thông báo')

@section('css')
@stop
@section('tracking')
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '928636344274255');
  fbq('track', 'Purchase', {
    value: <?php echo $order['id']?$order['id']:0;?>,
    currency: 'VND'
  });
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=928636344274255&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
@stop

@section('header')
@parent
@include('layouts.header')
@stop

@section('content')

<!--================End Main Header Area =================-->
<section class="banner_area">
    <div class="container">
        <div class="banner_text">
            <!--            <h3>Menu</h3>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><a href="menu.html">Menu</a></li>
                        </ul>-->
        </div>
    </div>
</section>
<!--================End Main Header Area =================-->

<!--================Recipe Menu list Area =================-->
<section class="price_list_area p_100">
    <div class="container">
        <div class="our_bakery_text">
            <p style="text-align: center;"><i class="fa fa-check"></i></p>
            <h1 style="text-align: center;"><strong>ĐẶT HÀNG THÀNH CÔNG!</strong></h1>
            <div class="notify--title">
                <p>Cảm ơn Khách hàng <span style="text-transform: uppercase; font-weight: bold">{!! $customer['name'] !!}</span> đã cho <span class="nha_tui">NHÀ TUI</span> decor được phục vụ.</p>
                <ul>
                  <li>Mã đơn hàng: #<span style="text-transform: uppercase;">{!! $order['order_number'] !!}</span></li>
                  @if($coupon)
                  <li>
                    Mã giảm giá: 
                    <span style="text-transform: uppercase;">{!! $coupon['code'] !!}</span> - 
                    <span style="color: red; font-weight: bold">
                      <?php
                        if($order['discount_percent'] >= 0 && $order['discount_percent'] <= 100){
                          $discount_price = ($order['total_price'] * $order['discount_percent']) / 100;
                        }else{
                          $discount_price = $order['discount_percent'];
                        }
                        echo number_format($discount_price).' đ';
                      ?>
                    </span>
                  </li>
                  @endif
                  <li>Người nhận: <span style="text-transform: uppercase;">{!! $customer['name'] !!}</span></li>
                  <li>Điện thoại: {!! $customer['phone'] !!}</li>
                  <li>
                    Tổng tiền: 
                    <span style="color: red; font-weight: bold">{!! number_format($order['total_price'] - $discount_price) !!} đ</span>
                  </li>
                  <li>Hình thức thanh toán: {!! $order['payment_method'] !!}</li>
                </ul>
                <p style="margin-top: 10px;">Ghi chú: Nhân viên <span class="nha_tui">NHÀ TUI</span> decor sẽ liên hệ với Quý khách để xác nhận thông tin.</p>
                <p style="text-align: center; margin-top: 20px;"><a class="pest_btn" href="{!! url('/') !!}"><i class="fa fa-home" aria-hidden="true"></i> Về trang chủ</a></p>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
</section>
<!--================End Main Header Area =================-->


@stop
@section('scripts')

@stop