<?php

use JetBrains\PhpStorm\ArrayShape;

defined("BASEPATH") or exit('No direct script access allowed');

class First_exam_model extends CI_Model
{
    // 資料表名稱 (公司資訊)
    protected $company_table = 'company_info';

    // 資料表名稱 (行業別)
    protected $ndustry_table = 'ndustry_info';

    public function __construct()
    {
        parent::__construct();

        //載入資料連線
        $this->load->database();
    }

    /**
     * 取得所有資料 (只取rec_status = 1 的資料)
     *
     * @param string $col 資料取得欄位 (預設為 * )
     * @return array
     */
    public function list($search_params)
    {
        // 設定參數預設值
        $default_params = [
            'limit' => null,
            'offset' => null,
            'keywords' => null,
            'order_by' => null,
            'desc_asc' => null,
            'col' => '*'
        ];
        // 過濾參數
        $search_params = array_merge($default_params, $search_params);

        // 執行查詢
        $query = $this->db->select($search_params['col'])
            ->from($this->company_table);

        // 判斷是否有keywords條件
        if (!empty($search_params['keywords'])) {
            // 創建欄位陣列
            $data_columns = [
                'id',
                'name',
                'founded_date',
                'contact',
                'email',
                'scale',
            ];
            // 關鍵字搜尋
            foreach ($data_columns as $column) {
                $query->or_like($column, $search_params['keywords']);
            }
        }

        // 判斷是否有limit條件
        if (!empty($search_params['limit']) && $search_params['limit'] != -1) {
            $query->limit($search_params['limit'], $search_params['offset']);
        }

        // 判斷是否有orderby條件
        if (!empty($search_params['order_by'])) {
            $query->order_by($search_params['order_by'], $search_params['desc_asc']);
        }

        // 回傳查詢結果
        return $query->where('rec_status', '1')->get()->result_array();
    }

    /**
     * 單筆/多筆資料查詢 (只取rec_status = 1 的資料)
     *
     * @param int/array $id 欲查詢之資料id
     * @param string $col 資料取得欄位 (預設為 * )
     * @return void
     */
    public function getBy($id, $col = '*')
    {
        // 執行查詢並回傳結果
        $query = $this->db->select($col)
            ->from($this->company_table)
            ->where_in('id', $id)
            ->where('rec_status', '1')
            ->get();

        // 判斷 單筆or多筆 查詢
        if (is_array($id)) {
            return $query->result_array();
        } else {
            return $query->row_array();
        }
    }

    /**
     * 新增一筆資料
     *
     * @param array $data
     * @return int
     */
    public function create($data)
    {
        // 寫入資料表
        $res = $this->db->insert($this->company_table, $data);
        // 寫入成功時，回傳寫入主鍵值，失敗則回傳0
        return $res ? $this->db->insert_id() : 0;
    }

    /**
     * 批次新增
     * 
     * @param object $data
     * @return boolean
     */
    public function batchAdd($data)
    {
        // 執行批次新增
        $res = $this->db->insert_batch($this->company_table, $data);

        // 寫入成功時，回傳True，失敗則回傳False
        return $res;
    }

    /**
     * 更新單筆資料
     *
     * @param int $id 欲更新之資料id
     * @param array $data 更新之資料內容
     * @return int
     */
    public function update($id, $data)
    {
        // 取得當前時間
        $time = date('Y-m-d H:i:s');
        // 欲更新資料加上更新時間
        $data['update_at'] = $time;

        // 執行單筆資料更新
        $res = $this->db->where('id', $id)->update($this->company_table, $data);
        
        // 更新成功時，回傳更新主鍵鍵值，失敗則回傳0
        return $res ? $id : 0;
    }

    /**
     * 批次更新
     *
     * @param object $data
     * @return boolean
     */
    public function batchUpdate($data)
    {
        // 執行批次更新，成功時，回傳True，失敗則回傳Fals
        return $this->db->update_batch($this->company_table, $data, 'id');
    }

    /**
     * 資料軟刪除
     *
     * @param int $id 欲刪除之資料id
     * @return int
     */
    public function softDelete($id)
    {
        // 取得當前時間
        $time = date('Y-m-d H:i:s');

        // 設定資料狀態為0，達到軟刪除，同時更新刪除時間
        $data = [
            'rec_status' => '0',
            'delete_at' => $time
        ];

        // 執行更新
        $res = $this->db->where_in('id', $id)->update($this->company_table, $data);

        // 成功時，回傳其資料id，失敗則回傳0
        return $res ? $id : 0;
    }

    /**
     * 批次軟刪除
     *
     * @param array $data 欲刪除之id陣列
     * @return boolean
     */
    public function softDeleteDatas($data)
    {
        // 取得當前時間
        $time = date('Y-m-d H:i:s');
        // 建立存放id空陣列
        $d_datas = [];
        // 產出符合批次更新之資料格式
        foreach ($data['id'] as $num => $id) {
            $d_datas[$num] = [
                'id' => $id,
                'rec_status' => '0',
                'delete_at' => $time
            ];
        }

        // 執行批次軟刪除(更新)，成功時回傳True，失敗則回傳False
        return $this->db->update_batch($this->company_table, $d_datas, 'id');
    }

    /**
     * 取得行業類別名稱
     *
     * @param array $ndustry_id 欲查詢之行業類別id
     * @return array
     */
    public function getNdustryName($ndustry_id)
    {
        // 取得欲查詢行業之類別名稱及id
        $res = $this->db->select(['id', 'name'])
            ->from($this->ndustry_table)
            ->where_in('id', $ndustry_id)
            ->get()
            ->result_array();

        // 回傳結果
        return $res;

    }

    /**
     * 取得資料總比數
     *
     * @param string $keywords 搜尋關鍵字
     * @return int
     */
    public function getTotalNumbers($keywords = null)
    {
        $query = $this->db->from($this->company_table);

         // 判斷是否有keywords條件
         if (!empty($keywords)) {
            // 創建欄位陣列
            $data_columns = [
                'id',
                'name',
                'founded_date',
                'contact',
                'email',
                'scale'
            ];
            // 關鍵字搜尋
            foreach ($data_columns as $column) {
                $query->or_like($column, $keywords);
            }
        }

        // 回傳資料數量
        return $query->count_all_results();
    }
}