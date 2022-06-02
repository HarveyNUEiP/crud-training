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


    public function get($id, $col = '*')
    {
        return $this->db->select($col)->from($this->table)->where('id', $id)->get()->result_array();
    }
}
