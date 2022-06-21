/**
 * @author Harvey
 */

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
    var el = '.container';
    var $el = $(el);

    var url = {
      ajaxApi: '/crud/ajax'
    };

    // 建構子
    var constructor = function() {
      // 初始化
      self.initialize();
      // 建立綁定事件
      self.events();

      // 載入資料並建立 DataTable
      loadAllData();
    };

    /**
     * 初始化
     */
    self.initialize = function() {
      console.log('_initialize');
    };

    /**
     * 事件綁定
     */
    self.events = function() {
      console.log('_eventsBind');
      
      // 點擊新增
      $('.insert-btn').on('click', function() {
        // 跳出新增Modal
        BootstrapDialog.show({
          // Modal 視窗標題
          title: "新增資料",
          // Model 視窗點空白處無法跳出
          closable: false,
          // Modal 視窗內容
          message: $($('#detail-insertForm').html()),
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
            action: function(dialog) {
              // 關閉 Modal 視窗
              var closeModal = function() {
                dialog.close();
              }
              // 新增一筆資料
              insertData(closeModal);
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
      $el.on('click', '.delete-btn', function() {
        // 將欲刪除之資料id放入陣列中
        var id = $(this).parents().children('.keyId').text();

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
            action: function(dialog) {
              // 關閉 Modal 視窗
              var closeModal = function() {
                dialog.close();
              }
              // 刪除一筆資料
              deleteOneData(id, closeModal);
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

      // 點擊批次刪除
      $('.deleteDatas').on('click', function() {
        
        // 創建一個陣列存放id
        var id = new Array;
        // 取得多個checkbox之id，並加入至陣列中
        $('input:checked').each(function() {
            id.push($(this).parents().children('.keyId').text())  
        });


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
            action: function(dialog) {
              // 關閉 Modal 視窗
              var closeModal = function() {
                dialog.close();
              }
              // 刪除多筆資料
              deleteData(id, closeModal);
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

      // 點擊編輯
      $el.on('click', '.edit-btn', function() {
        // 取得欲修改資料之id
        var keyId = $(this).parents().children('.keyId').text();

        // 顯示編輯Modal
        BootstrapDialog.show({
          // Modal 標題
          title: "修改資料",
          // Model 視窗點空白處無法跳出
          closable: false,
          // Modal 內容
          message: $($('#detail-modifyForm').html()),
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
            action: function(dialog) {
              // 關閉 Modal 視窗
              var closeModal = function() {
                dialog.close();
              }
              // 更新資料
              UpdateDate(keyId, closeModal);
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
          ],
          onshow: function(dialog) {
            // 抓取 Modal 中的表單位置
            var modalBody = dialog.getModalBody();
            // 讀取修改資料
            loadData(modalBody, keyId);
          }
        })
      });

      // 點擊匯入
      $('#file-uploader').on('change', function() {
        // 取得上傳檔案
        var file = this.files[0];
        // 創建一FormData
        var form = new FormData();
        // 將檔案放入FormData
        form.append('data', file)

        // 將FormData發送至後端處理
        $.ajax({
          method: 'POST',
          url: '/crud/import',
          processData: false,
          contentType: false,
          data: form
        }).done(function() {
          // 顯示匯入成功訊息
          $.rustaMsgBox({
            'content': "檔案匯入成功",
            'mode': 'info'
          });
          // 刷新資料
          reload();
        }).fail(function(jqXHR) {
          console.log(jqXHR.statusText);
          // 顯示匯入失敗訊息
          $.rustaMsgBox({
            'content': "檔案匯入失敗",
            'mode': 'error'
          });
        });

        // 清除上傳檔案
        $('#file-uploader').val('');
      });

      // 點擊匯出
      $('#export').on('click', function() {
        // 取得匯出Form
        var form = $('.export-form');
        // 將搜尋條件加入Form
        $(`<input type="text" id="export-data" name="keywords" value="${$('input[type="search"]').val()}">`).appendTo(form);
        // 提交Form
        $('.export-form').submit();
        // 移除搜尋條件
        $('#export-data').remove();
      });
    };

    /**
     * 建構資料表
     * 
     * @param {object} data 欲顯示之資料
     */
    var buildDataTable = function(data) {
      // 建立DataTable
      $('#table_account').DataTable({
        // 表單資料
        "data": data,
        // 表單欄位
        "columns": [{
          // checkBox 欄位
            data: null
          }, {
            data: "id",
            title: "序號"
          }, {
            data: "account",
            title: "帳號"
          }, {
            data: "name",
            title: "姓名"
          }, {
            data: "sex",
            title: "性別"
          }, {
            data: "birthday",
            title: "生日"
          }, {
            data: "email",
            title: "信箱"
          }, {
            data: "dept_name",
            title: "部門名稱"
          }, {
            data: "comments",
            title: "備註"
          }, {
            // 按鈕欄位
            data: null,
            title: '操作功能',
            render: function (data, type, row) {
                return '<button type="button" class="btn btn-info btn-sm edit-btn">編輯</button> ' +
                '<button type="button" class="btn btn-danger btn-sm delete-btn">刪除</button>';
            }
          }
        ],
        // 欄位設定
        "columnDefs": [{
          // 第一欄的 checkbox 取消排序與搜尋
          targets: [0],
          searchable: false,
          orderable: false,
          className: 'dt-body-center',
          render: function(data, type, row) {
            return '<label style="display:block;"><input class="checkchild" type="checkbox"/></label>';
          }
        }, {
          // 設定Id ClassName
          targets: [1], className: 'keyId'
        }, {
          // 設定最後一欄 取消排序、搜尋
          targets: [9],
          searchable: false,
          orderable: false,
          responsivePriority: 1
        }, {
          // 設定所有欄位 ClassName
          targets: '_all',
          className: 'text-center'
        }],

        // 每頁顯示數量的 Dropdown
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
      });
    }

    /**
     * 讀取全部資料並建立 DataTable
     * 
     * @param {int} limit 限制筆數 (預設為空)
     * @param {int} offset 起始筆數 (預設為空)
     * @param {string} keywords 搜尋關鍵字 (預設為空)
     * @param {string} orderBy 排序的依據欄位 (預設為空)
     * @param {string} descAsc (生冪/降冪) (預設為空)
     */
    var loadAllData = function(limit = '', offset = '', keywords = '', orderBy = '', descAsc = '') {
      // 發送AJAX GET請求
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
        // 建立 DataTable
        buildDataTable(data.data);
      }).fail(function(jqXHR) {
        // 顯示錯誤資訊
        console.log(jqXHR.statusText);
      });
    }

    /**
     * 讀取單筆資料
     * 
     * @param {object} modalBody Modal 中的表單位置
     * @param {int} id 欲讀取資料之id
     */
    var loadData = function(modalBody, id) {
      // 發送AJAX GET 請求
      $.ajax({
        method: 'GET',
        url: url.ajaxApi + `/${id}`,
        dataType: 'json'
      }).done(function(data) {
        // 將資料顯示在修改表單上
        $.each(data,function(index1, value1) {
          if (index1 == 'sex') {
            // 性別選項check
            modalBody.find(`input[name=${index1}][value=${data['sex']}]`).prop("checked", true);
          } else if (index1 == 'dept_no') {
            // 選擇部門
            modalBody.find(`select[name=${index1}]`).val(value1);
          } else if (index1 == 'comments') {
            // 顯示備註
            modalBody.find(`textarea[name=${index1}]`).val(value1);
          } else {
            // 將其餘資料顯示在修改表單上
            modalBody.find(`input[name=${index1}]`).val(value1);
          }
        })
      }).fail(function(jqXHR) {
        // 顯示錯誤資訊
        console.log(jqXHR.statusText);
      });
    }

    /**
     *  新增資料
     * 
     * @param {function} closeModal 關閉 Model 函式
     */
    var insertData = function(closeModal) {
      // 將輸入資料序列化
      var formData = $('#insertForm').serializeArray();

      try {
        // 資料驗證
        dataValidation(formData);
        
        // AJAX 發送新增資料請求
        $.ajax({
          method: 'POST',
          url: url.ajaxApi,
          data: formData,
          dataType: 'json'
        }).done(function(data) {
            // 通知新增成功
            $.rustaMsgBox({
              content: "資料新增成功",
              mode: "success"
            })
            // 關閉 Modal 視窗
            if (typeof closeModal == 'function') {
              closeModal();
            }
            // 刷新資料
            reload();
        }).fail(function(jqXHR) {
          // 顯示錯誤資訊
          console.log(jqXHR.statusText);
        });
      } catch(e) {
        // 抓取錯誤訊息
        $('.errorMessage#insert').text(e);
      }
      
    }

    /**
     * 刪除單筆資料
     * 
     * @param {int} id 欲刪除資料之id
     * @param {function} closeModal 關閉 Model 函式
     */
    var deleteOneData = function(id, closeModal) {
      // 發送 AJAX DELETE 請求
      $.ajax({
        method: 'DELETE',
        url: url.ajaxApi + `/${id}`,
        dataType: 'json'
      }).done(function() {
        // 判斷是否刪除成功
        $.rustaMsgBox({
          'content': "資料已刪除",
          'mode': 'success'
        });
        // 關閉 Modal 視窗
        if (typeof(closeModal) == 'function') {
          closeModal();
        }
        // 刷新資料
        reload();
      }).fail(function() {
        // 顯示刪除錯誤訊息
        $.rustaMsgBox({
          'content': "資料刪除失敗",
          'mode': 'error'
        });
      });
    }

    /**
     * 刪除多筆資料
     * 
     * @param {array} id 欲刪除資料之id陣列
     * @param {function} closeModal 關閉 Model 函式
     */
     var deleteData = function(id, closeModal) {
      // 發送 AJAX DELETE 請求
      $.ajax({
        method: 'DELETE',
        url: url.ajaxApi,
        data: {id: id},
        dataType: 'json'
      }).done(function() {
        // 顯示資料刪除成功訊息
        $.rustaMsgBox({
          'content': "資料已刪除",
          'mode': 'success'
        });
        // 關閉 Modal 視窗
        if (typeof(closeModal) == 'function') {
          closeModal();
        }
        // 刷新資料
        reload();
      }).fail(function() {
        // 顯示資料刪除失敗訊息
        $.rustaMsgBox({
          'content': "資料刪除失敗",
          'mode': 'error'
        });
      });
    }

    /**
     * 修改資料
     * 
     * @param {int} id 欲修改資料之id
     * @param {callback} closeModal 關閉 Model 函式
     */
    var UpdateDate = function(id, closeModal) {
      // 將表單序列化
      var formData = $('#modifyForm').serializeArray();

      try {
        // 資料驗證
        dataValidation(formData);

        // ajax發送更新請求
        $.ajax({
          method: 'PUT',
          data: formData,
          url: url.ajaxApi + `/${id}`,
          dataType: 'json'
        }).done(function() {
          // 顯示資料修改成功訊息
          $.rustaMsgBox({
            'content': "資料修改成功",
            'mode': 'success'
          })
          // 關閉Modal視窗
          if (typeof(closeModal) == 'function') {
            closeModal();
          }
          // 刷新資料
          reload();
        }).fail(function() {
          $.rustaMsgBox({
            'content': "資料修改失敗",
            'mode': 'error'
          });
        });
      } catch(e) {
        // 抓取錯誤訊息
        $('.errorMessage#modify').text(e);
      }
    }

    /**
     * 資料驗證
     * 
     * @param {object} data 待驗證資料
     */
     var dataValidation = function(data) {
      // 建立空物件
      var validData = {};

      // 處理序列化資料=>{key: 'value'}
      data.forEach(data => {
        validData[data['name']] = data['value'];
      });
      // 驗證資料格式
      var dataColumn = {
        'account': '',
        'name': '',
        'sex': '',
        'birthday': '',
        'email': '',
        'dept_no': '',
        'comments': ''
      };

      validData = Object.assign(dataColumn, validData);
      
      // 正規表示式
      var accountReg = /^[a-zA-Z\d]\w{3,13}[a-zA-z\d]$/i;
      var nameReg = /.+/;
      var sexReg = /.+/;
      var birthdayReg = /^\d{4}-[01][0-9]-[0-3][0-9]$/;
      var deptNoReg = /.+/;
      var emailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      
      // 檢查是否符合正規表示式
      var accountCheck = accountReg.test(validData['account']);
      var nameCheck = nameReg.test(validData['name']);
      var sexCheck = sexReg.test(validData['sex']);
      var birthdayCheck = birthdayReg.test(validData['birthday']);
      var deptNoCheck = deptNoReg.test(validData['dept_no']);
      var emailCheck = emailReg.test(validData['email']);
      
      // 拋出錯誤信息
      if (!accountCheck) {
        throw '**帳號驗證失敗**';
      } else if (!nameCheck) {
        throw '**姓名驗證失敗**';
      } else if (!sexCheck) {
        throw '**性別驗證失敗**';
      } else if (!birthdayCheck) {
        throw '**日期驗證失敗**';
      } else if (!deptNoCheck) {
        throw '**部門認證失敗**';
      } else if (!emailCheck) {
        throw '**信箱驗證失敗**';
      }
    };

    /**
     * 刷新表格
     */
    var reload = function() {
      // 刪除既有的表格
      $('.dataTables_wrapper').remove();

      // 新增表格位置
      $('<table id="table_account" class="display"></table>').appendTo('.table-location');

      // 載入表格
      loadAllData();
    }

    // 建構
    constructor();
  };
});