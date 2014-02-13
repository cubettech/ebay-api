<?php 
namespace Cubet\Ebay;
use Illuminate\View\Environment;
use Cubet\Ebay\eBaySession;


/**
 * Ebay controller to fetch usertoken, sellerlist and myebaylisting
 * 
 * @package Ebay
 * @date 23-Jan-2014
 * @author Rahul P R <rahul.pr@cubettech.com>
 * 
 */

class Ebay {
    
    protected $devID = "";
    protected $appID = "";
    protected $certID = "";
    protected $serverUrl = "";
    protected $userToken = "";
    protected $runame = "";
    protected $siteID = "";
    protected $compatabilityLevel = "";
    protected $StartTimeFrom= "";
    protected $StartTimeTo= "";
    protected $EntriesPerPage= "";
    protected $timeTail= "";
    protected $UserID= "";

    /**
     * Get config values 
     * 
     * @author Rahul P R <rahul.pr@cubettech.com>
     * @date 22-Jan-2014
     */
    
    public function __construct()
    {
        $this->devID = \Config::get('ebay::devID');
        $this->appID= \Config::get('ebay::appID');
        $this->certID= \Config::get('ebay::certID');
        $this->compatabilityLevel= \Config::get('ebay::compatabilityLevel');
        $this->siteID= \Config::get('ebay::siteID');
        $this->userToken= "";
        $this->serverUrl= \Config::get('ebay::serverUrl');
        $this->runame= \Config::get('ebay::runame');
        $this->StartTimeFrom= \Config::get('ebay::StartTimeFrom');
        $this->StartTimeTo= \Config::get('ebay::StartTimeTo');
        $this->EntriesPerPage= \Config::get('ebay::EntriesPerPage');
        $this->timeTail = 'T21:59:59.005Z';
    }
    
    
    /**
     * returns an array from an xml string
     * 
     * @param \Cubet\Ebay\SimpleXMLElement $parent
     * @return array
     */
    function XML2Array($xmlSrting){
        $xml = simplexml_load_string($xmlSrting);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        return $array;
    }

    
    /**
     * Parse XML content to Object
     * 
     * @author Rahul P R <rahul.pr@cubettech.com>
     * @date 24-Jan-2014
     * @param type $xml
     * @return response Object
     */
    
    public function parseXml($responseXml){
        if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
                die('<P>Error sending request');
        //Xml string is parsed and creates a DOM Document object
        $responseDoc = new \DomDocument();
        $responseDoc->loadXML($responseXml);
        return $responseDoc;
    }
   
    /**
     * Get get session id
     * 
     * @author Rahul P R <rahul.pr@cubettech.com>
     * @date 22-Jan-2014
     * @param \Cubet\Ebay\type $this->runame
     * @return type xml
     */
    
    protected function getSessionId($runame)
    {
            $session = new eBaySession('GetSessionID');
            //Build the request Xml string
            $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
                                <GetSessionIDRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                    <RuName>'.$runame.'</RuName>
                                </GetSessionIDRequest>';
            //Create a new eBay session with all details pulled in from included keys.php
            $responseXml = $session->sendHttpRequest($requestXmlBody);
            
            return $responseXml;
    }
    
    /**
     * Get get session id
     * 
     * @author Rahul P R <rahul.pr@cubettech.com>
     * @date 22-Jan-2014
     * @param \Cubet\Ebay\type $this->userToken
     * @return type xml
     */
    
    protected function GetUser($userToken)
    {
            $session = new eBaySession('GetUser');
            //Build the request Xml string
            $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
                                <GetUserRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                <RequesterCredentials>
                                <eBayAuthToken>'.$userToken.'</eBayAuthToken>
                                </RequesterCredentials>
                                </GetUserRequest>';

            //Create a new eBay session with all details pulled in from included keys.php
            $responseXml = $session->sendHttpRequest($requestXmlBody);
                        
            return $responseXml;
    }
    
