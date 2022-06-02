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
      
      $.ajax({
        method: 'GET',
        url: self._ajaxUrls.accountApi,
        dataType: 'json'
      }).done(function(data) {
          console.log(data.data);
          // 建立變數
          var tmp, table, tbody, tr, td;
          // 建立暫存容器
          tmp = $('<div></div>');
          // 建立tbody區塊資料
          tbody = $('<tbody></tbody>').appendTo(tmp);
          
          // 建立內容
          $.each(data.data, function(index1, value1) {
            tr = $('<tr></tr>').appendTo(tbody);
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
    /**
     * 事件綁定
     */
    
    };

    /**
     * 載入資料
     */
    var loadData = function () {
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