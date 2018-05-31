<?php
class Orders extends CI_Controller {
    public function __construct()
    {
        parent::__construct(); 
        $this->load->library('functions');
    }
    
    function index()
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
        
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/orders/manage_orders_vw');
        $this->load->view('panel/footer');
    }
    
    function order_call($id)
    {
        $this->form_validation->set_rules('slot_type','Slot Type','trim|required|xss_clean');
        $this->form_validation->set_rules('college_id','College Name','trim|required|xss_clean');
        $this->form_validation->set_rules('search','Search','trim|xss_clean');
        $this->form_validation->set_rules('date_from','Date from','trim|xss_clean');
        $this->form_validation->set_rules('date_to','Date To','trim|xss_clean');
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
            $where = ['a.order_type'=>$this->input->post('washtype'),'b.college_id'=>$college_id];
            if($this->input->post('slot_type')!='all' && $this->input->post('slot_type')!='')
            {
                $where['a.book_slot'] = $this->input->post('slot_type');
            }
            $from_1 = explode('/',$this->input->post('date_from'));
            $from = strtotime($from_1[2].'-'.$from_1[0].'-'.$from_1[1]);
            $to_1 = explode('/',$this->input->post('date_to'));
            $to = strtotime($to_1[2].'-'.$to_1[0].'-'.$to_1[1]);
            if($from != $to)
            {
                $where2 .= "(a.created >= '". $from."' and a.created <= '". $to."' ) ";
            }else{
					$newdate=date("Y-m-d",$from);
					$nfrom=strtotime($newdate." 00:01");
					$nto=strtotime($newdate." 23:59");
					$where2 .= "(a.created >= '". $nfrom."' and a.created <= '". $nto."' ) ";
            }
            
            $where2 .= ' and (a.status=1 or a.status=3) ';
            
            if($this->input->post('search')!='')
            {
                $where2 .= "and (firstname like '%".$this->input->post('search')."%' or email_id like '%".$this->input->post('search')."%')";
            }
            $c_join2 = '';
            $count_data = array('val'=>'count(a.id) as total','table'=>'tbl_order a','where'=>$where,'where2'=>$where2);
            $c_join = ['table'=>'tbl_users b', 'on'=>'a.user_id=b.id','join_type'=>''];
            $count_res = $this->common->get_join2($count_data,$c_join,'');
			//$count_res = $this->londury->countpickuporders($where,$where2,$id,$perpage);
            if($count_res['res'])
                $total_count=  $count_res['rows']->total;
				//$total_count=  count($count_res['rows']);
            else
                $total_count = 0;
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = BASE . "panel/orders/order-call/";
            $config["total_rows"] = $total_count;
            $perpage=$config["per_page"] = 10;
            $config["uri_segment"] = 4;

            $this->pagination->initialize($config);
            $res = $this->londury->pickuporders($where,$where2,$id,$perpage);
            $res['links'] = '';
            if($total_count > $perpage)
            {
                $res['links'] = $this->pagination->create_links();
            }
            $res['query'] = $total_count;
            echo json_encode($res);
        }
    }

   
    function cloth_detail()
    {
        $this->form_validation->set_rules('token_no','Token No','trim|required|xss_clean');
        $this->form_validation->set_rules('weight','Weight','trim|required|xss_clean');
        $this->form_validation->set_rules('no_of_items','No of Items','trim|required|xss_clean');
        $this->form_validation->set_rules('order_id','Order ID','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $invoice = $this->londury->get_invoice_data_ol($this->input->post('order_id'));
            $data = $this->input->post();
            $college_name=$invoice->college_name;
			$order_type="Bulk Wash";
			if($invoice->order_type==1){$order_type='Bulk Wash';}
			else if($invoice->order_type==4){$order_type='Individual Wash';}
			else if($invoice->order_type==3){$order_type='Dry Cleaning';}
			else if($invoice->order_type==2){$order_type='Premium Wash';}
			
                $weight = $this->input->post('weight');
                if($weight > $invoice->settings['slot_weight'] && $invoice->order_type==1)
                    {
                        $price = ceil($weight - $invoice->settings['slot_weight'])*$invoice->settings['extra_charge'];
                        $user = $this->londury->get_user_detail($invoice->user_id);
						
                        $amount = $user->wallet_balance - $price;
                         $data['extra_amount'] = $price;
                        $total = $this->db->select('total_amount')->where(['id'=>$this->input->post('order_id')])->get('tbl_order')->row()->total_amount;
                        $data['total_amount'] = $total + $price;
                        if($invoice->payment_type==1)
                         {$this->londury->update_wallet_by_id($amount,$invoice->user_id);}
                    }else{
                        $price = "0";
                    }
            
           
            //echo json_encode($data);
            $this->londury->update_cloth_detail($data);
            $this->db->update('tbl_order',['status'=>3],['id'=>  $this->input->post('order_id')]);
			$alldata=$data;
			$alldata['college_name']=$user->college_name;
			$alldata['wash_type']=$order_type;
            echo json_encode(['status'=>TRUE,'data'=>$alldata]);
        }
        else
        {
            $error = ['order_id_err'=>  form_error('order_id','<div class="err">','</div>'),'token_no_err'=>  form_error('token_no','<div class="err">','</div>'),
                'weight_err'=>form_error('weight','<div class="err">','</div>'), 'no_of_items_err'=>form_error('no_of_items','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function order_slip()
    {
        //echo $this->input->post('order_id');
        if(empty($this->input->post('order_id')))
        {
            $this->form_validation->set_rules('order_id','Order id','trim|required|xss_clean');
        }
        $this->form_validation->set_rules('bulkselect','Bulk Action','trim|xss_clean');
        if($this->form_validation->run())
        {
            $order_id = explode(',',$this->input->post('order_id'));
            $data['orders'] = $this->londury->get_orderslip_detail($order_id);

            //echo json_encode($data); 
            $this->load->view('panel/orders/order_slip_vw',$data);
        }else{
            echo 'Error Occured';
        }
    }
    
    function generate_token()
    {
        $this->form_validation->set_rules('name','name','trim|required|xss_clean');
        $this->form_validation->set_rules('token_no','Token No','trim|required|xss_clean');
        $this->form_validation->set_rules('total','Total','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $this->load->view('panel/orders/token_vw');
        }else{
            echo 'Error Occured';
        }
    }
    
    function pickup_reminder()
    {
        $this->form_validation->set_rules('order_id','Order id','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $data = $this->londury->get_reminder_details($this->input->post('order_id'),'LEFT');
            if($data['res'])
            {
                $pick_time = $this->londury->get_pickup_time($data['rows']->book_slot,$data['rows']->college_id);
                $msg = urlencode('Will Pick Up your clothes');
                $dropmsg = $this->db->select('value')->where(['options'=>'sc_pickup_reminder','college_id'=>$data['rows']->college_id])->get('tbl_settings')->row()->value;
                if($dropmsg)
                {
                    $dropmsg = $dropmsg;
                    $msg = urlencode($dropmsg);
                }
                $mobile = $data['rows']->phone_no;
                $url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
                $res = $this->functions->_curl_request($url);
                echo json_encode(['status'=>TRUE]);
            }
            else{
                echo json_encode(['status'=>FALSE,'error'=>'Something went wrong, Please try again.']);
            }
        }else{
            echo json_encode(['status'=>FALSE,'error'=>'Something went wrong, Please try again.']);
        }
    }
    
    function pickup_sms()
    {
        $this->form_validation->set_rules('order_id','Order id','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $data = $this->londury->get_reminder_details($this->input->post('order_id'));
            if($data['res'])
            {
                $msg = urlencode('Will Drop your clothes');
                $dropmsg = $this->db->select('value')->where(['options'=>'sc_dropoff_reminder','college_id'=>$data['rows']->college_id])->get('tbl_settings')->row()->value;
                if($dropmsg)
                {
                    $drop_time = date('d/m/Y H:i A',$data['rows']->dropoff_time);
                    $msg = urlencode($dropmsg);
                }

                $mobile = $data['rows']->phone_no;
                $url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
                $res = $this->functions->_curl_request($url);
                echo json_encode(['status'=>TRUE]);
            }else{
                echo json_encode(['status'=>FALSE,'error'=>'Something went wrong, Please try again.']);
            }
        }else{
            echo json_encode(['status'=>FALSE,'error'=>'Something went wrong, Please try again.']);
        }
    }
    
    function invoice($id)
    {
        $invoice = $pagedata['invoice'] = $this->londury->get_invoice_data($id);
        $booktype = $pagedata['booktype'] = [1=>'Bulk Wash',2=>'Premium Wash',3=>'Dry Cleaning',4=>'Individual Wash'];
        if($pagedata['invoice'])
        {
            $this->form_validation->set_rules('extra_amt','Extra Amount','trim|required|xss_clean');
            $this->form_validation->set_rules('iron_no','Iron Cloths','trim|required|xss_clean');
            $this->form_validation->set_rules('total_iron_price','Iron Price','trim|required|xss_clean');
            $this->form_validation->set_rules('pickdrop','Pickup Cost','trim|required|xss_clean');
            $this->form_validation->set_rules('total_price','Total','trim|required|xss_clean');
            $this->form_validation->set_rules('weight','weight','trim|required|xss_clean');
            $this->form_validation->set_rules('no_of_items','No of Clothes','trim|required|xss_clean');
            $this->form_validation->set_rules('gst','GST','trim|required|xss_clean');
            if($this->form_validation->run())
            {
                $iron = json_encode(['iron_no'=>$this->input->post('iron_no'),'total_iron_price'=>  $this->input->post('total_iron_price')]);
                $data = ['extra_amount'=>  $this->input->post('extra_amt'),'no_of_items'=>$this->input->post('no_of_items'),
                    'weight'=>  $this->input->post('weight'),'pickup_cost'=> $this->input->post('pickdrop'),
                    'total_amount'=> $this->input->post('total_price'),'iron_cost'=>$iron,'gst'=>  $this->input->post('gst')
                    ];
                    $invoice_date = date('d-m-Y', $invoice->invoice_date);
                    if(!$invoice->final_amount)
                    {
                        $data['created'] = time();
                        $invoice_date = date('d-m-Y');
                    }
                    $this->db->update('tbl_order_details',$data,['order_id'=>$id]);
                    $this->db->update('tbl_order',['status'=>2],['id'=>$id]);
                    if(($this->input->post('total_price')!=$invoice->total_amount)&&($invoice->order_type!=1))
                    {
                        $f_amount = $invoice->total_amount-$invoice->discount;
                        if($this->input->get('from')=='search')
                        {
                            $f_amount = $invoice->final_amount-$invoice->discount;
                        }
                        if($f_amount<0){
                            $f_amount=0;
                        }
                            $diff = $this->input->post('total_price')-$f_amount;
                        
                        
                        $amount = $invoice->wallet_balance-$diff;
                        $this->db->update('tbl_users',['wallet_balance'=>$amount],['id'=>  $invoice->user_id]);
                    }
                    if($invoice->order_type!=1)
                    {
                        $items = $this->input->post('items');
                        $quantity = $this->input->post('quantity');
                        $rate = $this->input->post('rate');
                        $total = count($items);
                        $i=0;$data=[];
                        foreach($items as $item)
                        {
                            $data[] = ['items'=>$item,'quantity'=>$quantity[$i],'cost'=>$rate[$i],'order_id'=>$id];
                            $i++;
                        }
                        if(!empty($data))
                        {
                            $this->db->where('order_id',$id);
                            $this->db->delete('tbl_order_items');
                            //insert data
                            $this->db->insert_batch('tbl_order_items',$data);
                            $data =[];
                        }
                        
                        //print_r($data);die;
                    }
                    
                    $invoice = $this->londury->get_invoice_data($id);
                    
                    $email['message'] = ['invoice_id'=>$invoice->invoice_id,'order_no'=>$id,'invoice_date'=>$invoice_date,'hostel_name'=>$invoice->hostel_name,
                        'order_date'=>date('d-m-Y',$invoice->created),'customer_name'=>$invoice->firstname.' '.$invoice->lastname,'room_no'=>$invoice->room_no,
                        'mobile'=>$invoice->phone_no,'no_of_clothes'=>$invoice->no_of_items,'washtype'=>$booktype[$invoice->order_type],'order_type'=>$invoice->order_type,
                        'weight'=>$this->input->post('weight'),'iron_qty'=>$this->input->post('iron_no'),'iron_rate'=>$invoice->settings['iron_price'],
                        'iron_amount'=>$this->input->post('total_iron_price'),'pick_rate'=>$invoice->settings['pickdrop'],'pick_cost'=>$this->input->post('pickdrop'),'gst'=>$invoice->gst,
                        'total'=>$this->input->post('total_price'),'settings'=>$invoice->settings,'order_data'=>$invoice->items,'extra_amt'=>$this->input->post('extra_amt'),
                        'order_amount'=>$invoice->total_amount,'coupon_applied'=>$invoice->coupon_applied,'discount'=>$invoice->discount,'college_name'=>$invoice->college_name,'college_address'=>$invoice->address,'college_phone'=>$invoice->phone,'college_service'=>$invoice->service_tax_no,'college_email'=>$invoice->college_email];

                    $email['to']=$invoice->email_id;
					$email['cc']=SUP_EMAIL_ID;
                    $email['subject'] = 'Order Invoice';
                    $this->functions->invoice_email($email);
                    $this->session->set_flashdata('msg','Invoice generated for order no '.$id);
                    redirect('panel/orders');
                    
            }
            //print_r($invoice->items);die;
            //echo json_encode($pagedata);
            $this->load->view('panel/header',$pagedata);
            $this->load->view('panel/menu');
            $this->load->view('panel/orders/invoice_vw');
            $this->load->view('panel/footer');
            
        }else{
            $this->session->set_flashdata('error','Invalid Request');
            redirect('panel/orders');
        }
    }
    
    function manage_dropoff()
    {
        $time = strtotime('07:30');
        $ntime= [];
        for($i=0;$i<25;$i++)
        {
            $newtime = date("H:i", strtotime('+30 minutes', $time));
            $current = strtotime(date('H:i'));
            $status = '';
            if(strtotime($newtime)<$current)
            {
                $status = 'disabled=""';
            }
            $dtime = date('h:i A',  strtotime($newtime));
            $ntime[] = ['dtime'=>$dtime,'status'=>$status];
            $time = strtotime($newtime);
        }
        $pagedata['dtime'] = $ntime;
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
        $pagedata['college_id'] = $college_id;
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/orders/dropoff_vw');
        $this->load->view('panel/footer');
    }
    
    function dropoff_call($id)
    {
        $this->form_validation->set_rules('slot_type','Slot Type','trim|required|xss_clean');
        $this->form_validation->set_rules('college_id','College Name','trim|required|xss_clean');
        $this->form_validation->set_rules('search','Search','trim|xss_clean');
        $this->form_validation->set_rules('date_from','Date from','trim|xss_clean');
        $this->form_validation->set_rules('date_to','Date To','trim|xss_clean');
        if($this->form_validation->run())
        {
            $where = ['a.order_type'=>$this->input->post('washtype'),'b.college_id'=>$this->input->post('college_id')];
            if($this->input->post('slot_type')!='all' && $this->input->post('slot_type')!='')
            {
                $where['a.book_slot'] = $this->input->post('slot_type');
            }
            $from_1 = explode('/',$this->input->post('date_from'));
            $from = strtotime($from_1[2].'-'.$from_1[0].'-'.$from_1[1]);
            $to_1 = explode('/',$this->input->post('date_to'));
            $to = strtotime($to_1[2].'-'.$to_1[0].'-'.$to_1[1]);
            if($from != $to)
            {
                $where2 .= "(book_date >= '". $from."' and book_date <= '". $to."' ) ";
            }else{
                $where2 .= "(book_date = '". $from."' ) ";
            }
            $where2 .= " and (a.status=2 or a.status=4) ";
            
            if($this->input->post('search')!='')
            {
                $where2 .= "and (firstname like '%".$this->input->post('search')."%' or email_id like '%".$this->input->post('search')."%')";
            }
            
            $c_join2 = '';
            $count_data = array('val'=>'count(a.id) as total','table'=>'tbl_order a','where'=>$where,'where2'=>$where2);
            $c_join = ['table'=>'tbl_users b', 'on'=>'a.user_id=b.id','join_type'=>''];
            $count_res = $this->common->get_join2($count_data,$c_join,'');
            if($count_res['res'])
                $total_count=  $count_res['rows']->total;
            else
                $total_count = 0;
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = BASE . "panel/orders/dropoff-call/";
            $config["total_rows"] = $total_count;
            $perpage=$config["per_page"] = 10;
            $config["uri_segment"] = 4;

            $this->pagination->initialize($config);
            $res = $this->londury->pickuporders($where,$where2,$id,$perpage);
            $res['links'] = '';
            if($total_count > $perpage)
            {
                $res['links'] = $this->pagination->create_links();
            }
            $res['query'] = $total_count;
            
            echo json_encode($res);
        }
    }
    
    function search_order()
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
        $pagedata['college_id'] = $college_id;
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/orders/search_order_vw');
        $this->load->view('panel/footer');
    }
    
    function search_call($id)
    {
        $this->form_validation->set_rules('slot_type','Slot Type','trim|required|xss_clean');
        $this->form_validation->set_rules('college_id','College Name','trim|required|xss_clean');
        $this->form_validation->set_rules('search','Search','trim|xss_clean');
        $this->form_validation->set_rules('date_from','Date from','trim|xss_clean');
        $this->form_validation->set_rules('date_to','Date To','trim|xss_clean');
        if($this->form_validation->run())
        {
            $college_id = $this->input->post('college_id');
            if($this->session->user_type==2)
            {
                $college_id = $this->session->a_college_id;

            }
            $where = ['a.status <>'=>'0','a.order_type'=>$this->input->post('washtype'),'b.college_id'=>$college_id];
            if($this->input->post('slot_type')!='all' && $this->input->post('slot_type')!='')
            {
                $where['a.book_slot'] = $this->input->post('slot_type');
            }
            $from_1 = explode('/',$this->input->post('date_from'));
            $from = strtotime($from_1[2].'-'.$from_1[0].'-'.$from_1[1]);
            $to_1 = explode('/',$this->input->post('date_to'));
            $to = strtotime($to_1[2].'-'.$to_1[0].'-'.$to_1[1]);
            if($from != $to)
            {
                $where2 .= "(book_date >= '". $from."' and book_date <= '". $to."' ) ";
            }else{
                $where2 .= "(book_date = '". $from."' ) ";
            }
			if($this->input->post('payment_type')!='' && $this->input->post('payment_type')!='0')
            {
                $where2 .= "and payment_type='".$this->input->post('payment_type')."' ";
            }
            
            if($this->input->post('search')!='')
            {
                $where2 .= "and (firstname like '%".$this->input->post('search')."%' or email_id like '%".$this->input->post('search')."%')";
            }
            
            $c_join2 = '';
            $count_data = array('val'=>'count(a.id) as total','table'=>'tbl_order a','where'=>$where,'where2'=>$where2);
            $c_join = ['table'=>'tbl_users b', 'on'=>'a.user_id=b.id','join_type'=>''];
            $count_res = $this->common->get_join2($count_data,$c_join,'');
            if($count_res['res'])
                $total_count=  $count_res['rows']->total;
            else
                $total_count = 0;
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = BASE . "panel/orders/search-call/";
            $config["total_rows"] = $total_count;
            $perpage=$config["per_page"] = 10;
            $config["uri_segment"] = 4;

            $this->pagination->initialize($config);
            $res = $this->londury->pickuporders($where,$where2,$id,$perpage);
            $res['links'] = '';
            if($total_count > $perpage)
            {
                $res['links'] = $this->pagination->create_links();
            }
            $res['query'] = $total_count;
            echo json_encode($res);
        }
    }
    
    function cancel()
    {
        $this->form_validation->set_rules('order_id','Order id','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $where = ['b.id'=>  $this->input->post('order_id'),'b.status <>'=>5];
            if($this->session->user_type==2)
            {
                $where['a.college_id'] = $this->session->a_college_id;
            }
            $check = $this->db->select('a.wallet_balance,b.total_amount,b.user_id,a.firstname,email_id,b.payment_type,b.discount')
                    ->join('tbl_users a','a.id=b.user_id')->where($where)
                    ->get('tbl_order b');
            if($check->num_rows()>0)
            {
                $data = $check->row();
                $this->db->update('tbl_order',['status'=>6],['id'=>  $this->input->post('order_id')]);
                if($data->payment_type==1){
                    $amount = $data->wallet_balance+$data->total_amount-$data->discount;
                    $this->db->update('tbl_users',['wallet_balance'=>$amount],['id'=>  $data->user_id]);
                }
                $message="<p>Hello ".$data->firstname."</p><p>Your are order has been cancelled by XpressLaundroMat.</p><p> Rs. ".$data->total_amount-$data->discount." will be refunded in your walllet. Logon to your account for more details</p>";
                $email=array('to'=>$data->email_id,'message'=>$message,'subject'=>'Welcome to XpressLaundroMat');
                $this->functions->_email($email);
                
                echo json_encode(['status'=>TRUE]);
            }else{
                echo json_encode(['status'=>FALSE,'error'=>'Something went wrong, Please try again.']);
            }
        }else{
            echo json_encode(['status'=>FALSE,'error'=>'Something went wrong, Please try again.']);
        }
    }
    
    function create_order()
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
        
        $pagedata['x'] = 1;
        $pagedata['bprice_iron'] = $this->londury->get_options('sc_bulk_price_iron',  $this->session->college_id);
        $pagedata['bprice_fold'] = $this->londury->get_options('sc_bulk_price_fold',  $this->session->college_id);
        $pagedata['college_id'] = $college_id;
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/orders/create_order_vw');
        $this->load->view('panel/footer');
    }
	
	function checkCouponCode()
	{
		$keyword=$this->input->post('coupon_code');
		$this->db->select('*');
		$this->db->from('tbl_coupon');
		$this->db->where('status', '1');
		$this->db->like('coupon_code', $keyword);
		$res=$this->db->get()->result_array();
		if(!empty($res))
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
	}
    
    function get_price($college_id)
    {
        $result =[];
       $res = $this->londury->get_options('',$college_id);
       foreach($res as $data)
       {
           $result[$data->options] = $data->value;
       }
       return $result;
    }
    
    function user_ajax($id='')
    {
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
        $query=  $this->_get_user($id,$search,$college);
        if($query['res'])
        {$i=$id+1;
            foreach($query['rows'] as $users)
            {
            ?>
            <tr>
                <td><input type="radio" name="user_check" data-balance="<?=$users->wallet_balance?>" class="user_check" data-name="<?=$users->firstname.' '.$users->lastname?>" data-college="<?=$users->college_id?>" data-hostel="<?=$users->hostel_id?>" value="<?=$users->id?>" /></td>
                <td><?=$users->firstname.' '.$users->lastname?></td>
                <td><?=$users->college_name?></td>
                <td><?=$users->hostel_name?></td>
                <td class="col-bl"><?=$users->roll_no?></td>
                <td><?=$users->email_id?></td>
                <td><?=$users->wallet_balance?></td>
        </tr>
            <?php $i++;}?>
                <tr><td id="paginate"  colspan="7">
                        <ul class="pagination"><?=$this->pagination->create_links()?></ul>
                    </td></tr>
                <?php }else{?>
                <tr><td id="paginate"  colspan="7">No Users Found</td></tr>
                <?php }
    }
    
    function _get_user($page='0',$search='',$college='',$sort='a.id',$sortas='desc')
    {
        $where = '';
        
        $where = '(concat(firstname, " ",lastname) like "'.$search.'%" or email_id like "'.$search.'%" or roll_no like "'.$search.'%" )';
        if($college!='')
        {
            $where2 = ['a.college_id'=>$college];
        }
        $count_data=['val'=>'count(a.id) as total','table'=>'tbl_users a','orderby'=>'','where'=>$where, 'where2'=>$where2,'orderas'=>'','start'=>'','limit'=>''];
        $join=['table'=>'tbl_college b','on'=>'a.college_id=b.id','join_type'=>''];
        $join2=['table'=>'tbl_hostel c','on'=>'a.hostel_id=c.id','join_type'=>''];
        $res_count=$this->common->get_join($count_data,$join);
        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = BASE . "panel/orders/user_ajax/";
        $config["total_rows"] = $res_count['rows']->total;
        $perpage=$config["per_page"] = 20;
        $config["uri_segment"] = 4;
 
        $this->pagination->initialize($config);
        $data=['val'=>'a.*,b.college_name,c.hostel_name','table'=>'tbl_users a','orderby'=>$sort,'where'=>$where, 'where2'=>$where2,'orderas'=>$sortas,'start'=>$page,'limit'=>$perpage];
        $join=['table'=>'tbl_college b','on'=>'a.college_id=b.id','join_type'=>''];
        $join2=['table'=>'tbl_hostel c','on'=>'a.hostel_id=c.id','join_type'=>''];
        $res=$this->common->get_join($data,$join,$join2);
        return $res;
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
            $message="<p>Hello ".$this->input->post('firstname')."</p><p>Your are registered with XpressLaundroMat. You can login with following details:-</p><p>Username: ".$this->input->post('emailid')."</p><p>Password: <b>$code</b></p>";
            $email=array('to'=>$this->input->post('emailid'),'message'=>$message,'subject'=>'Welcome to XpressLaundroMat');
            if($this->functions->_email($email))
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
    
    function check_slot()
    {
        $this->form_validation->set_rules('day','Day','trim|required|xss_clean');
        $this->form_validation->set_rules('service','Service','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $college_id = $this->input->post('college');
            $hostel_id = $this->input->post('hostel');
            if($this->session->user_type==2)
            {
                $college_id = $this->session->a_college_id;

            }
            $service =3;
            if($this->input->post('service')=='bulkwashing')
            {
                $service='1';
                $bulk_iron = $price = $this->londury->get_options('sc_bulk_price_iron',  $college_id);
                $bulk_fold = $price_fold = $this->londury->get_options('sc_bulk_price_fold',  $college_id);
                $data = $this->get_bulk_data($bulk_iron,$bulk_fold);
            }
            if($this->input->post('service')=='drycleaning')
            {
                $data = $this->get_drydata($college_id);
            }
            if($this->input->post('service')=='premium')
            {
                $data = $this->get_premdata($college_id);
            }
            if($this->input->post('service')=='individual')
            {
                $service = '2';
                $data = $this->get_indidata($college_id);
            }
            $day = date('Y-m-d',  strtotime($this->input->post('day')));
            $slot = $this->londury->check_slot($day,$service,$college_id);
            
            echo json_encode(['status'=>TRUE,'morning'=>$slot['morning'],'afternoon'=>$slot['afternoon'],'evening'=>$slot['evening'],'night'=>$slot['night'],'data'=>$data,'bulk_price_iron'=>$bulk_iron,'bulk_price_fold'=>$bulk_fold]);
        }else{
            echo json_encode(['status'=>FALSE,'error'=>  validation_errors()]);
        }
    }


    function check_slot_create()
    {
        $this->form_validation->set_rules('day','Day','trim|required|xss_clean');
        $this->form_validation->set_rules('service','Service','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $college_id = $this->input->post('college');
            //$hostel_id = $this->input->post('hostel');
            if($this->session->user_type==2)
            {
                $college_id = $this->session->a_college_id;

            }
            $service =3;
            if($this->input->post('service')=='bulkwashing')
            {
                $service='1';
                $bulk_iron = $price = $this->londury->get_options('sc_bulk_price_iron',  $college_id);
                $bulk_fold = $price_fold = $this->londury->get_options('sc_bulk_price_fold',  $college_id);
                $data = $this->get_bulk_data($bulk_iron,$bulk_fold);
            }
            if($this->input->post('service')=='drycleaning')
            {
                $data = $this->get_drydata($college_id);
            }
            if($this->input->post('service')=='premium')
            {
                $data = $this->get_premdata($college_id);
            }
            if($this->input->post('service')=='individual')
            {
	    	 $service = '2';
	    $ind_iron = $price = $this->londury->get_options('sc_shoe_price_iron',  $college_id);
                $ind_wash = $price_fold = $this->londury->get_options('sc_shoe_price',  $college_id);
                $data = $this->get_indidata($college_id,$ind_iron,$ind_wash);
            }
            $day = date('Y-m-d',  strtotime($this->input->post('day')));
            $slot = $this->londury->check_slot($day,$service,$college_id);
            
            echo json_encode(['status'=>TRUE,'morning'=>$slot['morning'],'afternoon'=>$slot['afternoon'],'evening'=>$slot['evening'],'night'=>$slot['night'],'data'=>$data,'bulk_price_iron'=>$bulk_iron,'bulk_price_fold'=>$bulk_fold,'ind_iron'=>$ind_iron,'ind_wash'=>$ind_wash]);
        }else{
            echo json_encode(['status'=>FALSE,'error'=>  validation_errors()]);
        }
    }
    
    function get_drydata($college_id)
    {
        $prices = $this->get_price($college_id);
        
        $outpot = '<div class="col-sm-6 border-right no-l-pad padding-bottom-20 padding-top-20">
                <div class="col-sm-12 no-pad">
            <div class="col-sm-4 margin-bottom-10 bold fs-12">SHIRTS / T SHIRTS / TOPS</div>
            <div class="col-sm-8 margin-bottom-10 no-padd">
                <input type="button" value="-" class="qtyminus" field="quantity_shirt" />
                <input type="text" name="quantity_shirt" data-id="quantity_shirt" readonly="" value="0" class="qty" />
                <input type="button" value="+" class="qtyplus" field="quantity_shirt" />
                <input type="hidden" value="'.$prices['sc_dry_shirt_price'].'" id="quantity_shirt_price">
                <span class="fs-11">  <i class="fa fa-inr p-l-10"></i> '.$prices['sc_dry_shirt_price'].'/- PER CLOTH</span>
            </div>
            </div>
                <div class="col-sm-12 no-pad">
            <div class="col-sm-4 margin-bottom-10 bold fs-12">PANTS / JEANS / LOWERS</div>
            <div class="col-sm-8 margin-bottom-10 no-padd">
                <input type="button" value="-" class="qtyminus" field="quantity_pants" />
                <input type="text" name="quantity_pants" data-id="quantity_pants" readonly="" value="0" class="qty" />
                <input type="button" value="+" class="qtyplus" field="quantity_pants" />
                <input type="hidden" value="'.$prices['sc_dry_pant_price'].'" id="quantity_pants_price">
                <span class="fs-11">  <i class="fa fa-inr p-l-10"></i> '.$prices['sc_dry_pant_price'].'/- PER CLOTH</span>
            </div>
            </div>
                <div class="col-sm-12 no-pad">
            <div class="col-sm-4 margin-bottom-10 bold fs-12">SUITS</div>
            <div class="col-sm-8 margin-bottom-10 no-padd">
                <input type="button" value="-" class="qtyminus" field="quantity_suit" />
                <input type="text" name="quantity_suit" data-id="quantity_suit" readonly="" value="0" class="qty" />
                <input type="button" value="+" class="qtyplus" field="quantity_suit" />
                <input type="hidden" value="'.$prices['sc_dry_suit_price'].'" id="quantity_suit_price">
                <span class="fs-11">  <i class="fa fa-inr p-l-10"></i> '.$prices['sc_dry_suit_price'].'/- PER CLOTH</span>
            </div>
            </div>
        </div>
        <div class="col-sm-6 no-r-pad padding-bottom-20 padding-top-20">
            <div class="col-sm-12 no-pad">
            <div class="col-sm-4 margin-bottom-10 bold fs-12">BLANKETS</div>
            <div class="col-sm-8 margin-bottom-10 no-padd">
                <input type="button" value="-" class="qtyminus" field="quantity_blanket" />
                <input type="text" name="quantity_blanket" data-id="quantity_blanket" readonly="" value="0" class="qty" />
                <input type="button" value="+" class="qtyplus" field="quantity_blanket" />
                <input type="hidden" value="'.$prices['sc_dry_blanket_price'].'" id="quantity_blanket_price">
                <span class="fs-11">  <i class="fa fa-inr p-l-10"></i> '.$prices['sc_dry_blanket_price'].'/- PER CLOTH</span>
            </div>
            </div>
            <div class="col-sm-12 no-pad">
            <div class="col-sm-4 margin-bottom-10 bold fs-12">OTHERS</div>
            <div class="col-sm-8 margin-bottom-10 no-padd">
                <input type="button" value="-" class="qtyminus" field="quantity_others" />
                <input type="text" name="quantity_others" data-id="quantity_others" readonly="" value="0" class="qty" />
                <input type="button" value="+" class="qtyplus" field="quantity_others" />
                <input type="hidden" value="'.$prices['sc_dry_others_price'].'" id="quantity_others_price">
                <span class="fs-11">  <i class="fa fa-inr p-l-10"></i> '.$prices['sc_dry_others_price'].'/- PER CLOTH</span>
            </div>
            </div>
        </div>';
        
        return $outpot;
    }
    
    function get_bulk_data($iron,$fold)
    {
        $outpot = '<div class="col-sm-3 padding-bottom-20 padding-top-20 bold fs-12">ENTER THE NO OF CLOTHES</div>
        <div class="col-sm-9 padding-bottom-20 padding-top-20">
            <input type="button" value="-" class="qtyminus1" data-p="no"  field="quantity" />
            <input type="text" name="quantity" value="0" class="qty" />
            <input type="button" value="+" data-p="no" class="qtyplus1" field="quantity" />
            <br>
            <input type="radio" id="w_iron" name="wash_type" value="iron" onclick="toggle_amt(1)" checked> Wash &amp; Iron
            <input type="radio" id="w_fold" name="wash_type" onclick="toggle_amt(0)" value="fold"> Wash &amp; Fold
            <input type="text" class="hidden" id="def_iron_price" value="'.$iron.'">
            <input type="text" class="hidden" id="def_fold_price" value="'.$fold.'">
        </div>';
        return $outpot;
    }
    
    function get_premdata($college_id)
    {
        $prices = $this->get_price($college_id);
        $outpot = '<div class="col-sm-6 border-right no-l-pad padding-bottom-20 padding-top-20">
                <div class="col-sm-12 no-pad">
                <div class="col-sm-4 margin-bottom-10 bold fs-12">SHIRTS / T SHIRTS / TOPS</div>
                <div class="col-sm-8 margin-bottom-10">
                    <input type="button" value="-" class="qtyminus" field="quantity_shirt" />
                    <input type="text" name="quantity_shirt" value="0" data-id="quantity_shirt" class="qty" />
                    <input type="button" value="+" class="qtyplus" field="quantity_shirt" />
                    <input type="hidden" value="'.$prices['sc_indi_shirt_price'].'" id="quantity_shirt_price" >
                    <span class="fs-11">  <i class="fa fa-inr p-l-10"></i> '.$prices['sc_indi_shirt_price'].'/- PER CLOTH</span>
                </div>
                </div>
                <div class="col-sm-12 no-pad">
                <div class="col-sm-4 margin-bottom-10 bold fs-12">PANTS / JEANS / LOWERS</div>
                <div class="col-sm-8 margin-bottom-10">
                    <input type="button" value="-" class="qtyminus" field="quantity_pants" />
                    <input type="text" name="quantity_pants" value="0" data-id="quantity_pants" class="qty" />
                    <input type="button" value="+" class="qtyplus" field="quantity_pants" />
                    <input type="hidden" value="'.$prices['sc_indi_pant_price'].'" id="quantity_pants_price">
                    <span class="fs-11">  <i class="fa fa-inr p-l-10"></i> '.$prices['sc_indi_pant_price'].'/- PER CLOTH</span>
                </div>
                </div>
                <div class="col-sm-12 no-pad">
                <div class="col-sm-4 margin-bottom-10 bold fs-12">SALWAR SUIT/ KURTA PAJAMA</div>
                <div class="col-sm-8 margin-bottom-10">
                    <input type="button" value="-" class="qtyminus" field="quantity_undergarments" />
                    <input type="text" name="quantity_undergarments" data-id="quantity_undergarments" value="0" class="qty" />
                    <input type="button" value="+" class="qtyplus" field="quantity_undergarments" />
                    <input type="hidden" value="'.$prices['sc_indi_undergarment_price'].'" id="quantity_undergarments_price" >
                    <span class="fs-11">  <i class="fa fa-inr p-l-10"></i> '.$prices['sc_indi_undergarment_price'].'/- PER CLOTH</span>
                </div>
                </div>
            </div>
            <div class="col-sm-6 no-r-pad padding-bottom-20 padding-top-20">
            <div class="col-sm-12 no-pad">
                <div class="col-sm-4 margin-bottom-10 bold fs-12">TOWELS / BEDSHEETS</div>
                <div class="col-sm-8 margin-bottom-10">
                    <input type="button" value="-" class="qtyminus" field="quantity_towel" />
                    <input type="text" name="quantity_towel" data-id="quantity_towel" value="0" class="qty" />
                    <input type="button" value="+" class="qtyplus" field="quantity_towel" />
                    <input type="hidden" value="'.$prices['sc_indi_towels_price'].'" id="quantity_towel_price" >
                    <span class="fs-11">  <i class="fa fa-inr p-l-10"></i> '.$prices['sc_indi_towels_price'].'/- PER CLOTH</span>
                </div>
                </div>
                <div class="col-sm-12 no-pad">
                <div class="col-sm-4 margin-bottom-10 bold fs-12">OTHERS</div>
                <div class="col-sm-8 margin-bottom-10">
                    <input type="button" value="-" class="qtyminus" field="quantity_others" />
                    <input type="text" name="quantity_others" data-id="quantity_others" value="0" class="qty" />
                    <input type="button" value="+" class="qtyplus" field="quantity_others" />
                    <input type="hidden" value="'.$prices['sc_indi_others_price'].'" id="quantity_others_price" >
                    <span class="fs-11">  <i class="fa fa-inr p-l-10"></i> '.$prices['sc_indi_others_price'].'/- PER CLOTH</span>
                </div>
                </div>
            </div>';
        return $outpot;
    }
    
    function get_indidata($college_id,$iron=0,$wash=0)
    {
        $price = $this->londury->get_options('sc_shoe_price',  $college_id);
        $outpot = '<div class="col-sm-3 padding-bottom-20 padding-top-20 bold fs-12">ENTER THE NO OF CLOTHES</div>
        <div class="col-sm-9 padding-bottom-20 padding-top-20">
            <input type="button" value="-" class="qtyminus1" data-p="yes" field="quantity" />
            <input type="text" name="quantity" data-id="quantity" value="1" class="qty" />
            <input type="button" value="+"  data-p="yes" class="qtyplus1" field="quantity" />
            <input type="hidden" value="'.$price.'" id="quantity_price" >
			<br>
            <input type="radio" id="w_wash" name="wash_type" value="wash" onclick="change_amt(0)" checked> Individual Wash
            <input type="radio" id="i_iron" name="wash_type" onclick="change_amt(1)" value="iron"> Individual Iron
            <input type="text" class="hidden" id="ind_wash_price" value="'.$wash.'">
            <input type="text" class="hidden" id="ind_iron_price" value="'.$iron.'">
        </div>';
        
        return $outpot;
    }
    
    function place_order()
    {
        $this->form_validation->set_rules('college_id','College','trim|required|xss_clean');
        $this->form_validation->set_rules('user_id','User ID','trim|required|xss_clean');
        $this->form_validation->set_rules('slotday','Day','trim|required|xss_clean');
        $this->form_validation->set_rules('slotInput','Slot Time','trim|required|xss_clean');
        $this->form_validation->set_rules('quantity_shirt','Shirts','trim|xss_clean');
        $this->form_validation->set_rules('quantity_pants','Pants','trim|xss_clean');
        $this->form_validation->set_rules('quantity_undergarments','Undergarments','trim|xss_clean');
        $this->form_validation->set_rules('quantity_towel','Towel','trim|xss_clean');
        $this->form_validation->set_rules('quantity_others','others','trim|xss_clean');
        $this->form_validation->set_rules('quantity_suit','Suit','trim|xss_clean');
        $this->form_validation->set_rules('quantity_blanket','blanket','trim|xss_clean');
        $this->form_validation->set_rules('order_type','Order Type','trim|required|xss_clean');
        $this->form_validation->set_rules('quantity','quantity','trim|xss_clean');
        $this->form_validation->set_rules('pickup','Pick Type','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $college_id = $this->input->post('college_id');
            if($this->session->user_type==2)
            {
                $college_id = $this->session->a_college_id;
            }
            $service =3;
            if(($this->input->post('order_type')=='bulkwashing')||($this->input->post('order_type')=='individual'))
            {
                $service='1';
            }
            $slot = $this->londury->check_slot($this->input->post('slotday'),$service,  $college_id);
            $aval = 'yes';
            switch($this->input->post('slotInput'))
            {
                case 1:
                    if($slot['morning']==0)
                    {
                        $aval ='no';
                    }
                    break;
                case 2:
                    if($slot['afternoon']==0)
                    {
                        $aval ='no';
                    }
                    break;
                case 3:
                    if($slot['evening']==0)
                    {
                        $aval ='no';
                    }
                    break;
                case 4:
                    if($slot['night']==0)
                    {
                        $aval ='no';
                    }
                    break;
            }
            if($aval=='no')
            {
                echo json_encode(['status'=>  FALSE,'error'=>['error'=>'<div class="err">Slot Not Available.</div>']]);
                exit;
            }
            
            $user = $this->users->get_user('firstname,wallet_balance',  $this->input->post('user_id'));
            if($this->input->post('payment_type')==1)
            {
                if($this->input->post('total_price') <= $user->wallet_balance)
                {
                    $log = 'UserID: '.$this->input->post('user_id').', Debited amount: '.$this->input->post('total_price');
                            $this->londury->wallet_log($log);

                    $id = $this->londury->_order($this->input->post(),1);
                    $balance = $user->wallet_balance - $this->input->post('total_price');
                    $this->db->update('tbl_users',['wallet_balance'=>$balance],['id'=>  $this->input->post('user_id')]);
                    echo json_encode(['status'=>TRUE]);
                }else{
                    echo json_encode(['status'=>  FALSE,'error'=>['error'=>'<div class="err">Insufficiant Wallet Balance</div>']]);
                    exit;
                }
            }elseif($this->input->post('payment_type')==2)
            {
                $id = $this->londury->_order($this->input->post(),1);
                echo json_encode(['status'=>TRUE]);
            }
        }else{
             $error = ['slotday_err'=>  form_error('slotday','<div class="err">','</div>'),'slotInput_err'=>  form_error('slotInput','<div class="err">','</div>'),'quantity_shirt_err'=>form_error('quantity_shirt','<div class="err">','</div>'),
                'quantity_pants_err'=>form_error('quantity_pants','<div class="err">','</div>'),'quantity_undergarments_err'=>form_error('quantity_undergarments','<div class="err">','</div>'),'quantity_err'=>form_error('quantity','<div class="err">','</div>'),
                'quantity_towel_err'=>form_error('quantity_towel','<div class="err">','</div>'),'quantity_others_err'=>form_error('quantity_others','<div class="err">','</div>'),'pickup_err'=>form_error('pickup','<div class="err">','</div>'),
                'quantity_suit_err'=>form_error('quantity_suit','<div class="err">','</div>'),'quantity_blanket_err'=>form_error('quantity_blanket','<div class="err">','</div>'),'order_type_err'=>form_error('order_type','<div class="err">','</div>')];
            echo json_encode(['status'=>  FALSE,'error'=>$error]);
        }
    }
    
    function complete($id)
    {
        $res = $this->londury->complete_order($id); 
       if($res)
        {
            $msg = urlencode('Thank you for order.');
            $data = $this->db->select('a.phone_no,a.college_id')->join('tbl_order b','a.id=b.user_id')->where(['b.id'=>$id])->get('tbl_users a')->row();
            $dropmsg = $this->db->select('value')->where(['options'=>'sc_complete_msg','college_id'=>$data->college_id])->get('tbl_settings')->row()->value;
                if($dropmsg)
                {
                    $msg = urlencode($dropmsg);
                }

                $mobile = $data->phone_no;
                $url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
                $res = $this->functions->_curl_request($url);
            $this->session->set_flashdata('msg','Order Markded as completed');
        }else{
            $this->session->set_flashdata('error','Invalid Request');
        }
        
        redirect('panel/orders/manage-dropoff');
    }
    
    function bulk_completed()
    {
        $this->form_validation->set_rules('order_action','Orders','trim|xss_clean');
        if(empty($this->input->post('order_action')))
        {
            $this->form_validation->set_rules('order_action','Orders','trim|required|xss_clean');
        }
        if($this->form_validation->run())
        {
            $this->db->where_in('id',$this->input->post('order_action'));
            $this->db->update('tbl_order',['status'=>5]);
            $msg = urlencode('Thank you for order.');
            foreach($this->input->post('order_action') as $user)
            {
                $data = $this->db->select('a.phone_no,a.college_id')->join('tbl_order b','a.id=b.user_id')->where(['b.id'=>$$user])->get('tbl_users a')->row();
                $dropmsg = $this->db->select('value')->where(['options'=>'sc_complete_msg','college_id'=>$data->college_id])->get('tbl_settings')->row()->value;
                if($dropmsg)
                {
                    $msg = urlencode($dropmsg);
                }

                $mobile = $data->phone_no;
                $url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
                $res = $this->functions->_curl_request($url);
            }
            echo json_encode(['status'=>TRUE]);
        }else{
            echo json_encode(['status'=>FALSE]);
        }
    }
    
    function bulk_delivery()
    {
        $this->form_validation->set_rules('d_time','Dropoff Time','trim|xss_clean');
        $this->form_validation->set_rules('d_date','Dropoff Date','trim|xss_clean');
        if(empty($this->input->post('order_action')))
        {
            $this->form_validation->set_rules('order_action','Orders','trim|required|xss_clean');
        }
        if($this->form_validation->run())
        {
            if($this->input->post('d_date')!='' && $this->input->post('d_time')!='')
            {
                $drop_time = strtotime($this->input->post('d_date').' '.$this->input->post('d_time'));
                $this->db->where_in('order_id',$this->input->post('order_action'));
                $this->db->update('tbl_order_details',['dropoff_time'=>$drop_time]);
            }
            
            $this->db->where_in('id',$this->input->post('order_action'));
            $this->db->update('tbl_order',['status'=>4]);
            echo json_encode(['status'=>TRUE]);
        }else{
            echo json_encode(['status'=>FALSE]);
        }
    }
	
	 function export_search_oder()
    {
		$college_id = $this->input->get('college_id', TRUE);
            if($this->session->user_type==2)
            {
                $college_id = $this->session->a_college_id;

            }
            $where = ['a.status <>'=>'0','a.order_type'=>$this->input->get('washtype', TRUE),'b.college_id'=>$college_id];
            if($this->input->get('slot_type', TRUE)!='all' && $this->input->get('slot_type', TRUE)!='')
            {
                $where['a.book_slot'] = $this->input->get('slot_type', TRUE);
            }
            $from_1 = explode('/',$this->input->get('date_from', TRUE));
            $from = strtotime($from_1[2].'-'.$from_1[0].'-'.$from_1[1]);
            $to_1 = explode('/',$this->input->get('date_to', TRUE));
            $to = strtotime($to_1[2].'-'.$to_1[0].'-'.$to_1[1]);
            if($from != $to)
            {
                $where2 .= "(book_date >= '". $from."' and book_date <= '". $to."' ) ";
            }else{
                $where2 .= "(book_date = '". $from."' ) ";
            }
			if($this->input->get('payment_type', TRUE)!='' && $this->input->get('payment_type', TRUE)!='0')
            {
                $where2 .= "and payment_type='".$this->input->get('payment_type', TRUE)."' ";
            }
            
            if($this->input->post('search')!='')
            {
                $where2 .= "and (firstname like '%".$this->input->get('search', TRUE)."%' or email_id like '%".$this->input->get('search', TRUE)."%')";
            }
			$query = $this->londury->searchOderExcel($where,$where2);
	//print_r($query['data']);die;
        if($query['data'])
        {
            $this->load->library("excel");
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Report');
            $this->excel->getActiveSheet()->setCellValue('A1', 'S.No.');
			$this->excel->getActiveSheet()->setCellValue('B1', 'Token No');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Name');
			$this->excel->getActiveSheet()->setCellValue('D1', 'Hostel');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Phone No');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Payment Type');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Booking Date');
            
            $i = 1;$j = 2;
            foreach($query['data'] as $product)
            {
				$payment_type='Wallet';
				if($product->payment_type==2){$payment_type='COD';};
                $row = array();
                $this->excel->getActiveSheet()->setCellValue('A'.$j, $i);
				$this->excel->getActiveSheet()->setCellValue('B'.$j, $product->token_no);
                $this->excel->getActiveSheet()->setCellValue('C'.$j, $product->firstname.' '.$product->lastname);
				$this->excel->getActiveSheet()->setCellValue('D'.$j, $product->hostel_name);
                $this->excel->getActiveSheet()->setCellValue('E'.$j, $product->phone_no);
                $this->excel->getActiveSheet()->setCellValue('F'.$j, $payment_type);
                $this->excel->getActiveSheet()->setCellValue('G'.$j, $product->book_date);
               
                $i++;$j++;
            }
            $this->excel->stream(time().'_report.xls');
        }
		else{redirect('panel/orders/search-order');}
    }
}