    /**
     * Get Token Status
     * 
     * @author Rahul P R <rahul.pr@cubettech.com>
     * @date 22-Jan-2014
     * @param type $this->userToken
     * @return type xml
     */
    public function GetTokenStatus($userToken)
    {
        $session = new eBaySession('GetTokenStatus');
        $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
                            <GetTokenStatusRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                <RequesterCredentials>
                                    <eBayAuthToken>'.$userToken.'</eBayAuthToken>
                                </RequesterCredentials>
                            </GetTokenStatusRequest>';
	//Create a new eBay session with all details pulled in from included keys.php
	$responseXml = $session->sendHttpRequest($requestXmlBody);
        
        return $responseXml;
    }
    
    /**
     * Fetch User Token
     * 
     * @author Rahul P R <rahul.pr@cubettech.com>
     * @date 22-Jan-2014
     * @param type $sessionId
     * @return type xml
     */
    public function fetchToken($sessionId)
    {
        $session = new eBaySession('FetchToken');

        $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
                            <FetchTokenRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                              <SessionID>'.$sessionId.'</SessionID>
                            </FetchTokenRequest>';
        //Create a new eBay session with all details pulled in from included keys.php
        $responseXml = $session->sendHttpRequest($requestXmlBody);

        return $responseXml;
    }
    
    
    /**
     * returns sellers list
     * 
     * @author Rahul P R <rahul.pr@cubettech.com>
     * @date 22-Jan-2014
     * @param type $userToken
     * @param type $StartTimeFrom
     * @param type $StartTimeTo
     * @param type $EntriesPerPage
     * @return type xml
     */
    
    public function GetSellerList($userToken,$StartTimeFrom,$StartTimeTo,$EntriesPerPage,$pageNumber)
    {
            $session = new eBaySession('GetSellerList');
            //Build the request Xml string
            $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
                                <GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                <RequesterCredentials>
                                <eBayAuthToken>'.$userToken.'</eBayAuthToken>
                                </RequesterCredentials>
                                 <ErrorLanguage>en_US</ErrorLanguage>
                                  <WarningLevel>High</WarningLevel>
                                  <GranularityLevel>Fine</GranularityLevel>
                                  <StartTimeFrom>'.$StartTimeFrom.'</StartTimeFrom>
                                  <StartTimeTo>'.$StartTimeTo.'</StartTimeTo>
                                  <IncludeWatchCount>true</IncludeWatchCount>
                                  <Pagination>
                                    <EntriesPerPage>'.$EntriesPerPage.'</EntriesPerPage>
                                    <PageNumber>'.$pageNumber.'</PageNumber>    
                                  </Pagination>
                                </GetSellerListRequest>';
            
            //Create a new eBay session with all details pulled in from included keys.php
            $responseXml = $session->sendHttpRequest($requestXmlBody);
            
            return $responseXml;
    }
    
    /**
     * Get my ebay selling details
     * 
     * @author Rahul P R <rahul.pr@cubettech.com>
     * @date 22-Jan-2014
     * @param type $userToken
     * @param type $EntriesPerPage
     * @return type xml
     */

    public function GetMyeBaySelling($userToken,$EntriesPerPage,$pageNumber)
    {
            $session = new eBaySession('GetMyeBaySelling');
            //Build the request Xml string
            $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
                            <GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                              <RequesterCredentials>
                                <eBayAuthToken>'.$userToken.'</eBayAuthToken>
                              </RequesterCredentials>
                              <Version>'.$this->compatabilityLevel.'</Version>
                              <ActiveList>
                                <Sort>TimeLeft</Sort>
                                <Pagination>
                                  <EntriesPerPage>'.$EntriesPerPage.'</EntriesPerPage>
                                  <PageNumber>'.$pageNumber.'</PageNumber>  
                                </Pagination>
                              </ActiveList>
                            </GetMyeBaySellingRequest>';

            //Create a new eBay session with all details pulled in from included keys.php
            $responseXml = $session->sendHttpRequest($requestXmlBody);
            
            return $responseXml;

    }

    /**
     * output result to view page
     * 
     * @author Rahul P R <rahul.pr@cubettech.com>
     * @date 28-Jan-2014
     * @param type $input 
     * @return type
     */
    
