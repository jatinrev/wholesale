<?php
/*
	$dataType:
	* n		=	numeric
	* s		= 	string
	* an	= 	alphanumeric
	* u		= 	URL	
	* e		= 	email
*/
	class formFieldsValidation {
		function is_password_valid($input) {
		/** must be at least 8 character in length, it must contain a lower case, an upper case, a number and a special character such as !@#$%^&+=
		 *  return true if password valid, else false;
		 */
			return preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}/', $input);
		}

		public function isFieldEmpty($val) {
			if(trim($val)=="") {
				return true;
			} else {
				return false;
			}
		}
		public function isValidEmail($emailId) {
			if(filter_var(trim($emailId), FILTER_VALIDATE_EMAIL)){ 
				return true;
			} else {
				return false;
			}
		}
		public function isValidURL($url) {
			if(filter_var(trim($url), FILTER_VALIDATE_URL)){ 
				return true;
			} else {
				return false;
			}
		}

		/**
		 * @param  $url
		 * @return true if url is valid, false if invalid
		 */
/* 		public function isValidURLAPI($url) {

			$urlOutput = array('status' => false);
			$url = trim($url);
			$trimmed_url = rtrim($url, '/');
			
			$url = $trimmed_url;
			$url = filter_var($url, FILTER_VALIDATE_URL);
			
			if($url!=''){
				$url = str_replace('http://www.','',$url);
				$url = str_replace('http://', '', $url);
				$url = str_replace('https://www.','',$url);
				$url = str_replace('https://', '', $url);
				$url = str_replace('www', '', $url);
				
				$splitURL = explode('.',$url);
				

				 $countLength = (int)count($splitURL);
				if($countLength==2){
					$urlOutput['status'] = true;
					$urlOutput['domain'] = $splitURL[0];
					$urlOutput['tld'] = $splitURL[1];

				} else if($countLength==3){
					$urlOutput['status'] = true;
					$urlOutput['subdomain'] = $splitURL[0];
					$urlOutput['domain'] = $splitURL[1].'.'.$splitURL[2];
				}

			} else {
				$urlOutput['status'] = false;
			}

			return $urlOutput;
		} */
		public function isValidURLAPI($url) {
			$urlOutput	= array('status' => false);
			$url		= rtrim(trim($url), '/');
			$url		= filter_var($url, FILTER_VALIDATE_URL);

			if (!empty($url)) {
				$url			= str_replace('www.', '', parse_url($url, PHP_URL_HOST));
				$splitURL		= explode('.',$url);
				$countLength	= count($splitURL);

				if ($countLength == 3) {
					$urlOutput['status']	= true;
					// $urlOutput['subdomain']	= $splitURL[0];
					$urlOutput['domain']	= $splitURL[0];
					$urlOutput['tld']		= $splitURL[1] .'.'. $splitURL[2];
				} else if ($countLength == 2) {
					$urlOutput['status']	= true;
					$urlOutput['domain']	= $splitURL[0];
					$urlOutput['tld']		= $splitURL[1];
				}
			} else {
				$urlOutput['status'] = false;
			}

			return $urlOutput;
		}

		public function validateUrlWithOrWithoutHttp($url){
			if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
				return true;
			} else {
				return false;
			}
		}
		public function secureInsert($str){
			if(trim($str)!='') {
				$str = trim($str);
				$str = htmlentities($str,ENT_QUOTES,'UTF-8');
				$str = addslashes($str); 
				return $str;
			}
		}
		public function secureFieldInsert($val){
			if(trim($val)!='') {
				return trim(addslashes($val));
			}
		}		
		function isStringContainsOnlyAlphabets($data, $use = 0) {
			/**
			 * DESC : IF $use == 1, then function will work
			 */
			if($use == 1) {
				$isValid = ctype_alpha(str_replace(' ', '', $data));
				if($isValid) {
					return true;		//if input is alpha-numeric
				} else {
					return false;
				}
			} else {
				return true;
			}
		}
		function isAlphaNumericDataWithSpace($data){
			/*if(trim($data)!='') {
				if (ctype_alnum(str_replace(' ', '', $data))) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}*/
			/*
			**	by labh chand
			*/
			return true;
		}
		function isAlphaNumericDataWithoutSpace($data){
			if(trim($data)!='') {
				if (ctype_alnum(trim($data))) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		public function dataWithoutSpace($data){
			if($data!='') {
				if (preg_match('/\s/',$data)){
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		}
		public function valid_file_upload($file_arr,$fileSize = 3145728){
			$allowedExts = array("gif","jpeg","jpg","png");
			$after_expld = explode(".", $file_arr["name"]);
			$extension = strtolower(end($after_expld));
			//3145728 = 3MB 
			if ($file_arr["size"] < $fileSize && in_array($extension, $allowedExts)){
				return true;
			} else {
				return false;
			}
		}
		public function isValidFile($file_arr,$fileSize = 3145728,$allowedExtensions= array("gif","jpeg","jpg","png","doc","xls","xlsx","pdf","docx","ppt","txt")) {
			$allowedExts = $allowedExtensions;
			$after_expld = explode(".", $file_arr["name"]);
			$extension = strtolower(end($after_expld));
			//3145728 = 3MB 
			if ($file_arr["size"] < $fileSize && in_array($extension, $allowedExts)){
				return true;
			} else {
				return false;
			}
		}
		public function checkValidFile($filename,$allowedExts = array("gif","jpeg","jpg","png","doc","xls","xlsx","pdf","docx","ppt","txt")){
			$after_expld = explode(".", $filename);
			$extension = strtolower(end($after_expld));
			//3145728 = 3MB 
			if (in_array($extension, $allowedExts)){
				return true;
			} else {
				return false;
			}
		}
		public function validateData($data="",$minLength=0,$maxLength=0,$dataType='',$dataWithoutSpace=false) {		
			$validStr = true;		
			if($data!='') {				
				if(!$this->checkLengthOfString($data,$minLength,$maxLength)) {				
					$validStr = false;
				} 		
				if(!$this->checkStringDataType($data,$dataType)) {
					$validStr = false;
				}	
				if($dataWithoutSpace == true) {
					if($this->dataWithoutSpace($data)==false) {
						$validStr = false;
					}
				}
			} else {
				$validStr = false;
			}
			return $validStr;
		}
		public function checkLengthOfString($data='',$minLength=0,$maxLength=0){
			$validLength = true;		
			if($data!='') {			
				if($minLength>0) {
					if(strlen($data)<$minLength) {
						$validLength = false;
					}
				}			
				if($maxLength>0) {
					if(strlen($data)>$maxLength) {
						$validLength = false;
					}
				}
			} else {
				$validLength = false;
			}						
			return $validLength;
		}
		private function checkStringDataType($data='',$dataType=''){		
			$validDataType = true;
			if($data!='') {
				if($dataType == 'n') {				
					if(!is_numeric($data)) {
						$validDataType = false;
					}				
				} else if($dataType == 's') {
					if (!ctype_alpha($data)) {
						$validDataType = false;
					}
				} else if($dataType == 'an') {					
					if (!ctype_alnum($data)) {
						$validDataType = false;
					}
				} else if($dataType == 'u') {
					if(!filter_var($data, FILTER_VALIDATE_URL)){ 
						$validDataType = false;
					}
				} else if($dataType == 'e') {
					if(!filter_var($data, FILTER_VALIDATE_EMAIL)){ 
						$validDataType = false;
					}
				}
			} else {
				$validDataType = false;
			}
			return $validDataType;
		}
			//gagan@12.9.14 function start
		public function LimitTextField($data='', $type=0, $textAreaLimit = 1000){
			if($data!='') {							//for <textarea> = 1
				if($type == 0) {					//others 		 = 0	
					if (strlen($data)>255){
						return true;
					}
				} else if($type == 1) {
					if (strlen($data)>$textAreaLimit){
						return true;
					}
				}
			}else {
				return false;
			}
		}
		public function TextLimtPerWord($value='',$words='',$WordCount='',$i=0,$totalwords=0,$validWords=false){
			$validWords	=	false;
			if($value!=''){
				$words=(explode(" ",$value));
				$WordCount=count($words);
				for ($i = 0; $i < $WordCount; $i++){	
					$totalwords = $WordCount[$i];
					if($totalwords > 45){
						$validWords	=	true;
					}
				}
			}
			else{
				return $validWords;
			}
		}
		//gagan@12.9.14 function end
		/**
		 * @return boolean        true=is valid ip, false=is not valid ip
		 */
		function is_valid_ip($input) {
			if(!filter_var($input, FILTER_VALIDATE_IP)) {
			   return false;
			} else {
				return true;
			}
		}
	}


	class formFieldsValidationCustom extends formFieldsValidation {
		/** Desc : show errors with msg.
		 *  types of error : 
		 *  1 = 
		 $inputType 	:	
		 		T 	= 	text,
		 		OA 	= 	only alphabetic characters allowed,
		 		E 	=	email,
		 		URL = 	url validation,
		 		DD 	=	dropdown validation,
		 		DB 	=	database name validation,
		 		AN_ = 	alpha-numeric with '_',
		 		P 	=	password,
		 		UC 	=	User credentials check
		 @input example :
		 $inputArr 	=	array(0	=>	array('inputType'	=>	'OA',				
		 								  'inputData'	=>	'serverName',		
		 								  'fieldName'	=>	'key pair name'),	
		 								  	//the type of validation to apply
											//the data on which validation are to be applied.
											//the thing which would come in errors.
		 					  );
		 ******************************EXAMPLE @ amazon/addEc2Request.php******************************
		 */
		public $result 		=	false;								//if this (TRUE), show error.
		public $error 		= 	array();							//will store the current error.
		public $error_ans 	=	array('0'	=>	':thing: should be alphabetic.',
									  '1'	=>	':thing: is empty.',
									  '2'	=>	':thing: is not a valid.',
									  '3'	=>	':thing: is not a valid URL. Please add http://.',
									  '4'	=>	':thing: is not specified in :thing2:.',
									  '5'	=>	':thing: should contain only lower case alphabets with underscore(_).',
									  '6'	=>	':thing: should contain only alpha-numeric data with underscore(_).',
									  '7'	=>	':thing: must be at least 8 character in length, it must contain a lower case, an upper case, a number and a special character such as !@#$%^&+=',
									  '8'	=>	'Wrong user credentials.'
									);
		public $field_name     =	'';
		public $error_result   = 	array();		//if index contain true then error in that index.
		private $current_index = '';

		function __construct($inputArr = array()) {
			$this->check_arr( $inputArr );
		}

		function check_arr($inputArr = array()) {
			foreach($inputArr as $key => $value) {
				$this->field_name     =	trim($value['fieldName']);
				$value['inputType']   =	trim($value['inputType']);
				$this->current_index  =	$key;
				$this->error_result[$key] =	false;	

				if( $value['inputType'] == 'T' ) {
					$this->checkText();
				} else if( $value['inputType'] == 'OA' ) {
					$this->alphaText($value['inputData']);
				} else if( $value['inputType'] == 'E' ) {
					$this->emailValidation($value['inputData']);
				} else if( $value['inputType'] == 'URL' ) {
					$this->urlValidation($value['inputData']);
				} else if( $value['inputType'] == 'DD' ) {
					$this->dropdownValidation( $value['inputData'], $value['DDListArr'] );
				} else if( $value['inputType'] == 'DB' ) {
					$this->databaseValidation( $value['inputData'] );
				} else if( $value['inputType'] == 'AN_' ) {
					$this->alpha_numeric_with_underscore( $value['inputData'] );
				} else if( $value['inputType'] == 'P' ) {
					$this->password_validation( $value['inputData'] );
				} else if( $value['inputType'] == 'UC' ) {
					$this->user_credential_check( $value['inputData'], $value['source'] );
				}
			}
			if( empty($this->error) ) {			//show error or not
				$this->result 	=	false;
			} else {
				$this->result 	=	true;
			}
		}

		function add_errors( $input_arr = array() ) {
			/** DESC : ADD CUSTOM ERRORS TO CURRENT CLASS.
			 */
			$this->error 	=	array_merge( $this->error, $input_arr );
			if( empty($this->error) ) {			//show error or not
				$this->result 	=	false;
			} else {
				$this->result 	=	true;
			}
		}

		function checkText() {
			return false;
		}

		/**
		 * @param  [type] $source {'amazon', 'azure', 'hp_cloud', 'ibm', 'linode', 'vultr', 'openshift', 'joyent'}
		 */
		function user_credential_check($input, $source) {
			global $mysqlDbOb,
				   $user_id,
				   $addNewSiteOb;
			$input 	=	trim($input);

			$no_of_user_credentials 	=	count($addNewSiteOb->get_user_credentialid_source($source));
			/*if( $no_of_user_credentials == 1 && !empty($input) ) {
				$this->error[] 	=	'Problem occured in user credentials.';
				$this->error_result[$this->current_index]	=	true;
			} else */if( $no_of_user_credentials < 1 ) {
				
				$this->error[] 	=	'No user credentials available.';
				$this->error_result[$this->current_index]	=	true;
			} else if( empty($input) && $no_of_user_credentials > 0 ) {
				
				$this->error[] 	=	'No user credentials available.';
				$this->error_result[$this->current_index]	=	true;
			} else if( !empty($input) && $no_of_user_credentials > 0 ) {
				$input 	=	decodeIdInCustomWay($input);
				$query	=	$mysqlDbOb->select_query_multiple_where_args(array('user_id', 'source'),
																		 TABLE_USER_CREDENTIALS,
																		 array('user_credentials_id'	=>	$input)
																		 );
				if( mysqli_num_rows($query) > 0 ) {
					$fetch_query 	=	mysqli_fetch_assoc($query);
					if( $user_id == $fetch_query['user_id'] && $fetch_query['source'] == $source ) {
					} else {
						$this->error[]	=	$this->error_ans[8];
						$this->error_result[$this->current_index]	=	true;
					}
				} else {
					$this->error[]		=	$this->error_ans[8];
					$this->error_result[$this->current_index]	=	true;
				}
			}
		}

		function alphaText($inputData) {
			if( trim($inputData) == '' ) {
				$this->error[] 	=	str_replace( ':thing:', $this->field_name, $this->error_ans[1] );
				$this->error_result[$this->current_index]	=	true;
			} else if( ctype_alpha($inputData) == false ) {
				$this->error[] 	=	str_replace( ':thing:', $this->field_name, $this->error_ans[0] );
				$this->error_result[$this->current_index]	=	true;
			}
		}

		function emailValidation($input) {
			if( trim($input) == '' ) {
				$this->error[]	=	str_replace( ':thing:', $this->field_name, $this->error_ans[1] );
				$this->error_result[$this->current_index]	=	true;
			} else if( parent::isValidEmail($input) == false) {
				$this->error[]	=	str_replace( ':thing:', $this->field_name, $this->error_ans[2] );
				$this->error_result[$this->current_index]	=	true;
			}
		}

		function urlValidation($input) {
			// $pattern = '/(?:https?:\/\/)?(?:[a-zA-Z0-9.-]+?\.(?:com|net|org|gov|edu|mil)|\d+\.\d+\.\d+\.\d+)/';
			$input 	=	trim( $input );
			if( $input == '' ) {
				$this->error[]	=	str_replace( ':thing:', $this->field_name, $this->error_ans[1] );
				$this->error_result[$this->current_index]	=	true;
			} 
			$url_validation 	=	$this->isValidURLAPI( $input );
			if( $url_validation['status'] == false ) {
				$this->error[]	=	str_replace( ':thing:', $this->field_name, $this->error_ans[3] );
				$this->error_result[$this->current_index]	=	true;
			}
		}

		function dropdownValidation($input, $list = array()) {
			$array 	=	array();
			foreach ($list as $value) {
				$array[]	=	trim($value);
			}
			$list 	=	$array;
			if( trim($input) == '' ) {
				$this->error[]	=	str_replace( ':thing:', $this->field_name, $this->error_ans[1] );
				$this->error_result[$this->current_index]	=	true;
			} else if( in_array( trim($input), $list) == false ) {
				$this->error[]	=	str_replace( ':thing2:', $this->field_name, str_replace(':thing:', $input, $this->error_ans[4]) );
				$this->error_result[$this->current_index]	=	true;
			}
		}

		function databaseValidation($input) {
			/** DESC : CHECKS IF THE DATABASE NAME IS VALID OR NOT.
			 */
			if( trim($input) == '' ) {
				$this->error[]	=	str_replace( ':thing:', $this->field_name, $this->error_ans[1] );
				$this->error_result[$this->current_index]	=	true;
			} else if( ctype_lower(str_replace('_', '', $input)) != 1 ) {
				$this->error[]	=	str_replace( ':thing:', $this->field_name, $this->error_ans[5] );
				$this->error_result[$this->current_index]	=	true;
			}
		}

		function alpha_numeric_with_underscore( $input ) {
			/**  	CHECKS IF DATA IS ALPHA NUMERIC WITH UNDERSCORE.
			 */
			if( trim($input) == '' ) {
				$this->error[]	=	str_replace( ':thing:', $this->field_name, $this->error_ans[1] );
				$this->error_result[$this->current_index]	=	true;
			} else if( !$this->isAlphaNumericDataWithoutSpace(str_replace('_', '', $input)) ) {
				$this->error[]	=	str_replace( ':thing:', $this->field_name, $this->error_ans[6] );
				$this->error_result[$this->current_index]	=	true;
			}
		}

		function password_validation( $input ) {
			if( trim($input) == '' ) {
				$this->error[]	=	str_replace( ':thing:', $this->field_name, $this->error_ans[1] );
				$this->error_result[$this->current_index]	=	true;
			} else if( !$this->is_password_valid($input) ) {
				$this->error[]	=	str_replace( ':thing:', $this->field_name, $this->error_ans[7] );
				$this->error_result[$this->current_index]	=	true;
			}
		}

	}
?>