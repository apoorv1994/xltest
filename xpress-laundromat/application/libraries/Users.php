<?php
class Users {
    var $table;
    public function __construct()
    {
        $this->ci =& get_instance();
        $this->table = 'tbl_users';
    }
        
    function get_user($fields="",$id)
    {
        if($id)
        {
            if(isset($fields) && (is_array($fields) || trim($fields)!='')){
                $data=array('val'=>$fields,'table'=>$this->table,'where'=>array('id'=>$id));
            }else{
                $data=array('val'=>'*','table'=>$this->table,'where'=>array('id'=>$id));
            }

            $res=$this->ci->common->get_where($data);
            if($res['res'])
            {
                return $res['rows'];
            }else{
                return false;
            }
        }
    }
    
    function _valid_admin()
    {        
        if(!$this->ci->session->admin_id)
        {
            redirect('panel/auth','refresh');
        }
    }
    
    function restrict_subadmin()
    {
        if($this->ci->session->user_type==2)
        {
             redirect('panel/home','refresh');
        }
    }
    
    function _valid_user()
    {
        $refferer = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if(!$this->ci->session->userdata('user_id'))
        {
            redirect(BASE.'auth/?redir='.$refferer,'refresh');
        }
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

