<?php

class alipay_pay {
	//应用ID
	public $appId = '2017111309909347';
	
	//私钥文件路径
	public $rsaPrivateKeyFilePath;

	//商户私钥值
	public $rsaPrivateKey = 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC2+h61Ct5NAd1inqtN55PMA2hTlpRb3PGT1D8MwTkDvt0xKuKOOfh8haRK6t/rOqZohL/mlCNlNMgVS8YEN6RBVklWtdoIDMLPF9PnUHw/XzzIRCNjZ5QzsCkv79kSutxICFUPHpYQlFhFP6jf7vO5fx9kpRDoTtitZS3yKmtuCp4Mdrs9HMkSRwu8AjHxgjBUWngvQn1u9FK9ZbSmFhn5fTBXpCiEOeGX9ZaJEtYfBqt1ctjPuE9sFVEznzKNP1z/exX8BcPHYo3nLTzaRq8fG03ZOrcehwelkTgjzkWQN4bBjOg2WBufzJqeY038OBhXQm47Pf4pnAJvHA2pw6whAgMBAAECggEAX0PAAxBChyNmaPclRy0/pONNSN/IJD/XQtkpbnGXRpzzuqqSQ+xotCQ8UokQxf7GLvqWku0jtIiTd4r48K8rhJzxGAUcHD7QmlPUjsU3uyLRmY7oQdPmtDaOaxfcE8VX9OTprDKHfOBPSNaJDPXyzOwjoxnRwLF0XGqmTkPJpQNc6qsAY32JgAcE9vQ1Z0F8Yzib0R1uK7ddZEBPDAwzZj27HVSIVpckgss0U4R6NfZfTVfwNoBXOEM8fpAakBeD3KAZDTKhRV0xVchIWcfhBBKSpagFJYGfs13qkZHHsumI7EgVEVEt6mHRcQ9yAVyJs3PpK4b3JR89sSOppZYdNQKBgQD17cBCGtplsuihoHINA/nMDbhEfErqD+E9oWAOf5cQQb+TkR334vcArU9ghBttBdF4OifCWKikRs+VmrUnSWI70Y1ruN9wx+Vr73LOAQ6rd0MYxhn64Shp6KUur36CawIiPhHIfxL9IsJdDV3BPwuNoSzGOQmaI50FZzRYD++ZmwKBgQC+eGabPMoa0xgfJAoyF3VxSa4CzGoYS7qBMFtOJBItgoXhLV+9tcFKfscE+9g5S58k1/K3dmOp2cESWkjcwRsf9oGTccBdyXVTGmaxuinSF9VGnzDj32KGBaBMLBxBEM6To7ZqSjOEF+ujZOoBvsSbN6EawHUWzB/vJ8+9ZPN68wKBgQCBqhsmP3ZLDKtvHGNFzYTVO56eLVJqWnkNv5ofytHhNmlF6st8OWS2LKqfXsf/EYRB+Zeg9pHkG5mzbWB6GEz88R25YD4e/qZN5HAJgbE0Yqsz0q88AZ8HSCxfkxQGu1jiqQtDRQzD/qGv4i4+h3kV8Zbj5IrVhFVz1dhZXf2cZQKBgQCeW8wzVR9Tnh54BabUbtyeC/w5J2suOAggUOwY07SpUdOtm+P1/p9uKGmfoyPqvwzZvRF3p17FYN49PANIRuUedfzVccXWNCDvrwuiyHzsyBPyW3hyfM+VTigwLJxxHGAkMAEB7h9Wu+yWNNi6Crm7s0ymyUyQX7ZNSHRXqw8kMQKBgD+2A+cVnAmWuLeAOahpoFOWf8QEIEC+N7Q0wj2dxeOIoPRXEsFnDZKJNoRmloFzTzhSP3ELH15nzkf4AtEwOui1Z3f3NHaJTBShTog++Fa8mDwtjnK//3R3K/DAX3vsLpzXq5uIzbm7jbYe1zcki1+XhzjDuvBxDwq5Jwc62B3e';

