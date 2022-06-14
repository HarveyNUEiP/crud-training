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
                    $this->_list($_GET['limit'], $_GET['offset'], $_GET['keywords'], $_GET['orderBy'], $_GET['descAsc']);
                    // // 判斷是否有限制筆數
                    // if(empty($_GET['limit'])) {
                    //     // 判斷是否有搜尋關鍵字
                    //     if(!empty($_GET['keywords'])) {
                    //         $this->_list('', '', $_GET['keywords']);
                    //     } else {
                    //         $this->_list();
                    //     }
                    // } else {
                    //     if (!empty($_GET['keywords'])) {
                    //         // 讀取全部資料
                    //         $this->_list($_GET['limit'], $_GET['offset'], $_GET['keywords']);
                    //     } else {
                    //         $this->_list($_GET['limit'], $_GET['offset']);  
                    //     }
                    // }
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
        // 建立資料欄位陣列
        $data_column = [
            'account' => '',
            'name' => '',
            'sex' => '',
            'birthday' => '',
            'email' => '',
            'comments' => ''
        ];
        // 確保資料欄位正確
        $data = array_merge($data_column, $data);
        try {
            // 資料驗證
            $data_check = $this->dataValidation($data);

            // 資料驗證，如錯誤丟出錯誤訊息
            if ($data_check == 'account_err') {
                throw new Exception("帳號驗證失敗", 400);
            };
            if ($data_check == 'name_err') {
                throw new Exception("姓名驗證失敗", 400);
            }
            if ($data_check == 'sex_err') {
                throw new Exception("性別驗證失敗", 400);
            }
            if ($data_check == 'birthday_err') {
                throw new Exception("生日驗證失敗", 400);
            }
            if ($data_check == 'email_err') {
                throw new Exception("信箱驗證失敗", 400);
            }

            // 資料驗證成功，將資料新增至資料庫
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
    protected function _list($limit = '', $offset = '', $keywords = '', $order_by = '', $descAsc = '') {

        $this->load->model('crud_model');
        $opt = $this->crud_model->get($limit, $offset, $keywords, $order_by, $descAsc);

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
        // 建立資料欄位陣列
        $data_column = [
            'account' => '',
            'name' => '',
            'sex' => '',
            'birthday' => '',
            'email' => '',
            'comments' => ''
        ];
        // 確保資料欄位正確
        $data = array_merge($data_column, $data);
        try {
            // 驗證資料
            $data_check = $this->dataValidation($data);

            // 資料驗證，如錯誤丟出錯誤訊息
            if ($data_check == 'account_err') {
                throw new Exception("帳號驗證失敗", 400);
            };
            if ($data_check == 'name_err') {
                throw new Exception("姓名驗證失敗", 400);
            }
            if ($data_check == 'sex_err') {
                throw new Exception("性別驗證失敗", 400);
            }
            if ($data_check == 'birthday_err') {
                throw new Exception("生日驗證失敗", 400);
            }
            if ($data_check == 'email_err') {
                throw new Exception("信箱驗證失敗", 400);
            }
            // 資料驗證成功，將資料更新至資料庫
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
        $sex_reg = '/.+/';
        $birthday_reg = '/^\d{4}-[01][0-9]-[0-3][0-9]$/';
        $email_reg = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';

        $account_check = preg_match($account_reg, $data['account']);
        $name_check = preg_match($name_reg, $data['name']);
        $sex_check = preg_match($sex_reg, $data['sex']);
        $birthday_check = preg_match($birthday_reg, $data['birthday']);
        $email_check = preg_match($email_reg, $data['email']);

        if ($account_check == false) {
            return 'account_err';
        } elseif ($name_check == false) {
            return 'name_err';
        } elseif ($sex_check == false) {
            return 'sex_err';
        } elseif ($birthday_check == false) {
            return 'birthday_err';
        } elseif ($email_check == false) {
            return 'email_err';
        }
    }

}
