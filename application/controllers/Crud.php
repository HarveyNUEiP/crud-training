<?php
defined("BASEPATH") or exit('No direct script access allowed');

class Crud extends CI_Controller
{
    /**
     * index page
     */
    public function index()
    {
        $this->load->view('crud');
    }


    /**
     * AJAX Controller
     */
    public function ajax($id = null)
    {
        // 參數處理
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $data = $this->input->input_stream();

        // 行為分類
        switch ($method) {
            case 'POST':
                // 新增一筆資料
                $this->_create($data);
                break;
            case 'GET':
                if (empty($id)) {
                    // 讀取全部資料
                    $this->_list();
                } else {
                    // 讀取一筆資料
                    $this->_read($id);
                }
                break;
            case 'PATCH':
            case 'PUT':
                // 更新一筆資料
                $this->_update($data, $id);
                break;
            case 'DELETE':
                if (empty($id)) {
                    //錯誤
                    http_response_code(404);
                    echo 'No Delete ID';
                    exit;
                } else {
                    //刪除一筆資料
                    $this->_delete($id);
                }
                break;
        }
    }


    /**
     * 新增一筆
     * 
     * @param $data
     * @return array
     */
    protected function _create($data)
    {
        try {
            // 資料驗證 丟錯誤訊息
            if (false) {
                throw new Exception('帳號驗證失敗', 400);
            };

            // 載入model
            $this->load->model('crud_model');
            $opt = $this->crud_model->post($data);

            // 輸出JSON
            echo json_encode($opt);

        // 接收錯誤訊息
        } catch (Exception $e) {
            http_response_code($e->getCode());
            echo json_encode([
                'message' => $e->getMessage()
            ]);
            exit;
        };
        
    }

    /**
     * 讀取全部
     * 
     * @return array
     */
    protected function _list()
    {
        
        $this->load->model('crud_model');
        $opt = $this->crud_model->get();
        
        // 輸出JSON
        echo json_encode($opt);
    }

    /**
     * 讀取一筆資料
     * 
     * @param int $id 目標資料id
     * @return array
     */

    protected function _read($id)
    {
        $this->load->model('crud_model');
        $opt = $this->crud_model->getBy($id);

        // 輸出JSON
        echo json_encode($opt);
    }

    /**
     * 更新一筆資料 
     * 
     * @param array $data 資料內容
     * @param int $id 目標資料id
     * @return array
     */

    protected function _update($data, $id)
    {
        // print_r($data);
        // exit;
        $this->load->model('crud_model');
        $opt = $this->crud_model->put($id, $data);
        // 輸出JSON
        echo json_encode($opt);
    }

    /**
     * 刪除一筆資料
     *
     * @param int $id 目標資料id
     * @return string
     */
    protected function _delete($id)
    {
        $this->load->model('crud_model');
        $opt = $this->crud_model->delete($id);

        // 輸出JSON
        echo json_encode($opt);
    }
}
