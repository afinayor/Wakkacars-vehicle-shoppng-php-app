<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 15/03/2015
 * Time: 14:05
 */
require_once 'core/init.php';

$user = new user();
$user->logout();

redirect::to('index.php');