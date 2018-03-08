<?php
if(!function_exists('loadMainContent')){
    /**
     * 
     */
    function loadMainContent($module = ''){
        if (isset($_SESSION['have_redirect'])){
            if ($_SESSION['have_redirect'] == 1){
                echo "<div id='message_rd' >";
                $types = array(
                    0 => 'error',
                    1 => 'alert',
                    2 => 'suc');
                foreach ($types as $type){
                    if (isset($_SESSION["msg_$type"])){
                        $msg_error = $_SESSION["msg_$type"];
                        foreach ($msg_error as $item){
                            echo "<script type='text/javascript'>alert('" . $item . "'); </script>";
                        }
                        unset($_SESSION["msg_$type"]);
                    }
                }
                echo "</div>";
            }
            unset($_SESSION['have_redirect']);
        }
        $view = FSInput::get('view', $module);
        /* Phiên bản mobile */
        if(IS_MOBILE)
            $view = 'm'.$view;
        $path = PATH_BASE . 'modules' . DS . $module . DS . 'controllers' . DS . $view .".php";
        //echo $path;die;
        if (file_exists($path)){
            require_once $path;
            $c = ucfirst($module) . 'Controllers' . ucfirst($view); 
            $controller = new $c();
            $task = FSInput::get('task');
            $task = $task ? $task : 'display';
            $controller->$task();
        }
    }
}
function randomkey($str, $keyword = 0)
{
    $return = '';
    $strreturn = explode(" ", trim($str));
    $i = 0;
    $listid = '';
    while ($i < count($strreturn))
    {
        $id = rand(0, count($strreturn));
        if (strpos($listid, '[' . $id . ']') === false)
        {
            if (isset($strreturn[$id]))
            {
                $return .= $strreturn[$id] . ' ';
                $i++;
                if ($keyword == 1 && ($i % 2) == 0 && $i < count($strreturn))
                    $return .= ',';
                $listid .= '[' . $id . ']';
            }
        }
    }
    return $return;
}
function array_language()
{
    return array(1 => "vn", 2 => "en");
}
function formatNumber($value)
{
    return number_format($value, 0, "", ".");
}
/*
*	type: msg, error, alert.
*/
function setRedirect($url, $msg = '', $type = '')
{
    if ($msg)
    {
        switch ($type)
        {
            case 'error':
                if (!isset($_SESSION['msg_error']))
                    $msg_error = array();
                else
                    $msg_error = $_SESSION['msg_error'];
                $msg_error[] = $msg;
                $_SESSION['msg_error'] = $msg_error;
                break;
            case 'alert':
                if (!isset($_SESSION['msg_alert']))
                    $msg_alert = array();
                else
                    $msg_alert = $_SESSION['msg_alert'];
                $msg_alert[] = $msg;
                $_SESSION['msg_alert'] = $msg_alert;
                break;
            case '':
            default:
                if (!isset($_SESSION['msg_suc']))
                    $msg_suc = array();
                else
                    $msg_suc = $_SESSION['msg_suc'];
                $msg_suc[] = $msg;
                $_SESSION['msg_suc'] = $msg_suc;
                break;
        }
        $_SESSION['have_redirect'] = 1;
    }
    if (headers_sent())
    {
        echo "<script>document.location.href='$url';</script>\n";
    } else
    {
        //@ob_end_clean(); // clear output buffer
        session_write_close();
        //header( 'HTTP/1.1 301 Moved Permanently' );
        header("Location: " . $url);
    }
    exit();
}
/******* CUT STRING BY LENGTH ********/
function format_money($price)
{
    if (!$price)
        $price = 0;
    return number_format($price, 0, ',', '.');
}
/******* end CUT STRING BY LENGTH ********/
function array_remove_empty($array)
{
    if (!count($array))
        return $array;
    $array_new = array();
    foreach ($array as $item)
    {
        if (trim($item) == '' || !$item)
            continue;
        $array_new[] = $item;
    }
    return $array_new;
}
function implodeWord($str, $noWord)
{
    $str = preg_replace("/ +/i", " ", $str);
    $array = explode(" ", $str);
    for ($i = 0; $i < $noWord; $i++)
    {
        if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/i", $array[$i]))
            $aryContent[] = $array[$i];
    }
    $strContent = implode(" ", $aryContent);
    return $strContent;
}
function getWord($noWord, $str)
{
    $noCountWord = count_words(strip_tags($str));
    if ($noCountWord >= $noWord)
    {
        $content = implodeWord(strip_tags($str), $noWord) . '...';
    } else
    {
        $content = strip_tags($str);
    }
    $k = chr(92);
    $content = str_replace($k, "", $content);
    return $content;
}
function count_words($str)
{
    $words = 0;
    $str = preg_replace("/ +/i", " ", $str);
    $array = explode(" ", $str);
    for ($i = 0; $i < count($array); $i++)
    {
        if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/i", $array[$i]))
            $words++;
    }
    return $words;
}
if (!function_exists('show_error'))
{
    function show_error($error)
    {
        echo $error;
    }
}
function testVar($var){
    print_r('<pre>');
    print_r($var);
    print_r('</pre>');
}
function getCurrentUrl($remove=''){
	$url = '';
	$qString = $_SERVER['REQUEST_URI'];
	if(strpos($qString, '?') ==FALSE) return $qString.'?';	
	$qString = explode('?',$qString);
	$url.=$qString[0];
	$get	= explode('&',$qString[1]);
	$pre	='';
	foreach ($get as $value){
  		$val = explode('=', $value);
  		if(!(in_array($val[0], $remove)) AND $val[1]!=''){
  			if($pre=='') { $pre = '?';
  			}else{
  				$pre ='&';
  			}
  			$url.=$pre.$val[0].'='.$val[1];
  		}
	}		
    if(strpos($url, '?') ==FALSE) {$url.='?'; }else{ $url.='&'; } 
	return $url;	
}
function convertDateTime($strDate = "", $strTime = ""){
	//Break string and create array date time
	$strDate			= str_replace("/", "-", $strDate);
	$strDateArray	= explode("-", $strDate);
	$countDateArr	= count($strDateArray);
	$strTime			= str_replace("-", ":", $strTime);
	$strTimeArray	= explode(":", $strTime);
	$countTimeArr	= count($strTimeArray);
	//Get Current date time
	$today			= getdate();
	$day				= $today["mday"];
	$mon				= $today["mon"];
	$year				= $today["year"];
	$hour				= $today["hours"];
	$min				= $today["minutes"];
	$sec				= $today["seconds"];
	//Get date array
	switch($countDateArr){
		case 2:
			$day	= intval($strDateArray[0]);
			$mon	= intval($strDateArray[1]);
			break;
		case $countDateArr >= 3:
			$day	= intval($strDateArray[0]);
			$mon	= intval($strDateArray[1]);
			$year = intval($strDateArray[2]);
			break;
	}
	//Get time array
	switch($countTimeArr){
		case 2:
			$hour	= intval($strTimeArray[0]);
			$min	= intval($strTimeArray[1]);
			break;
		case $countTimeArr >= 3:
			$hour	= intval($strTimeArray[0]);
			$min	= intval($strTimeArray[1]);
			$sec	= intval($strTimeArray[2]);
			break;
	}
	//Return date time integer
	if(@mktime($hour, $min, $sec, $mon, $day, $year) == -1) return $today[0];
	else return mktime($hour, $min, $sec, $mon, $day, $year);
}
function sendMailFS($title, $content, $nTo, $mTo, $mCc = ''){
    require_once(PATH_BASE.'libraries/PHPMailer_v5.1/class.phpmailer.php');
    $smtpHost   = 'smtp.gmail.com'; 
    $smtpPort   = '465'; 
    $smtpEmail  = 'lienhe@kivi.vn'; 
    $smtpPass   = 'giamcan2day';
    $nFrom = "Admin: ".$_SERVER['SERVER_NAME'];
	$mail             = new PHPMailer();
	$body             = $content;
	$mail->IsSMTP(); 							
	$mail->CharSet 	= "utf-8";
	$mail->SMTPDebug  = 0;                     	
	$mail->SMTPAuth   = true;                 
	$mail->SMTPSecure = "ssl";                 
	$mail->Host       = $smtpHost;      
	$mail->Port       = $smtpPort;                   	
	$mail->Username   = $smtpEmail;  
	$mail->Password   = $smtpPass;     
    $mail->SetFrom('cskh@kivi.vn','miski.vn');
    $mail->AddReplyTo('cskh@kivi.vn','miski.vn');     	 
    if($mCc != '')
        $mail->AddBCC($mCc, $nFrom);
	$mail->Subject    = $title;
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->MsgHTML($body);
	$mail->AddAddress($mTo, $nTo);
	if(!$mail->Send()) {
	  return 0;
	} else {
	  return 1;
	}
}
function writeFile($filename,$contents){
	$fp = fopen ($filename, "w"); 
	if($fp)
	{
		 fwrite ($fp,$contents); 
		 fclose ($fp); 
	}
}
function createOrderForm($id = 0, $product = ''){
    $html = '';
    $html .= '<div id="box-order-'.$id.'">';
    $html .= '    <form id="frmOrder-'.$id.'" name="frmOrder-'.$id.'" action="/" method="post">';
    $html .= '    <table class="tbl-order">';
    $html .= '        <tr>';
    $html .= '            <td><input class="order-name" name="order_name" type="text" placeholder="Nhập họ tên..." /></td>';
    $html .= '            <td><input class="order-email" name="order_email" type="text" placeholder="Nhập địa chỉ Email..." /></td>';
    $html .= '            <td><input class="order-mobile" name="order_mobile" type="text" placeholder="Nhập số điện thoại..." /></td>';
    $html .= '            <td><input class="order-address" name="order_address" type="text" placeholder="Nhập địa chỉ..." /></td>';
    $html .= '        </tr>';
    $html .= '        <tr>';
    $html .= '            <td colspan="4" style="text-align: center;">';
    $html .= '                <a class="btn-order" onclick="validQuickOrder('.$id.');" href="javascript:void(0);">Đăng ký mua ngay</a>';
    $html .= '            </td>';
    $html .= '        </tr>';
    $html .= '    </table>';
    $html .= '    <input class="order-product" name="order_product" type="hidden" value="'.$product.'" />';
    $html .= '    </form>';
    $html .= '</div>';
    return $html;
}
/**
 * Delete a file or delete all file in a directory
 *
 * @param string $str Path to file or directory
 */