    public function ebayManagement($input=array())
    {
        $sellerList = array();
        $myeBaySelling = array();
        $getUser = array();
        $tokenStatus = "";
        $sessionId = "";
        $showLogin = true;
        $StartTimeFrom = $this->StartTimeFrom;
        $StartTimeTo = $this->StartTimeTo;
        $EntriesPerPage = $this->EntriesPerPage;
        $pageNumber = 1;
        $error = "";
        $formInput = array( 'StartTimeFrom' =>  $StartTimeFrom,
                            'StartTimeTo'   =>  $StartTimeTo,
                            'EntriesPerPage'=>  $EntriesPerPage,
                            'pageNumber'    =>  $pageNumber ) ;
        
        $sessionIdXml = $this->getSessionId($this->runame) ;
        $sessionIdResponse = $this->parseXml($sessionIdXml);
        $sessionId = $sessionIdResponse->getElementsByTagName('SessionID')->item(0)->nodeValue;
        \Session::put('new',$sessionId);
        
        // GET userToken
        // 
        // Check if usertoken is getting using the sessionId(passed to the ebay pop up form)
        // if success save that userToken to $this->userToken
        // else set $this->userToken to the token value stored in session
        
        $fetchTokenXml = $this->fetchToken(\Session::get('passed4login','')) ;
        $fetchTokenResponse = $this->parseXml($fetchTokenXml);
        
        if($fetchTokenResponse->getElementsByTagName('Ack')->item(0)->nodeValue=='Success'){
            $this->userToken =  $fetchTokenResponse->getElementsByTagName('eBayAuthToken')->item(0)->nodeValue;
        } else {
            $this->userToken = \Session::get('userToken');
        }
        
        if($this->userToken) {
            
            //get token Status
            $tokenStatusXml = $this->GetTokenStatus($this->userToken) ;
            $tokenStatusResponse = $this->parseXml($tokenStatusXml);
            $tokenStatus = $tokenStatusResponse->getElementsByTagName('Ack')->item(0)->nodeValue=='Success'
                            ? $tokenStatusResponse->getElementsByTagName('Status')->item(0)->nodeValue
                            : 'Inactive' ;

            $GetUserXml = $this->GetUser($this->userToken);
            $getUser = $this->XML2Array($GetUserXml);

            //  if form submitted
            if(isset($input['sellerListSubmit'])){
                
                //echo $input['pageNumber'];

                $StartTimeFrom = isset($input['StartTimeFrom']) && $input['StartTimeFrom']!=''
                                ? $input['StartTimeFrom']
                                :$StartTimeFrom ;
                $StartTimeTo = isset($input['StartTimeTo']) && $input['StartTimeTo']!=''
                                ? $input['StartTimeTo'] 
                                : $StartTimeTo;
                $EntriesPerPage = isset($input['EntriesPerPage']) && $input['EntriesPerPage']!=''
                                ? $input['EntriesPerPage'] 
                                : $EntriesPerPage;
                $pageNumber = isset($input['pageNumber']) && $input['pageNumber']!=''
                                ? $input['pageNumber'] 
                                : $pageNumber;
                
                $formInput = array( 'StartTimeFrom' =>  $StartTimeFrom,
                                    'StartTimeTo'   =>  $StartTimeTo,
                                    'EntriesPerPage'=>  $EntriesPerPage,
                                    'pageNumber'    =>  $pageNumber) ;
                
                $sellerListXml = $this->GetSellerList($this->userToken, $StartTimeFrom, $StartTimeTo, $EntriesPerPage,$pageNumber);
                $sellerList = $this->XML2Array($sellerListXml);
                
                $myeBaySellingXml = $this->GetMyeBaySelling($this->userToken,$EntriesPerPage,$pageNumber); 
                $myeBaySelling = $this->XML2Array($myeBaySellingXml);
            }
            
        } else {
            //'no usertoken';  
        }
        
        \Session::put('passed4login',\Session::get('new',''));
        \Session::put('userToken',$this->userToken);
        
        return array(   'sellerList'    =>  $sellerList,
                        'myeBaySelling' =>  $myeBaySelling,
                        'tokenStatus'   =>  $tokenStatus,
                        'runame'        =>  $this->runame,
                        'sessionId'     =>  urlencode(\Session::get('passed4login')),
                        'userToken'     =>  $this->userToken,
                        'showLogin'     =>  $showLogin,
                        'formInput'     =>  $formInput,
                        'getUser'        => $getUser,
                        'error'         =>  $error
                    ) ;  
    }

}
