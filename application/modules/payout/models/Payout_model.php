<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payout_model extends CI_Model
{

    public $table = 'tr_payout';
    public $table_detail = 'tr_payout_detail';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_detail_by_id($id)
    {
        $this->db->where('payout_id', $id);
        return $this->db->get($this->table_detail)->result();
    }

    function create_data($post)
    {
        $arr_header = array(
            'title' => $post['title'],
            'total_payout' => to_number($post['totalAmount']),
            'created_date' => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->insert('tr_payout', $arr_header);

        $insert_id = $this->db->insert_id();

        for ($x = 0; $x < count($post['empName']); $x++) {
            $arr_detail = array(
                'payout_id' => $insert_id,
                'employee_name' => $post['empName'][$x],
                'payout_pct' => $post['empPct'][$x],
                'payout_amount' => to_number($post['empAmount'][$x]),
            );

            $this->db->insert('tr_payout_detail', $arr_detail);

            $this->db->trans_complete();
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function edit_data($post, $id)
    {
        $arr_header = array(
            'title' => $post['title'],
            'total_payout' => to_number($post['totalAmount'])
        );
        $this->db->trans_start();
        $this->db->where('payout_id', $id);
        $this->db->delete('tr_payout_detail');

        $this->db->where('id', $id);
        $this->db->update('tr_payout', $arr_header);


        for ($x = 0; $x < count($post['empName']); $x++) {
            $arr_detail = array(
                'payout_id' => $id,
                'employee_name' => $post['empName'][$x],
                'payout_pct' => $post['empPct'][$x],
                'payout_amount' => to_number($post['empAmount'][$x]),
            );

            $this->db->insert('tr_payout_detail', $arr_detail);

            $this->db->trans_complete();
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    // delete data
    function delete_data($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);

        $this->db->where('payout_id', $id);
        $this->db->delete($this->table_detail);

        return true;
    }
}