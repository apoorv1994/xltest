<?php
class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users');
        $this->load->library('functions');
        $this->users->_valid_admin();
    }


    function signup()
    {
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|alpha_numeric_spaces|xss_clean');
        $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|alpha_numeric_spaces|xss_clean');
        $this->form_validation->set_rules('emailid', 'Email ID', 'trim|required|xss_clean|valid_email|is_unique[tbl_users.email_id]');
        $this->form_validation->set_rules('dob', 'Birthday', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phonenumber', 'Phone No', 'trim|required|xss_clean|is_unique[tbl_users.phone_no]');
        $this->form_validation->set_rules('college_id', 'College', 'trim|required|xss_clean');
        $this->form_validation->set_rules('hostel_id', 'Hostel', 'trim|required|xss_clean');
        $this->form_validation->set_rules('roomnumber', 'Room Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('rollnumber', 'Roll Number', 'trim|required|xss_clean');
        $this->form_validation->set_message('is_unique', 'The %s already taken, Try another.');
        if($this->form_validation->run())
        {
            $new_dob = strtotime($this->input->post('dob')); 
            $code=rand(0000,999999);
            $profile = BASE.'assets/img/default.jpg';
            $val=['firstname'=>$this->input->post('firstname'),'lastname'=>$this->input->post('lastname'),'profile_pic'=>$profile,'email_id'=>$this->input->post('emailid'),
                'password'=>md5($code),'dob'=>$new_dob,'gender'=>$this->input->post('gender'),'roll_no'=>  $this->input->post('rollnumber'),
                'room_no'=>  $this->input->post('roomnumber'),'college_id'=>  $this->input->post('college_id'),'hostel_id'=>  $this->input->post('hostel_id'),
                'phone_no'=>  $this->input->post('phonenumber') ,'created'=>time(),'status'=>'1','verification_key'=>'0'];
            $data=['val'=>$val,'table'=>'tbl_users'];
            $id = $this->common->add_data_get_id($data);
            
            $emailid=$this->input->post('emailid');
            $dropmsg = "Hello ".$this->input->post('firstname').", Welcome to XL. Complete freedom from Laundry. Login to http://xpresslaundromat.in with Username: $emailid Password: $code Download the APP:";
            $msg = urlencode($dropmsg);
            $mobile = $this->input->post('phonenumber');
            $url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
            $res = file_get_contents($url);
                
            $message="<p>Hello ".$this->input->post('firstname')."</p><p>Your are registered with XpressLaundroMat. You can login with following details:-</p><p>Username: ".$this->input->post('emailid')."</p><p>Password: <b>$code</b></p>";
            $email=array('to'=>$this->input->post('emailid'),'message'=>$message,'subject'=>'Welcome to XpressLaundroMat');
            if($this->functions->registration_email($email))
            {
                echo json_encode(['status'=>TRUE,'id'=>$id,'name'=>$this->input->post('firstname').' '.$this->input->post('lastname'),'college'=>$this->input->post('college_id'),'hostel'=>$this->input->post('hostel_id')]);
            }else{
                echo json_encode(['status'=>TRUE,'error'=>['main_err'=>'Something went wrong, Try Again.','id'=>$id,'name'=>$this->input->post('firstname').' '.$this->input->post('lastname'),'college'=>$this->input->post('college_id')]]);
            } 
        }else{
            $error = ['firstname_err'=>  form_error('firstname','<div class="err">','</div>'),'lastname_err'=>  form_error('lastname','<div class="err">','</div>'),'emailid_err'=>form_error('emailid','<div class="err">','</div>'),
                'dob_err'=>form_error('dob','<div class="err">','</div>'),'gender_err'=>form_error('gender','<div class="err">','</div>'),'rollnumber_err'=>form_error('rollnumber','<div class="err">','</div>'),
                'phonenumber_err'=>form_error('phonenumber','<div class="err">','</div>'),'college_id_err'=>form_error('college_id','<div class="err">','</div>'),
                'hostel_id_err'=>form_error('hostel_id','<div class="err">','</div>'),'roomnumber_err'=>form_error('roomnumber','<div class="err">','</div>')];
            echo json_encode(['status'=>  FALSE,'error'=>$error]);
        }
    }

    function add_user(){
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
        
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/user/add_user_vw');
        $this->load->view('panel/footer');
    }
    
    function _get_user($page='0',$search='',$sort='a.id',$sortas='desc',$college='',$phone_no='')
    {
        $where = '';
		$where3 = '';
        if($search!='')
		{
			$where = '(concat(firstname, " ",lastname) like "'.$search.'%" or email_id like "'.$search.'%" or roll_no like "'.$search.'%" )';
		}
        if($college!='')
        {
            $where2 = ['a.college_id'=>$college];
        }
		if($phone_no!='')
        {
            $where3 = ['a.phone_no'=>$phone_no];
        }
       $count_data=['val'=>'count(a.id) as total','table'=>'tbl_users a','orderby'=>'','where'=>$where, 'where2'=>$where2, 'where3'=>$where3,'orderas'=>'','start'=>'','limit'=>''];
        $join=['table'=>'tbl_college b','on'=>'a.college_id=b.id','join_type'=>''];
        $res_count=$this->common->get_join2_modify($count_data,$join);
        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = BASE . "panel/user/user_ajax/";
        $config["total_rows"] = $res_count['rows']->total;
        $perpage=$config["per_page"] = 20;
        $config["uri_segment"] = 4;
 
        $this->pagination->initialize($config);
        $data=['val'=>'a.*,b.college_name','table'=>'tbl_users a','orderby'=>$sort,'where'=>$where, 'where2'=>$where2, 'where3'=>$where3,'orderas'=>$sortas,'start'=>$page,'limit'=>$perpage];
        $join=['table'=>'tbl_college b','on'=>'a.college_id=b.id','join_type'=>''];
        $res=$this->common->get_join_modify($data,$join);
        return ['data'=>$res,'paginate'=>$this->pagination->create_links()];
    }
    
    function index()
    {
        $pagedata['title']='Users';
        $where = ['status'=>1];
        if($this->session->user_type==2)
        {
            $where['id'] = $this->session->a_college_id;
        }
        $pagedata['colleges'] = $this->db->get_where('tbl_college',$where)->result();
        $pagedata['error']=  $this->session->flashdata('error');
        $pagedata['msg']=  $this->session->flashdata('msg');
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/user/user_vw');
        $this->load->view('panel/footer');
    }
    
    function user_ajax($id='')
    {
        if($this->input->post('phone_no')!='')
        {
            $phone_no = $this->input->post('phone_no');
        }
		if($this->input->post('search')!='')
        {
            $search = $this->input->post('search');
        }
        if($this->session->user_type==1)
        {
            $college = $this->input->post('college');
        }else{
            $college = $this->session->a_college_id;
        }
        if($id==''){$id='0';}
        $query=  $this->_get_user($id,$search,$this->input->post('sort'),$this->input->post('sortas'),$college,$phone_no);
        if($query['data']['res'])
        {$i=$id+1;
            foreach($query['data']['rows'] as $users)
            {
            ?>
            <tr>
                <td><?=$users->firstname.' '.$users->lastname?></td>
                <td><?=$users->college_name?></td>
                <td class="col-bl"><?=$users->roll_no?></td>
                <td><?=$users->email_id?></td>
                <td><i class="fa fa-inr"></i> <?=$users->wallet_balance?></td>
                <td>
                    <button class="btn btn-primary" onclick="load_walllet_modal(<?=$users->id?>)"><i class="fa fa-plus"></i> Wallet</button>
                    <a class="btn btn-success" href="<?=BASE?>panel/user/user-detail/<?=$users->id?>"><i class="fa fa-search"></i> View</a>
                    <?php if($this->session->user_type==1){?>
                    <a href="javascript:void(0)" class="btn btn-danger del" data-href="<?=BASE?>panel/user/delete/<?=$users->id?>"><i class="fa fa-trash"></i></a>
                    <?php }?>
                    <button class="btn btn-primary" onclick="load_reset_modal(<?=$users->id?>,'<?=$users->firstname." ".$users->lastname?>')"><i class="fa fa-gear"></i> Reset Password</button>
                </td>
				<td><i class="fa fa-comment" onclick="send_sms_email(<?=$users->id?>,<?=$users->college_id?>,1)"></i></td>
				<td><i class="fa fa-envelope" onclick="send_sms_email(<?=$users->id?>,<?=$users->college_id?>,2)"></i></td>
        </tr>
            <?php $i++;}?>
                <tr><td id="paginate"  colspan="7">
                        <ul class="pagination"><?=$query['paginate']?></ul>
                    </td></tr>
                <?php }else{?>
                <tr><td id="paginate"  colspan="7">No Users Found</td></tr>
                <?php }
    }
    
    function activate($id)
    {
        if(is_numeric($id))
        {
            $where = ['id'=>$id];
            if($this->session->user_type==2)
            {
                $where['college_id'] = $this->session->a_college_id;
            }
            $data=['val'=>['status'=>'1'],'where'=>$where,'table'=>'tbl_users'];
            $this->common->update_data($data);
            if($this->db->affected_rows()>0)
            {
               $this->session->set_flashdata('msg','User Activated.');
               redirect('panel/user/');
            }else{
                $this->session->set_flashdata('error','Something went wrong, Please try again.');
                redirect('panel/user/');
        }
        }else{
            $this->session->set_flashdata('error','Something went wrong, Please try again.');
               redirect('panel/user/');
        }
    }
    
    function deactivate($id)
    {
        if(is_numeric($id))
        {
            $where = ['id'=>$id];
            if($this->session->user_type==2)
            {
                $where['college_id'] = $this->session->a_college_id;
            }
            $data=['val'=>['status'=>'2'],'where'=>$where,'table'=>'tbl_users'];
            $this->common->update_data($data);
            if($this->db->affected_rows()>0)
            {
               $this->session->set_flashdata('msg','User Deactivated.');
               redirect('panel/user/');
            }else{
                $this->session->set_flashdata('error','Something went wrong, Please try again.');
                redirect('panel/user/');
        }
        }else{
            $this->session->set_flashdata('error','Something went wrong, Please try again.');
               redirect('panel/user/');
        }
    }
    
    function delete($id)
    {
        $this->users->restrict_subadmin();
        if(is_numeric($id))
        {
            $where = ['id'=>$id];
//            if($this->session->user_type==2)
//            {
//                $where['college_id'] = $this->session->a_college_id;
//            }
            $this->db->where($where);
            $this->db->delete('tbl_users');
            //echo $this->db->last_query();die;
            if($this->db->affected_rows()>0)
            {
               $this->session->set_flashdata('msg','User Deleted.');
               redirect('panel/user/');
            }else{
                $this->session->set_flashdata('error','Something went wrong, Please try again.');
                redirect('panel/user/');
        }
        }else{
            $this->session->set_flashdata('error','Something went wrong, Please try again.');
               redirect('panel/user/');
        }
    }
    
    function export()
    {
        $where = '';
        if($this->session->user_type==2)
        {
            $where=['a.college_id'=>$this->session->a_college_id];
        }
        $data=['val'=>'a.*,b.college_name,c.hostel_name','table'=>'tbl_users a','orderby'=>'a.id','where'=>$where,'orderas'=>'desc','start'=>'','limit'=>''];
        $join = ['table'=>'tbl_college b','on'=>'a.college_id=b.id','join_type'=>''];
        $join1 = ['table'=>'tbl_hostel c','on'=>'a.hostel_id=c.id','join_type'=>''];
        $res=$this->common->get_join($data,$join,$join1);
        if($res['res'])
        {
            $this->load->library("excel");
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Users');
            $this->excel->getActiveSheet()->setCellValue('A1', 'S.No.');
            $this->excel->getActiveSheet()->setCellValue('B1', 'First Name');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Last Name');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Email');
            $this->excel->getActiveSheet()->setCellValue('E1', 'DOB');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Roll No');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Gender');
            $this->excel->getActiveSheet()->setCellValue('H1', 'College Name');
            $this->excel->getActiveSheet()->setCellValue('I1', 'Hostel Name');
            $this->excel->getActiveSheet()->setCellValue('J1', 'Room No');
            $this->excel->getActiveSheet()->setCellValue('K1', 'Phone No');
            $this->excel->getActiveSheet()->setCellValue('L1', 'Wallet Balance');
            $i = 1;$j = 2;
            foreach($res['rows'] as $product)
            {
                $row = array();
                $this->excel->getActiveSheet()->setCellValue('A'.$j, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$j, $product->firstname);
                $this->excel->getActiveSheet()->setCellValue('C'.$j, $product->lastname);
                $this->excel->getActiveSheet()->setCellValue('D'.$j, $product->email_id);
                $this->excel->getActiveSheet()->setCellValue('E'.$j, date('d/m/Y',$product->dob));
                $this->excel->getActiveSheet()->setCellValue('F'.$j, $product->roll_no);
                $this->excel->getActiveSheet()->setCellValue('G'.$j, $product->gender==1?'Male':'Female');
                $this->excel->getActiveSheet()->setCellValue('H'.$j, $product->college_name);
                $this->excel->getActiveSheet()->setCellValue('I'.$j, $product->hostel_name);
                $this->excel->getActiveSheet()->setCellValue('J'.$j, $product->room_no);
                $this->excel->getActiveSheet()->setCellValue('K'.$j, $product->phone_no);
                $this->excel->getActiveSheet()->setCellValue('L'.$j, $product->wallet_balance);
                $i++;$j++;
            }
            $this->excel->stream('users.xls');
        }
    }
    
    function add_wallet()
    {
        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
        $this->form_validation->set_rules('user_id','User','trim|required|xss_clean');
        $this->form_validation->set_rules('transaction_no','MR No','trim|required|xss_clean');
        $this->form_validation->set_rules('transaction_date','Date','trim|xss_clean');
        $this->form_validation->set_rules('description','Description','trim|xss_clean');
        if($this->form_validation->run())
        {
            $where = '';
            if($this->session->user_type==2)
            {
                $where=" and college_id=".$this->session->a_college_id;
            }
            $query = "update tbl_users set wallet_balance = wallet_balance + ".$this->input->post('amount')." where id=".$this->input->post('user_id').$where;
            $res = $this->db->query($query);
            //echo $this->db->last_query();die;
            if($this->db->affected_rows()>0)
            {
                $log = 'UserID: '.$this->input->post('user_id').' Credited amount: '.$this->input->post('amount');
                $this->londury->wallet_log($log);
                $date = time();
                if($this->input->post('transaction_date')!='')
                {
                    $date = strtotime($this->input->post('transaction_date'));
                }
                $data = ['recharge_by'=>  $this->session->admin_id,'user_id'=>$this->input->post('user_id'),'amount'=>$this->input->post('amount'),'created'=>$date,'transcation_id'=>  $this->input->post('transaction_no'),'mihpayid'=>0,'payment_status'=>1,'payment_method'=>'offline','fail_reason'=>'','description'=>  $this->input->post('description')];
                $this->db->insert('tbl_transcations',$data);
            }
            $udata = $this->users->get_user('wallet_balance',$this->input->post('user_id'));
            echo json_encode(['status'=>TRUE,'balance'=>$udata->wallet_balance]);
        }else{
            $error = ['amount_err'=>  form_error('amount','<div class="err">','</div>'),'user_id_err'=>  form_error('user_id','<div class="err">','</div>'),
                'transaction_no_err'=>  form_error('transaction_no','<div class="err">','</div>'),'transaction_date_err'=>  form_error('transaction_date','<div class="err">','</div>'),'description_err'=>  form_error('description','<div class="err">','</div>')];
            echo json_encode(['status'=>  FALSE,'error'=>$error]);
        }
    }

    function update_user()
    {
        $this->form_validation->set_rules('firstname','First Name','trim|required|xss_clean');
        $this->form_validation->set_rules('u_user_id','User','trim|required|xss_clean');
        $this->form_validation->set_rules('lastname','Last Name','trim|required|xss_clean');
        $this->form_validation->set_rules('emailid','Email Id','trim|required|xss_clean');
        $this->form_validation->set_rules('phone_no','Phone No','trim|required|xss_clean');
        $this->form_validation->set_rules('room_no','Room No','trim|required|xss_clean');
		$this->form_validation->set_rules('hostel_id','Hostel','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $res = $this->db->update('tbl_users',['firstname'=>$this->input->post('firstname'),'lastname'=>$this->input->post('lastname'),'email_id'=>$this->input->post('emailid'),'phone_no'=>$this->input->post('phone_no'),'room_no'=>$this->input->post('room_no'),'hostel_id'=>$this->input->post('hostel_id')],['id'=>$this->input->post('u_user_id')]);
            echo json_encode(['status'=>TRUE]);
        }
        else
        {
            $error = ['firstname_err'=>  form_error('firstname','<div class="err">','</div>'),'lastname_err'=>  form_error('lastname','<div class="err">','</div>'),
                'emailid_err'=>  form_error('emailid','<div class="err">','</div>'),'phone_no_err'=>  form_error('phone_no','<div class="err">','</div>'),'room_no_err'=>  form_error('room_no','<div class="err">','</div>'),'hostel_id_err'=>  form_error('hostel_id','<div class="err">','</div>')];
            echo json_encode(['status'=>  FALSE,'error'=>$error]);
        }
    }
    
    function change_user_password()
    {
        $this->form_validation->set_rules('password','Password','trim|required|matches[cpassword]');
        $this->form_validation->set_rules('cpassword','Password','trim|required');
        $this->form_validation->set_rules('user_id','User','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $where = ['id'=>  $this->input->post('user_id')];
            if($this->session->user_type==2)
            {
                $where['college_id']=$this->session->a_college_id;
            }
            $data = ['val'=>['password'=>md5($this->input->post('password'))],'where'=>$where,'table'=>'tbl_users'];
            $this->common->update_data($data);
			
			$userInfo=$this->londury->get_user_detail($this->input->post('user_id'));
			$pass=$this->input->post('password');
			$uname=$userInfo->email_id;
			$dropmsg = "Hello ".$userInfo->firstname.", Your XL password has been reset. Please logon to http://xpresslaundromat.in with username: $uname, password : $pass. Please reset your password on first use.";
			$msg = urlencode($dropmsg);
			$mobile = $userInfo->phone_no;
			$url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
			$res = file_get_contents($url);
			
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['password_err'=>  form_error('password','<div class="err">','</div>'),'cpassword_err'=>  form_error('cpassword','<div class="err">','</div>')];
            echo json_encode(['status'=>  FALSE,'error'=>$error]);
        }
    }
    
    function import_users()
    {
        $this->form_validation->set_rules('college_id','College Name','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $chk = TRUE;
            if($this->session->user_type==2)
            {
                if($this->input->post('college_id')!=$this->session->a_college_id)
                {
                    $chk = FALSE;
                }
            }
            if($chk)
            {
                $hostellist=[];
                $res = $this->londury->get_hostel($this->input->post('college_id'));
                if($res)
                {
                    foreach($res as $hostel)
                    {
                        $hostellist[$hostel->id] = $hostel->hostel_name;
                    }
                }

                $data = $this->functions->import_csv('fwallet');
                if($data['status'])
                {
                    $new_data=$email=[];
                    foreach($data['data'] as $user)
                    {
                        $check = ['val'=>'id','where'=>['email_id'=>$user['email_id']],'table'=>'tbl_users'];
                        $c_res = $this->common->get_verify($check);
                        if($c_res['res'])
                        {
                            $email[]=$user['email_id'];
                        }else{
                            if(array_search($user['hostel'], $hostellist))
                            {
                                $user['hostel_id'] = $user['hostel'];
                            }else{
                                $user['hostel_id'] =0;
                            }
                            unset($user['hostel']);
                            $user['password'] = md5($user['password']);
                            $user['dob'] = strtotime($user['dob']);
                            $user['status']=1;
                            $user['college_id'] = $this->input->post('college_id');
                            $user['profile_pic']=BASE.'assets/img/default.png';
                            $user['created'] = time();
                            $user['gender']= strtolower($user['gender'])=='male'?1:2;
                            $user['verification_key'] = 0;
                            $new_data[]=$user;
                        }
                    }
                    if(!empty($new_data))
                    {
                        $this->db->insert_batch('tbl_users',$new_data);
                    }
                    if(!empty($email))
                    {
                        $e_email = implode(',', $email);
                        $this->session->set_flashdata('error',$e_email.' are already existed, So these users are ignored');
                    }
                    $this->session->set_flashdata('msg','User imported Successfully');
                    redirect('panel/user');
                }else{
                    $this->session->set_flashdata('error',$data['error']);
                    redirect('panel/user');
                }
            }else{
                $this->session->set_flashdata('error','Invalid Request');
                    redirect('panel/user');
            }
        }else{
            $this->session->set_flashdata('error',  validation_errors('<p class="err">','</p>'));
            redirect('panel/user');
        }
    }
    
    function user_detail($id)
    {
        $pagedata['title']='User Detail';
        $pagedata['details'] = $this->londury->get_user_detail($id);
		$pagedata['hostel_details'] = $this->londury->get_hostel_list();
        $chk = TRUE;
        if($this->session->user_type==2)
        {
            if($pagedata['details']->college_id!=$this->session->a_college_id)
            {
                $chk = FALSE;
            }
        }
        if($chk)
        {
            $pagedata['last_order'] = $this->londury->get_lastorder_day($id);
            $pagedata['order_history'] = $this->londury->order_history($id,'no');
            $pagedata['online_recharge'] = $this->londury->get_online_detail($id);
            $pagedata['offline'] = $this->londury->get_offline_detail($id);
            $pagedata['booktype'] = [1=>'Bulk Wash',2=>'Premium Wash',3=>'Dry Cleaning',4=>'Individual Wash'];
			$pagedata['iron_price'] = $this->londury->get_options('iron_price',  $pagedata['details']->college_id);
            $slots = $this->londury->get_slot($pagedata['details']->college_id);
            $newarr = [];
            foreach($slots as $slot)
            {
                switch($slot->slot_type)
                {
                    case 'Morning':
                        $newarr[1]=$slot->start_time;
                        break;
                    case 'Afternoon':
                        $newarr[2]=$slot->start_time;
                        break;
                    case 'Evening':
                        $newarr[3]=$slot->start_time;
                        break;
                    case 'Night':
                        $newarr[4]=$slot->start_time;
                        break;

                }
            }
            $pagedata['slots'] = $newarr;
            //echo json_encode($pagedata);
            $this->load->view('panel/header',$pagedata);
            $this->load->view('panel/user/userdetail_vw');
            $this->load->view('panel/footer');
        }else{
            $this->session->set_flashdata('error','Invalid Request');
            redirect('panel/user');
        }
        
    }
    
    function user_status($id,$status)
    {
        $where = ['id'=>$id];
        if($this->session->user_type==2)
        {
            $where['college_id']=$this->session->a_college_id;
        }
        $this->db->update('tbl_users',['status'=>$status],$where);
        $this->session->set_flashdata('msg','User Status changed.');
        redirect('panel/user/user-detail/'.$id);
    }
    
    function adminlist()
    {
        $this->users->restrict_subadmin();
        $pagedata['colleges'] = $this->db->get_where('tbl_college',['status'=>1])->result();
        $pagedata['admins'] = $this->londury->get_admin();
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/user/admin_vw');
        $this->load->view('panel/footer');
    }
    
    function change_admin_password()
    {
        $this->users->restrict_subadmin();
        $this->form_validation->set_rules('password','Password','trim|required|matches[cpassword]');
        $this->form_validation->set_rules('cpassword','Password','trim|required');
        $this->form_validation->set_rules('user_id','User','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $data = ['val'=>['password'=>md5($this->input->post('password'))],'where'=>['id'=>  $this->input->post('user_id')],'table'=>'tbl_admin'];
            $this->common->update_data($data);
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['password_err'=>  form_error('password','<div class="err">','</div>'),'cpassword_err'=>  form_error('cpassword','<div class="err">','</div>')];
            echo json_encode(['status'=>  FALSE,'error'=>$error]);
        }
    }
    
    function add_admin()
    {
        $this->users->restrict_subadmin();
        $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
        $this->form_validation->set_rules('email','Username','trim|required|xss_clean|is_unique[tbl_admin.email]');
        $this->form_validation->set_rules('admin_type','Admin Type','trim|required|xss_clean');
        $this->form_validation->set_rules('college_id','College','trim|xss_clean');
        $this->form_validation->set_rules('password','Password','trim|required|matches[cpassword]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required');
        if($this->form_validation->run())
        {
            $college_id = $this->input->post('college_id');   
            $data = ['name'=>$this->input->post('name'),'email'=>$this->input->post('email'),'user_type'=>$this->input->post('admin_type')
                    ,'college_id'=>$college_id,'password'=>md5($this->input->post('password')),'status'=>1,'created'=>time()];
                $this->db->insert('tbl_admin',$data);
            $message="<p>Hello ".$this->input->post('name')."</p><p>Your are registered with XpressLaundroMat as Subadmin. You can login with following details:-</p><p>Username: ".$this->input->post('email')."</p><p>Password: <b>".$this->input->post('password')."</b></p>";
            $email=array('to'=>$this->input->post('email'),'message'=>$message,'subject'=>'Welcome to XpressLaundroMat');
            //$this->functions->_email($email);
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['name_err'=>  form_error('name','<div class="err">','</div>'),'email_err'=>  form_error('email','<div class="err">','</div>'),
                'college_id_err'=>  form_error('college_id','<div class="err">','</div>'),'password1_err'=>  form_error('password','<div class="err">','</div>'),'cpassword1_err'=>  form_error('cpassword','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function edit_admin()
    {
        $this->users->restrict_subadmin();
        $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
        $this->form_validation->set_rules('email','Username','trim|required|xss_clean');
        $this->form_validation->set_rules('admin_type','Admin Type','trim|required|xss_clean');
        
            $this->form_validation->set_rules('college_id','College','trim|required|xss_clean');
        
        $this->form_validation->set_rules('admin_id','User','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            
                $college_id = $this->input->post('college_id');
           
            $data = ['name'=>$this->input->post('name'),'email'=>$this->input->post('email'),'college_id'=>$college_id,'user_type'=>$this->input->post('admin_type')];
                $this->db->update('tbl_admin',$data,['id'=>  $this->input->post('admin_id')]);
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['name_err'=>  form_error('name','<div class="err">','</div>'),'email_err'=>  form_error('email','<div class="err">','</div>'),
                'college_id_err'=>  form_error('college_id','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function admin_status($id,$status)
    {
        $this->users->restrict_subadmin();
        $this->db->update('tbl_admin',['status'=>$status],['id'=>$id]);
        $this->session->set_flashdata('msg','User Status changed.');
        redirect('panel/user/adminlist');
    }
    
    function admin_delete($id)
    {
        $this->users->restrict_subadmin();
        if(is_numeric($id))
        {
            $this->db->where('id',  $id);
            $this->db->delete('tbl_admin');
            if($this->db->affected_rows()>0)
            {
               $this->session->set_flashdata('msg','User Deleted.');
               redirect('panel/user/adminlist');
            }else{
                $this->session->set_flashdata('error','Something went wrong, Please try again.');
                redirect('panel/user/adminlist');
        }
        }else{
            $this->session->set_flashdata('error','Something went wrong, Please try again.');
               redirect('panel/user/adminlist');
        }
    }
	
	function sms_email_template()
	{
		$college_id=$this->input->post('college_id');
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
		$pagedata['option1']="Option 1";
		$pagedata['option2']="Option 2";
		$pagedata['option3']="Option 3";
		$pagedata['option4']="Custom";
		$pagedata['option5']="Upload File";
		$pagedata['email_sms_msg']="email_sms_msg";
		$pagedata['college_id']=$college_id;
		$pagedata['college_id']=$college_id;
		$pagedata['user_id']=$this->input->post('user_id');
		$pagedata['college_id']=$college_id;
		$pagedata['type']=$this->input->post('type');
		echo $this->load->view('panel/user/sms_email_vw',$pagedata);
	}
	
	function send_auto_mail()
    {
		$college_id = $this->input->post('college_id');
		$type = $this->input->post('type'); 
		$user_id = $this->input->post('user_id');
		$message_type = $this->input->post('message_type');		
		$msg=$this->input->post('message_'.$message_type);
		$subject=$this->input->post('subject');		
		if($type=='1')
		{
			$this->db->where('id',$user_id);
			$this->db->where('college_id',$college_id);
			$res = $this->db->get('tbl_users');
			if($res->num_rows()>0)
			{
				foreach($res->result() as $data)
				{
					$name=$data->firstname;
					$email=$data->email_id;
					$phone_no=$data->phone_no;
				}
				$msgs = urlencode("Hello ".$name.", ".$msg);
				$mobile = $phone_no;
				$url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msgs&title=XLOMAT";
				//$res = $this->functions->_curl_request($url);
				$res = file_get_contents($url);
				echo json_encode(['data'=>'Message Successfully Sended','errorcode'=>'101','success'=>'true']);
			}
			else
				echo json_encode(['data'=>'Message failed','errorcode'=>'100','success'=>'false']);
		}
		else if($type=='2')
		{
			$this->db->where('id',$user_id);
			$this->db->where('college_id',$college_id);
			$res = $this->db->get('tbl_users');
			if($res->num_rows()>0)
			{
				foreach($res->result() as $data)
				{
					$name=$data->firstname." ".$data->lastname;
					$email=$data->email_id;
				}
				$message="<p>Hello ".$name.",</p><p>".$msg."</p>";
				
				if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0 && $message_type=='5'){
					$emails=array('to'=>$email,'message'=>$message,'subject'=>$subject);
					$saveImage=$this->functions->upload_reminder_doc("photo","uploads","0","*");
					$emails['filename']=$saveImage['filename'];
					$msgres=$this->functions->send_auto_email_with_attach($emails);
					
				}
				else
				{
					$emails=array('to'=>$email,'message'=>$message,'subject'=>$subject);
					$msgres=$this->functions->send_auto_email($emails);
				}
				if($msgres)
					echo json_encode(['data'=>'Mail Successfully Sended','errorcode'=>'101','success'=>'true']);
				else
					echo json_encode(['data'=>'Mail failed','errorcode'=>'102','success'=>'false']);
			}
			else
				echo json_encode(['data'=>'Message failed','errorcode'=>'100','success'=>'false']);
		}
		
        
    }
}