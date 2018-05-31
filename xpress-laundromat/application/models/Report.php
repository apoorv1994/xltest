<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Model {
    
    function get_avg_order($id)
    {
        $this->db->select('avg(b.total_amount) as avg_order,avg(b.no_of_items) as avg_no,sum(b.total_amount) as total_amount,avg(b.weight) as avg_weight')
                ->join('tbl_order a','a.id=b.order_id')
                ->where(['a.status'=>5,'user_id'=>$id])
                ->group_by('user_id');
        $res = $this->db->get('tbl_order_details b');
        //echo $this->db->last_query();die;
        if($res->num_rows()>0)
        {
            return $res->row();
        }else{
            return '0';
        }
    }

    function get_timediff($id)
    {
        $this->db->select("a.created")
                ->where(['a.user_id'=>$id])
                ->order_by('created');
        $res = $this->db->get('tbl_order a');
        $x = $res;
        $cnt = 0;
        foreach($x->result() as $row)
        {
           // echo $row->created."<br>";
            $cnt+=$row->created;
        }
        $first = $x->row()->created.'<br>';
        $second = $cnt/$x->num_rows();
        $numDays = abs($first - $second)/60/60/24;
        return round($numDays);
    }
    
    function get_avg_timediff($id)
    {
        $this->db->select("FROM_UNIXTIME(AVG(UNIX_TIMESTAMP(a.created)), '%i:%s')  as avg_timediff",FALSE)
                ->join('tbl_order a','a.id=b.order_id')
                ->where(['a.status'=>5,'user_id'=>$id])
                ->group_by('user_id');
        $res = $this->db->get('tbl_order_details b');
        return $res->row();
        if($res->num_rows()>0)
        {
            return $res->row()->avg_timediff?$res->row()->avg_timediff:'0';
        }else{
            return '0';
        }
    }

    function get_created_time($id)
    {
        $this->db->select('created')->where(['user_id'=>$id]);
        $res= $this->db->get('tbl_users');
        if($res->num_rows()>0)
            return $res->row()->created?$res->row()->created:'0';
        else
            return '0';
    }
    
    function get_washtype_freq($id)
    {
        $this->db->select("count(a.id) as total,order_type")
                ->join('tbl_order a','a.id=b.order_id')
                ->where(['a.status'=>5,'user_id'=>$id])
                ->group_by('order_type');
        $res = $this->db->get('tbl_order_details b');
        if($res->num_rows()>0)
        {
            $rdata=[];
            foreach($res->result() as $data)
            {
                $rdata[$data->order_type] = $data->total;
            }
            return $rdata;
        }else{
            return [1=>0,2=>0,3=>0,4=>0];
        }
    }
    
    function get_avg_rating($id)
    {
        $this->db->select('avg(rating) as avg_rating')
                ->where(['user_id'=>$id]);
                //->group_by('user_id');
        $res = $this->db->get('tbl_ratings');
        if($res->num_rows()>0)
        {
            return $res->row()->avg_rating?$res->row()->avg_rating:'0';
        }else{
            return '0';
        }
    }
    function get_avg_recharge($id)
    {
        $this->db->select('avg(amount) as avg_recharge')
                ->where(['user_id'=>$id,'payment_status'=>1]);
                //->group_by('user_id');
        $res = $this->db->get('tbl_transcations');
        if($res->num_rows()>0)
        {
            return $res->row()->avg_recharge?$res->row()->avg_recharge:'0';
        }else{
            return '0';
        }
    }
    function get_avg_rating_bysetup($where)
    {
        $this->db->select('avg(rating) as avg_rating')
                ->join('tbl_order b','a.order_id=b.id')
                ->join('tbl_users c','b.user_id=c.id')
                ->where($where)
                ->group_by('c.college_id');
        $res = $this->db->get('tbl_ratings a');
        if($res->num_rows()>0)
        {
            return $res->row()->avg_rating?$res->row()->avg_rating:'0';
        }else{
            return '0';
        }
    }
    
    function get_avg_clothes_bysetup($where)
    {
        $this->db->select('avg(b.no_of_items) as avg_no')
                ->join('tbl_order a','a.id=b.order_id')
                ->join('tbl_users c','a.user_id=c.id')
                ->where($where)
                ->where('a.status <>',0)
                ->group_by('c.college_id');
        $res = $this->db->get('tbl_order_details b');
        //echo $this->db->last_query();die;
        if($res->num_rows()>0)
        {
            return $res->row()->avg_no;
        }else{
            return '0';
        }
    }
}