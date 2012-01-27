<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//id:1
//rating:5
if (!empty($_POST) && isset ($_SESSION['user'])) {
    $talk = App::getRepository('Talk')->rateTalk($_POST['id'],$_POST['rating']);
    echo (double)$talk['rating'];
    exit;
}
?>
