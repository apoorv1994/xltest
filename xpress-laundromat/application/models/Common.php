<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Model {

   function signin($data)
   {
        $this -> db -> select($data['val']);
        $this -> db -> from($data['table']);
        $this -> db -> where($data['where']);
        $this -> db -> limit(1);

        $query = $this -> db -> get();

        if($query -> num_rows() > 0)
        {
            $result=array('res'=>true,'rows'=>$query->row_object());
            return $result;
        }
        else
        {
            $result=array('res'=>false);
            return $result;
        }
    }
 // common functions
    function add_data($data)
	{
            return $this->db->insert($data['table'],$data['val']);
	}
	
    function add_referral_data($data)
    {
        return $this->db->insert($data['table'],$data['val2']);
    }

	function add_data_get_id($data)
	{
		
            $this->db->insert($data['table'],$data['val']);
            $insert_id = $this->db->insert_id();
   		
            return  $insert_id;
	}
	
    function get_referree_info($data)
    {
        // add referral code instead of phone no
        $res = $this->db->select('id,firstname,phone_no')
                        ->where(['referral_code'=>$data])
                        ->get('tbl_users')
                        ->row();
        return $res;
    }

    function get_referrer_info($data)
    {
        $res = $this->db->select('id,firstname,phone_no')
                        ->where(['phone_no'=>$data])
                        ->get('tbl_users')
                        ->row();
        return $res;       
    }
	function get_data($data)
	{
            if($data['orderby']!='')
            $this->db->order_by($data['orderby'],$data['orderas']);
            if(isset($data['start']) && $data['start']!='' && isset($data['limit']) && $data['limit']!='')
            {
                $this->db->limit($data['limit'], $data['start']);
            }
            $query=$this->db->get($data['table']);
		
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->result());
                return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
    }

	function get_where($data)
	{
            $this->db->select($data['val']);
            $this->db->where($data['where']); 
            $query=$this->db->get($data['table']);
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->row_object());
                return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
	}
        
        function get_where_array($data)
	{
            $this->db->select($data['val']);
            $this->db->where($data['where']);

            $query=$this->db->get($data['table']);

            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->row_array());
                return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
	}
	
	function get_where_all($data)
	{
            $this->db->select($data['val']);
            if($data['where']!='')
            $this->db->where($data['where']);
            if($data['where2']!='')
                $this->db->where($data['where2']);
            if(isset($data['orderby']) && trim($data['orderby'])!=''){
                $this->db->order_by($data['orderby'],$data['orderas']);
            }
            if($data['group_by']!=''){
                $this->db->group_by($data['group_by']);
            }

            if(isset($data['start']) && $data['start']!='' && isset($data['limit']) && $data['limit']!=''){
                $this->db->limit($data['limit'], $data['start']);
            }

            $query=$this->db->get($data['table']);

            if($query -> num_rows() > 0){
                $result=array('res'=>true,'rows'=>$query->result());
                return $result;
            }else{
                $result=array('res'=>false);
                return $result;
            }
	}
        
	function get_verify($data)
	{
            $this->db->select($data['val']);
            $this->db->where($data['where']);
            $query=$this->db->get($data['table']);
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true);
                return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
	}
	
	function get_verify_data($data)
	{
            $this->db->select($data['val']);
            $this->db->where($data['where']);
            $query=$this->db->get($data['table']);
            if($query -> num_rows() > 0)
            {
            $result=array('res'=>true,'rows'=>$query->row_object());
            return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
	}
	
	
	
	function get_some($data)
	{
            $this->db->select($data['val']);
            $this->db->order_by($data['orderby'],$data['orderas']);
            if($data['start']!='' && $data['limit']!='')
            {
                $this->db->limit($data['limit'], $data['start']);
            }
            $query=$this->db->get($data['table']);
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->result());
                return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
	}
	
	function get_join($data,$join,$join2)
	{
            $this->db->select($data['val']);
            $this->db->from($data['table']);
            $this->db->join($join['table'], $join['on'],$join['join_type']);
            if($join2!='')
            {
                $this->db->join($join2['table'], $join2['on'],$join2['join_type']);
            }
            if($data['where']!=''){
                $this->db->where($data['where']);
            }
            if($data['where2']!='')
                $this->db->where($data['where2']);
            
            if(isset($data['minvalue']) && $data['minvalue']!=''){
                $this->db->where("DATE_FORMAT(a.created, '%d %m %Y') >=", $data['minvalue']);
                $this->db->where("DATE_FORMAT(a.created, '%d %m %Y') <=", $data['maxvalue']);
            }
            if($data['group_by']!=''){
                $this->db->group_by($data['group_by']);
            }
            
            if(isset($data['orderby']) && trim($data['orderby'])!='' && isset($data['orderas']) && trim($data['orderas'])!=''){
                $this->db->order_by($data['orderby'],$data['orderas']);
            }
            
            if( $data['start']!=='' && $data['limit']!=''){
                $this->db->limit($data['limit'], $data['start']);
            }
                $query=$this->db->get();   //return $this->db->last_query();
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->result(),'count'=>$query -> num_rows());
                return $result;
            }
            else
            {
                $result=array('res'=>false, 'count'=>$query -> num_rows());
                return $result;
            }
	}
	
	function get_join2($data,$join,$join2){
            $this->db->select($data['val']);
            $this->db->from($data['table']);
            $this->db->join($join['table'], $join['on'],$join['join_type']);
            
            if($join2!=''){
                $this->db->join($join2['table'], $join2['on'],$join2['join_type']);
            }
            
            if($data['where']!=''){
            $this->db->where($data['where']);
            }
            if($data['where2']!='')
                $this->db->where($data['where2']);
            
            if(isset($data['group_by']) && $data['group_by']!=''){
                $this->db->group_by($data['group_by']);
            }
            $query=$this->db->get();   //return $this->db->last_query();
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->row_object());
                return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
	}
        
        function get_join3($data,$join,$join2){
            $this->db->select($data['val']);
            $this->db->from($data['table']);
            $this->db->join($join['table'], $join['on'],$join['join_type']);
            
            if($join2!=''){
                $this->db->join($join2['table'], $join2['on'],$join2['join_type']);
            }
            
            if($data['where']!=''){
            $this->db->where($data['where']);
            }
            
            //$this->db->order_by($data['orderby'],$data['orderas']);
            $query=$this->db->get();   //return $this->db->last_query();
            if($query -> num_rows() > 0){
                $result=array('res'=>true,'rows'=>$query->row_object());
                return $result;
            }else{
                $result=array('res'=>false);
                return $result;
            }
	}
        
	
        function get_data_group($data)
	{
            $this->db->select($data['val']);
            $this->db->from($data['table']);

            if($data['where']!='')
            {
                $this->db->where($data['where']);
            }
            $this->db->group_by($data['group']);
            $this->db->order_by($data['orderby'],$data['orderas']);
            if($data['start']!='' && $data['limit']!='')
            {
                 $this->db->limit($data['limit'], $data['start']);
            }
            $query=$this->db->get(); //return $this->db->last_query();
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->result());
                return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
    }
        
