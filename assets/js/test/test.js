$(function() {
  'use strict';

  // 載入頁面
  $(document).ready(function() {
    new App();
  });

  var App = function() {
    var self = this;
    // Application Options initialize
    // var options = options || {};
    // Application element
    // var el = option.el || option.element || '.container';
    // var $el = $(el);

    var url = {
      ajaxApi: '/test/ajax'
    };

    var constructor = function() {
      // 初始化
      self.initialize();
      // 建立綁定事件
      self.events();

      loadAllData();
    };

    /**
     * 事件綁定
     */
    self.events = function() {
      console.log('_eventsBind');
      
      // 點擊新增
      $('.insert-btn').on('click', function() {
        // console.log('新增按鈕')
        // 跳出新增Modal
        BootstrapDialog.show({
          // Modal 視窗標題
          title: "新增資料",
          // Modal 視窗內容
          message: $('#detail-insertForm').html(),
          // Modal 按鈕
          buttons: [{
            // 按鈕名稱
            id: 'btn-confirm',
            // 按鈕圖示
            icon: 'glyphicon glyphicon-floppy-save',
            // 按鈕文字
            label: '確認',
            // 按鈕顏色
            cssClass: 'btn-success',
            // 按鈕觸發之動作
            action: function() {

            }
          }, {
            // 按鈕名稱
            id: 'btn-cancel',
            // 按鈕圖示
            icon: 'glyphicon glyphicon-remove',
            // 按鈕文字
            label: '取消',
            // 按鈕顏色
            cssClass: 'btn-danger',
            // 按鈕觸發之動作
            action: function(dialog) {
              dialog.close();
            }
          }
          ]
        });
      });

      // 點擊刪除
      $('.deleteDatas').on('click', function() {
        // 跳出刪除Modal
        BootstrapDialog.show({
          // Modal 視窗標題
          title: '刪除資料確認',
          // Modal 視窗內容
          message: '<span>確定要刪除資料嗎？</span>',
          // Modal 視窗按鈕
          buttons :[{
            // 按鈕名稱
            id: 'btn-confirm',
            // 按鈕圖示
            icon: 'glyphicon glyphicon-check',
            // 按鈕文字
            label: '確認',
            // 按鈕顏色
            cssClass: 'btn-success',
            // 按鈕觸發之動作
            action: function() {

            }
          }, {
            // 按鈕名稱
            id: 'btn-cancel',
            // 按鈕圖示
            icon: 'glyphicon glyphicon-remove',
            // 按鈕文字
            label: '取消',
            // 按鈕顏色
            cssClass: 'btn-danger',
            // 按鈕觸發之動作
            action: function(dialog) {
              dialog.close();
            }
          }
          ]
        })
      });

      // 點擊匯出
      $('#export').on('click', function() {
        
      })
    };

    self.initialize = function() {
      console.log('_initialize');
    };

    var loadAllData = function(limit = '', offset = '', keywords = '', orderBy = '', descAsc = '') {
      $.ajax({
        method: 'GET',
        url: url.ajaxApi,
        data:{
          "limit": limit,
          "offset": offset,
          "keywords": keywords,
          "orderBy": orderBy,
          "descAsc": descAsc
        },
        dataType: 'json'
      }).done(function(data) {
        buildDataTable(data.data);
      });
    }

    /**
     * 建構資料表
     */
    var buildDataTable = function(data) {
      // var data = [
      //   {
      //     "id": 0,
      //     "account": "huang",
      //     "name": "CKhuang",
      //     "sex": "Male",
      //     "birthday": "1999-03-22",
      //     "email": "huang63261@gmail.com",
      //     "comments": ""
      //   },
      //   {
      //     "id": 1,
      //     "account": "kangyi",
      //     "name": "KangYiMA",
      //     "sex": "Female",
      //     "birthday": "1970-01-01",
      //     "email": "kangyima@gmail.com",
      //     "comments": ""
      //   },
      //   {
      //     "id": 2,
      //     "account": "joeyhuang",
      //     "name": "Joey",
      //     "sex": "Male",
      //     "birthday": "1962-05-09",
      //     "email": "joey@gmail.com",
      //     "comments": ""
      //   }
      // ];

      $('#table_account').DataTable({
        "data": data,
        "columns":[
          {
            data: "id", title: "序號"
          },
          {
            data: "account", title: "帳號"
          },
          {
            data: "name", title: "姓名"
          },
          {
            data: "sex", title: "性別"
          },
          {
            data: "birthday", title: "生日"
          },
          {
            data: "email", title: "信箱"
          },
          {
            data: "comments", title: "備註"
          },
        ]
      });
    }

    constructor();
  };
});