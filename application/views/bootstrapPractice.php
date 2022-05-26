<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootsrap 4 practice</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/popper.js"></script>
</head>

<body>
    <div class="container">
        <h2>Nav</h2>
        <p>Basic horizontal menu</p>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
        </ul><br>

        <h2>Stacked form</h2>
        <form action="/action_page.php">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
            </div>
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <br>

        <h2>Popover Example</h2>
        <button type="button" class="btn btn-default" title="Popover title" data-container="body" data-toggle="popover" data-placement="left" data-content="左侧的 Popover 中的一些内容">
            左侧的 Popover
        </button>
        <button type="button" class="btn btn-primary" title="Popover title" data-container="body" data-toggle="popover" data-placement="top" data-content="顶部的 Popover 中的一些内容">
            顶部的 Popover
        </button>
        <button type="button" class="btn btn-success" title="Popover title" data-container="body" data-toggle="popover" data-placement="bottom" data-content="底部的 Popover 中的一些内容">
            底部的 Popover
        </button>
        <button type="button" class="btn btn-warning" title="Popover title" data-container="body" data-toggle="popover" data-placement="right" data-content="右侧的 Popover 中的一些内容">
            右侧的 Popover
        </button><br>

        <h2>Tooltips Example</h2>
        <a href="#" data-toggle="tooltip" title="Hooray!">Hover over me</a>

    </div>
    <script>
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
        });
    </script>
</body>

</html>