function recursiveDelete($str){
    if(is_file($str)){
        return @unlink($str);
    }
    elseif(is_dir($str)){
        $scan = glob(rtrim($str,'/').'/*');
        foreach($scan as $index=>$path){
            recursiveDelete($path);
        }
    }
}

function custom_error_handler($e_number, $e_message, $e_files, $e_line, $e_var){
    $message = '<p>' . implode ( '</p><p>', (! is_array ( $e_message )) ? array ($e_message ) : $e_message ) . '</p>';
    if(!IS_LIVE)
        echo $message;
    else
        echo "<p class='warning'>Oop! Something went wrong, we are sorry for the inconvenice.</p>\n";          
}
/**
 * Ham cat chuoi
 * 
 * @param   string  $string     Chuoi ban dau
 * @param   int     $totalChar  Tong so ky tu muon lay
 * @param   string  $ext        Phan mo rong
 * 
 * @return  string
 */
function cutString($string = '', $totalChar = 0, $ext = '...'){
    if(mb_strlen($string, 'UTF-8') > $totalChar){
        $string = mb_substr($string, 0, $totalChar, 'UTF-8');
        if(mb_strrpos($string,' ',0,'UTF-8')){
            $string = mb_substr($string, 0, mb_strrpos($string,' ',0,'UTF-8'), 'UTF-8');
        }
        return $string.$ext;
    }
    return $string;
}   
/* Kế hoạch giảm cân */
function currenDate(){
    $day				= (int)date('d');
	$mon				= (int)date('m');
	$year				= (int)date('Y');
    return mktime(0, 0, 0, $mon, $day, $year);
}
function convertDatePlanner($strDate = ""){
	$strDate			= str_replace("/", "-", $strDate);
	$strDateArray	= explode("-", $strDate);
	$day	= intval($strDateArray[0]);
	$mon	= intval($strDateArray[1]);
	$year = intval($strDateArray[2]);
    return mktime(0, 0, 0, $mon, $day, $year);
}
function getCaloriesBurned($user = 0, $date = 0){
    global $db;
    $tdCalo = 0;
    $sqlFitness = " SELECT fit_calo, usf_duration
                    FROM fitness AS fits INNER JOIN users_fitness AS usfs ON(fits.id = usfs.usf_fitness)
                    WHERE usf_user = '$user' AND usf_date = $date";
    $db->query($sqlFitness);
    $listFitness = $db->getObjectList();
    if($listFitness){
        foreach($listFitness as $Fitness){
            $dCalo = number_format($Fitness->fit_calo*($Fitness->usf_duration/60),0,',','.');
            $tdCalo += $dCalo;
        }
    }
    return $tdCalo;
}
function getCalorieIntake($user = 0, $date = 0){
    global $db;
    $arrMeal = array(   
        1=>'Bữa sáng',
        2=>'Bữa trưa',
        3=>'Bữa tối',
        4=>'Bữa ăn nhẹ'
    );
    $totalCalo = 0;
    foreach($arrMeal as $meal_id=>$meal_title){
        $sqlFoods = "   SELECT fod_calo, usd_amount,
                            (SELECT fos_rate FROM foods_serving WHERE id = usd_serving LIMIT 1) AS fos_rate
                        FROM foods INNER JOIN users_diet AS usds ON(usds.usd_food = foods.id)
                        WHERE usd_date = $date AND usd_user = '$user' AND usd_meal = $meal_id";
        $db->query($sqlFoods);
        $listFoods = $db->getObjectList();
        if($listFoods){
            foreach($listFoods as $Foods){
                $fCalo      = $Foods->fod_calo    * $Foods->fos_rate * $Foods->usd_amount;
                $totalCalo += $fCalo;
            }
        }
    }
    return $totalCalo;
}
/* Phục vụ cho phiên bản mobile */
function getCategoriesTree(){
	global $db;
	$sql = $db->query('SELECT * FROM fs_products_categories WHERE published = 1');
	$result = $db->getObjectList();
	$tree  = FSFactory::getClass('tree','tree/');
	$list = $tree -> indentRows2($result);
	return $list;
}

