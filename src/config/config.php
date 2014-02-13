<?php 
defined('ENV') || define('ENV', 'DEVELOPMENT');
$compatabilityLevel = 855;    // eBay API version
$siteID = 0;            // eBay Site ID
$StartTimeFrom= '2014-01-12';
$StartTimeTo= '2014-02-22';
$EntriesPerPage= '2';

if(ENV=='production')
{
    $devID = 'DDD';   // these prod keys are different from sandbox keys
    $appID = 'AAA';
    $certID = 'CCC';
    //set the Server to use (Sandbox or Production)
    $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
    //the token representing the eBay user to assign the call with
    $userToken = 'YOUR_PROD_TOKEN';
} else {
    $devID = 'b820e7dd-83af-4245-9512-8ae140d23e77';   // insert your devID for sandbox
    $appID = 'Nibinsab3-b7dd-4b29-a2ad-eeab25ea8b1';   // different from prod keys
    $certID = '472e524d-f780-4b0f-8754-6008d6f30426';  // need three 'keys' and one token
    //set the Server to use (Sandbox or Production)
    $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
    // the token representing the eBay user to assign the call with
    // this token is a long string - don't insert new lines - different from prod token
    $userToken = 'USER_TOKEN_AFTER_LOGIN';                 
    $runame='Nibins-Nibinsab3-b7dd--csfctv';
}

return array(
      'devID' => $devID
    , 'appID' => $appID
    , 'certID' => $certID
    , 'serverUrl' => $serverUrl
    , 'userToken' => $userToken
    , 'runame' => $runame
    , 'siteID' => $siteID
    , 'compatabilityLevel' => $compatabilityLevel
    , 'StartTimeFrom' => $StartTimeFrom
    , 'StartTimeTo' => $StartTimeTo
    , 'EntriesPerPage' => $EntriesPerPage
);
