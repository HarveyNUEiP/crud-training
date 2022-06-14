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
     * @param string $limit 限制筆數
     * @param string $offset 跳過幾筆
     * @param string $col 選擇欄位
     * @return object
     */
    public function get($limit = '', $offset = '', $keywords = '', $order_by = '', $descAsc = '', $col = '*')
    {
        // 建立輸出陣列
        $opt = [];

        $num = $this->getNumbers($keywords);
        $query = $this->db->select($col)->from($this->table);

        // 判斷是否有limit, keywords, orderby條件
        if (!empty($keywords)) {
            // 關鍵字搜尋
            $query->like('id', $keywords);
            $query->or_like('account', $keywords);
            $query->or_like('name', $keywords);
            $query->or_like('sex', $keywords);
            $query->or_like('birthday', $keywords);
            $query->or_like('email', $keywords);
            $query->or_like('comments', $keywords);
        } 
        
        if (!empty($limit)) {
            $query->limit($limit, $offset);
        }

        if (!empty($order_by)) {
            $query->order_by($order_by, $descAsc);
        }

        $res = $query->get()->result_array();

        $opt = [
            'numbers' => $num,
            'data' => $res
        ];
        // print_r($opt);exit;
        return $opt;
    }

    /**
     * 查詢單筆資料
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
     * 新增資料
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
