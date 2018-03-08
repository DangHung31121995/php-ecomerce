<?php
class NL_Checkout 
{
	// URL chheckout của nganluong.vn
	private $nganluong_url = 'https://www.nganluong.vn/checkout.php';
    //private $nganluong_url = 'http://beta.nganluong.vn/checkout.php';

	// Mã merchante site 
	private $merchant_site_code = '30202';	// Biến này được nganluong.vn cung cấp khi bạn đăng ký merchant site

	// Mật khẩu bảo mật
	private $secure_pass= 'finalstyle'; // Biến này được nganluong.vn cung cấp khi bạn đăng ký merchant site

	
	public function buildCheckoutUrlNew($return_url, $receiver, $transaction_info, $order_code, $price, $currency = 'vnd', $quantity = 1, $tax = 0, $discount = 0, $fee_cal = 0, $fee_shipping = 0, $order_description = '', $buyer_info = '', $affiliate_code = '')
	{	
		$arr_param = array(
			'merchant_site_code'=>	strval($this->merchant_site_code),
			'return_url'		=>	strval(strtolower($return_url)),
			'receiver'			=>	strval($receiver),
			'transaction_info'	=>	strval($transaction_info),
			'order_code'		=>	strval($order_code),
			'price'				=>	strval($price),
			'currency'			=>	strval($currency),
			'quantity'			=>	strval($quantity),
			'tax'				=>	strval($tax),
			'discount'			=>	strval($discount),
			'fee_cal'			=>	strval($fee_cal),
			'fee_shipping'		=>	strval($fee_shipping),
			'order_description'	=>	strval($order_description),
			'buyer_info'		=>	strval($buyer_info),
			'affiliate_code'	=>	strval($affiliate_code)
		);
		$secure_code ='';
		$secure_code = implode(' ', $arr_param) . ' ' . $this->secure_pass;
		$arr_param['secure_code'] = md5($secure_code);
		/* */
		$redirect_url = $this->nganluong_url;
		if (strpos($redirect_url, '?') === false) {
			$redirect_url .= '?';
		} else if (substr($redirect_url, strlen($redirect_url)-1, 1) != '?' && strpos($redirect_url, '&') === false) {
			$redirect_url .= '&';			
		}
				
		/* */
		$url = '';
		foreach ($arr_param as $key=>$value) {
			$value = urlencode($value);
			if ($url == '') {
				$url .= $key . '=' . $value;
			} else {
				$url .= '&' . $key . '=' . $value;
			}
		}
		
		return $redirect_url.$url;
	}
	
	
	
	/*Hàm thực hiện xác minh tính đúng đắn của các tham số trả về từ nganluong.vn*/
	
	public function verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code)
	{
		// Tạo mã xác thực từ chủ web
		$str = '';
		$str .= ' ' . strval($transaction_info);
		$str .= ' ' . strval($order_code);
		$str .= ' ' . strval($price);
		$str .= ' ' . strval($payment_id);
		$str .= ' ' . strval($payment_type);
		$str .= ' ' . strval($error_text);
		$str .= ' ' . strval($this->merchant_site_code);
		$str .= ' ' . strval($this->secure_pass);

        // Mã hóa các tham số
		$verify_secure_code = '';
		$verify_secure_code = md5($str);
		
		// Xác thực mã của chủ web với mã trả về từ nganluong.vn
		if ($verify_secure_code === $secure_code) return true;
		
		return false;
	}
}