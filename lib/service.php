<?php

$allowed_commands = [
    'LIST-ISSUES',
    'CREATE-ISSUE',
];

$command = $argv[1];

if ( empty($command) || !in_array($command, $allowed_commands) ){
    echo 'Command \'' . $command . '\' is not recognized.' . "\n";
    exit;
}


$userdata = [
    'name' => 'thkillert',
    'pass' => 'LTwa22Nov2011g.',
];

$client = curl_init();

curl_setopt($client, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($client, CURLOPT_USERPWD, $userdata['name'] . ':' . $userdata['pass']);
curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($client, CURLOPT_USERAGENT, 'KIL Testskript Weitkamper');

if ( $command === 'LIST-ISSUES' ){
    curl_setopt($client, CURLOPT_URL, 'https://api.github.com/repos/thkillert/sandbox/issues');

    $result = curl_exec($client);

    curl_close($client);

    var_dump($result);
} else if ( $command === 'CREATE-ISSUE' ){
    curl_setopt($client, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($client, CURLOPT_URL, 'https://api.github.com/repos/thkillert/sandbox/issues');

    $fields = [
        'title' => 'Issue per Skript erstellen',
        'body' => 'Dieses Issue wurde per Skript erstellt!',
        'assignees' => [
            'thkillert'
        ]
    ];
    $data = json_encode($fields);

    curl_setopt($client, CURLOPT_POST, count($fields));
    curl_setopt($client, CURLOPT_POSTFIELDS, $data);
    curl_setopt($client, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]);

    $result = curl_exec($client);

    curl_close($client);

    var_dump($result);
}


