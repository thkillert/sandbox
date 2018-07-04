<?php

class ServiceClient {

    private $_client;
    private $_repository;
    
    private $_actions = [
      'LIST-ISSUES' => [
          'url' => '/repos/::REPOSITORY::/issues',
          'type' => 'GET'
      ],
      'CREATE-ISSUE' => [
          'url' => '/repos/::REPOSITORY::/issues',
          'type' => 'POST',
          'contentType' => 'application/json',
          'content' => [
              'title' => 'required',
              'body' => 'required',
              'assignees' => [
                  ''
              ],
              'labels' => [
                  ''
              ],
              'milestone' => ''
          ]
      ]
    ];
    
    private $_currentAction;
    private $_content;
    private $_url;

    public function __construct(){
        $this->_client = curl_init();
    }

    public function setOption($pOption, $pValue){
        curl_setopt($this->_client, $pOption, $pValue);
        return $this;
    }

    /**
     * multiple arguments allowed
     * @param mixed ...$pArguments   one argument: fully-qualified repository identifiert<br />two arguments :owner and repository name
     * @return void
     */
    public function setRepository(string ...$pArguments){
        $lRepoIdentifier = '';
        switch(count($pArguments)){
            case 1:
                $lRepoIdentifier = $pArguments[0];
                break;
            case 2:
                $lOwner = $pArguments[0];
                $lRepoName = $pArguments[1];
                $lRepoIdentifier = $lOwner . '/' . $lRepoName;
                break;
        }
        $this->__setRepository($lRepoIdentifier);
        return $this;
    }

    private function __setRepository($pRepo){
        $this->_repository = $pRepo;
    }
    
    public function action($pAction){
        $allowedActions = array_keys($this->_actions);
        if (!in_array($pAction, $allowedActions)){
            return null;
        }
        $this->_currentAction = $pAction;
        return $this;
    }
    
    public function content(array $pData){
        $reqContent = $this->_actions[$this->_currentAction]['content'];
        $reqFields = array_keys($reqContent, 'required');
        $diff = array_diff_key($req, $pData);
        if ( count($diff) > 0){
            return null;
        }
        $this->_content = json_encode($pData);
        return $this;
    }
    
    private function requiresContent(){
        return array_key_exists('content', $this->_actions[$this->_currentAction]);
    }
    
    public function execute(){
        if(empty($this->_currentAction)){
            throw new Exception("Action can not be null!");
        }
        if($this->requiresContent()){
            if(empty($this->_content)){
                throw new Exception("Content required!");
            }
        }
        $this->_url = strtr($this->_actions[$this->_currentAction]['url'], [
            '::REPOSITORY::' => $this->_repository
        ]);
        
    }
}
