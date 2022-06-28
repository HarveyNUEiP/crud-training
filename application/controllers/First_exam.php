<?php

use app\libraries\services\CompanyConfig;

defined("BASEPATH") or exit('No direct script access allowed');

class First_exam extends CI_Controller
{
    /**
     * index page
     */
    public function index()
    {
        $this->load->view('firstExam');
    }

    /**
     * AJAX Controller
     */
    public function ajax($id = null)
    {
        // 參數處理
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $data = $this->input->input_stream();
        $data_params = $this->input->get();

        //行為分類
        switch($method) {
            case 'GET':
                // 判斷有無$id
                if(empty($id)) {
                    // 取得所有資料
                    $this->_list($data_params);
                } else {
                    // 取得單筆資料
                    $this->_get($id);
                }
                break;
            case 'POST':
                // 新增一筆資料
                $this->_create($data);
                break;
            case 'PUT':
                // 更新資料
                $this->_update($id, $data);
                break;
            case 'DELETE':
                // 刪除資料
                if (!empty($id)) {
                    // 刪除單筆
                    $this->_delete($id);
                } else {
                    // 刪除多筆
                    $this->_deleteDatas($data);
                }
                break;
        }
    }

    /**
     * 取得所有資料
     * 
     * @return void
     */
    public function _list($data_params)
    {
        // 載入 Model
        $this->load->model('first_exam_model');

        /**
         * 參數取得
         */
        // 取得過濾前資料總筆數
        $recordsTotal = $this->first_exam_model->getTotalNumbers();
        // 取得過濾後資料總筆數
        $recordsFiltered = $this->first_exam_model->getTotalNumbers($data_params['search']['value']);
        // 取得資料顯示限制筆數
        $length = (int)$data_params['length'];
        // 取得資料顯示起始
        $offset = $data_params['start'];
        // 取得搜尋關鍵字
        $keywords = $data_params['search']['value'];
        // 取得排序依據
        $order_map = [
            "0" => "id",
            "1" => "name",
            "2" => "founded_date",
            "3" => "contact",
            "4" => "email",
            "5" => "scale",
            "6" => "ndustry_id"
        ];
        $order_by = $order_map[$data_params['order'][0]['column']];
        // 取得生冪/降冪
        $desc_asc = $data_params['order'][0]['dir'];

        /**
         * 參數陣列
         */
        $search_params = [
            'limit' => $length,
            'offset' => $offset,
            'keywords' => $keywords,
            'order_by' => $order_by,
            'desc_asc' => $desc_asc
        ];

        // 取得資料
        $res = $this->first_exam_model->list($search_params);

        /**
         * 行業別編號轉換行業類型名稱
         */
        // 取得行業別編號
        $ndustry_id = array_column($res, 'ndustry_id', 'ndustry_id');
        // 判斷有無資料，若無資料則跳過此步驟
        if (!empty($ndustry_id)) {
            // 取得行業類型名稱
            $ndustry_name = $this->first_exam_model->getNdustryName($ndustry_id);
            // 行業編號、類型對映表
            $ndustry_map = array_column($ndustry_name, 'name', 'id');
        }

        /**
         * 公司規模中英轉換
         */
        // 規模中英對映表
        $scale_map = [
            'big' => '大',
            'medium' => '中',
            'small' => '小'
        ];

        // 創建輸出陣列
        $opt = [];
        // 編號轉換類別名稱，公司規格英轉中。
        foreach ($res as $data) {
            $data['ndustry_name'] = $ndustry_map[$data['ndustry_id']];
            $data['scale'] = $scale_map[$data['scale']];
            array_push($opt, $data);
        }

        $tableOpt = [
            "draw"=> $data_params['draw'],
            "recordsTotal"=> $recordsTotal,
            "recordsFiltered"=> $recordsFiltered,
            "data" => $opt,
        ];

        // 回傳結果至前端
        echo json_encode($tableOpt);
    }

    /**
     * 取得單筆資料
     *  
     * @param int $id 欲取得之資料id
     * @return void
     */
    public function _get($id)
    {
        // 載入 Model
        $this->load->model('first_exam_model');
        // 執行查詢
        $opt = $this->first_exam_model->getBy($id);
        // 回傳結果至前端
        echo json_encode($opt);
    }

