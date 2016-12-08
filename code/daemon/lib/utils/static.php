<?php

require_once '/home/vagrant/code/daemon/etc/db.php';


function connection() {
    global $DB;
    $DB = mysql_connect(DB_HOST, DB_USER, DB_PASS);
    mysql_select_db(DB_NAME);
}

function get_auth_token($arg) {
    return `bin/registermo $arg`;
}

function save($sql) {
    global $DB;
    mysql_query($sql);
}

function disconnect() {
    global $DB;
    mysql_close($DB);
}
