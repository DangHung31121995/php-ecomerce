<!-- HEAD -->
<?php
	$title = @$order ? FSText :: _('Xem đơn hàng ').'DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
//	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('',FSText :: _('Print'),'','print.png',0,1); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
<div> Mã đơn hàng: <strong><?php echo 'DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT); ?></strong>, ngày đặt: <strong><?php echo date('d/m/Y', strtotime($order -> created_time))?></strong></div>
<br/>
<?php $print = FSInput::get('print',0,'int');?>
<?php if(!$print){?>
<?php include_once 'detail_status.php';?>
<?php }?>
<br />
<form
	action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>"
	name="adminForm" method="post" enctype="multipart/form-data">
<table cellpadding="6" cellspacing="0" border="1" bordercolor="#CECECE"
	width='100%'>
	<thead>
		<tr>
			<th width="30">STT</th>
			<th>Tên sản phẩm</th>
			<th width="117"><?php echo "Giá(VNĐ)"; ?></th>
			<th width="117"><?php echo "Số lượng"; ?></th>
			<th width="117"><?php echo "Tổng giá tiền"; ?></th>
		</tr>
	</thead>
	<tbody>
											<?php 
											$total_money = 0;
											$total_discount = 0;
											for($i = 0 ; $i < count($data); $i ++ ){?>
											<?php
												 $item = $data[$i];
												 $link_view_product = FSRoute::_('index.php?module=product&view=product&code='.$item -> product_alias.'&ccode='.$item -> category_alias.'&Itemid=6');
												 $total_money += $item -> price*$item -> quantity;
												 $total_discount += $item -> discount * $item -> quantity;
											?>
												<tr class='row<?php echo ($i%2); ?>'>
			<td align="center"><strong><?php echo ($i+1); ?></strong><br />
			</td>

			<td><a href="<?php echo $link_view_product; ?>" target="_blank">
															<?php echo $item -> product_name; ?>
														</a><br />
                <?php if($item->color){ ?>
                    <span class="select-size"><span>Màu:</span> <img src="<?php echo URL_ROOT.$arrColors[$item->color] ?>"/></span>&nbsp;&nbsp;
                <?php } ?>
                <?php if($item->size){ ?>
                    <span class="select-size"><span>Size:</span> <a class="size-item" href="javascript:void(0);"><?php echo $arrSizes[$item->size] ?></a></span>
                <?php } ?>
            </td>

			<!--		PRICE 	-->
			<td><strong>
															<?php echo format_money($item -> price);  ?>
														</strong> VND</td>
			<td><input type="text" size="20" disabled="disabled"
				value="<?php echo $item->quantity; ?>" /></td>
			<td><span class='red'>
															<?php echo format_money($item -> price*$item -> quantity);  ?> VN&#272;
														</span></td>
		</tr>
											<?php } ?>
		<tr>
			<td colspan="4" align="right"><strong>T&#7893;ng ti&#7873;n:</strong></td>
			<td><strong class='red'><?php echo format_money($total_money); ?> VN&#272;</strong>
			</td>
		</tr>
		
		<?php if($order-> discount):?>
			  <tr>
				<td colspan="4" align="right"><strong><?php echo $order-> discount_title?>:</strong></td>
				<td><strong class='red'>- <?php echo format_money($order-> discount);?> VN&#272;</strong></td>
			  </tr>
			  <tr>
				<td colspan="4" align="right"><strong>Phải thanh toán:</strong></td>
				<td><strong class='red'><?php echo format_money($order -> total_after_discount);?> VN&#272;</strong></td>
			  </tr>
		  <?php endif;?>
							  
		</tbody>
</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="<?php echo $this -> module;?>"
	name="module"> <input type="hidden" value="<?php echo $this -> view;?>"
	name="view"> <input type="hidden" value="" name="task"> <input
	type="hidden" value="0" name="boxchecked"></form>
<!-- end FORM	MAIN - ORDER						--> <!--  ESTORE INFO -->
						<?php // include_once 'detail_estore.php';?>
						<!--  end ESTORE INFO --> <br />
<!--  SENDER INFO -->
		<?php include_once 'detail_buyer.php';?>
	<!--  end SENDER INFO --> <br />
<!--  RECIPIENT INFO -->
		<?php include_once 'detail_recipient.php';?>
	<!--  end RECIPIENT INFO --> <br />
	<?php include_once 'detail_payment.php';?>
	<br />
	<br />
</div>
<!-- END BODY-->

<script  type="text/javascript" language="javascript">
	print_page();
	function print_page(){
		var width = 800;
		var centerWidth = (window.screen.width - width) / 2;
//	    var centerHeight = (window.screen.height - windowHeight) / 2;
		$('.Print').click(function(){
			link = window.location.href;
			link += '&print=1';
			window.open(link, "","width="+width+",menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0',left="+ centerWidth + ",top=0");
		});
	}
</script>
