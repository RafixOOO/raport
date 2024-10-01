<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['username']);
}

function isSidebar(): int{
    return isset($_SESSION['sidebar']) ? (int) $_SESSION['sidebar'] : 0;}
function isIdent() {
    return isset($_SESSION['id']) ? (int) $_SESSION['id'] : 0;}

function isUserAdmin()
{
    return isset($_SESSION['username']) && $_SESSION['role_admin'] == 1;
}

function logout()
{
    session_unset();
    session_destroy();
}

?>