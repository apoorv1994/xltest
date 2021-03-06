<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->users->_valid_user();
    }

    function index()
    {
        $this->londury->delete_incomplete();
        $pagedata['title']='Bulk Washing';
        $pagedata['bulk'] = 'current-slot';
        $last_order = $this->last_order();
        $pagedata['last_order'] = $last_order['last_order'];
        
        $pagedata['hslots'] = $last_order['slots'];
        $pagedata['droptime'] = '';
        $pagedata['details'] = $this->users->get_user('firstname,wallet_balance,profile_pic,phone_no,room_no,college_id,hostel_id',  $this->session->user_id);
        $this->db->select('slot_type,start_time,end_time,slots_available,pickup_time');
        $pagedata['slots'] = $this->db->from('tbl_slot_type')->where(['college_id'=>$pagedata['details']->college_id])->get()->result();
        $pagedata['hostel_details'] = $this->londury->get_hostel_detail($pagedata['details']->hostel_id);
        $pagedata['price_iron'] = $this->londury->get_options('sc_bulk_price_iron',  $this->session->college_id);
        $pagedata['price_fold'] = $this->londury->get_options('sc_bulk_price_fold',  $this->session->college_id);
        $pagedata['weight'] = $this->londury->get_options('slot_weight',  $this->session->college_id);
        $pagedata['shopstatus'] = $this->londury->get_options('shop_status',$this->session->college_id);
        //echo json_encode($pagedata['hostel_details']);
        $this->load->view('header_vw',$pagedata);
        $this->load->view('home/bookslot_vw',$pagedata);
        $this->load->view('footer_vw');
    }

    function check_close()
    {
        $cdata = ['val'=>'id,options,value','where'=>['college_id'=>$this->input->post('college_id'),'options'=>'shop_close'],'table'=>'tbl_settings'];
        $resc = $this->common->get_where_all($cdata);
        if($resc['res'])
        {
            $flag=0;
            foreach($resc['rows'] as $row)
            {
                if($row->value==$this->input->post('date'))
                    $flag=1;
            }
        }
        if($flag==1)
            echo json_encode(['status'=>true,'shop'=>true]);
        else
            echo json_encode(['status'=>true,'shop'=>false]);
    }

    function get_user() 
    {
        echo json_encode($this->users->get_user('firstname,wallet_balance,profile_pic,phone_no,room_no,college_id,hostel_id',  $this->session->user_id));
    }
    
    function drycleaning()
    {
        $this->londury->delete_incomplete();
        $pagedata['title']='Dry Cleaning';
        $pagedata['drycleaning'] = 'current-slot';
        $last_order = $this->last_order();
        $pagedata['last_order'] = $last_order['last_order'];
        
        $pagedata['hslots'] = $last_order['slot'];
        $pagedata['details'] = $this->users->get_user('firstname,profile_pic,wallet_balance,phone_no,room_no,college_id,hostel_id',  $this->session->user_id);
        $pagedata['hostel_details'] = $this->londury->get_hostel_detail($pagedata['details']->hostel_id);
        $pagedata['slots'] = $this->londury->get_slot($pagedata['details']->college_id);
        $pagedata['price'] = '0.00';
        $pagedata['prices'] = $this->get_price();
        $this->load->view('header_vw',$pagedata);
        $this->load->view('home/bookslot_vw');
        $this->load->view('footer_vw');
    }
    
    function premium()
    {
        $this->londury->delete_incomplete();
        $pagedata['title']='Premium Washing';
        $pagedata['individual'] = 'current-slot';
        $last_order = $this->last_order();
        $pagedata['last_order'] = $last_order['last_order'];
        
        $pagedata['hslots'] = $last_order['slot'];
        $pagedata['details'] = $this->users->get_user('firstname,profile_pic,wallet_balance,phone_no,room_no,college_id,hostel_id',  $this->session->user_id);
        $pagedata['hostel_details'] = $this->londury->get_hostel_detail($pagedata['details']->hostel_id);
        $pagedata['slots'] = $this->londury->get_slot($pagedata['details']->college_id);
        $pagedata['price'] = "0.00";
        $pagedata['prices'] = $this->get_price();
        $this->load->view('header_vw',$pagedata);
        $this->load->view('home/bookslot_vw');
        $this->load->view('footer_vw');
    }
    
    function individual()
    {
        $this->londury->delete_incomplete();
        $pagedata['title']='Individual Washing';
        $pagedata['shoelaundry'] = 'current-slot';
        $last_order = $this->last_order();
        $pagedata['last_order'] = $last_order['last_order'];
        
        $pagedata['hslots'] = $last_order['slot'];
        $pagedata['details'] = $this->users->get_user('firstname,profile_pic,wallet_balance,phone_no,room_no,college_id,hostel_id',  $this->session->user_id);
        $pagedata['slots'] = $this->londury->get_slot($pagedata['details']->college_id);
        $pagedata['hostel_details'] = $this->londury->get_hostel_detail($pagedata['details']->hostel_id);
        $pagedata['price'] = $this->londury->get_options('sc_shoe_price',  $this->session->college_id);
		$pagedata['price_iron'] = $this->londury->get_options('sc_shoe_price_iron',  $this->session->college_id);
        $this->load->view('header_vw',$pagedata);
        $this->load->view('home/bookslot_vw');
        $this->load->view('footer_vw');
    }
    
    function last_order()
    {
        $last_order = $this->londury->get_last_order();
        $slots = $this->londury->get_slot($this->session->college_id);
        $newarr = [];
        foreach($slots as $slot)
        {
            switch($slot->slot_type)
            {
                case 'Morning':
                    $newarr[1]=date('H:s A',strtotime($slot->start_time)).' - '.date('H:s A',strtotime($slot->end_time));
                    break;
                case 'Afternoon':
                    $newarr[2]=date('H:s A',strtotime($slot->start_time)).' - '.date('H:s A',strtotime($slot->end_time));
                    break;
                case 'Evening':
                    $newarr[3]=date('H:s A',strtotime($slot->start_time)).' - '.date('H:s A',strtotime($slot->end_time));
                    break;
                case 'Night':
                    $newarr[4]=date('H:s A',strtotime($slot->start_time)).' - '.date('H:s A',strtotime($slot->end_time));
                    break;
                
            }
        }
        return ['last_order'=>$last_order,'slots'=>$newarr];
    }
    
    function check_slot()
    {
        $this->form_validation->set_rules('day','Day','trim|required|xss_clean');
        $this->form_validation->set_rules('service','Service','trim|required|xss_clean');
        $this->form_validation->set_rules('college_id','College Id','trim|required|xss_clean');
        //$this->form_validation->set_rules('hostel_id','Hostel Id','trim|required|xss_clean');
        //echo $this->input->post('day');
        if($this->form_validation->run())
        {
            $service =2;
            if($this->input->post('service')=='bulkwashing')
            {
                $service='1';
            }
            //$this->londury->check_slot("2017-10-05",1,5,85)
            //echo $this->input->post('day');
            $slot = $this->londury->check_slot($this->input->post('day'),$service,$this->input->post('college_id'));
            //echo json_encode($slot);
            echo json_encode(['status'=>TRUE,'morning'=>$slot['morning'],'afternoon'=>$slot['afternoon'],'evening'=>$slot['evening'],'night'=>$slot['night']]);
        }else{
            echo json_encode(['status'=>FALSE,'error'=>  validation_errors()]);
        }
    }
    
    function order()
    {
        
        $this->form_validation->set_rules('slotday','Day','trim|required|xss_clean');
        $this->form_validation->set_rules('slotInput','Time Slot','trim|required|xss_clean');
        $this->form_validation->set_rules('quantity_shirt','Shirts','trim|xss_clean');
        $this->form_validation->set_rules('college_id','College Id','trim|required|xss_clean');
        $this->form_validation->set_rules('hostel_id','Hostel Id','trim|required|xss_clean');
        $this->form_validation->set_rules('quantity_pants','Pants','trim|xss_clean');
        $this->form_validation->set_rules('quantity_undergarments','Undergarments','trim|xss_clean');
        $this->form_validation->set_rules('quantity_towel','Towel','trim|xss_clean');
        $this->form_validation->set_rules('quantity_others','others','trim|xss_clean');
        $this->form_validation->set_rules('quantity_suit','Suit','trim|xss_clean');
        $this->form_validation->set_rules('quantity_blanket','blanket','trim|xss_clean');
        $this->form_validation->set_rules('order_type','Order Type','trim|required|xss_clean');
        if($this->input->post('order_type')=='individual')
        {
            if($this->input->post('quantity')==0){$_POST['quantity']='';}
            $this->form_validation->set_rules('quantity','No of clothes','trim|required|xss_clean');
        }
        $this->form_validation->set_rules('pickup','Pick Type','trim|required|xss_clean');
        $this->form_validation->set_message('required', 'Please select %s ');
        $this->form_validation->set_error_delimiters('', '');
        if($this->form_validation->run())
        {
            $service =2;
            if($this->input->post('order_type')=='bulkwashing')
            {
                $service='1';
            }
            //echo $this->input->post('slotday');
            $slot = $this->londury->check_slot($this->input->post('slotday'),$service,$this->input->post('college_id'),$this->input->post('hostel_id'));
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
                echo json_encode(['status'=>  FALSE,'error'=>['error'=>'Slot Not Available.']]);
                exit;
            }
            
            $id = $this->londury->_order($this->input->post());
            $this->session->set_userdata('order',$id);
            echo json_encode(['status'=>TRUE]);
        }else{
             $error = ['slotday_err'=> form_error('slotday'),'slotInput_err'=>  form_error('slotInput'),'quantity_shirt_err'=>form_error('quantity_shirt'),
                'quantity_pants_err'=>form_error('quantity_pants'),'quantity_undergarments_err'=>form_error('quantity_undergarments'),'quantity_err'=>form_error('quantity'),
                'quantity_towel_err'=>form_error('quantity_towel'),'quantity_others_err'=>form_error('quantity_others'),'pickup_err'=>form_error('pickup'),
                'quantity_suit_err'=>form_error('quantity_suit'),'quantity_blanket_err'=>form_error('quantity_blanket'),'order_type_err'=>form_error('order_type')];
                
            echo json_encode(['status'=>  FALSE,'error'=>$error]);
        }
    }
    
    function get_price()
    {
        $result =[];
       $res = $this->londury->get_options('',$this->session->college_id);
       foreach($res as $data)
       {
           $result[$data->options] = $data->value;
       }
       return $result;
    }
    
    function order_summary()
    {
        if($this->session->order)
        {
            $pagedata['details'] = $this->users->get_user('firstname,wallet_balance,college_id',  $this->session->user_id);
            $pagedata['orders'] = $this->londury->order_summary();
            $pagedata['cod']=$this->londury->get_cod_status($pagedata['details']->college_id);
            if($pagedata['orders'])
            {
                $pagedata['title'] = 'Order Summary';
                $this->load->view('header_vw',$pagedata);
                $this->load->view('home/ordersummary_vw');
                $this->load->view('footer_vw');
            }else{
                redirect('home');
            }
        }
        else{
                redirect('home');
            }
    }
    
    function order_history()
    {
        $pagedata['details'] = $this->users->get_user('firstname,wallet_balance',  $this->session->user_id);
        $pagedata['title'] = 'Order History';
        $pagedata['recent_order'] = $this->londury->recent_order();
        $pagedata['order_history'] = $this->londury->order_history();
        $slots = $this->londury->get_slot($this->session->college_id);
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
        $this->load->view('header_vw',$pagedata);
        $this->load->view('home/order_history_vw');
        $this->load->view('footer_vw');
    }
    
    function view_invoice($id)
    {
        $invoice =  $this->londury->get_invoice_data($id);
        $booktype = [1=>'Bulk Wash',2=>'Premium Wash',3=>'Dry Cleaning',4=>'Individual Wash'];
        if($invoice)
        {
            $iron = json_decode($invoice->iron_cost);
            
            $pagedata = ['invoice_id'=>'XPL'.$invoice->invoice_id,'order_no'=>$id,'invoice_date'=>date('d-m-Y',$invoice->invoice_date),'hostel_name'=>$invoice->hostel_name,
                        'order_date'=>date('d-m-Y',$invoice->created),'customer_name'=>$invoice->firstname.' '.$invoice->lastname,'room_no'=>$invoice->room_no,
                        'mobile'=>$invoice->phone_no,'no_of_clothes'=>$invoice->no_of_items,'washtype'=>$booktype[$invoice->order_type],'order_type'=>$invoice->order_type,
                        'weight'=>$invoice->weight,'iron_qty'=>$iron->iron_no,'iron_rate'=>$invoice->settings['iron_price'],
                        'iron_amount'=>$iron->total_iron_price,'pick_rate'=>$invoice->settings['pickdrop'],'pick_cost'=>$invoice->pickup_cost,
                        'total'=>$invoice->final_amount,'coupon_applied'=>$invoice->coupon_applied,'discount'=>$invoice->discount,'gst'=>$invoice->gst,'settings'=>$invoice->settings,'order_data'=>$invoice->items,'extra_amt'=>$invoice->extra_amount,'order_amount'=>$invoice->total_amount];
            
            $this->load->view('header_vw',$pagedata);
            $this->load->view('panel/orders/invoice_email_vw');
            $this->load->view('footer_vw');
        }  else {
            $this->session->set_flashdata('error','Invalid Request.');
            redirect('home/order_history');
        }
    }
    
    function check_coupon()
    {
        $this->form_validation->set_rules('coupon','Coupon','trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $order = $this->londury->order_summary();
            $res = $this->londury->check_coupon($this->input->post('coupon'));
            if($res)
            {
                if($res->valid_from < time() && $res->valid_upto > time())
                {
                    $used_coupon = $this->londury->check_no_of_coupon_applied($this->input->post('coupon'),  $this->session->user_id);
                    if($res->repeat_times>$used_coupon)
                    {
                        if($res->percent_discount!='0')
                        {
                            $d_amount = $order->total_amount*$res->percent_discount/100;
                            if($d_amount <= $res->max_discount)
                            {
                                $discount = $d_amount;
                            }else{
                                $discount = $res->max_discount;
                            }
                        }else{
                            $discount = $res->max_discount;
                        }
                        echo json_encode(['status' => TRUE,'discount' => $discount,'discount_percent'=>$res->percent_discount]);
                    }else{
                        echo json_encode(['status' => FALSE,'error'=>'Already used Coupon code '.$this->input->post('coupon')]);
                    }
                }else{
                    echo json_encode(['status' => FALSE,'error'=>'Coupon code is invalid or expired.']);
                }
            }
            else{
                    echo json_encode(['status' => FALSE,'error'=>'Coupon code is invalid or expired.']);
                }
        }
        else{
                    echo json_encode(['status' => FALSE,'error'=>  'Please enter coupon code']);
                }
    }
    
    function place_order()
    {
        if($this->session->order)
        {
            $details = $this->users->get_user('firstname,wallet_balance',  $this->session->user_id);
            $iron = $this->input->post('iron');
            $orders = $this->londury->order_summary();
            $this->form_validation->set_rules('total','Total','trim|required|xss_clean');
            $this->form_validation->set_rules('payment_method','Payment Method','trim|required|xss_clean');
            $this->form_validation->set_rules('coupon','Coupon Code','trim|xss_clean');
            if($this->form_validation->run())
            {
                $discount = 0;
                $coupon = '';
				$cost=$this->input->post('cost');
                if($this->input->post('coupon')!='')
                {
                    $res = $this->londury->check_coupon($this->input->post('coupon'));
                    if($res)
                    {
                        if($res->valid_from < time() && $res->valid_upto > time())
                        {
                            $used_coupon = $this->londury->check_no_of_coupon_applied($this->input->post('coupon'),  $this->session->user_id);
                            if($res->repeat_times>$used_coupon)
                            {
                                if($res->percent_discount>0)
                                {
                                    $d_amount = ($this->input->post('total')*$res->percent_discount)/100;
                                    if($d_amount <= $res->max_discount)
                                    {
                                        $discount = $d_amount;
                                    }else{
                                        $discount = $res->max_discount;
                                    }
                                }else{
                                    $discount = $res->max_discount;
                                }
                                $coupon = $this->input->post('coupon');
                            }
                        }
                    }
                }
                
                if($this->input->post('total') > $discount)
                {
                    $total_amount = $this->input->post('total') - $discount;
                }
                else{
                    $total_amount = 0;
                    $discount = $this->input->post('total');
                }
                if($this->input->post('payment_method')=='wallet')
                {
                    if($details->wallet_balance >= $total_amount)
                    {
                        if($total_amount>0)
                        {
                            $balance = $details->wallet_balance - $total_amount;
                            $this->londury->update_wallet($balance);
                        }
                        $this->londury->update_order_new_one(1,$discount,$coupon,$total_amount,$iron,$cost);
                    }else{
                        echo json_encode(['status'=>FALSE,'error'=>'<div class="err">Cannot proceed: Please recharge your Wallet to Continue</div>']);
                        exit;
                    }
                }
                if($this->input->post('payment_method')=='cod')
                {
                    if($this->londury->get_cod_status($pagedata['details']->college_id)=='On')
                    {
                        $this->londury->update_order_new_one(2,$discount,$coupon,0,$iron,$cost);
                    }else{
                        echo json_encode(['status'=>FALSE,'error'=>'<span class="err">Invalid Request</span>']);
                        exit;
                    }
                }
                echo json_encode(['status'=>TRUE,'msg'=>'<div class="alert alert-success">Order Completed</div>']);
            }else{
                echo json_encode(['status'=>FALSE,'error'=>'<span class="err">Invalid Request</span>']);
            }
        }else{
            echo json_encode(['status'=>FALSE,'error'=>'<span class="err">Invalid Request</span>']);
        }
    }
    
    function get_pending_rating()
    {
        $res = $this->londury->get_prating_order($this->session->user_id);
        if($res)
        {
            $booktype = [1=>'Bulk Wash',2=>'Premium Wash',3=>'Dry Cleaning',4=>'Individual Wash'];
            $slottype = [1=>'Morning',2=>'Afternoon',3=>'Evening',4=>'Night'];
            $data = ['id'=>$res->id,'book_date'=>date('d/m/Y',$res->book_date),'order_type'=>$booktype[$res->order_type],'slot_type'=>$slottype[$res->book_slot]];
            echo json_encode(['status'=>TRUE,'data'=>$data]);
        }else{
            echo json_encode(['status'=>FALSE]);
        }
    }
    
    function save_rating()
    {
        $this->form_validation->set_rules('rating','Rating','trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('order','Order','trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('review','Review','trim|xss_clean');
        if($this->form_validation->run())
        {
            if($this->input->post('rating')>0 && $this->input->post('rating')<6 )
            {
                if($this->londury->check_valid_order($this->input->post('order'),$this->session->user_id))
                {
                    $data=['user_id'=>  $this->session->user_id,'order_id'=>  $this->input->post('order'),'rating'=>$this->input->post('rating'),'comments'=>  $this->input->post('review'),'created'=>time()];
                    $this->db->insert('tbl_ratings',$data);
                    //echo $this->db->last_query();die;
                    echo json_encode(['status'=>TRUE]);
                }
                else{
                    echo json_encode(['status'=>FALSE,'error'=>['main_err'=>'<span class="err">Invalid Request1</span>']]);
                }
            }else{
                echo json_encode(['status'=>FALSE,'error'=>['main_err'=>'<span class="err">Invalid Request</span>']]);
            }
        }else{
            $error = ['rating_err'=>  form_error('rating'),'review_err'=>  form_error('review')];
            echo json_encode(['status'=>  FALSE,'error'=>$error]);
        }
    }
    
    function order_cancel($id)
    {
        $slots = $this->londury->get_slot($this->session->college_id);
        $newarr = [];
        foreach($slots as $slot)
        {
            switch($slot->slot_type)
            {
                case 'Morning':
                    $newarr[1]=strtotime($slot->start_time);
                    break;
                case 'Afternoon':
                    $newarr[2]=strtotime($slot->start_time);
                    break;
                case 'Evening':
                    $newarr[3]=strtotime($slot->start_time);
                    break;
                case 'Night':
                    $newarr[4]=strtotime($slot->start_time);
                    break;
            }
        }
        $order_d = $this->db->select('book_date,book_slot,pickup_type,total_amount,payment_type,user_id,discount')
                ->where(['id'=>$id,'user_id'=>  $this->session->user_id])->get('tbl_order');
        if($order_d->num_rows()>0)
        {
            $data = $order_d->row();
            $time = date('Y-m-d',$data->book_date).' '.date('H:i',$newarr[$data->book_slot]-(2*3600));
            if(time()> strtotime($time))
            {
                $user = $this->users->get_user('firstname,email_id,wallet_balance',  $this->session->user_id);
                $this->db->update('tbl_order',['status'=>6],['id'=>$id]);
                if($data->payment_type==1)
                {
                    $amount = ($user->wallet_balance+$data->total_amount)-$data->discount;
                    $this->db->update('tbl_users',['wallet_balance'=>$amount],['id'=>  $data->user_id]);
                }
                $message="<p>Hello ".$user->firstname."</p><p>Your are order has been cancelled.</p><p> Rs. ".$data->total_amount-$data->discount." will be refunded in your walllet. Log on to your account for more details</p>";
                $email=array('to'=>$user->email_id,'message'=>$message,'subject'=>'Order Cancelled');
                $this->functions->_email($email);
                $this->session->set_flashdata('msg','Order Cancelled.');
                redirect(BASE.'home');
            }else{
                $this->session->set_flashdata('error','Order cannot be Cancelled.');
                redirect(BASE.'home');
            }
        }else{
            $this->session->set_flashdata('error','Order cannot be Cancelled.');
            redirect(BASE.'home');
        }
        
    }
}