/*	function get_join_or($value,$join,$join2,$where,$or_where,$table1)
	{
		$this->db->select($value);
		$this->db->from($table1);
		$this->db->join($join['table'], $join['on'],$join['join_type']);
		if($join2!='')
		{
			$this->db->join($join2['table'], $join2['on'],$join2['join_type']);
		}
		if($where!=''){
		$this->db->where("(a.sent_to='".$where['sent_to']."' and  a.sent_by='".$where['sent_by']."') or (a.sent_to='".$or_where['sent_to']."' and  a.sent_by='".$or_where['sent_by']."')");
		}
		$this->db->order_by('a.id','asc');
		$query=$this->db->get();  // $this->db->last_query();
		if($query -> num_rows() > 0)
   {
     return  $query->result();
	 
   }
   else
   {
     return false;
   }
	}
	
	function get_message($where)
	{
		 $query= $this->db->query("SELECT * from (SELECT `b`.`id`, `b`.`name`, a.sent_by, a.status, `b`.`image`, `a`.`message`, `a`.`created`, `a`.`id` as message_id FROM (`message` as a) JOIN `user` as b ON `a`.`sent_by`=`b`.`id` WHERE `a`.`sent_to` = '".$where['sent_to']."' ORDER BY `a`.`id` desc) tb GROUP BY `id`  ORDER BY `message_id` desc");
		 return $query->result();
		// $this->db->last_query();
	}
	*/
	function get_join_group($data,$join,$join2)
	{
            $this->db->select($data['val']);
            $this->db->from($data['table']);
            $this->db->join($join['table'], $join['on'],$join['join_type']);
            if($join2!='')
            {
                    $this->db->join($join2['table'], $join2['on'],$join2['join_type']);
            }
            if($data['where']!='')
            {
                $this->db->where($data['where']);
            }
            $this->db->group_by($data['group']);
            $this->db->order_by($data['orderby'],$data['orderas']);
            $query=$this->db->get(); //return $this->db->last_query();
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->result());
                return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
    }

    function get_not_in($data)
	{
            $this->db->select($data['val']);
            $this->db->where_not_in($data['not_in'], $data['not_in_value']);
            $this->db->order_by($data['orderby'],$data['orderas']);
            if($data['start']!='' && $data['limit']!='')
            {
                 $this->db->limit($data['limit'], $data['start']);
            }
            $query=$this->db->get($data['table']);
		
            if($query -> num_rows() > 0)
            {
                return array('res'=>true,'rows'=>$query->result());
            }
            else
            {
                return array('res'=>false);
            }
	}
        
    function get_in($data)
    {
        $this->db->select($data['val']);
        if($data['where']!='')
        {
            $this->db->where($data['where']);
        }
        $this->db->where_in($data['in'], $data['in_value']);
        $this->db->order_by($data['orderby'],$data['orderas']);
        $query=$this->db->get($data['table']);

        if($query -> num_rows() > 0)
        {
            $result=array('res'=>true,'rows'=>$query->result());
            return $result;
        }
        else
        {
            $result=array('res'=>false);
            return $result;
        }
    }
	
    function update_data($data)
    {
        $this->db->where($data['where']);
        return $this->db->update($data['table'], $data['val']); 
         // $this->db->last_query();
    }
	
    function count_val($data)
    {
        $this->db->select('id');
        $this->db->from($data['table']);
        if($data['where']!='')
        {
            $this->db->where($data['where']);
        }
        return $num_results = $this->db->count_all_results();
    }
	
    function delete_data($data)
    {
        $this->db->where($data['where']);
        return $this->db->delete($data['table']);
    }	
	
    function delete_cond($cond,$data)
    {
        $this->db->select($cond['val']);
        $this->db->where($cond['where']);
        $query=$this->db->get($cond['table']);
        if($query -> num_rows() > 0)
        {
            $this->db->where($data['where']);
            return $this->db->delete($data['table']);
        }else{
            return $this->db->last_query;
        }
    }
	
	function get_join2_modify($data,$join,$join2){
            $this->db->select($data['val']);
            $this->db->from($data['table']);
            $this->db->join($join['table'], $join['on'],$join['join_type']);
            
            if($join2!=''){
                $this->db->join($join2['table'], $join2['on'],$join2['join_type']);
            }
            
            if($data['where']!=''){
            $this->db->where($data['where']);
            }
            if($data['where2']!='')
			{
                $this->db->where($data['where2']);
			}
			if($data['where3']!='')
			{
                $this->db->where($data['where3']);
			}
            
            if(isset($data['group_by']) && $data['group_by']!=''){
                $this->db->group_by($data['group_by']);
            }
            $query=$this->db->get();   
			//return $this->db->last_query();
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->row_object());
                return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
	}
	
	function get_join_modify($data,$join,$join2)
	{
            $this->db->select($data['val']);
            $this->db->from($data['table']);
            $this->db->join($join['table'], $join['on'],$join['join_type']);
            if($join2!='')
            {
                $this->db->join($join2['table'], $join2['on'],$join2['join_type']);
            }
            if($data['where']!=''){
                $this->db->where($data['where']);
            }
            if($data['where2']!='')
			{
                $this->db->where($data['where2']);
			}
			if($data['where3']!='')
			{
                $this->db->where($data['where3']);
			}
            
            if(isset($data['minvalue']) && $data['minvalue']!=''){
                $this->db->where("DATE_FORMAT(a.created, '%d %m %Y') >=", $data['minvalue']);
                $this->db->where("DATE_FORMAT(a.created, '%d %m %Y') <=", $data['maxvalue']);
            }
            if($data['group_by']!=''){
                $this->db->group_by($data['group_by']);
            }
            
            if(isset($data['orderby']) && trim($data['orderby'])!='' && isset($data['orderas']) && trim($data['orderas'])!=''){
                $this->db->order_by($data['orderby'],$data['orderas']);
            }
            
            if( $data['start']!=='' && $data['limit']!=''){
                $this->db->limit($data['limit'], $data['start']);
            }
                $query=$this->db->get();   //return $this->db->last_query();
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->result(),'count'=>$query -> num_rows());
                return $result;
            }
            else
            {
                $result=array('res'=>false, 'count'=>$query -> num_rows());
                return $result;
            }
	}
	
	
	function get_paytm_order_data($data)
	{
            $this->db->select($data['val']);
            $this->db->where($data['where']);
			$this->db->order_by($data['field'],$data['sort']);
			$this->db->limit($data['limit']); 
            $query=$this->db->get($data['table']);
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->row_object());
                return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
	}
	
	function get_join_with_phone_no($data,$join,$join2)
	{
            $this->db->select($data['val']);
            $this->db->from($data['table']);
            $this->db->join($join['table'], $join['on'],$join['join_type']);
            if($join2!='')
            {
                $this->db->join($join2['table'], $join2['on'],$join2['join_type']);
            }
            if($data['where']!=''){
                $this->db->where($data['where']);
            }
            if($data['where2']!='')
                $this->db->where($data['where2']);
			
			if($data['where3']!='')
                $this->db->where($data['where3']);
            
            if(isset($data['minvalue']) && $data['minvalue']!=''){
                $this->db->where("DATE_FORMAT(a.created, '%d %m %Y') >=", $data['minvalue']);
                $this->db->where("DATE_FORMAT(a.created, '%d %m %Y') <=", $data['maxvalue']);
            }
            if($data['group_by']!=''){
                $this->db->group_by($data['group_by']);
            }
            
            if(isset($data['orderby']) && trim($data['orderby'])!='' && isset($data['orderas']) && trim($data['orderas'])!=''){
                $this->db->order_by($data['orderby'],$data['orderas']);
            }
            
            if( $data['start']!=='' && $data['limit']!=''){
                $this->db->limit($data['limit'], $data['start']);
            }
                $query=$this->db->get();   //return $this->db->last_query();
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->result(),'count'=>$query -> num_rows());
                return $result;
            }
            else
            {
                $result=array('res'=>false, 'count'=>$query -> num_rows());
                return $result;
            }
	}
	
	function get_join2_for_search($data,$join,$join2){
            $this->db->select($data['val']);
            $this->db->from($data['table']);
            $this->db->join($join['table'], $join['on'],$join['join_type']);
            
            if($join2!=''){
                $this->db->join($join2['table'], $join2['on'],$join2['join_type']);
            }
            
            if($data['where']!=''){
            $this->db->where($data['where']);
            }
            if($data['where2']!='')
			{
                $this->db->where($data['where2']);
			}
			if($data['where3']!='')
			{
                $this->db->where($data['where3']);
			}
            
            if(isset($data['group_by']) && $data['group_by']!=''){
                $this->db->group_by($data['group_by']);
            }
            $query=$this->db->get();   
			//return $this->db->last_query();
            if($query -> num_rows() > 0)
            {
                $result=array('res'=>true,'rows'=>$query->row_object());
                return $result;
            }
            else
            {
                $result=array('res'=>false);
                return $result;
            }
	}
	// end common functions
	
}