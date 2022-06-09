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
      
      loadAllData();
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

      // 按下確認按鈕時，取得account之值
      $('.insert-confirm-btn').on('click', insertData);

      // 按下修改按鈕時，取得欲修改資料的原始資料
      $('.container').on('click', '.modifyBtn', function () {
        // 找到該資料的id
        var dataId = $(this).parents('tr').data('id');
        loadData(dataId);
      });

      // 送出更新
      $('.modify-confirm-btn').on('click', function () {
        var id = $(this).data('id');
        updateData(id);
      });

      // 點擊刪除按鈕，取得欲刪除資料之id
      $('.container').on('click', '.deleteBtn', function () {
        $('.deleteConfirm').data('id', $(this).parents('tr').data('id'));
      });

      //確認刪除資料
      $('.deleteConfirm').on('click', function () {
        var id = $('.deleteConfirm').data('id');
        deleteData(id);
      });
      
    };

    /**
     * 載入全部資料
     */
    var loadAllData = function () {
      $.ajax({
        method: 'GET',
        url: self._ajaxUrls.accountApi,
        dataType: 'json'
      }).done(function(data) {
          // console.log(data);
          // 建立變數
          var tmp, table, tbody, tr, td;
          // 建立暫存容器
          tmp = $('<div></div>');
          // 建立tbody區塊資料
          tbody = $('<tbody id="tableBody"></tbody>').appendTo(tmp);
          
          // 建立內容
          $.each(data, function(index1, value1) {
            tr = $('<tr></tr>').appendTo(tbody);
            tr.data('id', value1['id']);
            td = $('<td><button class="btn modifyBtn" data-toggle="modal" data-target="#modifyModal"><i class="fas fa-pen color_green ml-3"></i></button><button class="btn deleteBtn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash text-danger ml-3"></i></button></td>').appendTo(tr)
            // var accountTd = 
            // $('<td>'+value1['account']+'</td>').appendTo(tr);
            $.each(value1, function(index2, value2) {
              td = $('<td>'+value2+'</td>').appendTo(tr);
            });
          });
        
          // 取得table元件
          table = $('.ctrl-table');
          // 將暫存內容移至table元件
          tmp.children().appendTo(table);
        });
    };
    
    /**
     * 新增資料
     */
    var insertData = function () {
      // 抓取表單
      var $form = $('.modal-body.insert').find('form')
      
      // 將表單序列化
      var insData = $($form).serializeArray();
      
      // ajax發送新增資料請求
      $.ajax({
        method: 'POST',
        url: self._ajaxUrls.accountApi,
        data: insData,
        dataType: 'json'
      }).done(function(data) {

        // 判斷是否新增成功
        if(data != 0) {
          alert("資料新增成功！");
          //關閉modal彈窗
          $('#insertModal').modal('hide');
          // 清除tbody資料
          $('#tableBody').remove();
          // 刷新資料
          loadAllData();
        };
      }).fail(function (jqXHR) {
        console.log(jqXHR.statusText);
      });
    };

    /**
     * 載入原資料
     */
     var loadData = function (id) {
      $.ajax({
        method: 'GET',
        url: self._ajaxUrls.accountApi + `/${id}`,
        dataType: 'json'
      }).done(function (data) {
        //清除表格
        $('#modifyForm', 'insertForm').children('input,textarea').val("");
        $("input").prop('checked', false);

        // 填入原資料至表格中
        $('.modify-confirm-btn').data('id', `${data[0]['id']}`);
        $('#accountInput1').val(`${data[0]['account']}`);
        $('#nameInput1').val(`${data[0]['name']}`);
        $(`input[name="sex"][value=${data[0]['sex']}]`).prop("checked", true);
        $('#birthdayInput1').val(`${data[0]['birthday']}`);
        $('#emailInput1').val(`${data[0]['email']}`);
        $('#commentsInput1').val(`${data[0]['comments']}`);

      })
    };

    /**
     * 更新資料
     */
    var updateData = function (id) {
      // 抓取表單
      var $form = $('.modal-body.modify').find('form')
    
      // 將表單序列化
      var newData = $($form).serializeArray();
      
      // ajax發送更新請求
      $.ajax({
        method: 'PUT',
        data: newData,
        url: self._ajaxUrls.accountApi + `/${id}`,
        dataType: 'json'
      }).done(function (data) {
          // 判斷是否新增成功
          if(data != 0) {
            alert("資料更新成功！");
            //關閉modal彈窗
            $('#modifyModal').modal('hide');
            // 清除tbody資料
            $('#tableBody').remove();
            // 刷新資料
            loadAllData();
          };
      });
       
    };

    /**
     * 刪除資料
     */
    var deleteData = function (id) {
      $.ajax({
        method: 'DELETE',
        url: self._ajaxUrls.accountApi + `/${id}`,
        dataType: 'json'
      }).done(function (data) {
        // 判斷是否刪除成功
        if(data != 0) {
          alert("資料已刪除！");
          //關閉modal彈窗
          $('#deleteModal').modal('hide');
          // 清除tbody資料
          $('#tableBody').remove();
          // 刷新資料
          loadAllData();
        };
      });
    };

    /**
     * *************Run Constructor*************
     */
    _construct(); 
  };

  // Give the init function the Object prototype for later instantiation
  App.fn.init.prototype = App.prototype;
  
  // Alias prototype function
  $.extend(App, App.fn);
})(window, document, $);  