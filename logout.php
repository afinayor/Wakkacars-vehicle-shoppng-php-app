<?php
/**
 * Created by PhpStorm.
 * User: Afolabi mayowa
 * Date: 27/11/2015
 * Time: 04:20
 */

require_once 'core/init.php';

$user = new user();
$user->logout();

redirect::to('index.php');