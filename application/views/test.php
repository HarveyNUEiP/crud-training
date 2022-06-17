<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CRUD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="witdth=device-width, initial-scale=1">
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/popper.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="node_modules/bootstrap3-dialog/dist/js/bootstrap-dialog.js"></script>
    <!-- Font Awesome Icon -->  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />
    <!-- import javascript -->
    <script src="<?= JS_DIR; ?>test/test.js"></script>
</head>

<body>
    <div class="container">
        <!-- Title -->
        <div class="row">
            <div class="col-sm-12">
                <h1>帳號管理</h1>
            </div>
        </div>
        <!-- Controll Form -->
        <div class="row">
            <div class="col-sm-2"><button class="btn btn-warning insert-btn">新增</button></div>
            <div class="col-sm-2 btn-group">
                <button class="btn btn-primary" id="import" type="button" onclick="$('#file-uploader').click()">匯入</button>
                <button class="btn btn-primary" id="export" type="button">匯出</button>
            </div>
            <div class="col-sm-2"><button class="btn btn-danger deleteDatas">批次刪除</button></div>
        </div>

        <!-- Table -->
        <table id="table_account" class="display"></table>

        <div id="current-page" style="display: none;" data-page="1"></div>
        <div class="row">
            <div id="ctrl-message" class="text-danger ctrl-message"></div>
        </div>
        <!-- ExportForm -->
        <form action="crud/export" method="post" target="_blank" class="export-form" style="display: none;">
            <input type="submit" value="Submit">
        </form>
        <!-- ImportInput -->
        <div>
            <input type="file" id="file-uploader" data-target="file-uploader" accept=".xlsx" style="display: none;"/>
        </div>

    </div>

    <!-- insertForm template -->
    <script id="detail-insertForm" type="text/template">
        <form id="insertForm">
            <div class="form-group">
                <label for="accountInput">Account*</label>
                <input type="text" class="form-control" id="accountInput" name="account" placeholder="Account">
            </div>
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

    <!-- The Modify Modal -->
    <div class="modal fade" id="modifyModal" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="True">&times;</span></button>
                    <h4 class="modal-title">請輸入修改內容</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body modify">
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
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success modify-confirm-btn">完成</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>