<?php
error_reporting(0);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Activity Log</title>
    <meta name="description" content="">
    <meta name="google-signin-client_id" content="230562696906-nqlf1hc5picrmgf3hte7h0fd7s9ev581.apps.googleusercontent.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

    <!-- CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.0/gh-fork-ribbon.min.css" />
    <link href="<?php echo URL; ?>css/bootflat.min.css" rel="stylesheet">
    <link href="<?php echo URL; ?>css/bootstrap-multiselect.css" rel="stylesheet">
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
</head>
<body>
<a class="github-fork-ribbon" href="https://github.com/NeiChan/activitylog" title="Fork me on GitHub">Fork me on GitHub</a>
    <!-- logo -->
    <div class="logo">
        Activity Log
    </div>

    <!-- navigation -->
    <div class="navigation">
        <a href="<?php echo URL; ?>">Overview</a>
        <a href="<?php echo URL; ?>activities">activities</a>
        <a href="<?php echo URL; ?>categories">categories</a>
        <a href="<?php echo URL; ?>datatypes">datatypes</a>
        <a href="<?php echo URL; ?>companies">companies</a>
        <?php if($_SESSION["LoggedIn"]): ?>
        <div style="display:none;" class="g-signin2"></div>
        <a href="#" onclick="signOut();">Sign out</a>
        <?php else: ?>
        <div class="g-signin2" data-onsuccess="onSignIn"></div>
        <?php endif; ?>
    </div>
