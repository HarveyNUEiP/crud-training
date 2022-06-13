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
     * @return void
     */
    public function get($limit = '', $offset = '', $col = '*')
    {
        // 建立輸出陣列
        $opt = [];

        // 判斷是否有limit條件
        if(empty($limit)){
            $res = $this->db->select($col)->from($this->table)->get()->result_array();
            $num = $this->getNumbers();
            $opt = [
                'numbers' => $num,
                'data' => $res
            ];
            return $opt;
        } else {
            $res = $this->db->select($col)->from($this->table)->limit($limit,$offset)->get()->result_array();
            $num = $this->getNumbers();
            $opt = [
                'numbers' => $num,
                'data' => $res
            ];
            return $opt;
        }
    }

    /**
     * 查詢單筆資料
     *
     * @param [type] $id
     * @param string $col
     * @return void
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
     *
     * @return int
     */
    public function getNumbers()
    {
        $num = $this->db->count_all_results($this->table);

        return $num;
    }
}
