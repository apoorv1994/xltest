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
       
        $ref_code = $this->user_referral();
        $pagedata['referral_code'] = $ref_code; 
        $pagedata['u_pickup_t'] = $last_order['pickup_t'];
        $pagedata['u_delivery_date'] = $last_order['shop_close_date'];

        $pagedata['hslots'] = $last_order['slots'];
        $pagedata['droptime'] = '';
        $pagedata['details'] = $this->users->get_user('firstname,wallet_balance,profile_pic,phone_no,college_id,hostel_id',  $this->session->user_id);
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

    function alert_cashback()
    {
        // CASHBACK - After order status is completed--- amount directly added in the wallet
        $cashdata = $this->db->select('order_id,user_id,cashback_status')->where(['user_id'=>$this->session->user_id])->get('tbl_dynamic_ref')->result();
        $all_cb = '';
        $count = 0;
        foreach($cashdata as $cdata)       // referral_used is pickup date time stored 
        {   
            $ordid = $cdata->order_id;
            $orderdata = $this->db->select('status')->where(['id'=>$ordid])->get('tbl_order')->row();
            if($orderdata->status == 5) // 5 means order has been delivered
            {
                //$tm = time() + 24*60*60 ;     // after 24hrs of time of pickup user will get cashback
                //$cashback_date = $cback->referral_used ;
                $cbdata = $this->db->select('cashback_amount')->where(['order_id'=>$ordid])->get('tbl_referral_details')->row();
                $cashback_amt = $cbdata->cashback_amount;
                $msg_cb = "Rs ".$cashback_amt." is added in your wallet as cashback.<br>";
                
                $this->londury->apply_referral($this->session->user_id,$cashback_amt);
                $this->db->delete('tbl_dynamic_ref',['user_id'=> $this->session->user_id,'order_id'=>$ordid]);
            
                $all_cb = $all_cb.$msg_cb;
                $count+=1;
            }
        }

        if($count > 0)
        {
            echo json_encode(["status"=>true,"message"=>$all_cb]);
        }
        else{
            echo json_encode(["status"=>false]);
        }    
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

    function user_referral()
    {
    	$refdata = $this->db->select('referral_code')->where(['id'=>$this->session->user_id])->get('tbl_users')->row();
    	return $refdata->referral_code;
    }

    function get_user() 
    {
        echo json_encode($this->users->get_user('firstname,wallet_balance,profile_pic,phone_no,college_id,hostel_id',  $this->session->user_id));
    }
    
    function drycleaning()
    {
        $this->londury->delete_incomplete();
        $pagedata['title']='Dry Cleaning';
        $pagedata['drycleaning'] = 'current-slot';
        $last_order = $this->last_order();
        $pagedata['last_order'] = $last_order['last_order'];
        
        $pagedata['hslots'] = $last_order['slot'];
        $pagedata['details'] = $this->users->get_user('firstname,profile_pic,wallet_balance,phone_no,college_id,hostel_id',  $this->session->user_id);
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
        $pagedata['details'] = $this->users->get_user('firstname,profile_pic,wallet_balance,phone_no,college_id,hostel_id',  $this->session->user_id);
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
        $pagedata['details'] = $this->users->get_user('firstname,profile_pic,wallet_balance,phone_no,college_id,hostel_id',  $this->session->user_id);
        $pagedata['slots'] = $this->londury->get_slot($pagedata['details']->college_id);
        $pagedata['hostel_details'] = $this->londury->get_hostel_detail($pagedata['details']->hostel_id);
        //$pagedata['price'] = $this->londury->get_options('sc_shoe_price',  $this->session->college_id);
		$iron_price = $this->londury->get_options('iron_price',  $this->session->college_id);
		$sc_shoe_price = $this->londury->get_options('sc_shoe_price',  $this->session->college_id);
		$pagedata['price_iron'] = $this->londury->get_options('sc_shoe_price_iron',  $this->session->college_id);
		$pagedata['price'] = $iron_price + $sc_shoe_price;
        $this->load->view('header_vw',$pagedata);
        $this->load->view('home/bookslot_vw');
        $this->load->view('footer_vw');
    }
    
    function last_order()
    {
        $last_order = $this->londury->get_user_last_order();
        $slots = $this->londury->get_slot($this->session->college_id);
        $res = $this->db->select('value')->where(['options'=> 'shop_close','college_id'=>$this->session->college_id])->get('tbl_settings')->result();
        $newarr = [];
        $pickup = [];

        $shop_close_d = $this->get_delivery_date($last_order->book_date,$res,$last_order->order_type);
        foreach($slots as $slot)
        {
            switch($slot->slot_type)
            {
                case 'Morning':
                    $newarr[1]=date('H:s A',strtotime($slot->start_time)).' - '.date('H:s A',strtotime($slot->end_time));
                    $pickup[1]= date('H:s A',strtotime($slot->pickup_time));
                    break;
                case 'Afternoon':
                    $newarr[2]=date('H:s A',strtotime($slot->start_time)).' - '.date('H:s A',strtotime($slot->end_time));
                    $pickup[2]= date('H:s A',strtotime($slot->pickup_time));
                    break;
                case 'Evening':
                    $newarr[3]=date('H:s A',strtotime($slot->start_time)).' - '.date('H:s A',strtotime($slot->end_time));
                    $pickup[3]= date('H:s A',strtotime($slot->pickup_time));
                    break;
                case 'Night':
                    $newarr[4]=date('H:s A',strtotime($slot->start_time)).' - '.date('H:s A',strtotime($slot->end_time));
                    $pickup[4]= date('H:s A',strtotime($slot->pickup_time));
                    break;
                
            }
        }
        return ['last_order'=>$last_order,'slots'=>$newarr,'pickup_t'=>$pickup,'shop_close_date'=>$shop_close_d];
    }

function get_delivery_date($book,$close_info,$type)
{
    $temp_del = 0;
    if($type!='3'){
        $temp_del = $book + 2*24*3600;
    }
    else{
        $temp_del = $book + 5*24*3600;
    }
    $temp_close_info = $close_info;
    $i=0;
    foreach($temp_close_info as $tsci)
    {
            $str = explode("-",$tsci->value);
            $close = strtotime($str[2].'-'.$str[1].'-'.$str[0]);
            if($close < $temp_del && $close > $book){
                $i=$i+1;
            }      
    }
        
    $temp_del = $temp_del + $i*24*3600;

    foreach($close_info as $sci)
    {
        if($type!='3')
        {
            $str = explode("-",$sci->value);
            $close = strtotime($str[2].'-'.$str[1].'-'.$str[0]);            
            if($temp_del==$close){              
                $temp_del = $temp_del+24*3600;
            }     
        }
        else{
            if($temp_del==$close){
                $temp_del = $temp_del+24*3600;
            }      
        }
    }

    return $temp_del;
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
    
    function orderOld()
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
			$pagedata['sc_SGST'] = $this->londury->get_options('sc_SGST',  $pagedata['details']->college_id);
			$pagedata['sc_CGST'] = $this->londury->get_options('sc_CGST',  $pagedata['details']->college_id);
			$pagedata['sc_IGST'] = $this->londury->get_options('sc_IGST',  $pagedata['details']->college_id);
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
        $booktype = [1=>'Bulk Wash',2=>'Premium Wash',3=>'Dry Cleaning',4=>'Individual Wash',10=>'Bulk Wash & Fold',20=>'Premium Wash',30=>'Dry Cleaning',40=>'Individual Wash',11=>'Bulk Wash & Iron',21=>'Premium Wash',31=>'Dry Cleaning',41=>'Individual Iron',42=>'Individual Wash'];
        if($invoice)
        {
            $iron = json_decode($invoice->iron_cost);
			
            
            $pagedata = ['invoice_id'=>'XPL'.$invoice->invoice_id,'order_no'=>$id,'invoice_date'=>date('d-m-Y',$invoice->invoice_date),'hostel_name'=>$invoice->hostel_name,'college_name'=>$invoice->college_name,'college_email'=>$invoice->college_email,'phone'=>$invoice->phone,'college_address'=>$invoice->address,
                        'order_date'=>date('d-m-Y',$invoice->created),'customer_name'=>$invoice->firstname,
                        'mobile'=>$invoice->phone_no,'no_of_clothes'=>$invoice->no_of_items,'washtype'=>$booktype[$invoice->order_type.$invoice->iron],'order_type'=>$invoice->order_type,
                        'weight'=>$invoice->weight,'iron_qty'=>$iron->iron_no,'iron_rate'=>$invoice->settings['iron_price'],
                        'iron_amount'=>$iron->total_iron_price,'pick_rate'=>$invoice->settings['pickdrop'],'pick_cost'=>$invoice->pickup_cost,
                        'total'=>$invoice->final_amount,'coupon_applied'=>$invoice->coupon_applied,'discount'=>$invoice->discount,'gst'=>$invoice->gst,'settings'=>$invoice->settings,'order_data'=>$invoice->items,'extra_amt'=>$invoice->extra_amount,'order_amount'=>$invoice->total_amount,'sc_GST_Number'=>$invoice->sc_GST_Number,'sc_SGST'=>$invoice->sc_SGST,'sc_CGST'=>$invoice->sc_CGST,'sc_IGST'=>$invoice->sc_IGST,'iron'=>$invoice->iron,'book_date'=>$invoice->book_date,'other_sc_SGST'=>$invoice->other_sc_SGST,'other_sc_CGST'=>$invoice->other_sc_CGST,'other_sc_IGST'=>$invoice->other_sc_IGST,'comment'=>$invoice->comment,'ironed'=>$invoice->ironed,'extra_amount_for_adjustment'=>$invoice->extra_amount_for_adjustment,'other_discount'=>$invoice->other_discount];
            
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
			
            $details = $this->users->get_user('firstname,wallet_balance,college_id,phone_no',  $this->session->user_id);
            $iron = $this->input->post('iron');
            $orders = $this->londury->order_summary();
            $this->form_validation->set_rules('total','Total','trim|required|xss_clean');
            $this->form_validation->set_rules('payment_method','Payment Method','trim|required|xss_clean');
            $this->form_validation->set_rules('coupon','Coupon Code','trim|xss_clean');
            if($this->form_validation->run())
            {
				$orderAmount=$this->input->post('total');
				$orderdDetails = $this->londury->get_order_by_id($this->input->post('order_id'));
				if($orderdDetails)
				{
					$orderAmount=$orderdDetails;
				}
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
                                    $d_amount = ($orderAmount*$res->percent_discount)/100;
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
				
				$sc_SGST = $this->londury->get_options('sc_SGST',  $details->college_id);
				$sc_CGST = $this->londury->get_options('sc_CGST',  $details->college_id);
				$sc_IGST = $this->londury->get_options('sc_IGST',  $details->college_id);
				if(empty($sc_SGST)){$sc_SGST=0;}
				if(empty($sc_CGST)){$sc_CGST=0;}
				if(empty($sc_IGST)){$sc_IGST=0;}
				$totalSGST=number_format($orderAmount*$sc_SGST/100,2);
				
				$totalCGST=number_format($orderAmount*$sc_CGST/100,2);
				
				$totalIGST=number_format($orderAmount*$sc_IGST/100,2);
				
                if($orderAmount > $discount)
                {
                    $total_amount = $orderAmount - $discount;
                }
                else{
                    $total_amount = 0;
                    $discount = $orderAmount;
                }
                //echo "<script type='text/javascript'>alert('Referral System');</script>";
                $payment_type = 0;
                if($this->input->post('payment_method')=='wallet')
                {
                    $payment_type = 1;
                    if($details->wallet_balance >= $total_amount)
                    {
                        if($total_amount>0)
                        {
							$TotalPriceAmount=$total_amount + $totalSGST + $totalCGST + $totalIGST;
                            $balance = $details->wallet_balance - $TotalPriceAmount;
                            $this->londury->update_wallet($balance);
                            // apply referral system here when its user first order
                            $num_order = $this->londury->get_count_order($this->session->user_id);  // gets number of orders from tbl_orders by a user
                            if ($num_order == 1)    // true only if it is his first order
                            {
                                $ref_info = $this->londury->get_referral_info($this->session->user_id);
                                
                                $id1= $ref_info->referrer_id;
                                $id2 = $ref_info->referree_id;
                                $this->londury->test_working($id1,$id2);
                                if($ref_info)
                                {
                                    // add money to current user and also add money to referral_id
                                    $cashback = $total_amount * 0.1;
                                    $max_cashback = 100;  // maximum cashback a user can get if $cashback > 100
                                    if($cashback > $max_cashback)
                                    {
                                        $cashback = $max_cashback;
                                    }
                                    $order_info = $this->londury->get_details_first_order($this->session->user_id);
                                    $orderid = $order_info->id;
                                    $this->db->update('tbl_referral_details',['order_id'=>$orderid,'cashback_amount'=>$cashback],['referrer_id'=>$id1]);
                                    $this->db->insert('tbl_dynamic_ref',['order_id'=>$orderid,'user_id'=>$id1,'cashback_status'=>1]);
                                    $this->db->insert('tbl_dynamic_ref',['order_id'=>$orderid,'user_id'=>$id2,'cashback_status'=>1]);
                                }                    
                            }

                        }
                        $this->londury->update_order_with_gst(1,$discount,$coupon,$total_amount,$iron,$cost,$details->college_id,$totalSGST,$totalCGST,$totalIGST);
                    }else{
                        echo json_encode(['status'=>FALSE,'error'=>'<div class="err">Cannot proceed: Please recharge your Wallet to Continue</div>']);
                        exit;
                    }
                }
                if($this->input->post('payment_method')=='cod')
                {
                    if($this->londury->get_cod_status($details->college_id)=='On')
                    {
                        $this->londury->update_order_with_gst(2,$discount,$coupon,0,$iron,$cost,$details->college_id,$totalSGST,$totalCGST,$totalIGST);
                    }else{
                        echo json_encode(['status'=>FALSE,'error'=>'<span class="err">Invalid Request</span>']);
                        exit;
                    }
                }
				$orders = $this->londury->get_order_summary_by_id($this->input->post('order_id'));
				if($orders)
				{
						$uname=$details->firstname;
						$order_type="Bulk Wash";
						$slotName="Morning";
						if($orders->order_type==1){$order_type='Bulk Wash';}
						else if($orders->order_type==4){$order_type='Individual Wash';}
						else if($orders->order_type==3){$order_type='Dry Cleaning';}
						else if($orders->order_type==2){$order_type='Premium Wash';}
						
						if($orders->book_slot==1){$slotName="Morning";}
						else if($orders->book_slot==2){$slotName="Afternoon";}
						else if($orders->book_slot==3){$slotName="Evening";}
						else if($orders->book_slot==4){$slotName="Night";}
						
						$slotday=date("Y-m-d",$orders->book_date);
						$scheduledT=date("Y-m-d",$orders->created);
						$hostel_name=$orders->hostel_name;
						$dropmsg = "Congratulations $uname Your $order_type is booked for $slotday. Your Pickup is scheduled in the $slotName from $hostel_name .Contact +91 8448362772 for any Queries . Thank you for choosing XL.";
						$msg = urlencode($dropmsg);
						$mobile = $details->phone_no;
						$url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
						$res = file_get_contents($url);
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
        $order_d = $this->db->select('created,book_date,book_slot,pickup_type,total_amount,payment_type,user_id,discount')
                ->where(['id'=>$id,'user_id'=>  $this->session->user_id])->get('tbl_order');
		print_r($order_d->num_rows());		
           // after cancellation update tbl_dynamic_ref i.e. delete rows corresponding to order_id = $id
        $this->db->delete('tbl_dynamic_ref',['order_id'=>$id]);

	if($order_d->num_rows()>0)
        {
            $data = $order_d->row();
            $time = date('Y-m-d',$data->book_date).' '.date('H:i',$newarr[$data->book_slot]-(2*3600));
            //if(time()> strtotime($time))
			if(time()< strtotime($time))
            {
                $user = $this->users->get_user('firstname,email_id,wallet_balance,phone_no',  $this->session->user_id);
                $this->db->update('tbl_order',['status'=>6],['id'=>$id]);
                if($data->payment_type==1)
                {
                    $amount = ($user->wallet_balance+$data->total_amount)-$data->discount;
                    $this->db->update('tbl_users',['wallet_balance'=>$amount],['id'=>  $data->user_id]);
                }
				
				$firstname=$user->firstname;
				$date=date("Y-m-d",$data->book_date);
				$tam=$data->total_amount-$data->discount;
				if($data->payment_type==1)
                {
					$dropmsg = "Hello $firstname, You have canceled your order for $date. Rs.$tam will be refunded in your walllet. We would love to hear from you at : http://xpresslaundromat.in.";
				}
				else
				{
					$dropmsg = "Hello $firstname, You have canceled your order for $date. We would love to hear from you at : http://xpresslaundromat.in.";
				}
                $msg = urlencode($dropmsg);
                $mobile = $user->phone_no;
                $url = "http://www.siegsms.com/SendingSms.aspx?userid=xpress&pass=xpress@123&phone=$mobile&msg=$msg&title=XLOMAT";
				$res = file_get_contents($url);
				
                $message="<p>Hello ".$user->firstname."</p><p>Your are order has been cancelled.</p><p> Rs. ".$data->total_amount-$data->discount." will be refunded in your walllet. Log on to your account for more details</p>";
                $email=array('to'=>$user->email_id,'message'=>$message,'subject'=>'Order Cancelled');
                //$this->functions->_email($email);
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
	//$this->db->insert('tbl_string',['message'=>"Just outside validation order : "]);
        if($this->form_validation->run())
        {
	   // $this->db->insert('tbl_string',['message'=>"Inside validation order : "]);
            $service =2;
            if($this->input->post('order_type')=='bulkwashing')
            {
                $service='1';
            }
            //echo $this->input->post('slotday');
            $slot = $this->londury->check_slot($this->input->post('slotday'),$service,$this->input->post('college_id'),$this->input->post('hostel_id'));
            $aval = 'yes';
	    //$this->db->insert('tbl_string',['message'=>"Below Slot check : ".$slot['morning']]);
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
			//print_r($id);die;
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
}
