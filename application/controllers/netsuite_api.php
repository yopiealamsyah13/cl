<?php

    class callNetsuiteApi{
        
         // PRODUCTION CREDENTIALS
         const NETSUITE_CONSUMER_KEY = '48634a8cf1d39603b61c63e710ad4775fc5971c1c8deaa0e36b69fcd28bd33e6';
         const NETSUITE_ACCOUNT = '6381871';
         const NETSUITE_CONSUMER_SECRET = '582b3de5e8424785cef63ce8a47278672c66401500ffaee3182efa4d04cf2586';
         const NETSUITE_TOKEN_ID = '68d81014a8a3ddd8501ba94b9ea8d047cabe2085c1b64b84c8e2f6c06fecd25a';
         const NETSUITE_TOKEN_SECRET = 'a8491f75f34a971841d9099fd716cb749878e3b4c4975d08664609271593e7c2'; 
         
        public function callRestApi($url){
  
        $oauth_nonce = md5(mt_rand());
        $oauth_timestamp = time();
        $oauth_signature_method = 'HMAC-SHA1';
        $oauth_version = "1.0";
        
        // generate Signature 
        $baseString = $this->restletBaseString("GET",
        $url,
        self::NETSUITE_CONSUMER_KEY,
        self::NETSUITE_TOKEN_ID,
        $oauth_nonce,
        $oauth_timestamp,
        $oauth_version,
        $oauth_signature_method,null);
        
        
        $key = rawurlencode(self::NETSUITE_CONSUMER_SECRET) .'&'. rawurlencode(self::NETSUITE_TOKEN_SECRET);
    
    
         $signature = base64_encode(hash_hmac('sha1', $baseString, $key, true)); 
         
         // GENERATE HEADER TO PASS IN CURL
         $header = 'Authorization: OAuth '
                 .'realm="' .rawurlencode(self::NETSUITE_ACCOUNT) .'", '
                 .'oauth_consumer_key="' .rawurlencode(self::NETSUITE_CONSUMER_KEY) .'", '
                 .'oauth_token="' .rawurlencode(self::NETSUITE_TOKEN_ID) .'", '
                 .'oauth_nonce="' .rawurlencode($oauth_nonce) .'", '
                 .'oauth_timestamp="' .rawurlencode($oauth_timestamp) .'", '
                 .'oauth_signature_method="' .rawurlencode($oauth_signature_method) .'", '
                 .'oauth_version="' .rawurlencode($oauth_version) .'", '
                 .'oauth_signature="' .rawurlencode($signature) .'"';
             
             
        return  $this->callCurl($header,$url);
    
        }

        public function callCurl($header,$url){
                $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_SSL_VERIFYHOST=>false,
              CURLOPT_SSL_VERIFYPEER=>false,
              CURLOPT_CUSTOMREQUEST => "GET",
               CURLOPT_HTTPHEADER => array(
               $header,
               "content-type: application/json"
              ),
             
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
    
            $product = json_decode($response, true);
            return $product;        
        }
        public function restletBaseString($httpMethod, $url, $consumerKey, $tokenKey, $nonce, $timestamp, $version, $signatureMethod, $postParams){
              //http method must be upper case
              $baseString = strtoupper($httpMethod) .'&';
              
              //include url without parameters, schema and hostname must be lower case
              if (strpos($url, '?')){
                $baseUrl = substr($url, 0, strpos($url, '?'));
                $getParams = substr($url, strpos($url, '?') + 1);
              } else {
               $baseUrl = $url;
               $getParams = "";
              }
              $hostname = strtolower(substr($baseUrl, 0,  strpos($baseUrl, '/', 10)));
              $path = substr($baseUrl, strpos($baseUrl, '/', 10));
              $baseUrl = $hostname . $path;
              $baseString .= rawurlencode($baseUrl) .'&';
              
              //all oauth and get params. First they are decoded, next alphabetically sorted, next each key and values is encoded and finally whole parameters are encoded
              $params = array();
              $params['oauth_consumer_key'] = array($consumerKey);
              $params['oauth_token'] = array($tokenKey);
              $params['oauth_nonce'] = array($nonce);
              $params['oauth_timestamp'] = array($timestamp);
              $params['oauth_signature_method'] = array($signatureMethod);
              $params['oauth_version'] = array($version);
               
              foreach (explode('&', $getParams ."&". $postParams) as $param) {
                $parsed = explode('=', $param);
                if ($parsed[0] != "") {
                  $value = isset($parsed[1]) ? urldecode($parsed[1]): "";
                  if (isset($params[urldecode($parsed[0])])) {
                    array_push($params[urldecode($parsed[0])], $value);
                  } else {
                    $params[urldecode($parsed[0])] = array($value);
                  }
                }
              }
               
              //all parameters must be alphabetically sorted
              ksort($params);
               
              $paramString = "";
              foreach ($params as $key => $valueArray){
                //all values must be alphabetically sorted
                sort($valueArray);
                foreach ($valueArray as $value){
                  $paramString .= rawurlencode($key) . '='. rawurlencode($value) .'&';
                }
              }
              $paramString = substr($paramString, 0, -1);
               $baseString .= rawurlencode($paramString);
              
              return $baseString;
            }
    }

$obj = new callNetsuiteApi();
    $url = "https://6381871.restlets.api.netsuite.com/app/site/hosting/restlet.nl?script=348&deploy=1";
    $response = $obj->callRestApi($url);
    ?>