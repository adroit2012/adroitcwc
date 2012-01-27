<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!empty($_POST) && isset ($_SESSION['user'])) {
    $total_attending = App::getRepository('Event')->addAttendee($_POST['event_id'],$_SESSION['user']['user_id']);
    $total_attending = (int)$total_attending > 0 ? ($total_attending -1) : $total_attending;
    echo "<strong>You</strong> and <strong>".$total_attending." other people</strong> attending so far!";
    exit;
}
?>
