<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth extends CI_Controller {
    public function __construct()
    {
        parent::__construct(); 
        $this->load->library('users');
    }
    
    function _is_logged()
    {
        if($this->session->user_id)
        {
            redirect('home');
        }
    }
    
    function _login($username,$password)
    {
        $where="(email_id='".strtolower($username)."' or phone_no='".$username."') and password='$password' and status='1'";
        $data=array('val'=>'id,email_id,college_id','table'=>'tbl_users','where'=>$where);
        $log= $this->common->signin($data);
		//print_r($log);
        if($log['res'])
        {
           return ['status'=>true,'data'=>$log['rows']];
        }
        else{
            return ['status'=>false];
        }
    }
    
    function index()
    {
        if($this->input->get('redir'))
        {
            $redi = $this->input->get('redir');
            $this->session->set_userdata('redir',$redi);
        }
        $this->_is_logged();
        
        
        $pagedata['title']='Login';
        $pagedata['colleges'] = $this->db->get_where('tbl_college',['status'=>1])->result();
        $this->load->view('header_vw',$pagedata);
        $this->load->view('auth/index_vw');
        $this->load->view('footer_vw');
    }

    function test()
    {
        $user = $this->londury->check_order_history(1);
        echo json_encode($user);
    }

    function get_location_info()
    {

        $res = $this->londury->get_state();

        if($res)
        {
            echo json_encode(['status'=>TRUE,'data'=>$res]);
        }else{
            echo json_encode(['status'=>FALSE]);
        }
    }

    function get_college($id)
    {
        $res = $this->db->select('id,college_name,Longitude,latitude,Radius')
                        ->where(['area_code'=>$id])
                        ->order_by('college_name','ASC')
                        ->get('tbl_college')
                        ->result();
        if($res)
        {
            echo json_encode(['status'=>TRUE,'data'=>$res]);
        }else{
            echo json_encode(['status'=>FALSE]);
        }        
    }

    function wallet_correct() 
    {
        $res = $this->db->query('SELECT * FROM tbl_users');
        foreach ($res->result() as $row)
        {   $plus = 0;
            $minus = 0;
            $id = $row->id;
            $debit = $this->londury->check_order_history($id);
            foreach ($debit as $deb)
            {
                if($deb->status!=6)
                {  
                    $amt = $deb->final_amount?$deb->final_amount:$deb->total_amount;
                    $minus = $minus + $amt;
                }
            }

            $online = $this->londury->get_online_detail($id);
            foreach ($online as $cre)
            {
                $plus = $plus + $cre->amount;
            }

            $ofline = $this->londury->get_offline_detail($id);
            foreach ($ofline as $cre)
            {
                $plus = $plus + $cre->amount;
            }
            $final = $plus - $minus;
            if($row->wallet_balance!=$final)
            {
                $this->londury->update_wallet_by_id($final,$id);

            }
        }
        echo "Done";
    }
    
    function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if($this->form_validation->run())
        {
            $username=  $this->input->post('email');
            $password= ($this->input->post('password'));
            $log_check=$this->_login($username, $password);
            if($log_check['status'])
            {
                $res=$this->_verify_user('0',$log_check['data']->email_id);
                if($res['res'])
                {
                    $this->session->unset_userdata('admin_id');
                    $this->session->set_userdata('user_id',$log_check['data']->id);
                    $this->session->set_userdata('college_id',$log_check['data']->college_id);
                    echo json_encode(['status'=>TRUE,'rdir'=>BASE.'home']);
//                    if($this->session->redir)
//                    {
//                        $redirect = $this->session->redir;
//                        $this->session->unset_userdata('redir');
//                        echo json_encode(['status'=>TRUE,'rdir'=>$redirect]);
//                    }else{
//                        echo json_encode(['status'=>TRUE,'rdir'=>BASE.'home']);
//                    }
                }
                else{
                        $this->session->set_userdata('verify_email',$log_check['data']->email_id);
                        echo json_encode(['status'=>TRUE,'rdir'=>BASE.'auth/verify-email']);
                    }
            }else{
                echo json_encode(['status'=>FALSE,'error'=>'<span class="err">Username or Password is wrong.</span>']);
            }
        }else{
            echo json_encode(['status'=>FALSE,'error'=>  validation_errors('<span class="err">','</span>')]);
        }
    }
    
    function check_email()
    {
        $acn =TRUE;
        $college = $this->input->post('college_id');
//        $email = explode('@',$this->input->post('emailid'));
//        if($college==3)
//        {
//            $acn = TRUE;
//        }
//        $check = $this->db->select('id')->from('tbl_settings')->where(['college_id'=>$college,'options'=>'email_suffix','value'=>  '@'.$email[1]])->get();
//        if($check->num_rows()>0){
//            $acn = TRUE;
//        }
        if($acn){
            $res = $this->db->select('id')->from('tbl_users')->where(['college_id'=>$college,'email_id'=>  $this->input->post('emailid')])->get();
            if($res->num_rows()==0)
            {
                return TRUE;
            }else{
                $this->form_validation->set_message('check_email','The %s already taken, Try another.');
                return FALSE;
            }
        }else{
            $this->form_validation->set_message('check_email','Invalid email suffix.');
            return FALSE;
        }
    }
    
    function signup()
    {
        $this->_is_logged();
        $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces|xss_clean');
        //$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|alpha_numeric_spaces|xss_clean');
        $this->form_validation->set_rules('college_id', 'College', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email_id', 'Email ID', 'trim|required|xss_clean|valid_email|callback_check_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[20]|matches[cpassword]');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('dob', 'Birthday', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phonenumber', 'Phone No', 'trim|required|numeric|xss_clean|is_unique[tbl_users.phone_no]');
        $this->form_validation->set_rules('hostel_id', 'Hostel', 'trim|required|xss_clean');
        $this->form_validation->set_rules('state_id', 'City Name', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('rollnumber', 'Roll Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('terms', 'Terms and Condition', 'trim|required|xss_clean');
//        $this->form_validation->set_message('is_unique', 'The %s already taken, Try another.');
        if($this->form_validation->run())
        {
            //$new_dob = strtotime($this->input->post('dob')); 
            $code=rand(0000,999999);
            $profile = BASE.'assets/img/default.jpg';
            $val=['name'=>$this->input->post('firstname'),'profile_pic'=>$profile,'email_id'=>$this->input->post('emailid'),'password'=>md5($this->input->post('password')),'college_id'=>  $this->input->post('college_id'),'hostel_id'=>  $this->input->post('hostel_id'),'phone_no'=>  $this->input->post('phonenumber') ,'created'=>time(),'status'=>'1','verification_key'=>$code];
            $data=['val'=>$val,'table'=>'tbl_users'];
            $this->common->add_data($data);
			
				$emailid=$this->input->post('emailid');
				$pass=$this->input->post('password');
				$dropmsg1 = "Hello ".$this->input->post('firstname').", Welcome to XL. Complete freedom from Laundry. Login to http://xpresslaundromat.in with Username: $emailid Password: $pass Download the APP:";
                $msg1 = urlencode($dropmsg1);       
                $mobile1 = $this->input->post('phonenumber');
                $url1 = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile1&msg=$msg1&title=XLOMAT";
				$res1 = file_get_contents($url1);
            
                $dropmsg = "Hello ".$this->input->post('firstname')." Your Verification code for Xpress Laundromat is $code";
                $msg = urlencode($dropmsg);
                $mobile = $this->input->post('phonenumber');
                $url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
				$res = file_get_contents($url);
			
				
            $message="Hello ".$this->input->post('firstname').",<br>Your Verification code for Xpress Laundromat is <b>$code</b>";
            $email=array('to'=>$this->input->post('emailid'),'message'=>$message,'subject'=>'Verify Your Account');
            $this->functions->registration_email($email);
            if($res)
            {
                $this->session->set_userdata('verify_email',$this->input->post('emailid'));
                echo json_encode(['status'=>TRUE]);
            }else{
                echo json_encode(['status'=>FALSE,'error'=>['main_err'=>'Something went wrong, Try Again.']]);
            } 
        }else{
            $error = ['firstname_err'=>  form_error('firstname','<div class="err">','</div>'),'emailid_err'=>form_error('email_id','<div class="err">','</div>'),
                'phonenumber_err'=>form_error('phonenumber','<div class="err">','</div>'),'college_id_err'=>form_error('college_id','<div class="err">','</div>'),
                'state_id_err'=>form_error('state_id','<div class="err">','</div>'),'hostel_id_err'=>form_error('hostel_id','<div class="err">','</div>'),
                'password_err'=>form_error('password','<div class="err">','</div>'),'cpassword_err'=>form_error('cpassword','<div class="err">','</div>'),
                'terms_err'=>form_error('terms','<div class="err">','</div>')];
            echo json_encode(['status'=>  FALSE,'error'=>$error]);
        }
    }
    
    function _verify_user($code,$email)
    {
        $data=['val'=>'id,college_id','where'=>['verification_key'=>  $code,'email_id'=>  $email],'table'=>'tbl_users'];
        return $this->common->get_verify_data($data);
    }
    
    function verify_email()
    {
        if($this->session->verify_email)
        {
            $this->form_validation->set_rules('code','Verification Code','trim|required|xss_clean');
            if($this->form_validation->run())
            {
                $res=$this->_verify_user($this->input->post('code'),$this->session->verify_email);
                if($res['res'])
                {
                    $up=['val'=>['verification_key'=>'0'],'table'=>'tbl_users','where'=>['email_id'=>  $this->session->verify_email]];
                    $this->common->update_data($up);
                    $data=['user_id'=>$res['rows']->id];
                    $this->session->set_userdata('college_id',$res['rows']->college_id);
                    $this->session->set_userdata($data);
                    $this->session->unset_userdata('verify_email');
                    if($this->session->redir)
                    {
                        $redirect = $this->session->redir;
                        $this->session->unset_userdata('redir');
                        redirect($redirect);
                    }else{
                        redirect('auth');
                    }
                }else
                {
                $this->session->set_flashdata('error','You code is invalid.');
                redirect('auth/verify-email');
                }
            }
            
            $pagedata['title']='Verify Your Email';
            $this->load->view('header_vw',$pagedata);
            $this->load->view('auth/verify_email_vw');
            $this->load->view('footer_vw');
        }else{
            redirect('auth');
        }
    }
    
    function resend_to_email()
    {
        $this->_is_logged();
        if($this->session->has_userdata('verify_email'))
        {
            $user = $this->db->get_where('tbl_users',['email_id'=>$this->session->has_userdata('verify_email')])->row();
            $code=substr(md5(rand(000,9999)),5,6);
            //sms
            $dropmsg = "Hello ".$user->firstname." Your Verification code for xpresslaundromat is $code";
            $msg = urlencode($dropmsg);
            $mobile = $user->phone_no;
            $url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
            //$res = $this->functions->_curl_request($url);
			$res = file_get_contents($url);
            //email settings
            $message="Hello User<br>Your Verification code is <b>$code</b>";
            $email=array('to'=>$this->session->userdata('verify_email'),'message'=>$message,'subject'=>'Verify your account');
            //$this->functions->_email($email);
            if($res)
            {
                $new_data=array('val'=>array('verification_key'=>$code),'where'=>array('email_id'=>$this->session->userdata('verify_email')),'table'=>'tbl_users');
                if($this->common->update_data($new_data))
                {
                    $this->session->set_flashdata('msg','New code sent to your mail id and mobile no');
                    redirect('auth/verify-email', 'refresh');
                }
            }else{
                $this->session->set_flashdata('err','Something went wrong, Please try again.');
                    redirect('auth/verify-email', 'refresh');
            }
        }else{ 
            redirect(BASE); 
        }
    }

    
    function forgot_password() 
    {
        $this->_is_logged();
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
        if($this->form_validation->run() == false)
        {
            $pagedata['msg']=  $this->session->flashdata('err');
            $pagedata['title'] = 'Forgot Password ';
            $this->load->view('header_vw',$pagedata);
            $this->load->view('auth/forgot_vw');
            $this->load->view('footer_vw');
        }
        else
        {
            $data=array('val'=>'id,phone_no,firstname','table'=>'tbl_users','where'=>array('email_id'=>$this->input->post('email')));     
            $forgotten = $this->common->get_where($data);
            
            if($forgotten['res'])
            {
                $code=substr(md5(rand(000,9999)),5,6);
                $message="Hello User<br>Your Password reset code is <b>$code</b>";
                $email=array('to'=>$this->input->post('email'),'message'=>$message,'subject'=>'Reset password code');
                //$this->functions->_email($email);
                        //echo $this->email->print_debugger();die;
                $dropmsg = "Hello ".$forgotten['rows']->firstname.", Your Verification code for reset password is $code";
                $msg = urlencode($dropmsg);
                $mobile = $forgotten['rows']->phone_no;
                $url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
                //$res = $this->functions->_curl_request($url);
				$res = file_get_contents($url);
                //$this->functions->_email($email);
                if($res)
                {
                    $new_data=array('val'=>array('forgot_key'=>$code),'where'=>array('email_id'=>$this->input->post('email')),'table'=>'tbl_users');
                    if($this->common->update_data($new_data))
                    {
                    $this->session->set_userdata('verify',$this->input->post('email'));
                    redirect('auth/verify-code', 'refresh');
                    }

                }
            }else
            {
                $this->session->set_flashdata('error','Email does not exist.');
                redirect(BASE."auth/forgot-password", 'refresh');
            }
        }
    }
    
    function verify_code()
    {
        $this->_is_logged();
        if($this->session->userdata('verify'))
        {
            $this->form_validation->set_rules('code', 'Verification Code', 'trim|required');
            if ($this->form_validation->run())
            {
                $data=array('val'=>'id','where'=>array('email_id'=>$this->session->userdata('verify'),'forgot_key'=>$this->input->post('code')),'table'=>'tbl_users');
                $res=$this->common->get_verify($data);
                if($res['res'])
                {
                    $new_data=array('val'=>array('forgot_key'=>'0'),'where'=>array('email_id'=>$this->session->userdata('verify')),'table'=>'tbl_users');
                    $this->common->update_data($new_data);
                    if($this->db->affected_rows()>0)
                    {
                        $this->session->set_userdata('reset',$this->session->userdata('verify'));
                        $this->session->unset_userdata('verify');
                        redirect("auth/reset-password", 'refresh');

                    }else{
                    $this->session->set_flashdata('err','Invalid code,Please try again with valid code.');
                    redirect("auth/verify-code", 'refresh');
                }
                }else{
                    $this->session->set_flashdata('err','Invalid code,Please try again with valid code.');
                    redirect("auth/verify-code", 'refresh');
                }
            }
            $pagedata['msg']= $this->session->flashdata('err');
            $pagedata['title'] = 'Verify Code ';
            $this->load->view('header_vw',$pagedata);
            $this->load->view('auth/verify_vw');
            $this->load->view('footer_vw');
        }else{ redirect(BASE,'refresh'); }
    }
        
    function resend()
    {
        $this->_is_logged();
        if($this->session->userdata('verify'))
        {
            $user = $this->db->get_where('tbl_users',['email_id'=>$this->session->has_userdata('verify')])->row();
            
            $code=substr(md5(rand(000,9999)),5,6);
             //sms
            $dropmsg = "Hello ".$user->firstname." Your Verification code for xpresslaundromat is $code";
            $msg = urlencode($dropmsg);
            $mobile = $user->phone_no;
            $url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
            //$res = $this->functions->_curl_request($url);
			$res = file_get_contents($url);
            
            $message="Hello User<br>Your Password reset code is <b>$code</b>";
            $email=array('to'=>$this->session->userdata('verify'),'message'=>$message,'subject'=>'Reset password code');
            //$this->functions->_email($email);
            if($res)
            {
                $new_data=array('val'=>array('forgot_key'=>$code),'where'=>array('email_id'=>$this->session->userdata('verify')),'table'=>'tbl_users');
                if($this->common->update_data($new_data))
                {
                    $this->session->set_flashdata('msg','New code sent to your registered mail id and mobile no');
                    redirect('auth/verify-code', 'refresh');
                }
            }else{
                $this->session->set_flashdata('err','Something went wrong, Please try again.');
                redirect('auth/verify-code');
            }
        }else{ redirect(BASE,'refresh'); }
    }
        
    function reset_password()
    {
        $this->_is_logged();
       if($this->session->userdata('reset'))
        {
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[20]|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');
            if($this->form_validation->run() == false)
            {
                $pagedata['title'] = 'Reset Password';
                $this->load->view('header_vw',$pagedata);
                $this->load->view('auth/reset_password_vw');
                $this->load->view('footer_vw');

            }
            else{
                    $new_data=array('val'=>array('password'=>md5($this->input->post('password'))),'where'=>array('email_id'=>$this->session->userdata('reset')),'table'=>'tbl_users');
                    $this->common->update_data($new_data);
					
					$user = $this->db->get_where('tbl_users',['email_id'=>$this->session->userdata('reset')])->row();
					$pass=$this->input->post('password');
					$uname=$this->session->userdata('reset');
					$dropmsg = "Hello ".$user->firstname.", Your XL password has been reset. Please logon to http://xpresslaundromat.in with username: $uname, password : $pass. Please reset your password on first use.";
					$msg = urlencode($dropmsg);
					$mobile = $user->phone_no;
					$url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
					//$res = $this->functions->_curl_request($url);
					$res = file_get_contents($url);
			
                    $message="Hello User<br>Your Password has been successfully changed.";
                    $email=array('to'=>$this->session->userdata('reset'),'message'=>$message,'subject'=>'Password Changed Successfully');
                    if($this->functions->_email($email))
                    {
                        $this->session->unset_userdata('reset');
                        $this->session->set_flashdata('msg','Password Successfully changed, Please Login with new password.');
						redirect(BASE,'refresh');
                    }
					redirect(BASE,'refresh');
            }
        }else{ redirect(BASE,'refresh'); }
    }
                
    function logout()
    {
        $this->session->sess_destroy();
        redirect(BASE);
    }
    
    function get_hostel($id)
    {
        //get email suffix
        $suffix = $this->londury->get_suffix($id);
        $res = $this->londury->get_hostel($id);
        if($res)
        {
            echo json_encode(['status'=>TRUE,'data'=>$res,'suffix'=>$suffix]);
        }else{
            echo json_encode(['status'=>FALSE]);
        }
    }
    
    function contact()
    {
        $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('phone','Phone','trim|required|xss_clean|numeric');
        $this->form_validation->set_rules('college','College','trim|required|xss_clean');
        $this->form_validation->set_rules('purpose','Purpose','trim|required|xss_clean');
        $this->form_validation->set_rules('message','Message','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $message = '';
            foreach($this->input->post() as $key=>$data)
            {
                $message .= '<p>'.ucfirst($key).': '.$data.'</p>';
            }
            $email=array('to'=>'info@xpresslaundromat.in','message'=>$message,'subject'=>'Contact Form Enquiry');
            if($this->functions->_email($email))
            {
                $this->session->set_flashdata('msg','Inquiry sent successfully');
                redirect(current_url());
            }else{
                $this->session->set_flashdata('error','Something went wrong, Please try again.');
                redirect(current_url());
            }
        }
        $pagedata['colleges1'] = $this->db->get_where('tbl_college',['status'=>1])->result();
        if($this->session->college_id){
            $pagedata['colleges'] = $this->db->get_where('tbl_college',['status'=>1,'id'=>  $this->session->college_id])->result();
        }
        $pagedata['title'] = 'Contact US';
        $this->load->view('header_vw',$pagedata);
        $this->load->view('auth/contact_vw');
        $this->load->view('footer_vw');
    }
    
    function about()
    {
        $pagedata['title'] = 'About US';
        $this->load->view('header_vw',$pagedata);
        $this->load->view('auth/about_vw');
        $this->load->view('footer_vw');
    }
    function how_it_works()
    {
        $pagedata['title'] = 'How IT Works';
        $this->load->view('header_vw',$pagedata);
        $this->load->view('auth/how_works_vw');
        $this->load->view('footer_vw');
    }
    function faqs()
    {
        $pagedata['title'] = 'FAQ';
        $this->load->view('header_vw',$pagedata);
        $this->load->view('auth/faq_vw');
        $this->load->view('footer_vw');
    }
    
    function terms()
    {
        $pagedata['title'] = 'Terms And Conditions';
        $this->load->view('header_vw',$pagedata);
        $this->load->view('auth/terms_vw');
        $this->load->view('footer_vw');
    }
    
        function privacy()
    {
        $pagedata['title'] = 'Terms And Conditions';
        $this->load->view('header_vw',$pagedata);
        $this->load->view('auth/privacy_vw');
        $this->load->view('footer_vw');
    }
}
