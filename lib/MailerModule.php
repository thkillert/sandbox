<?php

class MailerModule {
    private $__mailuser;
    private $__mailpass;

    public function getMailCredentials(){
        return $this->__mailuser . " / " . $this->__mailpass;
    }

    public function doNothing(){}
}
