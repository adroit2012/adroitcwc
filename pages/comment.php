<?php

if (!empty($_POST) && isset ($_SESSION['user'])) {
	if(isset ($_POST['talk_id']))
	{
		App::getRepository('Comment')->create($_POST);
		header('Location: ' . ViewHelper::url('?page=talk&id=' . $_POST['talk_id'], true));
	}
	elseif(isset($_POST['event_id']))
	{
		App::getRepository('Comment')->create($_POST);
		header('Location: ' . ViewHelper::url('?page=event&id=' . $_POST['event_id'], true));
	}
} else {
    header('Location: ' . ViewHelper::url('', true));
}