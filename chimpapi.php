<?php
/**
 * The ChimpRewriter API class.
 * The methods on this class can be used to invoke specific ChimpRewriter API methods.
 * 
 * @package SpinChimp
 * @see https://www.ChimpRewriter.com/API
 *
 * @version: 1.0.1
 * 
 * Updates for 1.0.1
 * =================
 * - added new method setMaxSpinDepth
 * */
class chimpRewriter {
	var $user;
	var $apikey;
	var $apiURL;
	var $aid;
	var $quality=4;
	var $parameters=array();
	
	/**
	 * Class constructor for the ChimpRewriter class.
	 * @access public
	 * 
	 * @param string	$user
	 * @param string	$apikey
	 */
	public function __construct ($user, $apikey, $app_id = "YOUR_APP_NAME", $apiURL = 'https://api.chimprewriter.com/ChimpRewrite'){
		$this->user = $user;
		$this->apikey = $apikey;
		$this->aid = $app_id;
		$this->apiURL = $apiURL;
		$this->parameters();
	}
	
	function parameters() {
		$parameters = array();
		$parameters['email'] = $this->user;
		$parameters['apikey'] = $this->apikey;
		$parameters['aid'] = $this->aid; 
		$parameters['quality'] = $this->quality;
		$this->parameters = $parameters;
	}
	
	public function ChimpRewrite($text, $args = array()) {
		//Check Inputs
		if (!isset($text) || trim($text) === '') return "";

		$parameters = $this->parameters;
		$parameters['text'] = $text;
		$parameters = array_merge($parameters, $args);

		$result = $this->ApiRequest($this->apiURL, $parameters);
		return $result;
	}

	public function CreateSpin($text, $args = array()) {
		//Check Inputs
		if (!isset($text) || trim($text) === '') return "";

		$parameters = $this->parameters;
		$parameters['text'] = $text;

		$parameters = array_merge($parameters, $args);

		$result = $this->ApiRequest("https://api.chimprewriter.com/CreateSpin", $parameters);
		return $result;	
	}	
	
	public function Statistics($args = array()) {


		$parameters = $this->parameters;

		$parameters = array_merge($parameters, $args);

		$result = $this->ApiRequest("https://api.chimprewriter.com/Statistics", $parameters);
		return $result;	
	}
	
	function ApiRequest($url, $params) {

		
		$postData = '';
		//create name value pairs seperated by &
		foreach($params as $k => $v) 
		{ 
		  $postData .= $k . '='.urlencode($v).'&';
		}
		rtrim($postData, '&');
	
		$ch = curl_init();  

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_POST, count($params));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $output=curl_exec($ch);

		curl_close($ch);
		
		return $output;
	}
	
}
