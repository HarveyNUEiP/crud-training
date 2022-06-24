<?php
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
    public function list($keywords = '', $col = '*')
    {
        // 執行查詢並回傳結果
        $query =  $this->db->select($col)
            ->from($this->company_table)
            ->where('rec_status', '1');
        
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
            
        return $query->get()->result_array();
    }

    /**
     * 單筆資料查詢 (只取rec_status = 1 的資料)
     *
     * @param int $id 欲查詢之資料id
     * @param string $col 資料取得欄位 (預設為 * )
     * @return void
     */
    public function getBy($id, $col = '*')
    {
        // 執行查詢並回傳結果
        return $this->db->select($col)
            ->from($this->company_table)
            ->where_in('id', $id)
            ->where('rec_status', '1')
            ->get()
            ->row_array();
    }

    /**
     * 新增一筆資料
     *
     * @param array $data
     * @return void
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
        // 執行批次更新
        $res = $this->db->update_batch($this->company_table, $data, 'id');

        // 批次更新成功時，回傳True，失敗則回傳False
        return $res;
    }

    /**
     * 資料軟刪除
     *
     * @param int $id 欲刪除之資料id
     * @return void
     */
    public function softDelete($id)
    {
        // 設定資料狀態為0 達到軟刪除
        $data = [
            'rec_status' => '0'
        ];
        
        // print_r($id);exit;

        $res = $this->db->where_in('id', $id)->update($this->company_table, $data);
        
        return $res ? $id : 0;
    }
}