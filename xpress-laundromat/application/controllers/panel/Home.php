<?php
class Home extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users');
        $this->load->library('functions');
        $this->users->_valid_admin();
    }
    function index()
    {
        $where = ['status'=>1];
        if($this->session->user_type==2)
        {
            $where['college_id'] = $this->session->a_college_id;
            $college_id = $this->session->a_college_id;
            $pagedata['to_count'] = $this->londury->today_order_accord_college($college_id);

        }
        if($this->session->user_type==1){
            $pagedata['to_count'] = $this->londury->today_order();
        }
        $u_data = ['where'=>$where,'table'=>'tbl_users'];
        $pagedata['u_count'] = $this->common->count_val($u_data);
        $pagedata['t_count'] = $this->londury->total_sale()->total?$this->londury->total_sale()->total:'0';
        $pagedata['total_order'] = $this->londury->total_order();
        $where ='';
        if($this->session->user_type==2)
        {
            $where['id'] = $this->session->a_college_id;
        }
        $data=['val'=>'id,college_name','table'=>'tbl_college','where'=>$where,'orderby'=>'college_name','orderas'=>'ASC'];
        $res=$this->common->get_where_all($data);
        if($res['res'])
        {
            $pagedata['colleges']=$res['rows'];
        }
        
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/home');
        $this->load->view('panel/footer');
    }
    
    function search()
    {
        $this->form_validation->set_rules('college_id','College','trim|xss_clean');
        $this->form_validation->set_rules('byname','By Name','trim|xss_clean');
        $this->form_validation->set_rules('byroll','By Roll','trim|xss_clean');
        $this->form_validation->set_rules('bytoken','By Token','trim|xss_clean');
        if($this->form_validation->run())
        {
            $college_id = $this->input->post('college_id');
            if($this->session->user_type==2)
            {
                if($college_id!=$this->session->a_college_id)
                {
                    $college_id==$this->session->a_college_id;
                }
            }
            if($college_id!='All')
            {
                $where = ['b.college_id'=>$college_id];
            }
            if($this->input->post('byname')!='')
            {
                $where2 = " (concat(firstname,' ',lastname) like '".$this->input->post('byname')."%')";
            }elseif($this->input->post('byroll')!='')
            {
                $where2 = " (roll_no like '".$this->input->post('byroll')."%')";
            }elseif($this->input->post('bytoken')!='')
            {
                $where2 = " (token_no like '".$this->input->post('bytoken')."%')";
            }
            $res = $this->londury->homesearch($where,$where2,'0',10);
            if($res['res'])
            {
                foreach($res['rows'] as $user)
                { ?>
                    <tr>
                        <td><?=$user->token_no?></td>
                        <td><?=$user->firstname.' '.$user->lastname?></td>
                        <td><?=$user->id?></td>
                        <td><a style="color: #fff;" href="<?=BASE?>panel/user/user-detail/<?=$user->user_id?>" class="btn btn-success"><i class="fa fa-search"></i> View</a></td>
                    </tr>
          <?php }
            }else{?>
                    <tr><td colspan="4">No record found.</td></tr>
            <?php }
        }
        
    }
            
    function get_transaction_total()
    {
        $arr = [];
        $where2 = '';
        if($this->session->user_type==2)
        {
            $where2=['b.college_id' => $this->session->a_college_id];
        }
        $date = date('Y-m-d');
        for($i=0;$i<21;$i++)
        {
            $date = Date('Y-m-d', strtotime("-".$i." days"));
            $where = "(from_unixtime(a.created, '%Y-%m-%d')='$date') and payment_status=1";
            $this->db->select('sum(amount) as total',FALSE)
            ->join('tbl_users b','a.user_id=b.id');
            $this->db->where($where);
            if($where2!='')
            {
                $this->db->where($where2);
            }
            $this->db->group_by("from_unixtime(a.created, '%Y-%m-%d')");
            $res = $this->db->get('tbl_transcations a');
            if($res->num_rows()>0)
            {
                $arr[] = ['d'=>$date,'amount'=>$res->row_object()->total];
            }else{
                $arr[] = ['d'=>$date,'amount'=>0];
            }
            
        }
        echo json_encode($arr);
    }
	
	function get_transaction_total_modify()
    {
        $arr = [];
        $where2 = '';
        if($this->session->user_type==2)
        {
            $where2=['b.college_id' => $this->session->a_college_id];
        }
        $date = date('Y-m-d');
        for($i=0;$i<21;$i++)
        {
			$amount=0;
			$orderTotal=0;
			$offlineTotal=0;
			$payuTotal=0;
            $date = Date('Y-m-d', strtotime("-".$i." days"));
            $where = "(from_unixtime(a.created, '%Y-%m-%d')='$date') and payment_status=1";
            $this->db->select('sum(amount) as total',FALSE)
            ->join('tbl_users b','a.user_id=b.id');
            $this->db->where($where);
            if($where2!='')
            {
                $this->db->where($where2);
            }
            $this->db->group_by("from_unixtime(a.created, '%Y-%m-%d')");
            $res = $this->db->get('tbl_transcations a');
            if($res->num_rows()>0)
            {
                $amount=$res->row_object()->total;
            }
			$from=strtotime($date."00:00");

			$to=strtotime($date."23:59");
			$this->db->select('SUM(total_amount) as orderTotal');
			$this->db->where('bookDateON',$date);
			$res = $this->db->get('tbl_order');
            if($res->num_rows()>0)
            {
				if(!empty($res->row_object()->orderTotal))
                $orderTotal=$res->row_object()->orderTotal;
            }
			
			$this->db->select('SUM(amount) as offlineTotal');
			$this->db->where('created >= '.$from);
			$this->db->where('created <= '.$to);
			$this->db->where('payment_method','offline');
			$res = $this->db->get('tbl_transcations');
            if($res->num_rows()>0)
            {
				if(!empty($res->row_object()->offlineTotal))
                $offlineTotal=$res->row_object()->offlineTotal;
            }
			$payment_method = array('Payu', 'Paytm');
			$this->db->select('SUM(amount) as payuTotal');
			$this->db->where('created >= '.$from);
			$this->db->where('created <= '.$to);
			$this->db->where_in('payment_method', $payment_method);
			$this->db->where('payment_status','1');
			$res = $this->db->get('tbl_transcations');
            if($res->num_rows()>0)
            {
				if(!empty($res->row_object()->payuTotal))
                $payuTotal=$res->row_object()->payuTotal;
            }
			
			$arr[] = ['d'=>$date,'amount'=>$amount,'online'=>$payuTotal,'offline'=>$offlineTotal,'orders'=>$orderTotal];
        }
		
        echo json_encode($arr);
    }
	
	function get_transaction_total_modify_old()
    {
        $arr = [];
        $where2 = '';
        if($this->session->user_type==2)
        {
            $where2=['b.college_id' => $this->session->a_college_id];
        }
        $date = date('Y-m-d');
        for($i=0;$i<21;$i++)
        {
			$amount=0;
			$orderTotal=0;
			$offlineTotal=0;
			$payuTotal=0;
            $date = Date('Y-m-d', strtotime("-".$i." days"));
            $where = "(from_unixtime(a.created, '%Y-%m-%d')='$date') and payment_status=1";
            $this->db->select('sum(amount) as total',FALSE)
            ->join('tbl_users b','a.user_id=b.id');
            $this->db->where($where);
            if($where2!='')
            {
                $this->db->where($where2);
            }
            $this->db->group_by("from_unixtime(a.created, '%Y-%m-%d')");
            $res = $this->db->get('tbl_transcations a');
            if($res->num_rows()>0)
            {
                $amount=$res->row_object()->total;
            }
			$from=strtotime($date."00:00");

			$to=strtotime($date."23:59");
			$this->db->select('SUM(total_amount) as orderTotal');
			$this->db->where('created >= '.$from);
			$this->db->where('created <= '.$to);
			$res = $this->db->get('tbl_order');
            if($res->num_rows()>0)
            {
				if(!empty($res->row_object()->orderTotal))
                $orderTotal=$res->row_object()->orderTotal;
            }
			
			$this->db->select('SUM(amount) as offlineTotal');
			$this->db->where('created >= '.$from);
			$this->db->where('created <= '.$to);
			$this->db->where('payment_method','offline');
			$res = $this->db->get('tbl_transcations');
            if($res->num_rows()>0)
            {
				if(!empty($res->row_object()->offlineTotal))
                $offlineTotal=$res->row_object()->offlineTotal;
            }
			
			$this->db->select('SUM(amount) as payuTotal');
			$this->db->where('created >= '.$from);
			$this->db->where('created <= '.$to);
			$this->db->where('payment_method','Payu');
			$this->db->where('payment_status','1');
			$res = $this->db->get('tbl_transcations');
            if($res->num_rows()>0)
            {
				if(!empty($res->row_object()->payuTotal))
                $payuTotal=$res->row_object()->payuTotal;
            }
			
			$arr[] = ['d'=>$date,'amount'=>$amount,'online'=>$payuTotal,'offline'=>$offlineTotal,'orders'=>$orderTotal];
        }
		
        echo json_encode($arr);
    }
    
    function settings()
    {
        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]|max_length[20]|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[8]|max_length[20]');
        if($this->form_validation->run())
        {
            $verify=array('val'=>'id','where'=>array('password'=>  md5($this->input->post('current_password')),'id'=>  $this->session->userdata('admin_id')),'table'=>'admin');
            $res=$this->common->get_verify($verify);
            if($res['res'])
            {
                $data=array('val'=>array('password'=>md5($this->input->post('new_password'))),'where'=>array('id'=>  $this->session->userdata('admin_id')),'table'=>'admin');
                if($this->common->update_data($data))
                {
                    $this->session->set_flashdata('msg','Password has been successfully changed.');
                    redirect('panel/home/settings');
                }
                
            }else{
                $this->session->set_flashdata('error','You entered wrong password.');
                    redirect('panel/home/settings');
            }
        }
        $pagedata['error']=  $this->session->flashdata('error');
        $pagedata['msg']=  $this->session->flashdata('msg');
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/setting_vw');
        $this->load->view('panel/footer');
    }
    
    
    
    function college_list()
    {
        $this->users->restrict_subadmin();
        $data=['val'=>'*','table'=>'tbl_college','orderby'=>'id','orderas'=>'DESC'];
        $res=$this->common->get_where_all($data);
        if($res['res'])
        {
            $pagedata['colleges']=$res['rows'];
        }
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/home/college_vw');
        $this->load->view('panel/footer');
    }
    
    function get_college($id)
    {
        $res = $this->db->get_where('tbl_college',['id'=>$id]);
        if($res->num_rows()>0)
        {
            echo json_encode(['status'=>TRUE,'data'=>$res->row()]);
        }else{
            echo json_encode(['status'=>FALSE]);
        }
    }
    
    function edit_college()
    {
        $this->users->restrict_subadmin();
        $this->form_validation->set_rules('college_id', 'College ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('college_name', 'College name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone No', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name Of manager', 'trim|required|xss_clean');
        $this->form_validation->set_rules('store_time', 'Store Timings', 'trim|required|xss_clean');
        $this->form_validation->set_rules('service_tax', 'Service Tax No', 'trim|xss_clean');
        if($this->form_validation->run())
        {
            $this->db->update('tbl_college',['college_name'=>  $this->input->post('college_name'),'name'=>$this->input->post('name'),'store_timing'=>$this->input->post('store_time'),'service_tax_no'=>$this->input->post('service_tax'),
                'address'=>$this->input->post('address'),'email'=>$this->input->post('email'),'phone'=>$this->input->post('phone')],['id'=>$this->input->post('college_id')]);
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['college_name_err'=>  form_error('college_name','<div class="err">','</div>'),'name_err'=>  form_error('name','<div class="err">','</div>'),
                'address_err'=>  form_error('address','<div class="err">','</div>'),'phone_err'=>  form_error('phone','<div class="err">','</div>'),
                'email_err'=>  form_error('email','<div class="err">','</div>'),'store_time_err'=>  form_error('store_time','<div class="err">','</div>'),'service_tax_err'=>  form_error('service_tax','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function add_college()
    {
        $this->users->restrict_subadmin();
        $this->form_validation->set_rules('college_name', 'College name', 'trim|required|xss_clean|is_unique[tbl_college.college_name]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone No', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name Of manager', 'trim|required|xss_clean');
        $this->form_validation->set_rules('store_time', 'Store Timings', 'trim|required|xss_clean');
        $this->form_validation->set_rules('service_tax', 'Service Tax No', 'trim|xss_clean');
        if($this->form_validation->run())
        {
            $this->db->insert('tbl_college',['college_name'=>  $this->input->post('college_name'),'status'=>1,'name'=>$this->input->post('name'),
                'address'=>$this->input->post('address'),'email'=>$this->input->post('email'),'phone'=>$this->input->post('phone'),'store_timing'=>$this->input->post('store_time'),'service_tax_no'=>$this->input->post('service_tax')]);
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['college_name_err'=>  form_error('college_name','<div class="err">','</div>'),'name_err'=>  form_error('name','<div class="err">','</div>'),
                'address_err'=>  form_error('address','<div class="err">','</div>'),'phone_err'=>  form_error('phone','<div class="err">','</div>'),
                'email_err'=>  form_error('email','<div class="err">','</div>'),'store_time_err'=>  form_error('store_time','<div class="err">','</div>'),'service_tax_err'=>  form_error('service_tax','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function college_status($id,$status)
    {
        $this->users->restrict_subadmin();
        $this->db->update('tbl_college',['status'=>  $status],['id'=>$id]);
        $this->session->set_flashdata('msg','Status Updated');
        redirect('panel/home/college-list');
    }
    
    function college_delete($id)
    {
        $this->users->restrict_subadmin();
        $this->db->where(['id'=>$id]);
        $this->db->delete('tbl_college');
        $this->session->set_flashdata('msg','College Deleted');
        redirect('panel/home/college-list');
    }
    
    function hostel_list()
    {
        $this->users->restrict_subadmin();
        $where = '';
        if($this->input->get('filter_hostel')!='' && $this->input->get('filter_hostel')!='All' )
        {
            $where = ['a.college_id'=>$this->input->get('filter_hostel')];
        }
        
        $data=['val'=>'a.*,b.college_name','table'=>'tbl_hostel a','where'=>$where,'orderby'=>'a.id','orderas'=>'DESC'];
        $join = ['table'=>'tbl_college b','on'=>'a.college_id=b.id','join_type'=>''];
        $res=$this->common->get_join($data,$join);
        if($res['res'])
        {
            $pagedata['hostels']=$res['rows'];
        }
        
        $data=['val'=>'id,college_name','table'=>'tbl_college','orderby'=>'id','orderas'=>'DESC'];
        $res=$this->common->get_where_all($data);
        if($res['res'])
        {
            $pagedata['colleges']=$res['rows'];
        }
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/home/hostel_vw');
        $this->load->view('panel/footer');
    }

    function get_hostel($id)
    {
        $hostel = $this->londury->get_hostel($id);
        echo json_encode($hostel);
    }
    

    function edit_hostel()
    {
        $this->users->restrict_subadmin();
        $this->form_validation->set_rules('hostel_id', 'Hostel ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('hostel_name', 'Hostel name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('college_name', 'College name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pickup_morning','Morning Pickup','trim|xss_clean');
        $this->form_validation->set_rules('pickup_afternoon','Afternoon Pickup','trim|xss_clean');
        $this->form_validation->set_rules('pickup_evening','Evening Pickup','trim|xss_clean');
        $this->form_validation->set_rules('pickup_night','Night Pickup','trim|xss_clean');
        if($this->form_validation->run())
        {
            $this->db->update('tbl_hostel',['hostel_name'=>  $this->input->post('hostel_name'),'college_id'=>  $this->input->post('college_name'),'morning'=>$this->input->post('pickup_morning'),'afternoon'=>$this->input->post('pickup_afternoon'),'evening'=>$this->input->post('pickup_evening'),'night'=>$this->input->post('pickup_night')],['id'=>$this->input->post('hostel_id')]);
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['college_name_err'=>  form_error('college_name','<div class="err">','</div>'),'hostel_name_err'=>  form_error('hostel_name','<div class="err">','</div>'),'pickup_morning_err'=> form_error('pickup_morning','<div class="err">','</div>'),'pickup_afternoon_err'=> form_error('pickup_afternoon','<div class="err">','</div>'),'pickup_evening_err'=> form_error('pickup_evening','<div class="err">','</div>'),'pickup_night_err'=> form_error('pickup_night','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function add_hostel()
    {
        $this->users->restrict_subadmin();
        $this->form_validation->set_rules('hostel_name', 'Hostel name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('college_name', 'College name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pickup_morning','Morning','trim|xss_clean');
        $this->form_validation->set_rules('pickup_afternoon','Afternoon','trim|xss_clean');
        $this->form_validation->set_rules('pickup_evening','Evening','trim|xss_clean');
        $this->form_validation->set_rules('pickup_night','Night','trim|xss_clean');
        if($this->form_validation->run())
        {
            $this->db->insert('tbl_hostel',['hostel_name'=>  $this->input->post('hostel_name'),'college_id'=>  $this->input->post('college_name'),'morning'=>$this->input->post('pickup_morning'),'afternoon'=>$this->input->post('pickup_afternoon'),'evening'=>$this->input->post('pickup_evening'),'night'=>$this->input->post('pickup_night'),'status'=>1]);
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['college_name_err'=>  form_error('college_name','<div class="err">','</div>'),'hostel_name_err'=>  form_error('hostel_name','<div class="err">','</div>'),'pickup_morning_err'=> form_error('pickup_morning','<div class="err">','</div>'),'pickup_afternoon_err'=> form_error('pickup_afternoon','<div class="err">','</div>'),'pickup_evening_err'=> form_error('pickup_evening','<div class="err">','</div>'),'pickup_night_err'=> form_error('pickup_night','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function hostel_status($id,$status)
    {
        $this->users->restrict_subadmin();
        $this->db->update('tbl_hostel',['status'=>  $status],['id'=>$id]);
        $this->session->set_flashdata('msg','Status Updated');
        redirect('panel/home/hostel-list');
    }
    
    function hostel_delete($id)
    {
        $this->users->restrict_subadmin();
        $this->db->where(['id'=>$id]);
        $this->db->delete('tbl_hostel');
        $this->session->set_flashdata('msg','College Deleted');
        redirect('panel/home/hostel-list');
    }
    
    function slotlist()
    {
        $where2= $where = '';
        
        if($this->input->get('filter_hostel')!='' && $this->input->get('filter_hostel')!='All' )
        {
            $where = ['a.college_id'=>$this->input->get('filter_hostel')];
        }
        if($this->session->user_type==2)
        {
            $where['a.college_id'] = $this->session->a_college_id;
            $where2=['id' => $this->session->a_college_id];
        }
        
        $data=['val'=>'a.*,b.college_name','table'=>'tbl_slot_type a','where'=>$where,'orderby'=>'a.id','orderas'=>'DESC'];
        $join = ['table'=>'tbl_college b','on'=>'a.college_id=b.id','join_type'=>''];
        //$join2 = ['table'=>'tbl_hostel c','on'=>'a.hostel_id=c.id','join_type'=>'Left'];
        $res=$this->common->get_join($data,$join);
        if($res['res'])
        {
            $pagedata['slots']=$res['rows'];
        }
        
        $data=['val'=>'a.*,b.college_name','table'=>'tbl_custom_slot a','where'=>$where,'orderby'=>'a.id','orderas'=>'DESC'];
        $join = ['table'=>'tbl_college b','on'=>'a.college_id=b.id','join_type'=>''];
        //$join2 = ['table'=>'tbl_hostel c','on'=>'a.hostel_id=c.id','join_type'=>'Left'];
        $res=$this->common->get_join($data,$join);
        if($res['res'])
        {
            $pagedata['cslots']=$res['rows'];
        }
        
        $data=['val'=>'id,college_name','table'=>'tbl_college','where'=>$where2,'orderby'=>'id','orderas'=>'DESC'];
        $res=$this->common->get_where_all($data);
        if($res['res'])
        {
            $pagedata['colleges']=$res['rows'];
        }
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/home/slot_type_vw');
        $this->load->view('panel/footer');
    }
    
    function slot_status($id,$status)
    {
        $where = ['id'=>$id];
        if($this->session->user_type==2)
        {
            $where['college_id'] = $this->session->a_college_id;
        }
        $this->db->update('tbl_slot_type',['status'=>  $status],$where);
        $this->session->set_flashdata('msg','Status Updated');
        redirect('panel/home/slotlist');
    }
    
    function slot_delete($id)
    {
        $where = ['id'=>$id];
        if($this->session->user_type==2)
        {
            $where['college_id'] = $this->session->a_college_id;
        }
        $this->db->where($where);
        $this->db->delete('tbl_slot_type');
        $this->session->set_flashdata('msg','Slot Deleted');
        redirect('panel/home/slotlist');
    }
    
    function edit_slot()
    {
        $this->form_validation->set_rules('slot_id', 'Slot ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('slot_name', 'Slot Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('college_name', 'College name', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('hostel_name','Hostel name','trim|required|xss_clean');
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pickup_time', 'Pick UP Time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('slot_available', 'Slot Available', 'trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $where = ['id'=>$this->input->post('slot_id')];
            if($this->session->user_type==2)
            {
                $where['college_id'] = $this->session->a_college_id;
            }
            $this->db->update('tbl_slot_type',['slot_type'=>  $this->input->post('slot_name'),'college_id'=>  $this->input->post('college_name'),'start_time'=>  $this->input->post('start_time'),'end_time'=>  $this->input->post('end_time'),'pickup_time'=>  $this->input->post('pickup_time'),'slots_available'=>  $this->input->post('slot_available')],$where);
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['college_name_err'=>  form_error('college_name','<div class="err">','</div>'),'slot_name_err'=>  form_error('slot_name','<div class="err">','</div>'),
                'start_time_err'=>form_error('start_time','<div class="err">','</div>'),'end_time_err'=>form_error('end_time','<div class="err">','</div>'),'pickup_time_err'=>form_error('pickup_time','<div class="err">','</div>'),
                'slot_available_err'=>form_error('slot_available','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function add_slot()
    {
        $this->form_validation->set_rules('slot_name', 'Slot Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('college_name', 'College name', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('hostel_name','Hostel name','trim|required|xss_clean');
        $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_time', 'End Time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pickup_time', 'Pick UP Time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('slot_available', 'Slot Available', 'trim|required|xss_clean');
        if($this->form_validation->run())
        {
           
            $this->db->insert('tbl_slot_type',['slot_type'=>  $this->input->post('slot_name'),'college_id'=>  $this->input->post('college_name'),'start_time'=>  $this->input->post('start_time'),'end_time'=>  $this->input->post('end_time'),'pickup_time'=>  $this->input->post('pickup_time'),'slots_available'=>  $this->input->post('slot_available'),'status'=>1]);
            
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['college_name_err'=>  form_error('college_name','<div class="err">','</div>'),'slot_name_err'=>  form_error('slot_name','<div class="err">','</div>'),
                'start_time_err'=>form_error('start_time','<div class="err">','</div>'),'end_time_err'=>form_error('end_time','<div class="err">','</div>'),'pickup_time_err'=>form_error('pickup_time','<div class="err">','</div>'),
                'slot_available_err'=>form_error('slot_available','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function check_slot()
    {
        $res = $this->db->select('id')->from('tbl_slot_type')->where(['slot_type'=>$this->input->post('slot_name'),'college_id'=>$this->input->post('college_name')])->count_all_results();
        if($res>0)
        {
            $this->form_validation->set_message('check_slot', 'Slot with this name for this college already assigned.');
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    function edit_cslot()
    {
        $this->form_validation->set_rules('cslot_id', 'Slot ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('slot_date', 'Slot Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('college_name1', 'College name', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('hostel_name1','Hostel name','trim|required|xss_clean');
        $this->form_validation->set_rules('morning', 'Morning Slot', 'trim|required|xss_clean');
        $this->form_validation->set_rules('evening', 'Evening Slot', 'trim|required|xss_clean');
        $this->form_validation->set_rules('afternoon', 'Afternoon Slot', 'trim|required|xss_clean');
        $this->form_validation->set_rules('night', 'Night Slot', 'trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $where = ['id'=>$this->input->post('cslot_id')];
            if($this->session->user_type==2)
            {
                $where['college_id'] = $this->session->a_college_id;
            }
            $this->db->update('tbl_custom_slot',['date'=>  strtotime($this->input->post('slot_date')),'college_id'=>  $this->input->post('college_name1'),'morning'=>  $this->input->post('morning'),'afternoon'=>  $this->input->post('afternoon'),'evening'=>  $this->input->post('evening'),'night'=>  $this->input->post('night')],$where);
            echo json_encode(['status'=>TRUE]);
        }else{
             $error = ['college_name1_err'=>  form_error('college_name','<div class="err">','</div>'),'slot_date_err'=>  form_error('slot_date','<div class="err">','</div>'),
                'morning_err'=>form_error('morning','<div class="err">','</div>'),'evening_err'=>form_error('evening','<div class="err">','</div>'),'afternoon_err'=>form_error('afternoon','<div class="err">','</div>'),
                'night_err'=>form_error('night','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function add_cslot()
    {
        $this->form_validation->set_rules('slot_date', 'Slot Date', 'trim|required|xss_clean|callback_check_cslot');
        $this->form_validation->set_rules('college_name1', 'College name', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('hostel_name1','Hostel name','trim|required|xss_clean');
        $this->form_validation->set_rules('morning', 'Morning Slot', 'trim|required|xss_clean');
        $this->form_validation->set_rules('evening', 'Evening Slot', 'trim|required|xss_clean');
        $this->form_validation->set_rules('afternoon', 'Afternoon Slot', 'trim|required|xss_clean');
        $this->form_validation->set_rules('night', 'Night Slot', 'trim|required|xss_clean');
        $this->form_validation->set_rules('repeat_type', 'Repeat Type', 'trim|required|xss_clean');
        if($this->form_validation->run())
        {
                if($this->input->post('repeat_type')==1)
                {
                    $this->db->insert('tbl_custom_slot',['date'=>  strtotime($this->input->post('slot_date')),'college_id'=>  $this->input->post('college_name1'),'morning'=>  $this->input->post('morning'),'afternoon'=>  $this->input->post('afternoon'),'evening'=>  $this->input->post('evening'),'night'=>  $this->input->post('night'),'created'=>time()]);
                }elseif($this->input->post('repeat_type')==2)
                {
                    $data=[];
                    $cdate = date('Y-m-d',strtotime($this->input->post('slot_date')));
                    $edate = date('Y',strtotime($this->input->post('slot_date'))).'-12-31';
                    $day = date('w',strtotime($this->input->post('slot_date')));
                    $dates = $this->functions->get_alldate_byday($cdate,$edate,$day);
                    foreach($dates as $ndate)
                    {
                        $data[] = ['date'=>  strtotime($ndate),'college_id'=>  $this->input->post('college_name1'),'morning'=>  $this->input->post('morning'),'afternoon'=>  $this->input->post('afternoon'),'evening'=>  $this->input->post('evening'),'night'=>  $this->input->post('night'),'created'=>time()];
                    }
                    if(!empty($data))
                    {
                        $this->db->insert_batch('tbl_custom_slot',$data);
                    }
                }elseif($this->input->post('repeat_type')==3)
                {
                    $data=[];
                    $cdate = date('Y-m-d',strtotime($this->input->post('slot_date')));
                    $month = date('m',strtotime($this->input->post('slot_date')));
                    $day = date('d',strtotime($this->input->post('slot_date')));
                    $year = date('Y',strtotime($this->input->post('slot_date')));
                    for($i=$month;$i<=12;$i++)
                    {
                        if(cal_days_in_month(CAL_GREGORIAN, $i, $year)>=$day)
                        {
                            $ndate= sprintf($year.'-%02d-'.$day, $i);
                            $data[] = ['date'=>  strtotime($ndate),'college_id'=>  $this->input->post('college_name'),'morning'=>  $this->input->post('morning'),'afternoon'=>  $this->input->post('afternoon'),'evening'=>  $this->input->post('evening'),'night'=>  $this->input->post('night'),'created'=>time()];
                        }
                    }
                    if(!empty($data))
                    {
                        $this->db->insert_batch('tbl_custom_slot',$data);
                    }
                }
           
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['college_name1_err'=>  form_error('college_name','<div class="err">','</div>'),'slot_date_err'=>  form_error('slot_date','<div class="err">','</div>'),
                'morning_err'=>form_error('morning','<div class="err">','</div>'),'evening_err'=>form_error('evening','<div class="err">','</div>'),'afternoon_err'=>form_error('afternoon','<div class="err">','</div>'),
                'night_err'=>form_error('night','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function check_cslot()
    {
        $res = $this->db->select('id')->from('tbl_custom_slot')->where(['date'=>  strtotime($this->input->post('slot_date')),'college_id'=>$this->input->post('college_name')])->count_all_results();
        if($res>0)
        {
            $this->form_validation->set_message('check_slot', 'Slot with this date for this college already assigned.');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function edit_all_slot()
    {   
        $this->form_validation->set_rules('slot_name1', 'Slot Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('college_name2', 'College name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('start_time1', 'Start Time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_time1', 'End Time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pickup_time1', 'Pick UP Time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('slot_available1', 'Slot Available', 'trim|required|xss_clean');
        if($this->form_validation->run())
        {
             $hostel = $this->londury->get_hostel($this->input->post('college_name2'));
             foreach($hostel as $hos)
             {
                $hostel_sub = $this->db->select('hostel_id,id')->where(['hostel_id'=>$hos->id,'slot_type'=>$this->input->post('slot_name1')])->get('tbl_slot_type');
                if($hostel_sub->num_rows() == 1)
                {   
                    
                    $this->db->update('tbl_slot_type',['start_time'=>$this->input->post('start_time1'),'end_time'=>$this->input->post('end_time1'),'pickup_time'=>$this->input->post('pickup_time1'),'slots_available'=>$this->input->post('slot_available1')],['id'=>$hostel_sub->row()->id]);
    
                } else {
                    $this->db->insert('tbl_slot_type',['slot_type'=>  $this->input->post('slot_name1'),'college_id'=>  $this->input->post('college_name2'),'hostel_id'=>$hos->id,'start_time'=>$this->input->post('start_time1'),'end_time'=>$this->input->post('end_time1'),'pickup_time'=>$this->input->post('pickup_time1'),'slots_available'=>$this->input->post('slot_available1'),'status'=>1]);
                }
             }
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['college_name2_err'=>  form_error('college_name2','<div class="err">','</div>'),'slot_name1_err'=>  form_error('slot_name1','<div class="err">','</div>'),
                'start_time1_err'=>form_error('start_time1','<div class="err">','</div>'),'end_time1_err'=>form_error('end_time1','<div class="err">','</div>'),'pickup_time1_err'=>form_error('pickup_time1','<div class="err">','</div>'),
                'slot_available1_err'=>form_error('slot_available1','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }

    

    function cedit_all_slot()
    {
        $this->form_validation->set_rules('slot_date1', 'Slot Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('college_name3', 'College name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('morning1', 'Morning Slot', 'trim|required|xss_clean');
        $this->form_validation->set_rules('evening1', 'Evening Slot', 'trim|required|xss_clean');
        $this->form_validation->set_rules('afternoon1', 'Afternoon Slot', 'trim|required|xss_clean');
        $this->form_validation->set_rules('night1', 'Night Slot', 'trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $hostel = $this->londury->get_hostel($this->input->post('college_name3'));
            foreach($hostel as $hos)
            {
                $hostel_sub = $this->db->select('hostel_id,id')->where(['hostel_id'=>$hos->id,'date'=>strtotime($this->input->post('slot_date1'))])->get('tbl_custom_slot');
                if($hostel_sub->num_rows() == 1)
                {
                    $this->db->update('tbl_custom_slot',['date'=>  strtotime($this->input->post('slot_date1')),'morning'=>  $this->input->post('morning1'),'afternoon'=>  $this->input->post('afternoon1'),'evening'=>  $this->input->post('evening1'),'night'=>  $this->input->post('night1')],['hostel_id'=>$hos->id,'date'=>strtotime($this->input->post('slot_date1'))]);
                } else {
                    $this->db->insert('tbl_custom_slot',['date'=>  strtotime($this->input->post('slot_date1')),'college_id'=>  $this->input->post('college_name3'),'hostel_id'=>$hos->id,'morning'=>  $this->input->post('morning1'),'afternoon'=>  $this->input->post('afternoon1'),'evening'=>  $this->input->post('evening1'),'night'=>  $this->input->post('night1')]);
                }
            }
            echo json_encode(['status'=>TRUE]);
        }else{
             $error = ['college_name3_err'=>  form_error('college3_name','<div class="err">','</div>'),'slot_date1_err'=>  form_error('slot_date1','<div class="err">','</div>'),
                'morning1_err'=>form_error('morning1','<div class="err">','</div>'),'evening1_err'=>form_error('evening1','<div class="err">','</div>'),'afternoon1_err'=>form_error('afternoon1','<div class="err">','</div>'),
                'night1_err'=>form_error('night1','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }

    
    function cslot_delete($id)
    {
        $where = ['id'=>$id];
        if($this->session->user_type==2)
        {
            $where['college_id'] = $this->session->a_college_id;
        }
        $this->db->where($where);
        $this->db->delete('tbl_custom_slot');
        $this->session->set_flashdata('msg','Slot Deleted');
        redirect('panel/home/slotlist');
    }

    
    
    function shop_setting()
    {
        $where = '';
        if($this->session->user_type==2)
        {
            $where=['id' => $this->session->a_college_id];
        }
        $data=['val'=>'id,college_name','table'=>'tbl_college','where'=>$where,'orderby'=>'college_name','orderas'=>'ASC'];
        $res=$this->common->get_where_all($data);
        if($res['res'])
        {
            $pagedata['colleges']=$res['rows'];
        }
        $college_id = $res['rows'][0]->id;
        if($this->input->get('filter_setting')!='' )
        {
            $college_id = $this->input->get('filter_setting');
            if($this->session->user_type==2)
            {
                if($college_id!=$this->session->a_college_id)
                {
                    $college_id==$this->session->a_college_id;
                }
            }
            
        }
        
        $ndata = ['val'=>'options,value','where'=>['college_id'=>$college_id],'table'=>'tbl_settings'];
        $res = $this->common->get_where_all($ndata);
        if($res['res'])
        {
            $arr = [];
            foreach($res['rows'] as $result)
            {
                $arr[$result->options] = $result->value;
            }
            
            $pagedata['settings'] = $arr;
        }
        $cdata = ['val'=>'id,options,value','where'=>['college_id'=>$college_id,'options'=>'shop_close'],'table'=>'tbl_settings'];
        $resc = $this->common->get_where_all($cdata);
        if($resc['res'])
        {
            $pagedata['shop_close'] = $resc['rows'];
        }
        $pagedata['college_id'] = $college_id;
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/home/shop_setting_vw');
        $this->load->view('panel/footer');
    }

    
    
    function gensetting()
    {
        $this->form_validation->set_rules('college_id','College Name','trim|required|xss_clean');
        $this->form_validation->set_rules('shop_status','Shop Status','trim|required|xss_clean');
        $this->form_validation->set_rules('email_suffix','College Email Suffix','trim|required|xss_clean');
        $this->form_validation->set_rules('pickup_status','Pickup Status','trim|required|xss_clean');
        $this->form_validation->set_rules('dropoff_status','Dropoff Status','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_complete_msg','Complete Order Message','trim|required|xss_clean');
        $this->form_validation->set_rules('cod','COD','trim|required|xss_clean');
        $this->form_validation->set_rules('iron_price','Iron Price','trim|required|xss_clean');
        $this->form_validation->set_rules('slot_weight','Slot Weight','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_bulk_price_iron','Bulk Wash Price','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_bulk_price_fold','Bulk Wash Price Fold','trim|required|xss_clean');
        $this->form_validation->set_rules('extra_charge','Extra Charge','trim|required|xss_clean');
        $this->form_validation->set_rules('pickdrop','Pick And Drop','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_shoe_price','Shoe Wash Price','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_shoe_price_iron','Shoe Iron Price','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_pickup_reminder','Pick Up Reminder','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_dropoff_reminder','Drop Off Reminder','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_email_sms_msg_1','SMS/Email Message','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_email_sms_msg_2','SMS/Email Message','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_email_sms_msg_3','SMS/Email Message','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $college_id = $this->input->post('college_id');
            if($this->session->user_type==2)
            {
                if($college_id!=$this->session->a_college_id)
                {
                    $college_id==$this->session->a_college_id;
                }
            }
            $this->londury->update_setting('email_suffix',['college_id'=> $college_id,'options'=>'email_suffix','value'=> $this->input->post('email_suffix')]);
            $this->londury->update_setting('shop_status',['college_id'=> $college_id,'options'=>'shop_status','value'=> $this->input->post('shop_status')]);
            $this->londury->update_setting('pickup_status',['college_id'=> $college_id,'options'=>'pickup_status','value'=> $this->input->post('pickup_status')]);
            $this->londury->update_setting('dropoff_status',['college_id'=> $college_id,'options'=>'dropoff_status','value'=> $this->input->post('dropoff_status')]);
            $this->londury->update_setting('sc_complete_msg',['college_id'=> $college_id,'options'=>'sc_complete_msg','value'=> $this->input->post('sc_complete_msg')]);
            $this->londury->update_setting('cod',['college_id'=> $college_id,'options'=>'cod','value'=> $this->input->post('cod')]);
            $this->londury->update_setting('iron_price',['college_id'=> $college_id,'options'=>'iron_price','value'=> $this->input->post('iron_price')]);
            $this->londury->update_setting('slot_weight',['college_id'=> $college_id,'options'=>'slot_weight','value'=> $this->input->post('slot_weight')]);
            $this->londury->update_setting('sc_bulk_price_iron',['college_id'=> $college_id,'options'=>'sc_bulk_price_iron','value'=> $this->input->post('sc_bulk_price_iron')]);
            $this->londury->update_setting('sc_bulk_price_fold',['college_id'=> $college_id,'options'=>'sc_bulk_price_fold','value'=> $this->input->post('sc_bulk_price_fold')]);
            $this->londury->update_setting('extra_charge',['college_id'=> $college_id,'options'=>'extra_charge','value'=> $this->input->post('extra_charge')]);
            $this->londury->update_setting('pickdrop',['college_id'=> $college_id,'options'=>'pickdrop','value'=> $this->input->post('pickdrop')]);
            $this->londury->update_setting('sc_shoe_price',['college_id'=> $college_id,'options'=>'sc_shoe_price','value'=> $this->input->post('sc_shoe_price')]);
			$this->londury->update_setting('sc_shoe_price_iron',['college_id'=> $college_id,'options'=>'sc_shoe_price_iron','value'=> $this->input->post('sc_shoe_price_iron')]);
            $this->londury->update_setting('sc_pickup_reminder',['college_id'=> $college_id,'options'=>'sc_pickup_reminder','value'=> $this->input->post('sc_pickup_reminder')]);
            $this->londury->update_setting('sc_dropoff_reminder',['college_id'=> $college_id,'options'=>'sc_dropoff_reminder','value'=> $this->input->post('sc_dropoff_reminder')]);
			$this->londury->update_setting('sc_email_sms_msg_1',['college_id'=> $college_id,'options'=>'sc_email_sms_msg_1','value'=> $this->input->post('sc_email_sms_msg_1')]);
			$this->londury->update_setting('sc_email_sms_msg_2',['college_id'=> $college_id,'options'=>'sc_email_sms_msg_2','value'=> $this->input->post('sc_email_sms_msg_2')]);
			$this->londury->update_setting('sc_email_sms_msg_3',['college_id'=> $college_id,'options'=>'sc_email_sms_msg_3','value'=> $this->input->post('sc_email_sms_msg_3')]);
			$this->londury->update_setting('sc_order_reminder_msg_1',['college_id'=> $college_id,'options'=>'sc_order_reminder_msg_1','value'=> $this->input->post('sc_order_reminder_msg_1')]);
			$this->londury->update_setting('sc_order_reminder_msg_2',['college_id'=> $college_id,'options'=>'sc_order_reminder_msg_2','value'=> $this->input->post('sc_order_reminder_msg_2')]);
			$this->londury->update_setting('sc_order_reminder_msg_3',['college_id'=> $college_id,'options'=>'sc_order_reminder_msg_3','value'=> $this->input->post('sc_order_reminder_msg_3')]);
			$this->londury->update_setting('sc_drop_off_reminder_msg_1',['college_id'=> $college_id,'options'=>'sc_drop_off_reminder_msg_1','value'=> $this->input->post('sc_drop_off_reminder_msg_1')]);
			$this->londury->update_setting('sc_drop_off_reminder_msg_2',['college_id'=> $college_id,'options'=>'sc_drop_off_reminder_msg_2','value'=> $this->input->post('sc_drop_off_reminder_msg_2')]);
			$this->londury->update_setting('sc_drop_off_reminder_msg_3',['college_id'=> $college_id,'options'=>'sc_drop_off_reminder_msg_3','value'=> $this->input->post('sc_drop_off_reminder_msg_3')]);
			$this->londury->update_setting('sc_GST_Number',['college_id'=> $college_id,'options'=>'sc_GST_Number','value'=> $this->input->post('sc_GST_Number')]);
			$this->londury->update_setting('sc_SGST',['college_id'=> $college_id,'options'=>'sc_SGST','value'=> $this->input->post('sc_SGST')]);
			$this->londury->update_setting('sc_CGST',['college_id'=> $college_id,'options'=>'sc_CGST','value'=> $this->input->post('sc_CGST')]);
			$this->londury->update_setting('sc_IGST',['college_id'=> $college_id,'options'=>'sc_IGST','value'=> $this->input->post('sc_IGST')]);
            echo json_encode(['status'=>TRUE]);  
        }else{
            $error = ['college_id_err'=>  form_error('college_id','<div class="err">','</div>'),'shop_status_err'=>  form_error('shop_status','<div class="err">','</div>'),'dropoff_price_err'=>form_error('dropoff_price','<div class="err">','</div>'),
                'pickup_status_err'=>form_error('pickup_status','<div class="err">','</div>'),'dropoff_status_err'=>form_error('dropoff_status','<div class="err">','</div>'),'pickup_price_err'=>form_error('pickup_price','<div class="err">','</div>'),'email_suffix_err'=>form_error('email_suffix','<div class="err">','</div>'),
                'iron_price_err'=>form_error('iron_price','<div class="err">','</div>'),'slot_weight_err'=>form_error('slot_weight','<div class="err">','</div>'),'sc_bulk_price_err'=>form_error('sc_bulk_price','<div class="err">','</div>'),
                'extra_charge_err'=>form_error('extra_charge','<div class="err">','</div>'),'pickdrop_err'=>form_error('pickdrop','<div class="err">','</div>'),'sc_shoe_price_err'=>form_error('sc_shoe_price_iron','<div class="err">','</div>'),'sc_shoe_price_iron_err'=>form_error('sc_shoe_price_iron','<div class="err">','</div>')
                ,'sc_pickup_reminder_err'=>form_error('sc_pickup_reminder','<div class="err">','</div>'),'sc_dropoff_reminder_err'=>form_error('sc_dropoff_reminder','<div class="err">','</div>'),'sc_complete_msg_err'=>form_error('sc_complete_msg','<div class="err">','</div>'),'sc_email_sms_msg_1_err'=>form_error('sc_email_sms_msg_1','<div class="err">','</div>'),'sc_email_sms_msg_2_err'=>form_error('sc_email_sms_msg_2','<div class="err">','</div>'),'sc_email_sms_msg_3_err'=>form_error('sc_email_sms_msg_3','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }

    function deleteclose()
    {
        $this->form_validation->set_rules('id','Id','required');
        if($this->form_validation->run())
        {
            $this->londury->delete_setting(['id'=>$this->input->post('id')]);
            echo json_encode(['status'=>TRUE]);
        }
    }

    function closeshop()
    {
        $this->form_validation->set_rules('date_close','Date Close','required');
        $this->form_validation->set_rules('college_id','College Name','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $college_id = $this->input->post('college_id');
            if($this->session->user_type==2)
            {
                if($college_id!=$this->session->a_college_id)
                {
                    $college_id==$this->session->a_college_id;
                }
            }
             $this->londury->add_setting(['college_id'=> $college_id,'options'=>'shop_close','value'=> $this->input->post('date_close')]);
            echo json_encode(['status'=>TRUE]);
        }
    }

    function indisetting()
    {
        $this->form_validation->set_rules('college_id','College Name','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_indi_pant_price','Pant Price','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_indi_undergarment_price','Undergarment Price','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_indi_towels_price','Towel Price','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_indi_shirt_price','Shirt Price','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_indi_others_price','Others Price','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_indi_shirt_t_shirt','SHIRTS / T SHIRTS','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_indi_pant_trouser','PANTS / TROUSERS','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_indi_kurta','KURTA','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_indi_sweater','SWEATSHIRT / SWEATERS','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_indi_towel','TOWEL','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_indi_bedsheet','BEDSHEET','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_indi_curtains','CURTAINS','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_indi_ladies_top','LADIES TOP','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_indi_other_item','OTHER Price','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $college_id = $this->input->post('college_id');
            if($this->session->user_type==2)
            {
                if($college_id!=$this->session->a_college_id)
                {
                    $college_id==$this->session->a_college_id;
                }
            }
            $this->londury->update_setting('sc_indi_pant_price',['college_id'=> $college_id,'options'=>'sc_indi_pant_price','value'=> $this->input->post('sc_indi_pant_price')]);
            $this->londury->update_setting('sc_indi_undergarment_price',['college_id'=> $college_id,'options'=>'sc_indi_undergarment_price','value'=> $this->input->post('sc_indi_undergarment_price')]);
            $this->londury->update_setting('sc_indi_towels_price',['college_id'=> $college_id,'options'=>'sc_indi_towels_price','value'=> $this->input->post('sc_indi_towels_price')]);
            $this->londury->update_setting('sc_indi_shirt_price',['college_id'=> $college_id,'options'=>'sc_indi_shirt_price','value'=> $this->input->post('sc_indi_shirt_price')]);
            $this->londury->update_setting('sc_indi_others_price',['college_id'=> $college_id,'options'=>'sc_indi_others_price','value'=> $this->input->post('sc_indi_others_price')]);
			 $this->londury->update_setting('sc_indi_shirt_t_shirt',['college_id'=> $college_id,'options'=>'sc_indi_shirt_t_shirt','value'=> $this->input->post('sc_indi_shirt_t_shirt')]);
			 $this->londury->update_setting('sc_indi_pant_trouser',['college_id'=> $college_id,'options'=>'sc_indi_pant_trouser','value'=> $this->input->post('sc_indi_pant_trouser')]);
			 $this->londury->update_setting('sc_indi_kurta',['college_id'=> $college_id,'options'=>'sc_indi_kurta','value'=> $this->input->post('sc_indi_kurta')]);
			 $this->londury->update_setting('sc_indi_sweater',['college_id'=> $college_id,'options'=>'sc_indi_sweater','value'=> $this->input->post('sc_indi_sweater')]);
			 $this->londury->update_setting('sc_indi_towel',['college_id'=> $college_id,'options'=>'sc_indi_towel','value'=> $this->input->post('sc_indi_towel')]);
			 $this->londury->update_setting('sc_indi_bedsheet',['college_id'=> $college_id,'options'=>'sc_indi_bedsheet','value'=> $this->input->post('sc_indi_bedsheet')]);
			 $this->londury->update_setting('sc_indi_curtains',['college_id'=> $college_id,'options'=>'sc_indi_curtains','value'=> $this->input->post('sc_indi_curtains')]);
			 $this->londury->update_setting('sc_indi_ladies_top',['college_id'=> $college_id,'options'=>'sc_indi_ladies_top','value'=> $this->input->post('sc_indi_ladies_top')]);
			 $this->londury->update_setting('sc_indi_other_item',['college_id'=> $college_id,'options'=>'sc_indi_other_item','value'=> $this->input->post('sc_indi_other_item')]);
			   
            echo json_encode(['status'=>TRUE]);  
        }else{
            $error = ['college_id_err'=>  form_error('college_id','<div class="err">','</div>'),'sc_indi_pant_price_err'=>  form_error('sc_indi_pant_price','<div class="err">','</div>'),'sc_indi_undergarment_price_err'=>form_error('sc_indi_undergarment_price','<div class="err">','</div>'),
                'sc_indi_towels_price_err'=>form_error('sc_indi_towels_price','<div class="err">','</div>'),'sc_indi_shirt_price_err'=>form_error('sc_indi_shirt_price','<div class="err">','</div>'),'sc_indi_others_price_err'=>form_error('sc_indi_others_price','<div class="err">','</div>'),
				'sc_indi_shirt_t_shirt_err'=>form_error('sc_indi_shirt_t_shirt','<div class="err">','</div>'),
				'sc_indi_pant_trouser_err'=>form_error('sc_indi_pant_trouser','<div class="err">','</div>'),
				'sc_indi_kurta_err'=>form_error('sc_indi_kurta','<div class="err">','</div>'),
				'sc_indi_sweater_err'=>form_error('sc_indi_sweater','<div class="err">','</div>'),
				'sc_indi_towel_err'=>form_error('sc_indi_towel','<div class="err">','</div>'),
				'sc_indi_bedsheet_err'=>form_error('sc_indi_bedsheet','<div class="err">','</div>'),
				'sc_indi_curtains_err'=>form_error('sc_indi_curtains','<div class="err">','</div>'),
				'sc_indi_ladies_top_err'=>form_error('sc_indi_ladies_top','<div class="err">','</div>'),
				'sc_indi_other_item_err'=>form_error('sc_indi_other_item','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }

    
    function drysetting()
    {
        $this->form_validation->set_rules('college_id','College Name','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_dry_pant_price','Pant Price','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_dry_blanket_price','Undergarment Price','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_dry_suit_price','Towel Price','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_dry_shirt_price','Shirt Price','trim|required|xss_clean');
        $this->form_validation->set_rules('sc_dry_others_price','Others Price','trim|required|xss_clean');
		
		$this->form_validation->set_rules('sc_dry_shirt_t_shirt','SHIRTS / T SHIRTS','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_pant_trouser','PANTS / TROUSERS','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_shawl_stole','SHAWL / STOLE','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_kurta','KURTA','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_sarees','SAREES','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_blazer_jacket','BLAZERS / JACKETS','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_suit','SUIT (2 Pc.)','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_sweater','SWEATERS / SWEATSHIRT','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_quilt_blanket','QUILT / SINGLE BLANKET','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_curtain','CURTAINS','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_blanket_double','BLANKET (DOUBLE)','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_ladies_dress','LADIES DRESS','trim|required|xss_clean');
		$this->form_validation->set_rules('sc_dry_ohter_item','Others Price','trim|required|xss_clean');
		
        if($this->form_validation->run())
        {
            $college_id = $this->input->post('college_id');
            if($this->session->user_type==2)
            {
                if($college_id!=$this->session->a_college_id)
                {
                    $college_id==$this->session->a_college_id;
                }
            }
            $this->londury->update_setting('sc_dry_pant_price',['college_id'=> $college_id,'options'=>'sc_dry_pant_price','value'=> $this->input->post('sc_dry_pant_price')]);
            $this->londury->update_setting('sc_dry_blanket_price',['college_id'=> $college_id,'options'=>'sc_dry_blanket_price','value'=> $this->input->post('sc_dry_blanket_price')]);
            $this->londury->update_setting('sc_dry_suit_price',['college_id'=> $college_id,'options'=>'sc_dry_suit_price','value'=> $this->input->post('sc_dry_suit_price')]);
            $this->londury->update_setting('sc_dry_shirt_price',['college_id'=> $college_id,'options'=>'sc_dry_shirt_price','value'=> $this->input->post('sc_dry_shirt_price')]);
            $this->londury->update_setting('sc_dry_others_price',['college_id'=> $college_id,'options'=>'sc_dry_others_price','value'=> $this->input->post('sc_dry_others_price')]);
			
			$this->londury->update_setting('sc_dry_shirt_t_shirt',['college_id'=> $college_id,'options'=>'sc_dry_shirt_t_shirt','value'=> $this->input->post('sc_dry_shirt_t_shirt')]);
			$this->londury->update_setting('sc_dry_pant_trouser',['college_id'=> $college_id,'options'=>'sc_dry_pant_trouser','value'=> $this->input->post('sc_dry_pant_trouser')]);
			$this->londury->update_setting('sc_dry_shawl_stole',['college_id'=> $college_id,'options'=>'sc_dry_shawl_stole','value'=> $this->input->post('sc_dry_shawl_stole')]);
			$this->londury->update_setting('sc_dry_kurta',['college_id'=> $college_id,'options'=>'sc_dry_kurta','value'=> $this->input->post('sc_dry_kurta')]);
			$this->londury->update_setting('sc_dry_sarees',['college_id'=> $college_id,'options'=>'sc_dry_sarees','value'=> $this->input->post('sc_dry_sarees')]);
			$this->londury->update_setting('sc_dry_blazer_jacket',['college_id'=> $college_id,'options'=>'sc_dry_blazer_jacket','value'=> $this->input->post('sc_dry_blazer_jacket')]);
			$this->londury->update_setting('sc_dry_suit',['college_id'=> $college_id,'options'=>'sc_dry_suit','value'=> $this->input->post('sc_dry_suit')]);
			$this->londury->update_setting('sc_dry_sweater',['college_id'=> $college_id,'options'=>'sc_dry_sweater','value'=> $this->input->post('sc_dry_sweater')]);
			$this->londury->update_setting('sc_dry_quilt_blanket',['college_id'=> $college_id,'options'=>'sc_dry_quilt_blanket','value'=> $this->input->post('sc_dry_quilt_blanket')]);
			$this->londury->update_setting('sc_dry_curtain',['college_id'=> $college_id,'options'=>'sc_dry_curtain','value'=> $this->input->post('sc_dry_curtain')]);
			$this->londury->update_setting('sc_dry_blanket_double',['college_id'=> $college_id,'options'=>'sc_dry_blanket_double','value'=> $this->input->post('sc_dry_blanket_double')]);
			$this->londury->update_setting('sc_dry_ladies_dress',['college_id'=> $college_id,'options'=>'sc_dry_ladies_dress','value'=> $this->input->post('sc_dry_ladies_dress')]);
			$this->londury->update_setting('sc_dry_ohter_item',['college_id'=> $college_id,'options'=>'sc_dry_ohter_item','value'=> $this->input->post('sc_dry_ohter_item')]);
            echo json_encode(['status'=>TRUE]);  
        }else{
            $error = ['college_id_err'=>  form_error('college_id','<div class="err">','</div>'),'sc_dry_pant_price_err'=>  form_error('sc_dry_pant_price','<div class="err">','</div>'),'sc_dry_blanket_price_err'=>form_error('sc_dry_blanket_price','<div class="err">','</div>'),
                'sc_dry_suit_price_err'=>form_error('sc_dry_suit_price','<div class="err">','</div>'),'sc_dry_shirt_price_err'=>form_error('sc_dry_shirt_price','<div class="err">','</div>'),'sc_dry_others_price_err'=>form_error('sc_dry_others_price','<div class="err">','</div>'),
				
				'sc_dry_shirt_t_shirt_err'=>form_error('sc_dry_shirt_t_shirt','<div class="err">','</div>'),
				'sc_dry_pant_trouser_err'=>form_error('sc_dry_pant_trouser','<div class="err">','</div>'),
				'sc_dry_shawl_stole_err'=>form_error('sc_dry_shawl_stole','<div class="err">','</div>'),
				'sc_dry_kurta_err'=>form_error('sc_dry_kurta','<div class="err">','</div>'),
				'sc_dry_sarees_err'=>form_error('sc_dry_sarees','<div class="err">','</div>'),
				'sc_dry_blazer_jacket_err'=>form_error('sc_dry_blazer_jacket','<div class="err">','</div>'),
				'sc_dry_suit_err'=>form_error('sc_dry_suit','<div class="err">','</div>'),
				'sc_dry_sweater_err'=>form_error('sc_dry_sweater','<div class="err">','</div>'),
				'sc_dry_quilt_blanket_err'=>form_error('sc_dry_quilt_blanket','<div class="err">','</div>'),
				'sc_dry_curtain_err'=>form_error('sc_dry_curtain','<div class="err">','</div>'),
				'sc_dry_blanket_double_err'=>form_error('sc_dry_blanket_double','<div class="err">','</div>'),
				'sc_dry_ladies_dress_err'=>form_error('sc_dry_ladies_dress','<div class="err">','</div>'),
				'sc_dry_ohter_item_err'=>form_error('sc_dry_ohter_item','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
	
	
	function get_dashboard_data()
    {
        $where = ['status'=>1];
		$college_id=$this->input->post('college_id');
		if($college_id!='0' || $college_id=='')
		{
			$pagedata['college_id'] = $college_id;
			$where['college_id'] = $college_id;
			$u_data = ['where'=>$where,'table'=>'tbl_users'];
			$pagedata['u_count'] = $this->common->count_val($u_data);
			$pagedata['t_count'] = $this->londury->total_sale_accord_college($college_id)->total?$this->londury->total_sale_accord_college($college_id)->total:'0';
			$pagedata['to_count'] = $this->londury->today_order_accord_college($college_id);
			$pagedata['total_order'] = $this->londury->total_order_accord_college($college_id);
		}
		else
		{
			$pagedata['college_id']="0";
			if($this->session->user_type==2)
			{
				$where['college_id'] = $this->session->a_college_id;
			}
			$u_data = ['where'=>$where,'table'=>'tbl_users'];
			$pagedata['u_count'] = $this->common->count_val($u_data);
			$pagedata['t_count'] = $this->londury->total_sale()->total?$this->londury->total_sale()->total:'0';
			$pagedata['to_count'] = $this->londury->today_order();
			$pagedata['total_order'] = $this->londury->total_order();
		}
        echo $this->load->view('panel/home/dashboard_ajax',$pagedata);
    }
	
}