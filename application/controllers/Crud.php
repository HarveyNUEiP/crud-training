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
        $get_params = $this->input->get();

        // 行為分類
        switch ($method) {
            case 'POST':
                // 新增一筆資料
                $this->_create($data);
                break;
            case 'GET':
                if (empty($id)) {
                    $this->_list($get_params);
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
                if (empty($id) && !empty($data['id'])) {
                    // 批次刪除
                    $this->_delete($data['id']);
                } else if (!empty($id) && empty($data['id'])) {
                    // 單筆刪除
                    $this->_delete($id);
                } else {
                    http_response_code(404);
                    echo ('No Delete Id');
                }
                break;
        }
    }

    /**
     * 新增一筆
     * 
     * @param array $data
     * @return void
     */
    protected function _create($data)
    {
        // 載入model
        $this->load->model('crud_model');

        try {
            // 資料驗證，如錯誤丟出錯誤訊息
            $this->dataValidation($data);

            // 資料驗證成功，將資料新增至資料庫
            $opt = $this->crud_model->post($data);

            // 輸出JSON
            echo json_encode($opt);
        } catch (Exception $e) {
            // 印出錯誤代碼
            http_response_code($e->getCode());
            // 印出錯誤信息
            echo json_encode([
                'message' => $e->getMessage()
            ]);
            exit;
        };
    }

    /**
     * 讀取全部
     * @param array $arr_param
     * @return void
     */
    protected function _list($arr_params)
    {
        // 載入model
        $this->load->model('crud_model');

        // 取得資料
        $res = $this->crud_model->get($arr_params);

        // 取得資料筆數
        if (!empty($get_params['keywords'])) {
            $num = $this->crud_model->getNumbers($arr_params['keywords'] ?? '');
        } else {
            $num = $this->crud_model->getNumbers();
        }

        /**
         * 部門編號轉換部門名稱
         */
        // 取得資料之部門編號
        $dept_no = array_column($res, 'dept_no', 'dept_no');
        // 取得資料之部門名稱
        $d_name = $this->crud_model->getDeptName($dept_no);
        // 部門編號與部門名稱之對映表
        $dept_map = array_column($d_name, 'd_name', 'd_id');
        // 將部門編號轉為名稱
        foreach ($res as &$data) {
            $data['dept_name'] = $dept_map[$data['dept_no']];
        }

        // 建立輸出陣列
        $opt = [
            'numbers' => $num,
            'data' => $res
        ];

        // 資料轉換JSON並回傳資料
        echo json_encode($opt);
    }

    /**
     * 讀取單筆資料
     * 
     * @param int $id 目標資料id
     * @return void
     */
    protected function _read($id)
    {
        // 載入 model
        $this->load->model('crud_model');

        // 取得單筆資料
        $opt = $this->crud_model->getBy($id);

        // 輸出JSON
        echo json_encode($opt);
    }

    /**
     * 更新一筆資料 
     * 
     * @param array $data 資料內容
     * @param int $id 目標資料id
     * @return void
     */
    protected function _update($id, $data)
    {
        // 載入model
        $this->load->model('crud_model');

        try {
            // 驗證資料，如錯誤丟出錯誤訊息
            $this->dataValidation($data);

            // 資料驗證成功，將資料更新至資料庫
            $opt = $this->crud_model->put($id, $data);

            // 輸出JSON
            echo json_encode($opt);
        } catch (Exception $e) {

            // 印出錯誤代碼
            http_response_code($e->getCode());

            // 印出錯誤信息
            echo json_encode([
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * 刪除單筆/多筆資料
     *
     * @param int $id 目標資料id
     * @return void
     */
    protected function _delete($id)
    {
        // 載入 Model
        $this->load->model('crud_model');

        // 刪除單筆資料
        $opt = $this->crud_model->delete($id);

        // 輸出JSON
        echo json_encode($opt);
    }

    /**
     * 資料驗證
     *
     * @param array $data
     * @return void
     */
    public function dataValidation($data)
    {
        // 建立資料欄位陣列
        $data_column = [
            'account' => '',
            'name' => '',
            'sex' => '',
            'birthday' => '',
            'email' => '',
            'dept_no' => '',
            'comments' => ''
        ];
        // 確保資料欄位正確
        $data = array_merge($data_column, $data);

        // 正規表示式
        $account_reg = '/^[a-zA-Z\d]\w{3,13}[a-zA-z\d]$/i';
        $name_reg = '/.+/';
        $sex_reg = '/.+/';
        $birthday_reg = '/^\d{4}-[01][0-9]-[0-3][0-9]$/';
        $dept_no_reg = '/.+/';
        $email_reg = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        // 驗證資料
        if (!preg_match($account_reg, $data['account'])) {
            throw new Exception("帳號驗證失敗", 400);
        } elseif (!preg_match($name_reg, $data['name'])) {
            throw new Exception("姓名驗證失敗", 400);
        } elseif (!preg_match($sex_reg, $data['sex'])) {
            throw new Exception("性別驗證失敗", 400);
        } elseif (!preg_match($birthday_reg, $data['birthday'])) {
            throw new Exception("生日驗證失敗", 400);
        } elseif (!preg_match($dept_no_reg, $data['dept_no'])) {
            throw new Exception("部門驗證失敗", 400);
        } elseif (!preg_match($email_reg, $data['email'])) {
            throw new Exception("信箱驗證失敗", 400);
        }
    }

    /**
     * 資料匯出
     *
     * @return void
     */
    public function export()
    {
        // 獲取資料查詢條件
        $params = $this->input->post();
        // 載入model
        $this->load->model('crud_model');
        // 取得資料
        $data = $this->crud_model->get($params);

        // IO物件建構
        $io = new \marshung\io\IO();
        // 匯出處理 - 建構匯出資料
        $io->export($data, $config = 'SimpleExample', $builder = 'Excel', $style = 'Io');
    }

    /**
     * 資料匯入
     *
     * @return void
     */
    public function import()
    {
        /**
         * 獲取data
         */
        // IO物件建構
        $io = new \marshung\io\IO();
        // 匯入處理 - 取得匯入資料
        $data = $io->import($builder = 'Excel', $fileArgu = 'data');
        // 取得匯入config名子
        $configName = $io->getConfig()->getOption('configName');
        // 取得有異常有下拉選單內容
        $mismatch = $io->getMismatch();

        /**
         * 資料驗證及差異處理
         */
        // 建立空陣列
        $acc_arr = $arr_exist = $update_data = $insert_data = $error_message = [];

        try {
            foreach ($data as $valid_data) {
                try {
                    // 資料驗證
                    $this->dataValidation($valid_data);
                    // 取得匯入資料之帳號名稱
                    $acc_arr[] = $valid_data['account'];
                } catch (Exception $e) {
                    // 將資料驗證失敗的資訊存入陣列中
                    $error_message[$valid_data['account']] = [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ];
                }
            }
            // 判斷是否有Error訊息，如果有則丟出Exception
            if (!empty($error_message)) {
                throw new Exception(serialize($error_message));
            }

            // 載入model
            $this->load->model('crud_model');
            // 取得已存在之帳號
            $arr_exist = $this->crud_model->getAcc($acc_arr, 'account');
            // 已存在帳號陣列處理
            $arr_exist = array_column($arr_exist, 'account');

            // 差異處理
            foreach ($data as $valid_data) {
                if (in_array($valid_data['account'], $arr_exist)) {
                    $update_data[] = $valid_data;
                } else {
                    $insert_data[] = $valid_data;
                }
            }

            // 如新增的陣列不為空則批次新增
            $insert_data && $this->crud_model->batchAdd($insert_data);
            // 如修改的陣列不為空則批次修改
            $update_data && $this->crud_model->batchUpdate($update_data);
        } catch (Exception $e) {
            // 抓取錯誤訊息
            http_response_code('400');
            echo json_encode([
                'errorData' => $error_message
            ]);
            exit;
        };
    }
}
