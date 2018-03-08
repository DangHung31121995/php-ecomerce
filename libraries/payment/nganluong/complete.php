<?
ob_start();
require_once('nganluong.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php


$transaction_info = $_REQUEST['transaction_info'];
$order_code = $_REQUEST['order_code'];
$price = $_REQUEST['price'];
$payment_id = $_REQUEST['payment_id'];
$payment_type = $_REQUEST['payment_type'];
$error_text = $_REQUEST['error_text'];
$secure_code = $_REQUEST['secure_code'];

	/*Hàm thực hiện xác minh tính đúng đắn của các tham số trả về từ nganluong.vn*/
	
function verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code)
	{
		$merchant_site_code="29962";// mã website khai báo tại Ngân Lượng
		$secure_pass="phongcachso"; // Mật khẩu giao tiếp API
		// Tạo mã xác thực từ chủ web
		$str = '';
		$str .= ' ' . strval($transaction_info);
		$str .= ' ' . strval($order_code);
		$str .= ' ' . strval($price);
		$str .= ' ' . strval($payment_id);
		$str .= ' ' . strval($payment_type);
		$str .= ' ' . strval($error_text);
		$str .= ' ' . strval($merchant_site_code);
		$str .= ' ' . strval($secure_pass);
		
        // Mã hóa các tham số
		$verify_secure_code = '';
		$verify_secure_code = md5($str);
		
		
		
		// Xác thực mã của chủ web với mã trả về từ nganluong.vn
		if ($verify_secure_code == $secure_code) return true;
		
		return false;
	}


if(verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code)){
echo"|||Thanh toán thành công";
// code xử ký đơn hàng tại đây
}else { echo"Thất bại";
// Tham số trả về từ NL đã bị thay đổi
}
?>

</body>
</html>

