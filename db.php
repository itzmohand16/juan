<?php

$db = new SQLite3('./safeassets/main.db');
if (!$db) {
    die("Connection failed: " . $db->lastErrorMsg());
}

$tableCheckQuery = "SELECT name FROM sqlite_master WHERE type='table' AND name='posts'";


$tableCheckResult = $db->querySingle($tableCheckQuery);

if (!$tableCheckResult) {
    $createTableQuery = 'CREATE TABLE "posts" (
        "id"	INTEGER,
        "title"	TEXT NOT NULL,
        "file"	TEXT NOT NULL,
        "desc"	TEXT NOT NULL,
        "time" DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY("id" AUTOINCREMENT)
    );';

    
    $createTableResult = $db->exec($createTableQuery);

    
    if (!$createTableResult) {
        die("Error creating table: " . $db->lastErrorMsg());
    }
}