	//支付宝网关地址
	public $gatewayUrl = "https://openapi.alipay.com/gateway.do";
	//返回数据格式
	public $format = "json";
	//api版本
	public $apiVersion = "1.0";

	// 表单提交字符集编码
	public $postCharset = "UTF-8";

	//使用文件读取文件格式，请只传递该值
	public $alipayPublicKey = null;

	//支付宝公钥  使用读取字符串格式，请只传递该值
	public $alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAn5Y1CbRJyCSxEIhOwUALhOC4EVoul7uMhIKOeOb/9wYDpnoNS7hUDx0wtADRDF1McbM7a7Rvq5umBq+uBsfpfv5nyE1V8l+LS/9AFA/KLn54Oq7O7XjGreY5H54+WYPCuVIpctG5MxxIZSi41jZzUUuBDE0C4KaIXPZf5uaDlCy5SzuR/Q6BTbwuXlr1jO8dfrGlGkW4jAWYJqplochT2zD6KybMKayBmtDgV9xC/O1fRASdL5+R2TiIsoR8QiNXbzMRvOgyItQ1XmQkpsOc3a6m7+Hx+Bx1z11h2liB0tu9mmXhsEvFjfArTqDZI8AdOIqb07TjvZ1nHXg/YlgURQIDAQAB';

	// 开启页面信息输出
	public $debugInfo = true;

	private $fileCharset = "UTF-8";

	private $RESPONSE_SUFFIX = "_response";

	private $ERROR_RESPONSE = "error_response";

	private $SIGN_NODE_NAME = "sign";


	//加密XML节点名称
	private $ENCRYPT_XML_NODE_NAME = "response_encrypted";

	private $needEncrypt = false;


	//签名类型
	public $signType = "RSA2";


	//加密密钥和类型

	public $encryptKey;

	public $encryptType = "AES";

	protected $alipaySdkVersion = "alipay-sdk-php-20161101";

	public function dopay($arr) {
		$bizContentarr = array();
	    $bizContentarr['product_code'] = "FAST_INSTANT_TRADE_PAY";
	    $bizContentarr['body'] = trim($arr['ordbody']);
	    $bizContentarr['subject'] = trim($arr['ordsubject']);
	    $bizContentarr['total_amount'] = trim($arr['ordtotal_fee']);
	    $bizContentarr['out_trade_no'] = trim($arr['oid']);
	    $bizContent = json_encode($bizContentarr,JSON_UNESCAPED_UNICODE);
	    
		
		$sysParams["app_id"] = $this->appId;
		$sysParams["version"] = $this->apiVersion;
		$sysParams["format"] = $this->format;
		$sysParams["sign_type"] = $this->signType;
		$sysParams["method"] = "alipay.trade.page.pay";
		$sysParams["timestamp"] = date("Y-m-d H:i:s");
		$sysParams["alipay_sdk"] = $this->alipaySdkVersion;
		// 回调地址
		$sysParams["notify_url"] = 'http://ygjzhaopin.com/Home/callback/alipay_notify_url';
		$sysParams["return_url"] = $arr['site_dir'].'?m=Home&c=callback&a=alipay_return_url';
		$sysParams["charset"] = $this->postCharset;
		$sysParams["biz_content"] = $bizContent;

		//待签名字符串
		// $preSignStr = $this->getSignContent($sysParams);

		//签名
		$sysParams["sign"] = $this->generateSign($sysParams, $this->signType);

		$response = $this->buildRequestForm($sysParams);
		//输出表单
		echo $response;
	}

	/**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @return 提交表单HTML文本
     */
	protected function buildRequestForm($para_temp) {
		
		$sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->gatewayUrl."?charset=".trim($this->postCharset)."' method='POST'>";
		while (list ($key, $val) = each ($para_temp)) {
			if (false === $this->checkEmpty($val)) {
				//$val = $this->characet($val, $this->postCharset);
				$val = str_replace("'","&apos;",$val);
				//$val = str_replace("\"","&quot;",$val);
				$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
			}
        }

		//submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='ok' style='display:none;''></form>";
		
		$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
		
		return $sHtml;
	}

