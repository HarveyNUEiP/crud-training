<?php
class Crud_model extends CI_Model
{
    /**
     * 資料表名稱(帳號)
     */
    protected $acc_table = "account_info";

    /**
     * 欄位資料(帳號)
     */
    protected $acc_tableColumns = [
        'id',
        'account',
        'sex',
        'birthday',
        'email',
        'dept_no',
        'comments'
    ];

    /**
     * 資料表名稱(部門)
     */
    protected $dept_table = "dept_info";

    /**
     * 欄位資料(部門)
     */
    protected $dept_tableColumns = [
        'd_id',
        'd_code',
        'd_name',
        'd_level',
        'date_start',
        'date_end',
        'remark',
        'date_create',
        'user_create',
        'date_update',
        'user_update',
        'date_delete',
        'user_delete',
        'rec_status'
    ];

    public function __construct()
    {
        parent::__construct();

        //載入資料連線
        $this->load->database();
    }

    /**
     * 讀取全部資料
     *
     * @param array $arr_params 搜尋條件(limit, offset, keywords, orederBy, descAsc)
     * @return array
     */
    public function get($arr_params)
    {
        // 設定參數預設值
        $default_params = [
            'limit' => null,
            'offset' => null,
            'keywords' => null,
            'orderBy' => null,
            'descAsc' => null,
            'col' => '*'
        ];
        // 過濾參數
        $arr_params = array_merge($default_params, $arr_params);

        // 執行查詢
        $query = $this->db->select($arr_params['col'])
            ->from($this->acc_table);

        // 判斷是否有keywords條件
        if (!empty($arr_params['keywords'])) {
            // 創建欄位陣列
            $data_columns = [
                'id',
                'account',
                'name',
                'sex',
                'birthday',
                'email',
                'dept_no',
                'comments'
            ];
            // 關鍵字搜尋
            foreach ($data_columns as $column) {
                $query->or_like($column, $arr_params['keywords']);
            }
        }

        // 判斷是否有limit條件
        if (!empty($arr_params['limit'])) {
            $query->limit($arr_params['limit'], $arr_params['offset']);
        }

        // 判斷是否有orderby條件
        if (!empty($arr_params['orderBy'])) {
            $query->order_by($arr_params['orderBy'], $arr_params['descAsc']);
        }

        // 回傳查詢結果
        return $query->get()->result_array();
    }

    /**
     * 查詢單筆資料 從主鍵
     *
     * @param int $id
     * @param string $col
     * @return array
     */
    public function getBy($id, $col = '*')
    {
        // 執行查詢
        $query = $this->db->select($col)->from($this->acc_table)->where('id', $id);

        // 產生查詢結果
        $res = $query->get()->row_array();
        return $res;
    }

    /**
     * 查詢資料 (帳號)
     *
     * @param array $acc 帳號
     * @param string $col
     * @return array
     */
    public function getAcc($acc, $col = '*')
    {
        $query = $this->db->select($col)
            ->from($this->acc_table)
            ->where_in('account', $acc);
        return $query->get()->result_array();
    }

    /**
     * 新增單筆資料
     *
     * @param array $data
     * @return int
     */
    public function post($data)
    {
        // 過濾可用欄位資料
        $data = array_intersect_key($data, array_flip($this->acc_tableColumns));

        // 寫入資料表
        $res = $this->db->insert($this->acc_table, $data);

        // 寫入成功時，回傳寫入主鍵鍵值，失敗則回傳0
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
        $res = $this->db->insert_batch($this->acc_table, $data);

        // 寫入成功時，回傳True，失敗則回傳False
        return $res;
    }

    /**
     * 更新單筆資料
     *
     * @param int $id 主鍵
     * @param array $data
     * @return int
     */
    public function put($id, $data)
    {
        // 執行單筆資料更新
        $res = $this->db->where('id', $id)->update($this->acc_table, $data);

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
        $res = $this->db->update_batch($this->acc_table, $data, 'account');

        // 批次更新成功時，回傳True，失敗則回傳False
        return $res;
    }

    /**
     * 刪除資料
     *
     * @param array|int $id 欲刪除的主鍵值
     * @return boolean
     */
    public function delete($id)
    {
        // 將 $id 轉為陣列
        $id = (array) $id;

        // 執行單筆/批次刪除
        $res = $this->db->where_in('id', $id)->delete($this->acc_table);

        // 刪除成功時，回傳True，失敗則回傳False
        return $res;
    }

    /**
     * 取得所有資料總筆數
     * @param string $keywords 搜尋關鍵字
     * @return int
     */
    public function getNumbers($keywords = '')
    {
        // 
        $query = $this->db->from($this->acc_table);

        // 判斷關鍵字是否為空
        if (!empty($keywords)) {
            // 創建欄位陣列
            $data_columns = [
                'id',
                'account',
                'name',
                'sex',
                'birthday',
                'email',
                'dept_no',
                'comments'
            ];
            // 對每個欄位做關鍵字查詢
            foreach ($data_columns as $column) {
                $query->or_like($column, $keywords);
            }
        }

        // 回傳資料數量
        return $query->count_all_results();
    }

    /**
     * 從部門資料表取得部門名稱
     *
     * @param int $d_id 主鍵
     * @return array
     */
    public function getDeptName($d_id)
    {
        // 取得部門名稱
        $query = $this->db->select(['d_id', 'd_name'])->from($this->dept_table)->where_in('d_id', $d_id);

        // 取得結果
        $res = $query->get()->result_array();

        // 回傳結果
        return $res;
    }
}
