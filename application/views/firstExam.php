<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- 網頁名稱 -->
    <title>Document</title>
    <!-- /網頁名稱 -->
    <meta charset="UTF-8">
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
    <script src="<?= JS_DIR; ?>firstExam/firstExam.js"></script>
</head>
<body>
    <div class="container">
        <!-- Title -->
        <div class="row">
            <div class="col-sm-12">
                <h2>公司資訊</h2>
            </div>
        </div>
        <!-- /Title -->

        <!-- Control Buttons -->
        <div class="row">
            <div class="col-sm-1"><button class="btn btn-warning insert-btn">新增</button></div>
            <div class="col-sm-4"><button class="btn btn-primary import-btn" onclick="$('#file-uploader').click()">匯入</button></div>
            <div class="col-sm-1"><button class="btn btn-primary export-btn">匯出</button></div>
            <div class="col"><button class="btn btn-danger deleteDatas">批次刪除</button></div>
        </div>
        <!-- /Control Buttons -->

        <!-- Table -->
        <div class="table-location">
            <table id="table_company" class="display"></table>
        </div>
        <!-- /Table -->

        <!-- ExportForm -->
        <form action="first_exam/export" method="post" target="_blank" class="export-form" style="display: none;">
            <input type="submit" value="Submit">
        </form>
        <!-- /ExportForm -->

        <!-- ImportInput -->
        <div>
            <input type="file" id="file-uploader" data-target="file-uploader" accept=".xlsx" style="display: none;"/>
        </div>
        <!-- /ImportInput -->

    </div>
    <!-- Form Modal Template -->
    <script type="text/template" id="detail-form">
        <form id="formModal">
            <div class="form-group">
                <label for="nameInput">* 公司名稱
                <input type="text" class="form-control" id="nameInput" name="name" placeholder="Company Name" maxlength="20"/>
                </label>
            </div>
            <div class="form-group">
                <label for="foundedDateInput">* 公司成立日期
                <input type="datetime-local" step="1" class="form-control" id="foundedDateInput" name="founded_date"/>
                </label>
            </div>
            <div class="form-group">
                <p><b>* 聯絡窗口</b></p>
                <input type="text" class="form-control" id="contactInput" name="contact" placeholder="ex:吳小姐 (02)1234-5678" style="width: 300px;"/>
            </div>
            <div class="form-group">
                <p><b>* 公司信箱</b></p>
                <input type="email" class="form-control" id="emailInput" name="email" placeholder="ex: example@gmail.com" style="width: 300px;"/>
            </div>
            <div class="form-group">
                <p><b>* 公司規模</b></p>
                <select name="scale" id="scaleInput">
                    <option value="">請選擇公司規模</option>
                    <option value="big">大</option>
                    <option value="medium">中</option>
                    <option value="small">小</option>
                </select>
            </div>
            <div>
                <p><b>* 行業別編號</b></p>
                <select name="ndustry_id" id="ndustryInput">
                    <option value="0">請選擇行業</option>
                    <option value="1">農、林、漁、牧業</option>
                    <option value="2">礦業及土石採取業</option>
                    <option value="3">製造業</option>
                    <option value="4">電力及燃氣供應業</option>
                    <option value="5">用水供應及污染整治業</option>
                    <option value="6">營造業</option>
                    <option value="7">批發及零售業</option>
                    <option value="8">運輸及倉儲業</option>
                    <option value="9">住宿及餐飲業</option>
                    <option value="10">資訊及通訊傳播業</option>
                    <option value="11">金融及保險業</option>
                    <option value="12">不動產業</option>
                    <option value="13">專業、科學及技術服務業</option>
                    <option value="14">支援服務業</option>
                    <option value="15">公共行政及國防；強制性社會安全</option>
                    <option value="16">教育服務業</option>
                    <option value="17">醫療保健及社會工作服務業</option>
                    <option value="18">藝術、娛樂及休閒服務業</option>
                    <option value="19">其他服務業</option>
                    <option value="20">非營利組織</option>
                </select>
            </div>
            <div>
                <p class="errorMessage" style="color:red"></p>
            </div>
        </form>
    </script>
    <!-- /Form Modal Template -->
</body>
</html>