<?php
function getUserByUsername($username) {
    $sql_u = "SELECT * FROM signup WHERE username LIKE ?";
    $user = sqlGet($sql_u,'s',array($username));
    return $user;
}

function getUserByEmail($email) {
    $sql_u = "SELECT * FROM signup WHERE email LIKE ?";
    $user = sqlGet($sql_u,'s',array($email));
    return $user;
}

function getUserByUsernameOrEmailAndPassword($username, $password) {
    $sql_u = "SELECT * FROM signup WHERE ( email LIKE ? OR username LIKE ? ) AND `password` = ?";
    $user = sqlGet($sql_u,'sss',array($username,$username,md5($password)));
    return $user;
}
?>