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
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/popper.js"></script>
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />

    <script src="<?= JS_DIR; ?>crud/crud.js"></script>
</head>

<body>
    <div class="container">
        <!-- Title -->
        <div class="row">
            <div class="col-sm-12">
                <h1>帳號管理</h1>
            </div>
        </div
        <!-- Controll Form -->
        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="請輸入搜尋關鍵字">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">搜尋!</button>
                    </span>
                </div>
            </div>
            <div class="col-sm-4"><button class="btn btn-warning" data-toggle="modal" data-target="#insertModal">新增</button></div>
            <div class="btn-group sort-btn">
                <button class="btn btn-primary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="flase">排序</button>
                <button class="btn btn-primary dropdown-toggle" data-sort="none"><i class="fa fa-sort"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="#" tabindex="-1" data-type="alpha">Name</a></li>
                        <li><a href="#" tabindex="-1" data-type="numeric">Account</a></li>
                    </ul>
            </div>
        </div>

        <!-- Table -->
        <div class="row">
            <table class="table table-striped table-bordered table-hover ctrl-table">
                <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Id</th>
                        <th>Account</th>
                        <th>Name</th>
                        <th>Sex</th>
                        <th>Birthday</th>
                        <th>Email</th>
                        <th>Comments</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Pagination -->
        <div class="row pull-right">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </div>
        <div class="row">
            <div id="ctrl-message" class="text-danger ctrl-message"></div>
        </div>
    </div>

    <!-- The Insert Modal -->
    <div class="modal fade" id="insertModal" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="True">&times;</span></button>
                    <h4 class="modal-title">新增一筆資料</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body insert">
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
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success insert-confirm-btn">完成</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>

            </div>
        </div>
    </div>

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
                                <input type="radio" name="sex" id="sexRadio2" value="Male"> Male
                            </label>
                            <label class="radio-sex">
                                <input type="radio" name="sex" id="sexRadio2" value="Female"> Female
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

    <!-- The Modify Modal -->
    <div class="modal fade" id="deleteModal" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="True">&times;</span></button>
                    <h4 class="modal-title">提醒</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <span>確定要刪除這筆資料嗎？</span>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success deleteConfirm">是</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">否</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>