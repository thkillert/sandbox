<?php

require_once('ServiceClient.php');

$client = new ServiceClient();

$client->setRepository('myUser/repoName')
       ->action('CREATE-ISSUE')
        ->content([]);

//print_r($client);
