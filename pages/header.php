<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo ViewHelper::config('app.title') ?></title>
    <meta name="description" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="<?php echo ViewHelper::url("assets/css/bootstrap.css") ?>" rel="stylesheet">
    <link href="<?php echo ViewHelper::url("assets/css/app.css") ?>" rel="stylesheet">
    <link href="<?php echo ViewHelper::url("assets/css/overwrite.css") ?>" rel="stylesheet">
    <link href="<?php echo ViewHelper::url("assets/css/token-input.css") ?>" rel="stylesheet">
    <link href="<?php echo ViewHelper::url("assets/css/token-input-facebook.css") ?>" rel="stylesheet">
    <link href="<?php echo ViewHelper::url("assets/jquery-ui/jquery-ui.min.css") ?>" rel="stylesheet">
    <script src="<?php echo ViewHelper::url("assets/js/jquery-1.7.1.min.js") ?>" type="text/javascript"></script>
    <script src="<?php echo ViewHelper::url("assets/js/jquery.validate.min.js") ?>" type="text/javascript"></script>
    <script src="<?php echo ViewHelper::url("assets/jquery-ui/jquery-ui.min.js") ?>" type="text/javascript"></script>
    <script src="<?php echo ViewHelper::url("assets/js/jquery.tokeninput.js") ?>" type="text/javascript"></script>
</head>

<body>

<div class="topbar">

    <div class="fill">

        <div class="container">

            <a class="brand" href="<?php ViewHelper::url() ?>"><?php echo ViewHelper::config('app.title') ?></a>

            <ul class="nav">
                <li><a href="<?php ViewHelper::url() ?>">Home</a></li>
                <li><a href="<?php ViewHelper::url('?page=events') ?>">Events</a></li>
                <li><a href="<?php ViewHelper::url('?page=about') ?>">About</a></li>
            </ul>

            <span class="pull-right">
                <?php if ($_SESSION['user']): ?>
                    <span><?php echo $_SESSION['user']['email'] ?></span> | <a href="<?php ViewHelper::url('?page=logout') ?>">Logout</a>
                <?php else: ?>
                    <div class="sign-in-with">Sign in with :</div>
                    <a href="<?php ViewHelper::url('?page=login&type=google') ?>">
                      <img width="24px" height="24px" src="<?php ViewHelper::url('assets/images/google_signin.png') ?>" alt="Sign in with Google">
                    </a>
                    <a href="<?php ViewHelper::url('?page=login&type=yahoo') ?>">
                      <img width="24px" height="24px" src="<?php ViewHelper::url('assets/images/yahoo_signin.png') ?>" alt="Sign in with Yahoo!">
                    </a>
                <?php endif; ?>
            </span>

        </div>

    </div>

</div>

<div class="container">

