/**
 * @author Harvey
 */

$(function() {
  // 使用嚴格模式
  'use strict';

  // 載入頁面
  $(document).ready(function() {
    new App();
  });

  var App = function() {
    var self = this;
    
    // 取得主要頁面元件
    var el = '.container';
    var $el = $(el);
    
    var url = {
      ajaxApi : '/first_exam/ajax'
    };

    /**
     * 建構子
     */
    var constructor = function() {
    //初始化
    self.initialize();
    // 事件綁定
    self.events();
    }

    /**
     * 初始化
     */
    self.initialize = function() {
      console.log('_initialize');
      
      getAllData();
    }

    /**
     * 事件綁定
     */
    self.events = function() {
      console.log('_eventsBind')
      
      // 按下新增
      $('.insert-btn').on('click', function() {
        // console.log('新增');return;
        // 顯示新增 Modal 視窗
        BootstrapDialog.show({
          // Modal 標題
          title: "<div class='text-center'><h3><b>新增資料</b></h3></div>",
          // Modal 視窗點擊空白處無法跳出
          closable: false,
          // Modal 視窗內容
          message: $($('#detail-form').html()),
          // Modal 按鈕
          buttons: [{
            // 按鈕名稱
            id: 'btn-confirm',
            // 按鈕圖示
            icon:'glyphicon glyphicon-floppy-save',
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
          }]
        })
      })

      // 按下編輯
      $el.on('click', '.edit-btn', function() {
        // 取得欲修改資料之id
        var keyId = $(this).parents().children('.keyId').text();

        // 顯示編輯 Modal 視窗
        BootstrapDialog.show({
          // Modal 標題
          title: "<div class='text-center'><h3><b>修改資料</b></h3></div>",
          // Model 視窗點空白處無法跳出
          closable: false,
          // Modal 內容
          message: $($('#detail-form').html()),
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

      // 點擊刪除
      $el.on('click', '.delete-btn', function() {
        // 將欲刪除之資料id放入陣列中
        var id = $(this).parents().children('.keyId').text();

        // 跳出刪除Modal
        BootstrapDialog.show({
          // Modal 視窗標題
          title: "<div class='text-center'><h3><b>資料刪除確認</b></h3></div>",
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
        
        console.log(id);
        // 判斷有無勾選資料
        if (id.length == 0) {
          // 顯示錯誤訊息
          $.rustaMsgBox({
            'content': "無勾選資料",
            'mode': 'error'
          });
        } else {
          // 跳出刪除Modal 視窗
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
            }]
          })
        }
      });

      // 點擊匯入
      $('#file-uploader').on('change', function() {
        // 取得上傳檔案
        var file = this.files[0];
        // 創建一FormData
        var formData = new FormData();
        // 將檔案放入FormData
        formData.append('data', file)

        // 將FormData發送至後端
        $.ajax({
          method: 'POST',
          url: '/first_exam/import',
          processData: false,
          contentType: false,
          data: formData
        }).done(function() {
          // 顯示匯入成功訊息
          $.rustaMsgBox({
            'content': "檔案匯入成功",
            'mode': 'info'
          });
          // 刷新資料
          reload();
        }).fail(function() {
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
      $('.export-btn').on('click', function() {
        // 取得匯出Form
        var form = $('.export-form');
        // 將搜尋條件加入Form
        $(`<input type="text" id="export-data" name="keywords" value="${$('input[type="search"]').val()}">`).appendTo(form);
        // 提交Form
        $('.export-form').submit();
        // 移除搜尋條件
        $('#export-data').remove();
      });
    }

    /**
     * 建構DataTable
     * 
     * @param {object} data 欲顯示之所有資料 
     */
    var buildDataTable = function(data) {
      // 建立DataTable
      $('#table_company').DataTable({
        // 表單資料
        "data": data,
        "columns": [{
          // checkBox 欄位
            data: null
          }, {
            data: "id",
            title: "系統編號"
          }, {
            data: "name",
            title: "公司名稱"
          }, {
            data: "founded_date",
            title: "成立日期"
          }, {
            data: "contact",
            title: "聯絡窗口"
          }, {
            data: "email",
            title: "公司信箱"
          }, {
            data: "scale",
            title: "規模"
          }, {
            data: "ndustry_id",
            title: "行業別編號"
          }, {
            // 按鈕欄位
            data: null,
            title: '操作功能',
            render: function (data, type, row) {
                return '<button type="button" class="btn btn-info btn-sm edit-btn">編輯</button>' +
                '<button type="button" class="btn btn-danger btn-sm delete-btn">刪除</button>';
            }
          }
        ],
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
          targets: [8],
          searchable: false,
          orderable: false,
          responsivePriority: 1
        }, {
          // 設定所有欄位 ClassName
          targets: '_all',
          className: 'text-center'
        }],
        // 每頁顯示數量的 Dropdown
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]]
      });
    }

    /**
     * 取得所有資料並建構DataTable
     */
    var getAllData = function(keywords = '') {
      // 發送Ajax GET 請求
      $.ajax({
        method: 'GET',
        url: url.ajaxApi,
        data: keywords,
        dataType: 'json'
      }).done(function(data) {
        // console.log(data);return;
        // 將取得之資料放入DataTable
        buildDataTable(data);
      }).fail(function() {
        // 顯示錯誤資訊
        $.rustaMsgBox({
          'content': "資料載入失敗",
          'mode': 'error'
        });
      });
    }

    /**
     * 取得單筆資料
     * 
     * @param {function} modalBody 關閉 Modal 視窗函式
     * @param {int} id 欲取得之單筆資料id
     */
    var loadData = function(modalBody, id) {
      // 發送Ajax GET 請求
      $.ajax({
        method: 'GET',
        url: url.ajaxApi + `/${id}`,
        dataType: 'json'
      }).done(function(data) {
        // 將原本之資料填入表格中
        $.each(data, function(index, value) {
          if (index == "founded_date") {
            // 日期格式校正
            value = value.replace(' ', 'T')
            // 填入日期
            modalBody.find(`input[name=${index}]`).val(value);
          } if (index == 'scale' | index == 'ndustry_id') {
            // 填入公司類別&行業別編號
            modalBody.find(`select[name=${index}]`).val(value);
          } else {
            // 將其餘資料填入表格中
            modalBody.find(`input[name=${index}]`).val(value);
          }
        })
          
        });
      }

    /**
     * 新增單筆資料
     * 
     * @param {function} closeModal 關閉 Modal 視窗函式
     */
    var insertData = function(closeModal) {
      // 表單資料序列化
      var formData = $('#formModal').serializeArray();
      
      try {
        // 資料驗證
        dataValidation(formData);

        // 發送Ajax POST 請求
        $.ajax({
          method: 'POST',
          url: url.ajaxApi,
          data: formData,
          dataType: 'json'
        }).done(function() {
          // 顯示資料新增成功訊息
          $.rustaMsgBox({
            'content': "資料新增成功",
            'mode': 'success'
          });

          // 關閉 Modal 視窗
          if (typeof(closeModal) == 'function') {
            closeModal();
          }

          // 刷新頁面
          reload();

        }).fail(function() {
          // 顯示資料新增失敗訊息
          $.rustaMsgBox({
            'content': "資料新增失敗",
            'mode': 'error'
          });
        });
      } catch (error) {
        $('.errorMessage').text(error);
      }
    }

    /**
     * 更新單筆資料
     * 
     * @param {int} id 欲更新之資料id
     * @param {function} closeModal 關閉 Modal 視窗函式
     */
    var UpdateDate = function(id, closeModal) {
      // 表單資料序列化
      var formData = $('#formModal').serializeArray();

      try {
        // 資料驗證
        dataValidation(formData);

        // 發送Ajax POST 請求
        $.ajax({
          method: 'PUT',
          url: url.ajaxApi + `/${id}`,
          data: formData,
          dataType: 'json'
        }).done(function() {
          // 顯示資料更新成功訊息
          $.rustaMsgBox({
            'content': "資料更新成功",
            'mode': 'success'
          });

          // 關閉 Modal 視窗
          if (typeof(closeModal) == 'function') {
            closeModal();
          }

          // 刷新頁面
          reload();
        }).fail(function() {
          // 顯示資料更新失敗訊息
          $.rustaMsgBox({
            'content': "資料更新失敗",
            'mode': 'error'
          });
        });
      } catch (error) {
        $('.errorMessage').text(error);
      }
    }

    /**
     * 刪除單筆資料
     * 
     * @param {int} id 欲刪除之資料id
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
     * @param {array} id 
     */
    var deleteData = function(id, closeModal) {
      $.ajax({
        method: 'DELTE',
        url: url.ajaxApi,
        data: {id : id},
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
     * 資料驗證
     */
    var dataValidation = function(data) {
      // 建立空物件
      var validData = {};

      // 公司規模對映表
      var scaleTable = [
        'big',
        'medium',
        'small'
      ]

      // 處理序列化資料
      data.forEach(data => {
        validData[data['name']] = data['value'];
      });

      // 正規表示式
      var nameReg = /.{1,20}/;
      var dateReg = /^\d{4}-[01][0-9]-[0-3][0-9][T ][0-2][0-9]:[0-6][0-9]:[0-6][0-9]$/;
      var contactReg = /.+/;
      var emailReg = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;
      var scaleReg = /.+/;

      // 檢查是否符合驗證格式
      var nameCheck = nameReg.test(validData['name']);
      var dateCheck = dateReg.test(validData['founded_date']);
      var contactCheck = contactReg.test(validData['contact']);
      var emailCheck = emailReg.test(validData['email']);
      var scaleCheck = scaleReg.test(validData['scale']);

      // 資料驗證
      if (!nameCheck) {
        throw '公司名稱驗證失敗';
      } else if (!dateCheck) {
        throw '日期驗證失敗';
      } else if (!contactCheck) {
        throw '聯絡窗口驗證失敗';
      } else if (!emailCheck) {
        throw '信箱驗證失敗';
      } else if (!scaleCheck || !scaleTable.includes(validData['scale'])) {
        throw '公司規模驗證失敗';
      } else if (validData['ndustry_id'] == "0") {
        throw '行業別編號驗證失敗';
      }
    }

    /**
     * 頁面刷新
     */
    var reload = function() {
      // 刪除既有表格
      $('.dataTables_wrapper').remove();
      
      // 新增表格位置
      $('<table id="table_company" class="display"></table>').appendTo('.table-location');

      // 載入資料並建立表格
      getAllData();
    }

    // 建構
    constructor();

  }
})