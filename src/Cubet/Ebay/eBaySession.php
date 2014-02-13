<?php
namespace Cubet\Ebay;

/**
 * AUTHOR: Michael Hawthornthwaite - Acid Computer Services (www.acidcs.co.uk) 
 * 
 * Modified by Rahul P R <rahul.pr@cubettech.com>
 * @package Ebay
 * @date 22-Jan-2014
 */

class eBaySession
{
	private $requestToken;
	private $devID;
	private $appID;
	private $certID;
	private $serverUrl;
	private $compatLevel;
	private $siteID;
	private $verb;
        private $runame;
        
        /**
         * Fetch ebay configuration values
         * 
         * @author Rahul P R <rahul.pr@cubettech.com>
         * @date 22-Jan-2014
         * @param type $callName
         */
        public function __construct($callName)
	{
		$this->verb = $callName;
                $this->devID = \Config::get('ebay::devID');
                $this->appID= \Config::get('ebay::appID');
                $this->certID= \Config::get('ebay::certID');
                $this->compatLevel= \Config::get('ebay::compatabilityLevel');
                $this->siteID= \Config::get('ebay::siteID');
                $this->requestToken= \Config::get('ebay::userToken');
                $this->serverUrl= \Config::get('ebay::serverUrl');
                $this->runame= \Config::get('ebay::runame');
	}
	
	
	/**	
         * sendHttpRequest
         * Sends a HTTP request to the server for this session
         * Input: $requestBody
         * Output:The HTTP Response as a String
         * 
         * @author Rahul P R <rahul.pr@cubettech.com>
         * @date 22-Jan-2014
         * @param type $requestBody
         * @return type response
	 */
	public function sendHttpRequest($requestBody)
	{
		//build eBay headers using variables passed via constructor
		$headers = $this->buildEbayHeaders();
		//initialise a CURL session
		$connection = curl_init();
		//set the server we are using (could be Sandbox or Production server)
		curl_setopt($connection, CURLOPT_URL, $this->serverUrl);
		
		//stop CURL from verifying the peer's certificate
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		
		//set the headers using the array of headers
		curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
		
		//set method as POST
		curl_setopt($connection, CURLOPT_POST, 1);
		
		//set the XML body of the request
		curl_setopt($connection, CURLOPT_POSTFIELDS, $requestBody);
		
		//set it to return the transfer as a string from curl_exec
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
		
		//Send the Request
		$response = curl_exec($connection);
		
		//close the connection
		curl_close($connection);
		
		//return the response
		return $response;
	}
	
	
	
	/**	
         * BuildEbayHeaders
         * Generates an array of string to be used as the headers for the HTTP request to eBay
         * Output:String Array of Headers applicable for this call
         * 
         * @author Rahul P R <rahul.pr@cubettech.com>
         * @date 22-Jan-2014
         * @return type XML Headers
         */
	private function buildEbayHeaders()
	{
		$headers = array (
			//Regulates versioning of the XML interface for the API
			'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $this->compatLevel,
			
			//set the keys
			'X-EBAY-API-DEV-NAME: ' . $this->devID,
			'X-EBAY-API-APP-NAME: ' . $this->appID,
			'X-EBAY-API-CERT-NAME: ' . $this->certID,
			
			//the name of the call we are requesting
			'X-EBAY-API-CALL-NAME: ' . $this->verb,			
			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-API-SITEID: ' . $this->siteID
		);
		
		return $headers;
	}
}
?>