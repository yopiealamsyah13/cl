<?php


class Customer_api extends CI_Controller{

    const NETSUITE_CONSUMER_KEY = '17be8debb8c3efc523ed6aa0f0871a6429713f361e013127ab1fec5b23f12650';
    const NETSUITE_ACCOUNT = '6381871_SB1';
    const NETSUITE_CONSUMER_SECRET = 'a11a0fa9c50ad09641025f3563f3600a4587c87ef6c27825756348f6d106d0df';
    const NETSUITE_TOKEN_ID = '55453f0dfe6ba12e90f6148ee75cdc4fddc83b34acb0276bbcc7d34f74d54ae4';
    const NETSUITE_TOKEN_SECRET = '907fc3caeacf5769b38d253b74c2e37691e097cadbfeb11cc70bb25bac44547a'; 
    

    public $data = array(
        'modul' => 'customer',
        'breadcrumb' => 'Customer',
        'pesan' => '',
        'pagination' => '',
        'tabel_data' => '',
        'main_view' => 'preview',
        'form_action' => '',
        'form_value' => ''
        );

    function __construct(){
        parent::__construct();
    }

    //get data from CL API Server
    //function index()
    //{
    //
    //    $ch = curl_init($this->url);
    //    
    //    curl_setopt($ch, CURLOPT_TIMEOUT,30);
    //    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    //    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    //    curl_setopt($ch, CURLOPT_HTTPHEADER,array("cl_key:".$this->apikey));
    //    curl_setopt($ch, CURLOPT_USERPWD,"$this->username:$this->password");
    //    $result = curl_exec($ch);
    //    curl_close($ch);
    //    
    //    if($result)
    //    {
    //        $data['customer'] = json_decode($result);
    //        //var_dump($data);
    //    }else{
    //        $data['customer'] = $this->session->set_flashdata('status','Tidak Bisa Ambil Data');
    //    }
    //    
    //    $data['isi'] = 'customer/list2';
    //    $this->load->view('preview', $data, true);
    //    $this->load->view('template/template', $this->data);
    //}


    //post data from CL API Server
    //function updateCLRequest()
    //{
    //    $ch = curl_init($this->url);
    //
    //    $data = array(
    //        'id_customer' => $this->input->post('id_customer'),
    //        'credit_limit' => $this->input->post('credit_limit')
    //    );
    //    
    //    curl_setopt($ch, CURLOPT_TIMEOUT,30);
    //    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    //    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    //    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    //    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
    //    curl_setopt($ch, CURLOPT_HTTPHEADER,array("cl_key:".$this->apikey));
    //    curl_setopt($ch, CURLOPT_USERPWD,"$this->username:$this->password");
    //    $result = curl_exec($ch);
    //    curl_close($ch);
    //    
    //    if($result)
    //    {
    //        //return true;
    //        var_dump($result);
    //    }else{
    //        //$this->session->set_flashdata('status','Tidak Bisa Ambil Data');
    //        return false;
    //    }
    //    
    //}

    //menggenerate signature
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
    

    //Get data from NETSUITE API Server
    function index()
    {

        $oauth_nonce = md5(mt_rand());
        $oauth_timestamp = time();
        $oauth_signature_method = 'HMAC-SHA1';
        $oauth_version = "1.0";
        $url = "https://6381871-sb1.restlets.api.netsuite.com/app/site/hosting/restlet.nl?script=341&deploy=1";
        
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
        var_dump($response);
    }

    function update_cl()
    {
      $oauth_nonce = md5(mt_rand());
        $oauth_timestamp = time();
        $oauth_signature_method = 'HMAC-SHA1';
        $oauth_version = "1.0";
        $url = "https://6381871-sb1.restlets.api.netsuite.com/app/site/hosting/restlet.nl?script=341&deploy=1";
        
        // generate Signature 
        $baseString = $this->restletBaseString("PUT",
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

        $datanetsuite = array(
          'recordtype' => 'customer',
          'internalid' => 18488,
          'creditlimit' => 5
        );

        $hasil = json_encode($datanetsuite);

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
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $hasil,
            CURLOPT_HTTPHEADER => array(
            $header,
            "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $product = json_decode($response, true);
        var_dump($product);
    }

    
}