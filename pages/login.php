<?php

try {
    /*
     * Do not hard code the host url
     * load host url from app.ini file
     */
    $openid = new LightOpenID(ViewHelper::config('url.host'));

    if (!$openid->mode) {
        if ($_GET['page'] == 'login') {
            /*
             * Check Whether OpenID (1.1 and 2.0) authentication is Google or Yahoo!
             */
            if($_GET['type'] == 'google'){
              $openid->identity = ViewHelper::config('openid.google');
            }  elseif ($_GET['type'] == 'yahoo') {
              $openid->identity = ViewHelper::config('openid.yahoo');
            }
            $openid->required = array('namePerson', 'contact/email');
            $openid->optional = array('namePerson/friendly');
            header('Location: ' . $openid->authUrl());
        }

    } elseif ($openid->mode == 'cancel') {

        $_SESSION['flash']['message'] = 'User has cancelled authentication!';

    } else {

        if ($openid->validate()) {

            $authData = $openid->getAttributes();

            $_SESSION['user']['openid']   = $openid->identity;
            $_SESSION['user']['email']    = $authData['contact/email'];
            $_SESSION['user']['name']    = $authData['namePerson'] ? $authData['namePerson'] : $authData['namePerson/friendly'];
            $_SESSION['flash']['type']    = 'success';
            $_SESSION['flash']['message'] = '<b>Successfully authenticated!</b>. Welcome ' . $authData['contact/email'];

            $userRepository = App::getRepository('User');

            if (!$userRepository->getUserByEmail($_SESSION['user']['email'])){
                $userRepository->create($_SESSION['user']['email'], $_SESSION['user']['name']);
            }

            $user = $userRepository->getUserByEmail($_SESSION['user']['email']);
            $_SESSION['user'] = $user;

        } else {

            $_SESSION['flash']['message'] = 'User was not authenticated!';
            $_SESSION['flash']['type']    = 'error';
        }

		//return to previous url
        header('Location: ' . ViewHelper::url('', true));

    }

} catch (ErrorException $e) {
    header('Location: ' . ViewHelper::url('', true));
}
