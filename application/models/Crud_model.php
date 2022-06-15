<?php
class Crud_model extends CI_Model
{
    /**
     * 資料表名稱
     */
    protected $table = "account_info";

    /**
     * 欄位資料
     */
    protected $tableColumns = [
        'id',
        'account',
        'name',
        'sex',
        'birthday',
        'email',
        'comments'
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
     * @return object
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

        $query = $this->db->select($arr_params['col'])->from($this->table);
        // 判斷是否有keywords條件
        if (!empty($arr_params['keywords'])) {
            // 關鍵字搜尋
            $query->like('id', $arr_params['keywords']);
            $query->or_like('account', $arr_params['keywords']);
            $query->or_like('name', $arr_params['keywords']);
            $query->or_like('sex', $arr_params['keywords']);
            $query->or_like('birthday', $arr_params['keywords']);
            $query->or_like('email', $arr_params['keywords']);
            $query->or_like('comments', $arr_params['keywords']);
        } 
        // 判斷是否有limit條件
        if (!empty($arr_params['limit'])) {
            $query->limit($arr_params['limit'], $arr_params['offset']);
        }
        // 判斷是否有orderby條件
        if (!empty($arr_params['orderBy'])) {
            $query->order_by($arr_params['orderBy'], $arr_params['descAsc']);
        }

        $res = $query->get()->result_array();
        return $res;
    }

    /**
     * 查詢單筆資料 從主鍵
     *
     * @param [type] $id
     * @param string $col
     * @return array
     */
    public function getBy($id, $col = '*')
    {
        // 查詢
        $query = $this->db->select($col)->from($this->table)->where('id', $id);

        $res = $query->get()->row_array();
        return $res;
    }

    /**
     * 查詢資料 從帳號
     *
     * @param array $acc
     * @param string $col
     * @return array
     */
    public function getAcc($acc, $col = '*')
    {
        $query = $this->db->select($col)->from($this->table)->where_in('account', $acc);
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
        $data = array_intersect_key($data, array_flip($this->tableColumns));

        // 寫入資料表
        $res = $this->db->insert($this->table, $data);

        // 寫入成功時，回傳寫入主鍵鍵值，失敗則回傳0
        return $res ? $this->db->insert_id() : 0;
    }

    /**
     * 批次新增
     * 
     * @param object $data
     * @return int
     */
    public function batchAdd($data)
    {
        $res = $this->db->insert_batch($this->table, $data);

        return $res ? 1 : 0;
    }

    /**
     * 更新資料
     *
     * @param int $id
     * @param array $data
     * @return int
     */
    public function put($id, $data)
    {
        $res = $this->db->where('id', $id)->update($this->table, $data);

        return $res ? $id : 0;
    }

    /**
     * 批次更新
     *
     * @param object $data
     * @return void
     */
    public function batchUpdate($data)
    {
        $res = $this->db->update_batch($this->table, $data, 'account');
        return $res ? 1 : 0;
    }

    /**
     * 刪除資料
     *
     * @param array|int $id 欲刪除的主鍵值
     * @return boolean
     */
    public function delete($id)
    {

        $id = (array) $id;
        
        $res = $this->db->where_in('id', $id)->delete($this->table);

        return $res;
    }

    /**
     * 取得所有資料總筆數
     *@param string $keywords 搜尋關鍵字
     * @return int
     */
    public function getNumbers($keywords = '')
    {
        if (!empty($keywords)) {
            $query = $this->db->like('id', $keywords);
            $query->or_like('account', $keywords);
            $query->or_like('name', $keywords);
            $query->or_like('sex', $keywords);
            $query->or_like('birthday', $keywords);
            $query->or_like('email', $keywords);
            $query->or_like('comments', $keywords);

            $num = $query->count_all_results($this->table);
            
        } else {
            $num = $this->db->count_all_results($this->table);
        }

        return $num;
    }
}