    /**
     * 新增單筆資料
     *
     * @param array $data 資料內容
     * @return void
     */
    public function _create($data)
    {
        // 載入 Model
        $this->load->model('first_exam_model');

        try {
            // 資料驗證
            $this->dataValidation($data);

            // 資料新增至資料庫
            $opt = $this->first_exam_model->create($data);
            // 回傳結果
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
     * 修改單筆資料
     */
    public function _update($id, $data)
    {
        // 載入 Model
        $this->load->model('first_exam_model');
        try {
            // 驗證資料
            $this->dataValidation($data);

            // 資料更新至資料庫
            $res = $this->first_exam_model->update($id, $data);
            // 回傳結果
            echo json_encode($res);

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
     * 刪除資料
     * 
     * @param int $id 欲刪除之資料id
     */
    public function _delete($id)
    {
        // 載入 Model
        $this->load->model('first_exam_model');
        // 執行軟刪除
        $res = $this->first_exam_model->softDelete($id);
        // 回傳結果
        echo json_encode($res);
    }

    /**
     * 刪除多筆資料
     *
     * @param array $data
     * @return void
     */
    public function _deleteDatas($data)
    {
        // 載入 Model
        $this->load->model('first_exam_model');
        // 執行軟刪除
        $res = $this->first_exam_model->softDeleteDatas($data);
        // 回傳結果
        echo json_encode($res);
    }

    /**
     * 資料驗證
     *
     * @param array $data 待驗證資料
     * @return void
     */
    public function dataValidation($data)
    {

        // 正規表示式
        $name_reg = '/.{1,20}/';
        $date_reg = '/^\d{4}-[01][0-9]-[0-3][0-9][T ][0-2][0-9]:[0-6][0-9]:[0-6][0-9]$/';
        $contact_reg = '/.+/';
        $email_reg = '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/';
        $scale_reg = '/.+/';

        // 驗證資料
        if (!preg_match($name_reg, $data['name'])) {
            throw new Exception("公司名稱驗證失敗", 400);
        } elseif (!preg_match($date_reg, $data['founded_date'])) {
            throw new Exception("日期驗證失敗", 400);
        } elseif (!preg_match($contact_reg, $data['contact'])) {
            throw new Exception("聯絡窗口驗證失敗", 400);
        } elseif (!preg_match($email_reg, $data['email'])) {
            throw new Exception("信箱驗證失敗", 400);
        } elseif (!preg_match($scale_reg, $data['scale'])) {
            throw new Exception("公司規模驗證失敗", 400);
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
        $search_params = $this->input->post();
        // 載入model
        $this->load->model('first_exam_model');
        // 取得資料
        $data = $this->first_exam_model->list($search_params);
        // IO物件建構
        $io = new \marshung\io\IO();
        // config物件建構
        $company = new CompanyConfig;
        // 匯出處理 - 建構匯出資料
        $io->export($data, $config = $company, $builder = 'Excel', $style = 'Io');
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
        $id_arr = $id_exist = $update_data = $insert_data = $error_message = [];

        try {
            foreach ($data as $valid_data) {
                try {
                    // 資料驗證
                    $this->dataValidation($valid_data);
                    // 取得匯入資料之帳號名稱
                    $id_arr[] = $valid_data['id'];
                } catch (Exception $e) {
                    // 將資料驗證失敗的資訊存入陣列中
                    $error_message[$valid_data['id']] = [
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
            $this->load->model('first_exam_model');
            // 取得已存在之帳號
            $id_exist = $this->first_exam_model->getBy($id_arr, 'id');
            print_r($id_exist);
            // 已存在帳號陣列處理
            $id_exist = array_column($id_exist, 'id');

            // 差異處理
            foreach ($data as $valid_data) {
                if (in_array($valid_data['id'], $id_exist)) {
                    $update_data[] = $valid_data;
                } else {
                    $insert_data[] = $valid_data;
                }
            }
            // print_r($update_data);
            // 如新增的陣列不為空則批次新增
            $insert_data && $this->first_exam_model->batchAdd($insert_data);
            // 如修改的陣列不為空則批次修改
            $update_data && $this->first_exam_model->batchUpdate($update_data);
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