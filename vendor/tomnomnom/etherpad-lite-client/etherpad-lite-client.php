<?php
// The following code is automatically generated by ./tools/generate.php
// please edit the files in ./tools/templates/ instead of editing this
// file directly.

class EtherpadLiteClient {

  const API_VERSION             = '1.2.11';

  const CODE_OK                 = 0;
  const CODE_INVALID_PARAMETERS = 1;
  const CODE_INTERNAL_ERROR     = 2;
  const CODE_INVALID_FUNCTION   = 3;
  const CODE_INVALID_API_KEY    = 4;

  protected $apiKey = "";
  protected $apiKey = "4442c5d7688d78cb31f8fa4eb6312bd031e0896f6a4117612d92602b6342050e";
  protected $baseUrl = "http://localhost:9001/api";
  
  public function __construct($apiKey, $baseUrl = null){
    if (strlen($apiKey) < 1){
      throw new InvalidArgumentException("[{$apiKey}] is not a valid API key");
    }
    $this->apiKey  = $apiKey;

    if (isset($baseUrl)){
      $this->baseUrl = $baseUrl;
    }
    if (!filter_var($this->baseUrl, FILTER_VALIDATE_URL)){
      throw new InvalidArgumentException("[{$this->baseUrl}] is not a valid URL");
    }
  }

  protected function get($function, array $arguments = array()){
    return $this->call($function, $arguments, 'GET');
  }

  protected function post($function, array $arguments = array()){
    return $this->call($function, $arguments, 'POST');
  }

  protected function convertBools($candidate){
    if (is_bool($candidate)){
      return $candidate? "true" : "false";
    }
    return $candidate;
  }

  protected function call($function, array $arguments = array(), $method = 'GET'){
    $arguments['apikey'] = $this->apiKey;
    $arguments = array_map(array($this, 'convertBools'), $arguments);
    $arguments = http_build_query($arguments, '', '&');
    $url = $this->baseUrl."/".self::API_VERSION."/".$function;
    if ($method !== 'POST'){
      $url .=  "?".$arguments;
    }
    // use curl of it's available
    if (function_exists('curl_init')){
      $c = curl_init($url);
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($c, CURLOPT_TIMEOUT, 20);
      if ($method === 'POST'){
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $arguments);
      }
      $result = curl_exec($c);
      curl_close($c);
    // fallback to plain php
    } else {
      $params = array('http' => array('method' => $method, 'ignore_errors' => true, 'header' => 'Content-Type:application/x-www-form-urlencoded'));
      if ($method === 'POST'){
        $params['http']['content'] = $arguments;
      }
      $context = stream_context_create($params);
      $fp = fopen($url, 'rb', false, $context);
      $result = $fp ? stream_get_contents($fp) : null;
    }
    
    if(!$result){
      throw new UnexpectedValueException("Empty or No Response from the server");
    }
    