function getQuarterText($start_date, $quarter){ 
    $return = array(
        'quarter' => '1',
        'year' => '1990',
        'text' => '1/1990'
    );
    $cMonth = date('n', strtotime($start_date));
    $cQuarter = ceil($cMonth / 3);
    $cYear = date('Y', strtotime($start_date));
    switch($quarter){
        case 'after2quarter':
            $cMonth = $cMonth + 3;
            $cQuarter = ceil(($cMonth%12) / 3);
            if($cMonth > 12)
                $cYear++;
            break;
        case 'after3quarter':
            $cMonth = $cMonth + 6;
            $cQuarter = ceil(($cMonth%12) / 3);
            if($cMonth > 12)
                $cYear++;
            break;
        case 'after4quarter':
            $cMonth = $cMonth + 9;
            $cQuarter = ceil(($cMonth%12) / 3);
            if($cMonth > 12)
                $cYear++;
            break;
    }
    $return = array(
        'quarter' => $cQuarter,
        'year' => $cYear,
        'text' => 'Q'.$cQuarter.'/'.$cYear
    );
    return $return;
}

function getQuarterToCurrent(){
    $return = array();
    $sMonth = date('n', strtotime(OPERATING_SYSTEM));
    $cMonth = date('n');
    $cYear = date('Y');
    $sQuarter = ceil($sMonth / 3);
    $cQuarter = ceil($cMonth / 3);
    
    for($i = $sQuarter; $i <= $cQuarter; $i++){
        $return[] = array(
            'quarter' => $i,
            'year' => $cYear,
            'text' => $i.'/'.$cYear
        );
    }
    return $return;
}

