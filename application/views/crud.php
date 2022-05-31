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
            <div class="col-sm-4 form-group">
                <input type="password" class="form-control" id="pwd">
            </div>
            <div class="col-sm-4"><button class="btn btn-primary">搜尋</button></div>
            <div class="col-sm-4"><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal">新增</button></div>
        </div>

        <!-- Table -->
        <div class="row">
            <table class="table table-striped table-bordered table-hover tablesorter">
                <thead>
                    <tr>
                        <th>&nbsp</th>
                        <th>Account</th>
                        <th>Name</th>
                        <th>Sex</th>
                        <th>Birthday</th>
                        <th>Email</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><button class="btn"><i class="fas fa-pen color_green ml-3"></i></button><button class="btn"><i class="fas fa-trash text-danger ml-3"></i></button></td>
                        <td>a111111</td>
                        <td>John</td>
                        <td>Male</td>
                        <td>1999/01/01</td>
                        <td>john@example.com</td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td><button class="btn"><i class="fas fa-pen color_green ml-3"></i></button><button class="btn"><i class="fas fa-trash text-danger ml-3"></i></button></td>
                        <td>b222222</td>
                        <td>Marry</td>
                        <td>Female</td>
                        <td>1999/02/02</td>
                        <td>marry@example.com</td>
                        <td>None</td>
                    </tr>
                    <tr>
                    <td><button class="btn"><i class="fas fa-pen color_green ml-3"></i></button><button class="btn"><i class="fas fa-trash text-danger ml-3"></i></button></td>
                        <td>c333333</td>
                        <td>July</td>
                        <td>Female</td>
                        <td>1999/03/03</td>
                        <td>july@example.com</td>
                        <td>None</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="row float-end">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </div>
    </div>


    <!-- The Modal -->
    <div class="modal fade" id="myModal" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">新增一筆資料</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Modal body..
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Confirm</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- The Modify Modal -->
    <div class="modal fade" id="modifyModal" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">請輸入修改內容</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Modal body..
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Confirm</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>