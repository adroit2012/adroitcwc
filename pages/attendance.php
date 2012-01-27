<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!empty($_POST) && isset ($_SESSION['user'])) {
    $total_attending = App::getRepository('Event')->addAttendee($_POST['event_id'],$_POST['user_id']);
    echo "<strong>You</strong> and <strong>".($total_attending -1)." other people</strong> attending so far!";
    exit;
}
?>
