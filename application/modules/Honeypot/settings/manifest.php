<?php

return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'honeypot',
        'version' => '4.7.0',
        'path' => 'application/modules/Honeypot',
        'title' => 'Honeypot',
        'description' => '',
        'author' => 'WebHive Team',
        'callback' => array(
            'path' => 'application/modules/Honeypot/settings/install.php',
            'class' => 'Honeypot_Installer',
        ),
        'actions' =>
        array(
            0 => 'install',
            1 => 'upgrade',
            2 => 'refresh',
            3 => 'enable',
            4 => 'disable',
        ),
        'directories' =>
        array(
            0 => 'application/modules/Honeypot',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/honeypot.csv',
        ),
    ),
);
?>