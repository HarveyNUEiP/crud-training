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
                $this->_update($id, $data);
                break;
            case 'DELETE':

                if (empty($data['id'])) {
                    //錯誤
                    http_response_code(404);
                    echo 'No Delete ID';
                    exit;
                } else {
                    //刪除一筆資料
                    $this->_delete($data['id']);
                }
                break;
        }
    }


    /**
     * 新增一筆
     * 
     * @param array $data
     * @return array
     */
    protected function _create($data)
    {
        try {
            // 資料驗證
            $data_check = $this->dataValidation($data);

            // 如驗證失敗：丟錯誤訊息
            if (!$data_check) {
                throw new Exception('資料驗證失敗', 400);
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
    protected function _update($id, $data)
    {
        try {
            // 驗證資料
            $data_check = $this->dataValidation($data);

            // 如驗證失敗，丟錯誤訊息
            if (!$data_check) {
                throw new Exception("資料驗證失敗", 400);
            };
            // 
            $this->load->model('crud_model');
            $opt = $this->crud_model->put($id, $data);
            // 輸出JSON
            echo json_encode($opt);
        } catch (Exception $e) {
            http_response_code($e->getCode());
            echo json_encode([
                'message' => $e->getMessage()
            ]);
            exit;
        }
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

    /**
     * 資料驗證
     *
     * @param array $data
     * @return boolean
     */
    public function dataValidation($data)
    {

        $account_reg = '/^[a-zA-Z\d]\w{3,13}[a-zA-z\d]$/i';
        $name_reg = '/.+/';
        $birthday_reg = '/^\d{4}-[01][0-9]-[0-3][0-9]$/';
        $email_reg = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';

        $account_check = preg_match($account_reg, $data['account']);
        $name_check = preg_match($name_reg, $data['name']);
        $sex_check = function ($data) {
            if (count($data) == 6) {
                return true;
            } else {
                return false;
            };
        };
        $birthday_check = preg_match($birthday_reg, $data['birthday']);
        $email_check = preg_match($email_reg, $data['email']);

        if ($account_check && $name_check && $sex_check && $birthday_check && $email_check) {
            return true;
        } else {
            return false;
        };
    }
}
