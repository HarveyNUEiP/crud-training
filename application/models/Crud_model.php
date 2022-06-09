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
     * @param int $id 目標主鍵資料
     * @param string $col 輸出欄位
     * @return array
     */
    public function get($col = '*')
    {
        return $this->db->select($col)->from($this->table)->get()->result_array();
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
}
