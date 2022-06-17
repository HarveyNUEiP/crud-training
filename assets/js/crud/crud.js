/**
 * 
 * @author    Harvey
 */

(function(window, document, $, undefined) {
  // 使用嚴格模式
  'use strict';

  $(document).ready(function() {
    window.Page = window.Page || new function() {}();
    window.Page[name] = App();
  });

  var name = '{name}';
  var version = '{version}';
  var defaults = {};

  var App = function(options) {
    return new App.fn.init(options);
  }

  App.fn = App.prototype = {
    // Object Name
    _name: name,

    _defaults: defaults,

    // AJAX URL
    _ajaxUrls: {
      // Account CRUD AJAX server side url.
      accountApi: '/crud/ajax'
    }
  };

  App.fn.init = function(options) {
    var self = this;
    // Application Options initialize
    var _options = options || {};
    var _jqXHRs;

    /**
     * 建構子
     */
    var _construct = function() {
      console.log('_construct');
      _initialize();
    };

    /**
     * 初始化
     */
    var _initialize = function() {
      console.log('_initialize');
      
      loadAllData(10);

    /**
     * 事件綁定
     */
      _evenBind();
    };

    /**
     * 事件綁定
     */
    var _evenBind = function() {
      console.log('_evenBind');

      /**
       * 事件 - 增加
       */

      // 按下確認時，取得account之值
      $('.insert-confirm-btn').on('click', insertData);

      // 按下修改時，取得欲修改資料的原始資料
      $('.container').on('click', '.modifyBtn', function() {
        // 找到該資料的id
        var dataId = $(this).parents('tr').data('id');
        loadData(dataId);
      });

      // 送出更新
      $('.modify-confirm-btn').on('click', function() {
        var id = $(this).data('id');
        updateData(id);
      });

      // 點擊刪除，取得欲刪除資料之id
      $('.container').on('click', '.deleteBtn', function() {

        // 創建一個陣列存放id
        var id = [];

        // 將陣列放至data物件中
        var data = {id};

        // 將欲刪除之id放至data中
        id.push($(this).parents('tr').data('id'));
        $('.deleteConfirm').data('id', data);
      });

      // 點擊批次刪除，取得多個欲刪除資料之id
      $('.deleteDatas').on('click', function() {
        
        // 創建一個陣列存放id
        var id = [];

        // 將陣列放至data物件中
        var data = {id};

        // 取得多個checkbox之id，並加入至陣列中
        $('input[type="checkbox"]').each(function() {
          if($(this).prop("checked") == true) {
            id.push($(this).attr("id"))  
          };
        });

        // 將欲刪除之id放至data中
        $('.deleteConfirm').data('id', data);

      });

      // 確認刪除資料
      $('.deleteConfirm').on('click', function() {

        // 創建data物件
        var data = $('.deleteConfirm').data('id');

        // 刪除資料
        deleteData(data);
      });

      // 選擇每頁顯示筆數
      $('.pageSelector').change(function() {
        // 重置頁數
        $('#current-page').data('page', '1')
        // 刷新每頁顯示筆數
        loadAllData($(this).val(), '', $('.search-text').data('text'));
        
      });

      // 選擇頁數
      $('.container').on('click', '.page-item', function() {
        // 取得觸發頁數
        var triggerPage = $(this).attr('id');
        // 取得當前顯示數量
        var numberDisplay = $('.pageSelector').val()
        // 計算從第幾筆資料開始取
        var offset = numberDisplay * (triggerPage - 1);
        //儲存offset
        $('#current-page').data('offset', offset);
        // 儲存當前頁面
        $('#current-page').data('page', triggerPage);
        // 取得頁面資料
        loadAllData(numberDisplay, offset, $('.search-text').data('text'), $('.ctr-tr').data('sort'), $('.ctr-tr').data('status'));

      });
      
      // 點擊搜尋
      $('.search-btn').on('click', function() {
        // 將搜尋關鍵字存入data-text
        $('.search-text').data('text', $('.search-text').val())
        loadAllData($('.pageSelector').val(),'',$('.search-text').val())
      });

      // 點擊排序
      $('.sort-btn').on('click', function() {
        // 重置頁數
        $('#current-page').data('page', '1')
        // 儲存當前排序方式
        $(this).parents('tr').data('sort', $(this).data('sort'));
        // 判斷當前升冪(0)降冪(1)狀態，若無狀態設為0
        if ($(this).data('status') == 0) {
          // 儲存當前排序狀態
          $(this).parents('tr').data('status', 'DESC');
          $(this).data('status', 1);
          loadAllData($('.pageSelector').val(), '', $('.search-text').val(), $(this).data('sort'), 'DESC');
        } else if ($(this).data('status') == 1) {
          // 儲存當前排序狀態
          $(this).parents('tr').data('status', 'ASC');
          $(this).data('status', 0);
          loadAllData($('.pageSelector').val(), '', $('.search-text').val(), $(this).data('sort'), 'ASC');
        } else if (!$(this).data('status')) {
          // 儲存當前排序狀態
          $(this).parents('tr').data('status', 'ASC');
          $(this).data('status', 0);
          loadAllData($('.pageSelector').val(), '', $('.search-text').val(), $(this).data('sort'), 'ASC');
        }
        
      });

      // 點擊匯出
      $('#export').on('click', function() {
        var form = $('.export-form');
        $(`<input type="text" id="export-data" name="keywords" value="${$('.search-text').val()}">`).appendTo(form);
        $('.export-form').submit();
        $('#export-data').remove();
      });

      // 檔案匯入
      $('#file-uploader').on('change', function() {
        var file = this.files[0];
        var form = new FormData();
        form.append('data', file)

        $.ajax({
          method: 'POST',
          url: '/crud/import',
          processData: false,
          contentType: false,
          data: form
        }).done(function() {
          $.rustaMsgBox({
            'content': "檔案匯入成功",
            'mode': 'info'
          }); 
          loadAllData($('.pageSelector').val());
        }).fail(function(jqXHR) {
          console.log(jqXHR.statusText);
          alert('檔案匯入失敗');
        });

        // 清除上傳檔案
        $('#file-uploader').val('');
      });
    };

    /**
     * 載入全部資料
     */
    var loadAllData = function(limit = '', offset = '', keywords = '', orderBy = '', descAsc = '') {
      $.ajax({
        method: 'GET',
        url: self._ajaxUrls.accountApi,
        data:{
          "limit": limit,
          "offset": offset,
          "keywords": keywords,
          "orderBy": orderBy,
          "descAsc": descAsc
        },
        dataType: 'json'
      }).done(function(data) {
          /**
           * 清除tbody及分頁
           */
          // 清除tbody資料
          $('#tableBody').remove();
          // 清除分頁
          $('.pagination').remove();
            
          /**
           * 建立表格
           */
          // 建立變數
          var tmp, table, tbody, tr, td;
          // 建立暫存容器
          tmp = $('<div></div>');
          // 建立tbody區塊資料
          tbody = $('<tbody id="tableBody"></tbody>').appendTo(tmp);
          
          /**
           * 建立內容
           */
          $.each(data.data, function(index1, value1) {
            tr = $('<tr></tr>').appendTo(tbody);
            tr.data('id', value1['id']);
            td = $(`<td><input type="checkbox" id="${value1['id']}"><button class="btn modifyBtn" data-toggle="modal" data-target="#modifyModal"><i class="fas fa-pen color_green ml-3"></i></button><button class="btn deleteBtn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash text-danger ml-3"></i></button></td>`).appendTo(tr)
            $.each(value1, function(index2, value2) {
              td = $('<td>'+value2+'</td>').appendTo(tr);
            });
          });
        
          // 取得table元件
          table = $('.ctrl-table');
          // 將暫存內容移至table元件
          tmp.children().appendTo(table);

          /**
           * 建立分頁
           */
          // 取得資料總數
          var numberOfDatas = data.numbers;
          // 取得單頁資料顯示數量
          var numberDisplay = $(".pageSelector").val()
          // 計算所需頁數
          var pages = Math.ceil(numberOfDatas/numberDisplay)
          //建立變數
          var tmp, row, ul, li;
          // 建立暫存容器
          tmp = $('<div></div>');
          // 建立ul區塊
          ul = $('<ul class="pagination"></ul>').appendTo(tmp);
          for (var i = 1; i < pages + 1; i++) {
            if (i == $('#current-page').data('page')) {
              li = $(`<li class="active" id="${i}"><a class="page-link" href="#">${i}</a></li>`).appendTo(ul);
            } else {
            li = $(`<li class="page-item" id="${i}"><a class="page-link" href="#">${i}</a></li>`).appendTo(ul);
            }
          }
          row = $('.page');
          // 將暫存內容移至pagination元件
          tmp.children().appendTo(row);
      });
    };

    /**
     * 新增資料
     */
    var insertData = function() {
      // 抓取表單
      var $form = $('.modal-body.insert').find('form')

      // 將表單序列化
      var insData = $($form).serializeArray();

      try {
        // 資料驗證
        // dataValidation(insData);
        
        // ajax發送新增資料請求
        $.ajax({
          method: 'POST',
          url: self._ajaxUrls.accountApi,
          data: insData,
          dataType: 'json'
        }).done(function(data) {
            // 通知新增成功
            alert("資料新增成功！");
            //關閉modal彈窗
            $('#insertModal').modal('hide');
            // 刷新資料
            loadAllData($('.pageSelector').val());
            // 清空表格欄位
            $('#modifyForm, #insertForm').find('input, textarea').not('input[type=radio]').val('');
            $('#modifyForm, #insertForm').find('input').prop('checked', false);
            $('#modifyForm, #insertForm').find('.errorMessage#insert').text('');
            // 清除分頁
            $('.pagination').remove();
        }).fail(function(jqXHR) {
          console.log(jqXHR.statusText);
        });
      } catch(e) {
        $('.errorMessage#insert').text(e);
      }
    };

    /**
     * 載入原資料
     */
     var loadData = function(id) {
      $.ajax({
        method: 'GET',
        url: self._ajaxUrls.accountApi + `/${id}`,
        dataType: 'json'
      }).done(function(data) {
        //清空表格欄位
        $('#modifyForm, #insertForm').find('input, textarea').not('input[type=radio]').val('');
        $('#modifyForm, #insertForm').find('input').prop('checked', false);
        
        // 填入原資料至表格中
        $('.modify-confirm-btn').data('id', `${data['id']}`);
        $('#accountInput1').val(`${data['account']}`);
        $('#nameInput1').val(`${data['name']}`);
        $(`input[name="sex"][value=${data['sex']}]`).prop("checked", true);
        $('#birthdayInput1').val(`${data['birthday']}`);
        $('#emailInput1').val(`${data['email']}`);
        $('#commentsInput1').val(`${data['comments']}`);

      })
    };

    /**
     * 更新資料
     */
    var updateData = function(id) {
      // 抓取表單
      var $form = $('.modal-body.modify').find('form')
    
      // 將表單序列化
      var newData = $($form).serializeArray();

      try {
        // 資料驗證
        dataValidation(newData);

        // ajax發送更新請求
        $.ajax({
          method: 'PUT',
          data: newData,
          url: self._ajaxUrls.accountApi + `/${id}`,
          dataType: 'json'
        }).done(function(data) {
            // 判斷是否新增成功
            if(data != 0) {
              alert("資料更新成功！");
              // 關閉modal彈窗
              $('#modifyModal').modal('hide');
              // 清除錯誤信息欄位
              $('#modifyForm, #insertForm').find('.errorMessage#modify').text('');
              // 刷新資料
              loadAllData($('.pageSelector').val(), $('#current-page').data('offset'));
            };
        });
      } catch(e) {
        $('.errorMessage#modify').text(e);
      }
    };

    /**
     * 刪除資料
     */
    var deleteData = function(data) {
      $.ajax({
        method: 'DELETE',
        url: self._ajaxUrls.accountApi,
        data: data,
        dataType: 'json'
      }).done(function(data) {
        // 判斷是否刪除成功
        if(data != 0) {
          alert("資料已刪除！");
          //關閉modal彈窗
          $('#deleteModal').modal('hide');
          // 清除tbody資料
          $('#tableBody').remove();
          // 清除分頁
          $('.pagination').remove();
          // 刷新資料
          loadAllData(10);
        };
      }).fail(function() {
        
      });
    };

    /**
     * 資料驗證
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
        'comments': ''
      };

      validData = Object.assign(dataColumn, validData);
      

      var accountReg = /^[a-zA-Z\d]\w{3,13}[a-zA-z\d]$/i;
      var nameReg = /.+/;
      var sexReg = /.+/;
      var birthdayReg = /^\d{4}-[01][0-9]-[0-3][0-9]$/;
      var emailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      
      var accountCheck = accountReg.test(validData['account']);
      var nameCheck = nameReg.test(validData['name']);
      var sexCheck = sexReg.test(validData['sex']);
      var birthdayCheck = birthdayReg.test(validData['birthday']);
      var emailCheck = emailReg.test(validData['email']);
      
      if(!accountCheck) {
        throw '**帳號驗證失敗**';
      } else if(!nameCheck) {
        throw '**姓名驗證失敗**';
      } else if(!sexCheck) {
        throw '**性別驗證失敗**';
      } else if(!birthdayCheck) {
        throw '**日期驗證失敗**';
      } else if(!emailCheck) {
        throw '**信箱驗證失敗**';
      }
    };

    /**
     * *************Run Constructor*************
     */
    _construct(); 
  };

  // Give the init functionthe Object prototype for later instantiation
  App.fn.init.prototype = App.prototype;
  
  // Alias prototype function
  $.extend(App, App.fn);
})(window, document, $);  