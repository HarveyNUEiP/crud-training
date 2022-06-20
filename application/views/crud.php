<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 網頁名稱 -->
    <title>CRUD_Training</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    
    <!-- bootstrap -->
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- bootstrapDialog -->
    <script src="node_modules/bootstrap3-dialog/dist/js/bootstrap-dialog.js"></script>

    <!-- datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    <!-- rustaMsgBox -->
    <script src="node_modules/jquery/dist/jquery.rustaMsgBox.js"></script>

    <!-- Font Awesome Icon -->  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />

    <!-- import javascript -->
    <script src="<?= JS_DIR; ?>crud/crud.js"></script>

</head>

<body>
    <div class="container">
        <!-- Title -->
        <div class="row">
            <div class="col-sm-12">
                <h1>帳號管理</h1>
            </div>
        </div>
        <!-- /Title -->

        <!-- Controll Form -->
        <div class="row">
            <div class="col-sm-2"><button class="btn btn-warning insert-btn">新增</button></div>
            <div class="col-sm-2 btn-group">
                <button class="btn btn-primary" id="import" type="button" onclick="$('#file-uploader').click()">匯入</button>
                <button class="btn btn-primary" id="export" type="button">匯出</button>
            </div>
            <div class="col-sm-2"><button class="btn btn-danger deleteDatas">批次刪除</button></div>
        </div>
        <!-- /Controll Form -->

        <!-- Table -->
        <div class="table-location">
            <table id="table_account" class="display"></table>
        </div>
        <!-- /Table -->

        <!-- ExportForm -->
        <form action="crud/export" method="post" target="_blank" class="export-form" style="display: none;">
            <input type="submit" value="Submit">
        </form>
        <!-- /ExportForm -->

        <!-- ImportInput -->
        <div>
            <input type="file" id="file-uploader" data-target="file-uploader" accept=".xlsx" style="display: none;"/>
        </div>
        <!-- /ImportInput -->

    </div>

    <!-- insertForm template -->
    <script type="text/template" id="detail-insertForm">
        <form id="insertForm">
            <div class="form-group">
                <label for="accountInput">Account*</label>
                <input type="text" class="form-control" id="accountInput" name="account" placeholder="Account">
            <div class="form-group">
                <label for="nameInput">Name*</label>
                <input type="text" class="form-control" id="nameInput" name="name" placeholder="name">
            </div>
            <div>
                <p><b>Sex*</b></p>
                <label class="radio-sex">
                    <input type="radio" name="sex" id="sexRadio1"  value="Male"> Male
                </label>
                <label class="radio-sex">
                    <input type="radio" name="sex" id="sexRadio1" value="Female"> Female
                </label>
            </div>    
            <div>
                <p><b>Birthday*</b></p>
                <input type="text" class="form-control" id="birthdayInput" name="birthday" placeholder="ex:1999-03-22">
            </div>
            <div>
                <p><b>Email*</b></p>
                <input type="text" class="form-control" id="emailInput" name="email" placeholder="email@example.com">
            </div>
            <div>
                <p><b>Comments</b></p>
                <textarea class="form-control" id="commentsInput" name="comments" rows="3"></textarea>
            </div>
            <div>
                <p class="errorMessage" id="insert" style="color:red"></p>
            </div>
        </form>
    </script>
    <!-- /insertForm template -->

    <!-- ModifyForm template -->
    <script type="text/template" id="detail-modifyForm">
        <form id="modifyForm">
            <div class="form-group">
                <label for="accountInput">Account*</label>
                <input type="text" class="form-control" id="accountInput1" name="account" placeholder="Account">
            </div>
            <div class="form-group">
                <label for="nameInput">Name*</label>
                <input type="text" class="form-control" id="nameInput1" name="name" placeholder="name">
            </div>
            <div>
                <p><b>Sex*</b></p>
                <label class="radio-sex">
                    <input type="radio" name="sex" id="sexRadio3" value="Male"> Male
                </label>
                <label class="radio-sex">
                    <input type="radio" name="sex" id="sexRadio4" value="Female"> Female
                </label>
            </div>
            <div>
                <p><b>Birthday*</b></p>
                <input type="text" class="form-control" id="birthdayInput1" name="birthday" placeholder="ex:1999-03-22">
            </div>
            <div>
                <p><b>Email*</b></p>
                <input type="text" class="form-control" id="emailInput1" name="email" placeholder="email@example.com">
            </div>
            <div>
                <p><b>Comments</b></p>
                <textarea class="form-control" id="commentsInput1" name="comments" rows="3"></textarea>
            </div>
            <div>
                <p class="errorMessage" id="modify" style="color:red"></p>
            </div>
        </form>
    </script>
    <!-- /ModifyForm template -->


</body>
</html>