function getCurrentQuarter(){
    $cMonth = date('n');
    $cYear = date('Y');
    $cQuarter = ceil($cMonth / 3);
    $cYear = date('Y');
    return array(
        'quarter' => $cQuarter,
        'year' => $cYear,
        'text' => $cQuarter.'/'.$cYear
    );
}

function getPrevCurrentQuarter(){
    $cMonth = date('n');
    $cYear = date('Y');
    $cQuarter = ceil($cMonth / 3);
    $cYear = date('Y');
    if($cQuarter == 1){
        $cQuarter = 4;
        $cYear--;
    }else
        $cQuarter--;
    return array(
        'quarter' => $cQuarter,
        'year' => $cYear,
        'text' => $cQuarter.'/'.$cYear
    );
}

/**
 * Mã hóa chuối
 * @param String $str: chuỗi cần mã hóa
 * @return String 
 */ 
function fsEncode($str = ""){
	$returnStr = "";
	if(!empty($str)) {
		$enc = base64_encode($str);
		$enc = str_replace('=', '', $enc);
		$enc = str_rot13($enc);
		$returnStr = $enc;
	}
	return $returnStr;
}

/**
 * Giả mã chuỗi được mã hóa bởi hàm fsEncode()
 * @param String $str: chuỗi cần giải mã
 * @param Int $type: 0-String, 1-Int, 2-Double 
 * @return String đã giải mã
 */ 
function fsDecode($str = "", $type = 0){
    $returnStr = "";
    $str = str_replace(" ", "+", $str);
    if(!empty($str)) {
        $dec = str_rot13($str);
        $dec = base64_decode($dec);
        $returnStr = $dec;
    }
    switch($type){
        case 0:
            $returnStr = str_replace("\'","'",$returnStr);
            $returnStr = str_replace("'","''",$returnStr);
            return $returnStr;
            break;
        case 1:
            return intval($returnStr);
            break;
        case 3:
            return doubleval($returnStr);
            break;
    }
}