    $result = json_decode($result);
    if ($result === null){
      throw new UnexpectedValueException("JSON response could not be decoded");
    }
    return $this->handleResult($result);
  }

  protected function handleResult($result){
    if (!isset($result->code)){
      throw new RuntimeException("API response has no code");
    }
    if (!isset($result->message)){
      throw new RuntimeException("API response has no message");
    }
    if (!isset($result->data)){
      $result->data = null;
    }

    switch ($result->code){
      case self::CODE_OK:
        return $result->data;
      case self::CODE_INVALID_PARAMETERS:
      case self::CODE_INVALID_API_KEY:
        throw new InvalidArgumentException($result->message);
      case self::CODE_INTERNAL_ERROR:
        throw new RuntimeException($result->message);
      case self::CODE_INVALID_FUNCTION:
        throw new BadFunctionCallException($result->message);
      default:
        throw new RuntimeException("An unexpected error occurred whilst handling the response");
    }
  }

    // createGroup
  public function createGroup(){
    $params = array();


    return $this->post("createGroup", $params);
  }

  // createGroupIfNotExistsFor
  public function createGroupIfNotExistsFor($groupMapper){
    $params = array();

    $params['groupMapper'] = $groupMapper;

    return $this->post("createGroupIfNotExistsFor", $params);
  }

  // deleteGroup
  public function deleteGroup($groupID){
    $params = array();

    $params['groupID'] = $groupID;

    return $this->post("deleteGroup", $params);
  }

  // listPads
  public function listPads($groupID){
    $params = array();

    $params['groupID'] = $groupID;

    return $this->get("listPads", $params);
  }

  // listAllPads
  public function listAllPads(){
    $params = array();


    return $this->get("listAllPads", $params);
  }

  // createDiffHTML
  public function createDiffHTML($padID, $startRev, $endRev){
    $params = array();

    $params['padID'] = $padID;
    $params['startRev'] = $startRev;
    $params['endRev'] = $endRev;

    return $this->post("createDiffHTML", $params);
  }

  // createPad
  public function createPad($padID, $text = null){
    $params = array();

    $params['padID'] = $padID;
    if (isset($text)){
      $params['text'] = $text;
    }

    return $this->post("createPad", $params);
  }

  // createGroupPad
  public function createGroupPad($groupID, $padName, $text = null){
    $params = array();

    $params['groupID'] = $groupID;
    $params['padName'] = $padName;
    if (isset($text)){
      $params['text'] = $text;
    }

    return $this->post("createGroupPad", $params);
  }

  // createAuthor
  public function createAuthor($name = null){
    $params = array();

    if (isset($name)){
      $params['name'] = $name;
    }

    return $this->post("createAuthor", $params);
  }

  // createAuthorIfNotExistsFor
  public function createAuthorIfNotExistsFor($authorMapper, $name = null){
    $params = array();

    $params['authorMapper'] = $authorMapper;
    if (isset($name)){
      $params['name'] = $name;
    }

    return $this->post("createAuthorIfNotExistsFor", $params);
  }

  // listPadsOfAuthor
  public function listPadsOfAuthor($authorID){
    $params = array();

    $params['authorID'] = $authorID;

    return $this->get("listPadsOfAuthor", $params);
  }

  // createSession
  public function createSession($groupID, $authorID, $validUntil){
    $params = array();

    $params['groupID'] = $groupID;
    $params['authorID'] = $authorID;
    $params['validUntil'] = $validUntil;

    return $this->post("createSession", $params);
  }

  // deleteSession
  public function deleteSession($sessionID){
    $params = array();

    $params['sessionID'] = $sessionID;

    return $this->post("deleteSession", $params);
  }

  // getSessionInfo
  public function getSessionInfo($sessionID){
    $params = array();

    $params['sessionID'] = $sessionID;

    return $this->get("getSessionInfo", $params);
  }

  // listSessionsOfGroup
  public function listSessionsOfGroup($groupID){
    $params = array();

    $params['groupID'] = $groupID;

    return $this->get("listSessionsOfGroup", $params);
  }

  // listSessionsOfAuthor
  public function listSessionsOfAuthor($authorID){
    $params = array();

    $params['authorID'] = $authorID;

    return $this->get("listSessionsOfAuthor", $params);
  }

  // getText
  public function getText($padID, $rev = null){
    $params = array();

    $params['padID'] = $padID;
    if (isset($rev)){
      $params['rev'] = $rev;
    }

    return $this->get("getText", $params);
  }

  // setText
  public function setText($padID, $text){
    $params = array();

    $params['padID'] = $padID;
    $params['text'] = $text;

    return $this->post("setText", $params);
  }

  // getHTML
  public function getHTML($padID, $rev = null){
    $params = array();

    $params['padID'] = $padID;
    if (isset($rev)){
      $params['rev'] = $rev;
    }

    return $this->get("getHTML", $params);
  }

  // setHTML
  public function setHTML($padID, $html){
    $params = array();

    $params['padID'] = $padID;
    $params['html'] = $html;

    return $this->post("setHTML", $params);
  }

  // getAttributePool
  public function getAttributePool($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("getAttributePool", $params);
  }

  // getRevisionsCount
  public function getRevisionsCount($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("getRevisionsCount", $params);
  }

  // getSavedRevisionsCount
  public function getSavedRevisionsCount($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("getSavedRevisionsCount", $params);
  }

  // listSavedRevisions
  public function listSavedRevisions($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("listSavedRevisions", $params);
  }

  // saveRevision
  public function saveRevision($padID, $rev){
    $params = array();

    $params['padID'] = $padID;
    $params['rev'] = $rev;

    return $this->post("saveRevision", $params);
  }

  // getRevisionChangeset
  public function getRevisionChangeset($padID, $rev = null){
    $params = array();

    $params['padID'] = $padID;
    if (isset($rev)){
      $params['rev'] = $rev;
    }

    return $this->get("getRevisionChangeset", $params);
  }

  // getLastEdited
  public function getLastEdited($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("getLastEdited", $params);
  }

  // deletePad
  public function deletePad($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->post("deletePad", $params);
  }

  // copyPad
  public function copyPad($sourceID, $destinationID, $force = null){
    $params = array();

    $params['sourceID'] = $sourceID;
    $params['destinationID'] = $destinationID;
    if (isset($force)){
      $params['force'] = $force;
    }

    return $this->post("copyPad", $params);
  }

  // movePad
  public function movePad($sourceID, $destinationID, $force = null){
    $params = array();

    $params['sourceID'] = $sourceID;
    $params['destinationID'] = $destinationID;
    if (isset($force)){
      $params['force'] = $force;
    }

    return $this->post("movePad", $params);
  }

  // getReadOnlyID
  public function getReadOnlyID($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("getReadOnlyID", $params);
  }

  // getPadID
  public function getPadID($roID){
    $params = array();

    $params['roID'] = $roID;

    return $this->get("getPadID", $params);
  }

  // setPublicStatus
  public function setPublicStatus($padID, $publicStatus){
    $params = array();

    $params['padID'] = $padID;
    $params['publicStatus'] = $publicStatus;

    return $this->post("setPublicStatus", $params);
  }

  // getPublicStatus
  public function getPublicStatus($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("getPublicStatus", $params);
  }

  // setPassword
  public function setPassword($padID, $password){
    $params = array();

    $params['padID'] = $padID;
    $params['password'] = $password;

    return $this->post("setPassword", $params);
  }

  // isPasswordProtected
  public function isPasswordProtected($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("isPasswordProtected", $params);
  }

  // listAuthorsOfPad
  public function listAuthorsOfPad($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("listAuthorsOfPad", $params);
  }

  // padUsersCount
  public function padUsersCount($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("padUsersCount", $params);
  }

  // getAuthorName
  public function getAuthorName($authorID){
    $params = array();

    $params['authorID'] = $authorID;

    return $this->get("getAuthorName", $params);
  }

  // padUsers
  public function padUsers($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("padUsers", $params);
  }

  // sendClientsMessage
  public function sendClientsMessage($padID, $msg){
    $params = array();

    $params['padID'] = $padID;
    $params['msg'] = $msg;

    return $this->post("sendClientsMessage", $params);
  }

  // listAllGroups
  public function listAllGroups(){
    $params = array();


    return $this->get("listAllGroups", $params);
  }

  // checkToken
  public function checkToken(){
    $params = array();


    return $this->post("checkToken", $params);
  }

  // getChatHistory
  public function getChatHistory($padID, $start = null, $end = null){
    $params = array();

    $params['padID'] = $padID;
    if (isset($start)){
      $params['start'] = $start;
    }
    if (isset($end)){
      $params['end'] = $end;
    }

    return $this->get("getChatHistory", $params);
  }

  // getChatHead
  public function getChatHead($padID){
    $params = array();

    $params['padID'] = $padID;

    return $this->get("getChatHead", $params);
  }

  // restoreRevision
  public function restoreRevision($padID, $rev){
    $params = array();

    $params['padID'] = $padID;
    $params['rev'] = $rev;

    return $this->post("restoreRevision", $params);
  }


}

