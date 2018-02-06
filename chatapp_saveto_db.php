<?php

$chatAppConn = new PDO('mysql:host=localhost;dbname=chatappdb;charset=utf8mb4', 'root', '');

CREATE TABLE `chatmessages`
(
    `id`        int(11) AUTO_INCREMENT PRIMARY KEY,
    `says`      varchar(255),
    `who`       varchar(64),
    `privateMessage`  varchar(64),
    `date_time`  datetime
);