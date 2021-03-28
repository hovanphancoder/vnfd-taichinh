<?php use App\Http\Controllers\Admin\OrderController;?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
	</head>
  <style type="text/css" media="all">
  @import url('https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin-ext');
  body{font-size:13px;line-height: 22px;font-family: FontAwesome,DejaVu Sans;}
  .content{width: 100%;display: inline-block;}
  .table{width:100%;border-spacing: 0;}
  .table thead th{padding:7px;border-bottom: 6px double #000;background:#ddd;}
  .table tbody td{padding: 8px 5px;}
  .table tbody .padd td{padding: 20px 5px;}
  .table tbody .bor td{border-top: 2px solid #000;}
  .table tbody .paddsub td{padding:2px 7px;}
  .table tbody .bor-end td{border-top: 2px solid #000;border-bottom: 6px double #000;}
  .kyten{text-transform: uppercase;}
  .block-dieukhoan{font-weight:bold;}
  .block-dieukhoan .dieukhoan{text-decoration: underline;}
  .left{text-align:left;}
  .right{text-align:right;}
  .center{text-align:center;}
  .bold{font-weight:bold;}
  .top{vertical-align: top;}
  .underline{text-decoration: underline;}
  .content img{width:120px;right:0;top:0;float:right;display: inline-block;text-align:right;}
  </style>
  </style>
  <body>
	<div class="content">
		<div class="right"><img src="{!!url('admin_assets/img/mt1.png')!!}" /></div>
		
		<h1>Sales Quotation</h1>
		<table class="table">
			<tr>
				<td class="bold top">					
					<div class="underline">TO</div>
					<div>{!!$customer['name']!!}</div>
					<div>{!!$customer['address']!!}</div>
					<div>{!!$customer['tel']!!}</div>
					<div>{!!$customer['fax']!!}</div>
					<div>{!!$customer['contact']!!}</div>				
				</td>
				<td>					
					<div class="underline">FROM</div>
					<div>Cty TNHH Thương Mại Dịch Vụ Quốc Tế M&T </div>
					<div>46 Phan Đình Phùng,P.Tân Thành,Q.Tân Phú, Tp.HCM </div>
					<div>ĐT +84 8 6656 0610</div>
					<div>MST 0313634290</div>
					<div>NH Vietcombank Sài Gòn</div>
					<div>69 Bùi Thị Xuân, P.Phạm Ngũ Lão, Q.1, Tp.HCM</div>
					<div>Số TK: 0331000453851</div>				
				</td>
			</tr>
			<tr>
				<td>
					<div>Ngày báo giá: &nbsp;&nbsp;&nbsp;&nbsp; <?php echo date('d/m/Y');?> </div>				
				</td>
				<td>
					<div>Mã KH: {!!$customer['customer_id']!!}</div>
					<div>Số BG: <b><?php echo date('ym').'-'.sprintf("%04d", $order_num).'V' ;?></b></div>
				</td>
			</tr>
		</table>
		<br />
		<table class="table">
			<thead>
			  <tr>
				<th>Stt</th>
				<th>Mã</th>
				<th>Mô tả</th>  
				<th>ĐVT</th>
				<th>SL</th>
				<th class="right">Đơn giá</th>
				<th class="right">T.Tiền(VND)</th>
			  </tr>
			</thead>
		  
			<tbody>
			@foreach($orderDetail as $count => $detail)
			  <tr class="padd">
				<td>{{$count+1}}</td>
				<td>14-132-423</td>
				<td class="bold">{{$detail['product']['name']}}</td>
				<?php 
					$items = OrderController::getUnit($detail['product']['unit']);
				?>
				<td class="center">{{$items['unit_vi']}}</td>
				<td class="center">{{$detail['quantity']}}</td>
				<td class="right">{{number_format($detail['quantity'])}}</td>
				<td class="right">{{number_format($detail['quantity'] * $detail['unit_price'])}}</td>
			  </tr>
			@endforeach  
			  <tr class="bor paddsub">
				<td colspan="6">TỔNG GIÁ TRỊ HÀNG HOÁ, VND</td>
				<td class="right">{{number_format($orders['subtotal'])}}</td>
			  </tr>
			  <?php
				$discount_num = '';
				if($orders['discount_percent']>0 && $orders['discount_percent']<=100){
					$discount = ($orders['subtotal'] * $orders['discount_percent'])/100;
					$discount_num = $orders['discount_percent'].'%';
				}else 	$discount = $orders['discount_percent'];
			 ?>
			  <tr class="paddsub">
				<td colspan="6">CHIẾT KHẤU: {{$discount_num}}</td>
				<td class="right">- {{number_format($discount)}}</td>
			  </tr>
			  <tr class="paddsub">
				<td colspan="6">THUẾ GTGT, 10%</td>
				<td class="right">+ {{number_format($orders['gtgt'])}}</td>
			  </tr>
			  <tr class="bor-end">
				<td colspan="6"><b>TỔNG GIÁ TRỊ ĐƠN HÀNG, VND</b></td>
				<td class="right"><b>{{number_format($orders['total_price'])}}</b></td>
			  </tr>
			</tbody>
		  
		</table>
		<br/><br/>
		<div class="block-dieukhoan">
			<div class="dieukhoan">Điều khoản</div>
			<p>
			Thanh toán (CK) 100% : 0% tạm ứng và 15 ngày sau khi xuất hoá đơn <br/>
			Giao hàng 08-10 tuần kể từ ngày nhận tiền thanh toán tạm ứng <br/>
			Hàng được giao tại quý công ty không bao gồm phí lắp đặt <br/>
			Bảo hành 0 tháng, không bảo hành phụ kiện và vật tư tiêu hao <br/>
			Hiệu lực báo giá 30 ngày kể từ ngày báo giá
			</p>
		</div>
		<br/>
		<br/>
		<div>TRÂN TRỌNG</div>
		
		<br/>
		<br/>
		<br/>
		<br/>
		--------------------------------------
		<div class="kyten">{!!$user['name']!!}</div>
		<div>+84 {!!$user['phone']!!}</div>
	</div>
    
  </body>
</html>