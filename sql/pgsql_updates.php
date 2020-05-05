<?php

global $_TABLES;

$_UPDATES = [
    '1.9.4' => [
        // to accept IPv6
        "ALTER TABLE {$_TABLES['messenger_msg']} ALTER COLUMN ip TYPE VARCHAR(39)",
    ],
];
