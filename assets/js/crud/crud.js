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

      // 按下確認按鈕時 取得account之值
      $('.insert-confirm-btn').on('click', insertData);
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
          console.log(data);
          // 建立變數
          var tmp, table, tbody, tr, td;
          // 建立暫存容器
          tmp = $('<div></div>');
          // 建立tbody區塊資料
          tbody = $('<tbody></tbody>').appendTo(tmp);
          
          // 建立內容
          $.each(data, function(index1, value1) {
            tr = $('<tr></tr>').appendTo(tbody);
            tr.data('id', value1['id']);
            td = $('<td><button class="btn" data-toggle="modal" data-target="#modifyModal"><i class="fas fa-pen color_green ml-3"></i></button><button class="btn" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash text-danger ml-3"></i></button></td>').appendTo(tr)
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
      // 抓取帳號
      var accountInput = $('#accountInput').val();
      // 抓取姓名
      var nameInput = $('#nameInput').val();
      // 抓取性別
      var sexInput = $('input[name=sex]:checked').val();
      // 抓取生日
      var birthdayInput = $('#birthdayInput').val();
      // 抓取信箱
      var emailInput = $('#emailInput').val();
      // 抓取備註
      var commentsInput = $('#commentsInput').val();
      // 定義輸出JSON檔
      var insData = {
        'account': accountInput,
        'name': nameInput,
        'sex': sexInput,
        'birthday': birthdayInput,
        'email': emailInput,
        'comments': commentsInput
      };

      // var $form = $('.modal-body .insert').find('form')
      
      // var insData = $($form).serializeArray();
      // console.log(insData);
      // return;
      
      $.ajax({
        method: 'POST',
        url: self._ajaxUrls.accountApi,
        data: insData,
        dataType: 'json'
      }).done(function(data) {
        // 處理回傳資料
        console.log(data)

        // 判斷是否新增成功
        if(data != 0) {
          alert("資料新增成功！");
          $('#insertModal').modal('hide');
        };
      }).fail(function (jqXHR) {
        console.log(jqXHR);
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