	public function generateSign($params, $signType = "RSA") {
		return $this->sign($this->getSignContent($params), $signType);
	}

	public function getSignContent($params) {
		ksort($params);

		$stringToBeSigned = "";
		$i = 0;
		foreach ($params as $k => $v) {
			if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

				// 转换成目标字符集
				$v = $this->characet($v, $this->postCharset);

				if ($i == 0) {
					$stringToBeSigned .= "$k" . "=" . "$v";
				} else {
					$stringToBeSigned .= "&" . "$k" . "=" . "$v";
				}
				$i++;
			}
		}

		unset ($k, $v);
		return $stringToBeSigned;
	}

	protected function sign($data, $signType = "RSA") {
		$priKey=$this->rsaPrivateKey;
		$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
			wordwrap($priKey, 64, "\n", true) .
			"\n-----END RSA PRIVATE KEY-----";		

		($res) or die('您使用的私钥格式错误，请检查RSA私钥配置'); 

		if ("RSA2" == $signType) {
			openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
		} else {
			openssl_sign($data, $sign, $res);
		}

		if(!$this->checkEmpty($this->rsaPrivateKeyFilePath)){
			openssl_free_key($res);
		}
		$sign = base64_encode($sign);
		return $sign;
	}

	/**
	 * 验签方法
	 * @param $arr 验签支付宝返回的信息，使用支付宝公钥。
	 * @return boolean
	 */
	function checkSign($arr){
		$result = $this->rsaCheckV1($arr, $this->alipayrsaPublicKey, $this->signtype);
		return $result;
	}

	/** rsaCheckV1
	 *  验证签名
	 *  在使用本方法前，必须初始化AopClient且传入公钥参数。
	 *  公钥是否是读取字符串还是读取文件，是根据初始化传入的值判断的。
	 **/
	public function rsaCheckV1($params, $rsaPublicKey,$signType='RSA') {
			$sign = $params['sign'];
			$params['sign_type'] = null;
			$params['sign'] = null;
			return $this->verify($this->getSignContent($params), $sign, $rsaPublicKey,$signType);
	}

	function verify($data, $sign, $rsaPublicKey, $signType = 'RSA') {

		$res = "-----BEGIN PUBLIC KEY-----\n" .
				wordwrap($rsaPublicKey, 64, "\n", true) .
				"\n-----END PUBLIC KEY-----";		

		($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');  

		//调用openssl内置方法验签，返回bool值

		if ("RSA2" == $signType) {
			$result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
		} else {
			$result = (bool)openssl_verify($data, base64_decode($sign), $res);
		}

		if(!$this->checkEmpty($this->alipayPublicKey)) {
			//释放资源
			openssl_free_key($res);
		}

		return $result;
	}

	/**
	 * 校验$value是否非空
	 *  if not set ,return true;
	 *    if is null , return true;
	 **/
	protected function checkEmpty($value) {
		if (!isset($value))
			return true;
		if ($value === null)
			return true;
		if (trim($value) === "")
			return true;

		return false;
	}

	/**
	 * 转换字符集编码
	 * @param $data
	 * @param $targetCharset
	 * @return string
	 */
	function characet($data, $targetCharset) {		
		if (!empty($data)) {
			$fileType = $this->fileCharset;
			if (strcasecmp($fileType, $targetCharset) != 0) {
				$data = mb_convert_encoding($data, $targetCharset, $fileType);
				//				$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
			}
		}
		return $data;
	}

	/**
	 * 请确保项目文件有可写权限，不然打印不了日志。
	 */
	function writeLog($text) {
		// $text=iconv("GBK", "UTF-8//IGNORE", $text);
		//$text = characet ( $text );
		file_put_contents ( dirname ( __FILE__ ).DIRECTORY_SEPARATOR."./log.txt", date ( "Y-m-d H:i:s" ) . "  " . $text . "\r\n", FILE_APPEND );
	}


}