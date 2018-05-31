<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Londury extends CI_Model {
    function get_hostel($id)
    {
        return $this->db->select('id,hostel_name,morning,afternoon,evening,night')
                ->where(['college_id'=>$id])
                ->order_by('hostel_name','ASC')
                ->get('tbl_hostel')
                ->result();
    }

    function get_hostel_detail($id)
    {
        return $this->db->select('id,hostel_name,morning,afternoon,evening,night')
                ->where(['id'=>$id])
                ->get('tbl_hostel')
                ->row();
    }
    	function get_hostel_list()
    {
        return $this->db->select('id,hostel_name')
                ->order_by('hostel_name','ASC')
                ->get('tbl_hostel')
                ->result();
    }
    function get_suffix($id)
    {
        return $this->db->select('value')->where(['college_id'=>$id,'options'=>'email_suffix'])->get('tbl_settings')->row()->value;
    }
            
    function get_slot($college_id)
    {
        $this->db->select('slot_type,start_time,end_time,slots_available,pickup_time');
        $res = $this->db->from('tbl_slot_type')->where(['college_id'=>$college_id])->get()->result();
        return $res;
    }
    function get_custom_slot($college_id,$date)
    {
        $this->db->select('morning,afternoon,evening,night');
        return $this->db->from('tbl_custom_slot')->where(['college_id'=>$college_id,'date'=>$date])->get()->row();
    }
    
    function get_options($option='',$college_id)
    {
        if($option!='')
        {
            $res = $this->db->select('value')->where(['options'=>$option,'college_id'=>$college_id])->get('tbl_settings')->row()->value;
        }else{
            $res = $this->db->select('options,value')->where(['college_id'=>$college_id])->get('tbl_settings')->result();
        }
        return $res;
    }
    
    function _order($data,$status=0)
    {
        //return $data;
        /*if($this->session->college_id)
        {
            $data['college_id'] = $this->session->college_id;
        }*/
        if($this->session->user_id)
        {
            $data['user_id'] = $this->session->user_id;
        }
        $data['status'] = $status;
        
        switch ($data['order_type'])
        {
            case 'bulkwashing':
                return $this->bulkwashing_order($data);
                break;
            case 'premium':
                return $this->premium_order($data);
                break;
            case 'drycleaning':
                return $this->drycleaning_order($data);
                break;
            case 'individual':
                return $this->individual_order($data);
                break;
        }
    }
            
    function bulkwashing_order($data)
    {
		$coupon_code="";
		if($data['coupon_code'])
		{
			$coupon_code=$data['coupon_code'];
		}
        $cost = 0;
        $iron = 0;
        if($data['wash_type']=='iron')
         {
            $cost = $this->get_options('sc_bulk_price_iron',  $data['college_id']);
            $iron = 1;
         }
        if($data['wash_type']=='fold')
         $cost = $this->get_options('sc_bulk_price_fold',  $data['college_id']);
        $pickuptype = $data['pickup']=='self_pickup'?1:2;
        if(!$data['payment_type']){$data['payment_type']=2;}
        $bookdate = strtotime($data['slotday']);
        $indata = ['user_id'=>  $data['user_id'],'order_type'=>1,'total_amount'=>$cost,'discount'=>0,'pickup_type'=>$pickuptype,'payment_type'=>$data['payment_type'],'book_date'=>$bookdate,'book_slot'=>$data['slotInput'],'created'=>time(),'status'=>$data['status'],'iron'=>$iron,'coupon_applied'=>$data['coupon_code'],'discount'=>$data['discount']];
        $this->db->insert('tbl_order',$indata);
        $id = $this->db->insert_id();
        $order_data = ['order_id'=>$id,'items'=>'Total Clothes','quantity'=>$data['quantity'],'cost'=>$cost];
        $this->db->insert('tbl_order_items',$order_data);
        return $id;
    }
    
    function premium_order($data)
    {
		$coupon_code="";
		if($data['coupon_code'])
		{
			$coupon_code=$data['coupon_code'];
		}
        $costlist = $this->get_options('',  $data['college_id']);
        $cost=0;
        $total = $data['total_price'];
        if(!$data['payment_type']){$data['payment_type']=2;}
        $order_data = [];
        foreach($costlist as $prices)
        {
            if($prices->options =='sc_indi_pant_price')
            {
                $cost +=$data['quantity_pants']*$prices->value;
                $total -=$data['quantity_pants']*$prices->value;
                $order_data[] = ['items'=>'Pant','quantity'=>$data['quantity_pants'],'cost'=>$prices->value];
            }
            if($prices->options =='sc_indi_undergarment_price')
            {
                $cost += $data['quantity_undergarments']*$prices->value;
                $total -= $data['quantity_undergarments']*$prices->value;
                $order_data[] = ['items'=>'Salwar Suit or Kurta Pajama','quantity'=>$data['quantity_undergarments'],'cost'=>$prices->value];
            }
            if($prices->options =='sc_indi_shirt_price')
            {
                $cost +=$data['quantity_shirt']*$prices->value;
                $total -= $data['quantity_shirt']*$prices->value;
                $order_data[] = ['items'=>'Shirt','quantity'=>$data['quantity_shirt'],'cost'=>$prices->value];
            }
            if($prices->options =='sc_indi_towels_price')
            {
                $cost += $data['quantity_towel']*$prices->value;
                $total -= $data['quantity_towel']*$prices->value;
                $order_data[] = ['items'=>'Towel','quantity'=>$data['quantity_towel'],'cost'=>$prices->value];
            }
            if($prices->options =='sc_indi_others_price')
            {
                $cost +=$total;
                
                    $order_data[] = ['items'=>'Others','quantity'=>$data['quantity_others'],'cost'=>$total];
            }
        }
        
        $pickuptype = $data['pickup']=='self_pickup'?1:2;
        $bookdate = strtotime($data['slotday']);
        $indata = ['user_id'=>  $data['user_id'],'order_type'=>2,'total_amount'=>$cost,'discount'=>0,'pickup_type'=>$pickuptype,'payment_type'=>$data['payment_type'],'book_date'=>$bookdate,'book_slot'=>$data['slotInput'],'created'=>time(),'status'=>$data['status'],'coupon_applied'=>$data['coupon_code'],'discount'=>$data['discount']];
        $this->db->insert('tbl_order',$indata);
        $id = $this->db->insert_id();
        if($data['quantity_others']==0)
        {
            if($total != 0)
            {
                $dat['order_id'] = $id;
                $dat['extra_amount'] = $total;
                $dat['total_amount'] = $data['total_price'];
                $this->update_cloth_detail($dat);
            }
        }
        //updating data with order_id
        $newdata = [];
        foreach($order_data as $order_item)
        {
            $order_item['order_id'] = $id;
            $newdata[] = $order_item;
        }
        
        $this->db->insert_batch('tbl_order_items',$newdata);
        return $id;
    }
    
    function drycleaning_order($data)
    {
		$coupon_code="";
		if($data['coupon_code'])
		{
			$coupon_code=$data['coupon_code'];
		}
        $costlist = $this->get_options('',  $data['college_id']);
        $cost=0;
        $total = $data['total_price'];
        if(!$data['payment_type']){$data['payment_type']=2;}
        $order_data = [];
        foreach($costlist as $prices)
        {
            if($prices->options =='sc_dry_pant_price')
            {
                $cost +=$data['quantity_pants']*$prices->value;
                $total -=$data['quantity_pants']*$prices->value;
                $order_data[] = ['items'=>'Pant','quantity'=>$data['quantity_pants'],'cost'=>$prices->value];
            }
            if($prices->options =='sc_dry_suit_price')
            {
                $cost += $data['quantity_suit']*$prices->value;
                $total -= $data['quantity_suit']*$prices->value;
                $order_data[] = ['items'=>'Suit','quantity'=>$data['quantity_suit'],'cost'=>$prices->value];
            }
            if($prices->options =='sc_dry_shirt_price')
            {
                $cost +=$data['quantity_shirt']*$prices->value;
                $total -= $data['quantity_shirt']*$prices->value;
                $order_data[] = ['items'=>'Shirt','quantity'=>$data['quantity_shirt'],'cost'=>$prices->value];
            }
            if($prices->options =='sc_dry_blanket_price')
            {
                $cost += $data['quantity_blanket']*$prices->value;
                $total -= $data['quantity_blanket']*$prices->value;
                $order_data[] = ['items'=>'Blanket','quantity'=>$data['quantity_blanket'],'cost'=>$prices->value];
            }
            if($prices->options =='sc_dry_others_price')
            {
                $cost +=$total;
                if( $total == $data['quantity_others']*$prices->value)
                    $order_data[] = ['items'=>'Others','quantity'=>$data['quantity_others'],'cost'=>$prices->value];
                else
                    $order_data[] = ['items'=>'Others','quantity'=>$data['quantity_others'],'cost'=>$total];
            }
        }
        
        $pickuptype = $data['pickup']=='self_pickup'?1:2;
        $bookdate = strtotime($data['slotday']);
        $indata = ['user_id'=>  $data['user_id'],'order_type'=>3,'total_amount'=>$cost,'discount'=>0,'payment_type'=>$data['payment_type'],'pickup_type'=>$pickuptype,'book_date'=>$bookdate,'book_slot'=>$data['slotInput'],'created'=>time(),'status'=>$data['status'],'coupon_applied'=>$data['coupon_code'],'discount'=>$data['discount']];
        $this->db->insert('tbl_order',$indata);
        $id = $this->db->insert_id();
        if($data['quantity_others']==0)
        {
            if($total != 0)
            {
                $dat['order_id'] = $id;
                $dat['extra_amount'] = $total;
                $dat['total_amount'] = $data['total_price'];
                $this->update_cloth_detail($dat);
            }
        }
        //updating data with order_id
        $newdata = [];
        foreach($order_data as $order_item)
        {
            $order_item['order_id'] = $id;
            $newdata[] = $order_item;
        }
        
        $this->db->insert_batch('tbl_order_items',$newdata);
        return $id;
    }
    
    function individual_order($data)
    {
		$coupon_code="";
		if($data['coupon_code'])
		{
			$coupon_code=$data['coupon_code'];
		}
		$cost = 0;
        $iron = 0;
        if($data['wash_type']=='iron')
        {
            $cost = $this->get_options('sc_shoe_price_iron',  $data['college_id']);
            $iron = 1;
        }
		else
		{
			  $cost = $this->get_options('sc_shoe_price',  $data['college_id']);
		}
        $pickuptype = $data['pickup']=='self_pickup'?1:2;
        $bookdate = strtotime($data['slotday']);
        if(!$data['payment_type']){$data['payment_type']=2;}
        $total_amount = $cost * $data['quantity'];
        $indata = ['user_id'=>  $data['user_id'],'order_type'=>4,'total_amount'=>$total_amount,'discount'=>0,'payment_type'=>$data['payment_type'],'pickup_type'=>$pickuptype,'book_date'=>$bookdate,'book_slot'=>$data['slotInput'],'created'=>time(),'status'=>$data['status'],'coupon_applied'=>$coupon_code,'iron'=>$iron,'discount'=>$data['discount']];
        $this->db->insert('tbl_order',$indata);
        $id = $this->db->insert_id();
        $order_data = ['order_id'=>$id,'items'=>'No of clothes','quantity'=>$data['quantity'],'cost'=>$cost];
        $this->db->insert('tbl_order_items',$order_data);
        return $id;
    }
    
    function order_summary()
    {
        $res = $this->db->get_where('tbl_order',['id'=>  $this->session->order]);
        if($res->num_rows()>0)
        {
            $data = $res->row_object();
            $data->items = $this->db->get_where('tbl_order_items',['order_id'=>  $this->session->order])->result();
            return $data;
        }else{
            return FALSE;
        }
    }
    
    function delete_incomplete()
    {
        $this->db->where(['user_id'=>  $this->session->user_id,'status'=>0]);
        $this->db->delete('tbl_order');
        $this->session->unset_userdata('order');
    }
    
    function check_slot($day,$service,$college_id='',$hostel_id='')
    {
        if($this->session->college_id)
        {
            $college_id = $this->session->college_id;
        }
        $slots = $this->londury->get_slot($college_id);
        //echo json_encode($slots);
        if(($service=='1')||($service=='2'))
        {
            $morning1=$afternoon1=$evening1=$night1='';
            $date = strtotime($day);
            $cust = $this->get_custom_slot($college_id,$date);
            //echo json_encode($cust);
            if($cust)
            {
                $morning1 = $cust->morning;
                $afternoon1 = $cust->afternoon;
                $evening1 = $cust->evening;
                $night1 = $cust->night;
            }
        }

        foreach($slots as $slot)
        {
            switch($slot->slot_type)
            {
                case 'Morning':
                    if(date('Y-m-d')==$day && strtotime($slot->end_time) < strtotime(date('H:i')))
                    {
                        $morning = 0;
                    }  else {
                        if(($service=='1')||($service=='2'))
                        {
                            if($morning1!='')
                            {
                                $morning = $morning1;
                            }
                            else{
                                $morning = $slot->slots_available;
                            }
                            $booked = $this->get_booked_count(strtotime($day), 1,$college_id);
                            $morning = $morning - $booked;
                        }else{
                            if($morning1!='')
                            {
                                $morning = $morning1;
                            }
                            else{
                            $morning = 1000;
                            }
                        }
                    }
                    break;
                case 'Afternoon':
                    if(date('Y-m-d')==$day && strtotime($slot->end_time) < strtotime(date('H:i')))
                    {
                        $afternoon = 0;
                    }else{
                        if(($service=='1')||($service=='2'))
                        {
                           if($afternoon1!='')
                            {
                                $afternoon = $afternoon1;
                            }
                            else{
                                $afternoon = $slot->slots_available;
                            }
                            $booked = $this->get_booked_count(strtotime($day), 2,$college_id);
                            $afternoon = $afternoon - $booked;
                        }else{
                            if($afternoon1!='')
                            {
                                $afternoon = $afternoon1;
                            }
                            else{
                            $afternoon = 1000;
                            }
                        }
                    }
                    break;
                case 'Evening':
                    if(date('Y-m-d')==$day && strtotime($slot->end_time) < strtotime(date('H:i')))
                    {
                        $evening = 0;
                    }else{
                        if(($service=='1')||($service=='2'))
                        {
                            if($evening1!='')
                            {
                                $evening = $evening1;
                            }
                            else{
                                $evening = $slot->slots_available;
                            }
                            $booked = $this->get_booked_count(strtotime($day), 3,$college_id);
                            $evening = $evening - $booked;
                        }else{
                            if($evening1!='')
                            {
                                $evening = $evening1;
                            }
                            else{
                            $evening = 1000;
                            }
                        }
                    }
                    break;
                case 'Night':
                    if(date('Y-m-d')==$day && strtotime($slot->end_time) < strtotime(date('H:i')))
                    {
                        $night = 0;
                    }else{
                        if(($service=='1')||($service=='2'))
                        {
                            if($night1!='')
                            {
                                $night = $night1;
                            }
                            else{
                                $night = $slot->slots_available;
                            }
                            $booked = $this->get_booked_count(strtotime($day), 4,$college_id);
                            $night = $night - $booked;
                        }else{
                            if($night1!='')
                            {
                                $night = $night1;
                            }
                            else{
                            $night = 1000;
                            }
                        }
                    }
                    break;
            }
        }
        
        return ['morning'=>$morning<0?0:$morning,'afternoon'=>$afternoon<0?0:$afternoon,'evening'=>$evening<0?0:$evening,'night'=>$night<0?0:$night];
    }
    
    function get_booked_count($day,$slot,$college_id)
    {
        return $this->db->select('a.id')->from('tbl_order a')->join('tbl_users b','a.user_id=b.id')->where(['book_date'=>$day,'book_slot'=>$slot,'a.status <>'=>6])->where(['a.status <>'=>0,'b.college_id'=>$college_id])->where_in('a.order_type ',[1,4])->count_all_results();
    }
    
    function update_wallet($amount)
    {
        $user = $this->londury->get_user_detail($this->session->user_id);
        $final = $user->wallet_balance-$amount;
        $log = 'UserID: '.$this->session->user_id.', Debited amount: '.$final;
                $this->londury->wallet_log($log);
        $this->db->update('tbl_users',['wallet_balance'=>$amount],['id'=>  $this->session->user_id]);
    }

    function update_wallet_by_id($amount,$id)
    {
        $user = $this->londury->get_user_detail($id);
        $final = $user->wallet_balance-$amount;
        $log = 'UserID: '.$id.', Wallet amount corrected by : '.$final;
                $this->londury->wallet_log($log);
        $this->db->update('tbl_users',['wallet_balance'=>$amount],['id'=> $id]);
    }
    
    function update_order($type,$discount,$coupon,$total_amount,$iron)
    {
        $update = ['status'=>1,'payment_type'=>$type,'discount'=>$discount,'coupon_applied'=>$coupon,'iron'=>$iron];
        $this->db->update('tbl_order',$update,['id'=>  $this->session->order]);
        $this->db->update('tbl_order_items',['cost'=>$total_amount],['order_id'=>  $this->session->order]);
	$this->session->unset_userdata('order');
	    }
	function update_order_new_one($type,$discount,$coupon,$total_amount,$iron,$cost)
    {
        $update = ['status'=>1,'payment_type'=>$type,'discount'=>$discount,'coupon_applied'=>$coupon,'iron'=>$iron];
        $this->db->update('tbl_order',$update,['id'=>  $this->session->order]);
        $this->db->update('tbl_order_items',['cost'=>$cost],['order_id'=>  $this->session->order]);
        $this->session->unset_userdata('order');
    }
    
    function get_user_detail($user_id='')
    {
        if($this->session->user_id)
        {
            $user_id = $this->session->user_id;
        }
        $this->db->select('a.id,a.status,a.created,a.firstname,a.lastname,a.wallet_balance,a.profile_pic,a.dob,a.gender,a.roll_no,a.phone_no,a.room_no,a.email_id,a.hostel_id,a.college_id,b.college_name,c.hostel_name')
            ->join('tbl_college b','a.college_id=b.id')
            ->join('tbl_hostel c','a.hostel_id=c.id')
                ->where(['a.id'=>$user_id]);
        return $this->db->get('tbl_users a')->row();
    }

    function wallet_log($content)
    {
        $con = date("Y-m-d h:i:sa").'-'.$content;
        $this->db->insert('tbl_wallet_log',['content'=>$con]);
    }
    
    function recent_order()
    {
        $this->db->select('a.*,b.total_amount as final_amount,b.no_of_items,b.weight');
        $this->db->join('tbl_order_details b','b.order_id=a.id','LEFT');
        $this->db->where(['a.user_id'=>  $this->session->user_id,'a.status <>'=> 0]);
        $this->db->where('a.status <> 5 and a.status <> 6');
        $this->db->order_by('a.id','DESC');
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            $arr = [];
            foreach($res->result() as $data)
            {
                $items = $this->db->select('items,quantity,cost')->where(['order_id'=>$data->id])->get('tbl_order_items');
                if($items->num_rows()>0)
                {
                    $data->items = $items->result();
                    $arr[] = $data;
                }
            }
            return $arr;
        }
    }

    function check_order_history($user_id)
    {
        $this->db->select('a.*,b.total_amount as final_amount');
        $this->db->join('tbl_order_details b','b.order_id=a.id','LEFT');
        $this->db->where(['a.user_id'=>  $user_id,'a.status <>'=>0,'payment_type'=>1]);
        $this->db->order_by('a.id','DESC');
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            return $res->result();
        }
    }
    
    function order_history($user_id='',$chk='yes')
    {
        if($this->session->user_id)
        {
            $user_id = $this->session->user_id;
        }
        $this->db->select('a.*,b.total_amount as final_amount,b.extra_amount,b.iron_cost,b.pickup_cost,b.no_of_items,b.weight');
        $this->db->join('tbl_order_details b','b.order_id=a.id','LEFT');
        $this->db->where(['a.user_id'=>  $user_id,'a.status <>'=>0]);
        if($chk!='no')
        {
            $this->db->where('( a.status =6 or a.status = 5)');
        }
        $this->db->order_by('a.id','DESC');
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            $arr = [];
            foreach($res->result() as $data)
            {
                $items = $this->db->select('items,quantity,cost')->where(['order_id'=>$data->id])->get('tbl_order_items');
                if($items->num_rows()>0)
                {
                    $data->items = $items->result();
                    $arr[] = $data;
                }
            }
            return $arr;
        }
    }
    
    function get_lastorder_day($id)
    {
        $res = $this->db->select('created')
                ->where(['user_id'=>$id,'status <>'=>'0','status <>'=>6])
                ->order_by('id','DESC')
                ->limit(1)
                ->get('tbl_order');
        if($res->num_rows()>0)
        {
            return $res->row()->created;
        }
    }

    function delete_setting($data)
    {
        return $this->db->delete('tbl_settings',$data);
    }

    function add_setting($data)
    {
        return $this->db->insert('tbl_settings',$data);
    }
    
    function update_setting($field,$data)
    {
        $res = $this->db->select('id')->where(['options'=>$field,'college_id'=>$data['college_id']])->get('tbl_settings');
        if($res->num_rows()>0)
        {
            $id = $res->row()->id;
            return $this->db->update('tbl_settings',$data,['id'=>$id]);
        }else{
            return $this->db->insert('tbl_settings',$data);
        }
    }
    
    function pickuporders($where,$where2,$start,$limit)
    {
        $this->db->select("a.id,a.order_type,a.book_slot,a.pickup_type,a.status,a.payment_type ,a.iron,b.id as user_id,b.college_id,b.firstname,b.lastname,b.phone_no,b.room_no,c.hostel_name,book_date,d.token_no,d.weight,d.no_of_items,d.dropoff_time,e.college_name");
        $this->db->join('tbl_users b','a.user_id=b.id');
        $this->db->join('tbl_hostel c','b.hostel_id=c.id');
		$this->db->join('tbl_college e','b.college_id=e.id');
        $this->db->join('tbl_order_details d','a.id=d.order_id','left');
		$this->db->join('tbl_order_items i','a.id=i.order_id','left');
        if($where!='')
        $this->db->where($where);
        $this->db->where($where2);
        $this->db->order_by('a.book_date','ASC');
        $this->db->order_by('a.id','DESC');
        if($limit>0)
        {
            $this->db->limit($limit,$start);
        }
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            $newarr = [];
			$wash_type="Bulk Wash";
            foreach($res->result() as $data)
            {
                $data->book_date = date('d-m-Y',$data->book_date);
                $data->dropoff_time = date('d-m-Y H:i',$data->dropoff_time);
				if($data->order_type==1){$wash_type='Bulk Wash';}
				else if($data->order_type==4){$wash_type='Individual Wash';}
				else if($data->order_type==3){$wash_type='Dry Cleaning';}
				else if($data->order_type==2){$wash_type='Premium Wash';}
				$data->wash_type=$wash_type;
                $newarr[]=$data;
            }
            return ['res'=>TRUE,'rows'=>$newarr];
        }else{
            return ['res'=>FALSE];
        }
    }
	function countpickuporders($where,$where2,$start,$limit)
    {
        $this->db->select("a.id,a.order_type,a.book_slot,a.pickup_type,a.status,a.payment_type ,a.iron,b.id as user_id,b.college_id,b.firstname,b.lastname,b.phone_no,b.room_no,c.hostel_name,book_date,d.token_no,d.weight,d.no_of_items,d.dropoff_time,e.college_name");
        $this->db->join('tbl_users b','a.user_id=b.id');
        $this->db->join('tbl_hostel c','b.hostel_id=c.id');
		$this->db->join('tbl_college e','b.college_id=e.id');
        $this->db->join('tbl_order_details d','a.id=d.order_id','left');
        if($where!='')
        $this->db->where($where);
        $this->db->where($where2);
        $this->db->order_by('a.book_date','ASC');
        $this->db->order_by('a.id','DESC');
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            return ['res'=>TRUE,'rows'=>$res->num_rows()];
        }else{
            return ['res'=>FALSE];
        }
    }
    
    function homesearch($where,$where2,$start,$limit)
    {
        $this->db->select("a.id,b.id as user_id,b.firstname,b.lastname,d.token_no");
        $this->db->from('tbl_order a');
        $this->db->join('tbl_users b','a.user_id=b.id');
        $this->db->join('tbl_order_details d','a.id=d.order_id','left');
        if($where!='')
        $this->db->where($where);
        $this->db->where($where2);
        $this->db->group_by('user_id');
        $this->db->order_by('a.id','DESC');
        $this->db->limit($limit,$start);
        $res = $this->db->get();
        if($res->num_rows()>0)
        {
            return ['res'=>TRUE,'rows'=>$res->result()];
        }else{
            return ['res'=>FALSE];
        }
    }
    
    function update_cloth_detail($data)
    {
        $check = $this->db->get_where('tbl_order_details',['order_id'=>$data['order_id']]);
        if($check->num_rows()>0)
        {
            //unset($data['order_id']);
            $data['status']=1;
            return $this->db->update('tbl_order_details',$data,['order_id'=>$data['order_id']]);
        }else{
            $slot = [1=>'Morning',2=>'Afternoon',3=>'Evening',4=>'Night'];
            //getting booking date and slot
            $res = $this->db->select('a.book_date,a.book_slot,b.college_id')->join('tbl_users b','a.user_id=b.id')
                    ->where(['a.id'=>$data['order_id']])->get('tbl_order a')->row();
            //getting booking time
            $slottime = $this->db->select('start_time')->where(['slot_type'=>$slot[$res->book_slot],'college_id'=>$res->college_id])->get('tbl_slot_type')->row();

            $orderdate = date('d-m-Y',$res->book_date).' '.$slottime->start_time;
            $drop_time = strtotime('+1 day', strtotime($orderdate));
            $data['dropoff_time'] = $drop_time;
            $data['status']=1;
            $data['created'] = time();
            return $this->db->insert('tbl_order_details',$data);
        }
    }
    
    function get_reminder_details($id,$join='')
    {
        $where = ['a.id'=>$id];
        if($this->session->user_type==2)
        {
            $where=['b.college_id' => $this->session->a_college_id];
        }
        $this->db->select("a.book_slot,a.pickup_type,a.book_date ,b.id as user_id,b.firstname,b.lastname,b.phone_no,b.college_id,c.dropoff_time");
        $this->db->join('tbl_users b','a.user_id=b.id');
        $this->db->join('tbl_order_details c','a.id=c.order_id',$join);
        $this->db->where($where);
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            return ['res'=>TRUE,'rows'=>$res->row()];
        }
        else
        {
            return ['res'=>FALSE];
        }
    }
    
    function get_orderslip_detail($id)
    {
        if($this->session->user_type==2)
        {
            $where=['b.college_id' => $this->session->a_college_id];
            
        }
        $this->db->select("a.id,a.book_slot,a.order_type ,a.payment_type,b.firstname,b.lastname,b.phone_no,b.room_no,b.roll_no,c.hostel_name,book_date,d.college_name");
        $this->db->join('tbl_users b','a.user_id=b.id');
        $this->db->join('tbl_hostel c','b.hostel_id=c.id');
        $this->db->join('tbl_college d','b.college_id=d.id');
        //$this->db->join('tbl_order_details e','a.id=e.order_id');
        if($where!='')
        $this->db->where($where);
        $this->db->where_in('a.id',$id);
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            $data=[];
                    foreach($res->result() as $slip)
                    {
                        $slip->book_date = date('d-m-Y', $slip->book_date);
                        $data[] = $slip;
                    }
            
//            $items = $this->db->select('items,quantity')->where(['order_id'=>$data->id])->get('tbl_order_items');
//            if($items->num_rows()>0)
//            {
//                $arr = [];
//                foreach($items->result() as $it)
//                {
//                    $ne = strtr(strtolower($it->items),' ','_');
//                    $arr[$ne] = $it->quantity;
//                }
//                $data->items = $arr;
//            }
            return $data;
        }
    }

    
    
    function get_online_detail($user_id)
    {
        $where = ['user_id'=>$user_id,'payment_status'=>1,'payment_method'=>'Payu'];
        if($this->session->user_type==2)
        {
            $where['college_id'] = $this->session->a_college_id;
        }
        return $this->db->select('transcation_id,amount,a.created')
                ->join('tbl_users b','a.user_id=b.id')
                ->where($where)
                ->get('tbl_transcations a')->result();
    }
    
    function get_offline_detail($user_id)
    {
        $where = ['a.user_id'=>$user_id,'payment_method'=>'offline'];
        if($this->session->user_type==2)
        {
            $where['c.college_id'] = $this->session->a_college_id;
        }
        return $this->db->select('b.name,a.amount,a.created')
                ->join('tbl_admin b','a.recharge_by=b.id')
                ->join('tbl_users c','a.user_id=c.id')
                ->where($where)
                ->get('tbl_transcations a')->result();
    }
    
    function total_sale()
    {
        $where = ['payment_status'=>1];
        if($this->session->user_type==2)
        {
            $where['college_id'] = $this->session->a_college_id;
        }
        return $this->db->select('sum(amount) as total')
                ->join('tbl_users b','a.user_id=b.id')
                ->where($where)
                ->get('tbl_transcations a')->row();
    }
	
	function total_sale_accord_college($college_id)
    {
        $where = ['payment_status'=>1];
        $where['college_id'] = $college_id;
        return $this->db->select('sum(amount) as total')
                ->join('tbl_users b','a.user_id=b.id')
                ->where($where)
                ->get('tbl_transcations a')->row();
    }
    
    function today_orderOld()
    {
        $tomorrow  = strtotime(date("Y-m-d", strtotime("+1 day")));
        $where = ['a.status <>'=>0,'a.created >='=>strtotime(date('Y-m-d')), 'a.created <'=>$tomorrow];
        if($this->session->user_type==2)
        {
            $where['college_id'] = $this->session->a_college_id;
        }
        return $this->db->select('count(a.id) as total')
                ->join('tbl_users b','a.user_id=b.id')
                ->where($where)
                ->get('tbl_order a')->row()->total;
    }
	
	function today_order()
    {
		$strdate=date("Y-m-d")." 00:00";
		$enddate=date("Y-m-d")." 23:59";
		$sdate=strtotime($strdate);
		$edate=strtotime($enddate);
		/*$sdate=strtotime("2017-11-10 00:00");
		$edate=strtotime("2017-11-10 23:59");*/
        $tomorrow  = strtotime(date("Y-m-d", strtotime("+1 day")));
        $where = ['a.status <>'=>0,'a.created >='=>strtotime(date('Y-m-d')), 'a.created <'=>$tomorrow];
        if($this->session->user_type==2)
        {
            $where['college_id'] = $this->session->a_college_id;
        }
        return $this->db->select('count(a.id) as total')
                ->join('tbl_users b','a.user_id=b.id ')
				->where('a.created >= '.$sdate)
				->where('a.created <= '.$edate)
                ->get('tbl_order a')->row()->total;
    }
	
	function today_order_accord_college($college_id)
    {
		$strdate=date("Y-m-d")." 00:00";
		$enddate=date("Y-m-d")." 23:59";
		$sdate=strtotime($strdate);
		$edate=strtotime($enddate);
		/*$sdate=strtotime("2017-11-10 00:00");
		$edate=strtotime("2017-11-10 23:59");*/
        return $this->db->select('count(a.id) as total')
                ->join('tbl_users b','a.user_id=b.id ')
				->where('b.college_id',$college_id)
				->where('a.created >= '.$sdate)
				->where('a.created <= '.$edate)
                ->get('tbl_order a')->row()->total;
    }
    
    function total_order()
    {
        $where = ['a.status <>'=>0];
        if($this->session->user_type==2)
        {
            $where['college_id'] = $this->session->a_college_id;
        }
        return $this->db->select('count(a.id) as total')
                ->join('tbl_users b','a.user_id=b.id')
                ->where($where)
                ->get('tbl_order a')->row()->total;
    }
	
	function total_order_accord_college($college_id)
    {
        $where = ['a.status <>'=>0];
       
        $where['college_id'] = $college_id;
        return $this->db->select('count(a.id) as total')
                ->join('tbl_users b','a.user_id=b.id')
                ->where($where)
                ->get('tbl_order a')->row()->total;
    }
    
    function get_admin()
    {
        return $this->db->select('a.*,b.college_name')
                ->join('tbl_college b','b.id=a.college_id','left')
                ->get('tbl_admin a')->result();
    }
    
    function get_last_order()
    {
        return $this->db->select('a.id,a.total_amount,a.book_date,a.book_slot,a.pickup_type,a.status,b.total_amount as final_amount,b.dropoff_time')
                ->join('tbl_order_details b','b.order_id=a.id','left')
                ->where('a.status <> 0 and a.status <> 6 and a.status <> 5')
                ->where(['user_id'=>  $this->session->user_id])
                ->order_by('a.id','desc')->get('tbl_order a')->row();
    }

    function get_invoice_data_ol($id)
    {
        $where = ['a.id'=>$id];$where2='';
        if($this->session->user_type==2)
        {
            $where['b.college_id'] = $this->session->a_college_id;
            $where2 = '(a.status =1 or a.status = 3) and a.status<> 5';
        }
        $this->db->select("a.id,a.order_type,a.book_slot,a.payment_type,a.order_type,a.total_amount,a.pickup_type,a.book_slot,a.created,b.college_id,a.iron,b.firstname,b.lastname,b.phone_no,b.room_no,b.roll_no,b.wallet_balance,b.email_id,b.id as user_id,c.hostel_name,book_date,e.email as college_email,e.address,e.phone,e.service_tax_no,e.college_name,a.discount,a.coupon_applied");
        $this->db->join('tbl_users b','a.user_id=b.id');
        $this->db->join('tbl_hostel c','b.hostel_id=c.id');
        $this->db->join('tbl_college e','b.college_id=e.id');
        $this->db->where('a.status <> 6 and a.status <> 0');
        if($this->session->user_id!='' && $this->session->user_type=='')
        {
            $this->db->where(['b.id'=>$this->session->user_id,'a.status <>'=> 3,'a.status <>'=> 1]);
        }
        $this->db->where($where);
        if($where2!='')
        {
            $this->db->where($where2);
        }
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            $data = $res->row();
            $data->book_date = date('d-m-Y',$data->book_date);
            $resu = $this->db->get_where('tbl_settings',['college_id'=>$data->college_id])->result();
            foreach($resu as $ndata)
            {
                $val[$ndata->options] = $ndata->value;
            }
            $data->settings = $val;
            
            $items = $this->db->select('items,quantity,cost')->where(['order_id'=>$data->id])->get('tbl_order_items');
            if($items->num_rows()>0)
            {
                $arr = [];
                foreach($items->result() as $it)
                {
                    if($it->items == 'Others')
                    {   if($it->quantity>0)
                        {
                            $rate = $it->cost/$it->quantity;
                        }
                        else
                        {
                            $rate = $it->cost;
                        }
                    }
                    else{
                        $rate = $it->cost;
                    }
                        $arr[] = ['item'=>$it->items,'quantity'=>$it->quantity,'rate'=>$rate,'cost'=>$rate*$it->quantity];
                }
                $data->items = $arr;
            }
            
            return $data;
        }
        else
        {
            return FALSE;
        }
    }
    
    
    function get_invoice_data($id)
    {
        $where = ['a.id'=>$id];$where2='';
        if($this->session->user_type==2)
        {
            $where['b.college_id'] = $this->session->a_college_id;
            $where2 = '(a.status =1 or a.status = 3) and a.status<> 5';
        }
        $this->db->select("a.id,a.book_slot,a.payment_type,a.order_type,a.total_amount,a.pickup_type,a.book_slot,a.created,b.college_id,a.iron,b.firstname,b.lastname,b.phone_no,b.room_no,b.roll_no,b.wallet_balance,b.email_id,b.id as user_id,c.hostel_name,book_date,d.token_no,d.weight,d.no_of_items,d.id as invoice_id,d.extra_amount,d.iron_cost,d.pickup_cost,d.total_amount as final_amount,d.created as invoice_date,e.email as college_email,e.address,e.phone,e.service_tax_no,e.college_name,a.discount,a.coupon_applied");
        $this->db->join('tbl_users b','a.user_id=b.id');
        $this->db->join('tbl_hostel c','b.hostel_id=c.id');
        $this->db->join('tbl_order_details d','d.order_id=a.id');
        $this->db->join('tbl_college e','b.college_id=e.id');
        $this->db->where('a.status <> 6 and a.status <> 0');
        if($this->session->user_id!='' && $this->session->user_type=='')
        {
            $this->db->where(['b.id'=>$this->session->user_id,'a.status <>'=> 3,'a.status <>'=> 1]);
        }
        $this->db->where($where);
        if($where2!='')
        {
            $this->db->where($where2);
        }
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            $data = $res->row();
            $data->book_date = date('d-m-Y',$data->book_date);
            $resu = $this->db->get_where('tbl_settings',['college_id'=>$data->college_id])->result();
            foreach($resu as $ndata)
            {
                $val[$ndata->options] = $ndata->value;
            }
            $data->settings = $val;
            
            $items = $this->db->select('items,quantity,cost')->where(['order_id'=>$data->id])->get('tbl_order_items');
            if($items->num_rows()>0)
            {
                $arr = [];
                foreach($items->result() as $it)
                {
                    if($it->items == 'Others')
                    {   if($it->quantity>0)
                        {
                            $rate = $it->cost/$it->quantity;
                        }
                        else
                        {
                            $rate = $it->cost;
                        }
                    }
                    else{
                        $rate = $it->cost;
                    }
                        $arr[] = ['item'=>$it->items,'quantity'=>$it->quantity,'rate'=>$rate,'cost'=>$rate*$it->quantity];
                }
                $data->items = $arr;
            }
            
            return $data;
        }
        else
        {
            return FALSE;
        }
    }
    
    function complete_order($id)
    {
        $where = ['a.id'=>$id];
        if($this->session->user_type==2)
        {
            $where['b.college_id'] = $this->session->a_college_id;
        }
        $this->db->select('a.id')->join('tbl_users b','a.user_id=b.id')
                ->where('(a.status=2 or a.status=4)');
            $this->db->where($where);
        $res = $this->db->get('tbl_order a');
        if($res->num_rows() > 0)
        {
            $this->db->where(['id'=>$id]);
            $this->db->update('tbl_order', ['status'=>5]);
            return TRUE;
            exit;
        }
        else{
            return FALSE;
        }
    }
    
    function check_coupon($coupon)
    {
        $res = $this->db->select('*')
                ->where(['coupon_code'=>$coupon,'status'=>1])
                ->get('tbl_coupon');
        if($res->num_rows()>0)
        {
            return $res->row();
        }
    }
    
        
    function get_pickup_time($slot,$college_id)
    {
        $booktype = [1=>'Morning',2=>'Afternoon',3=>'Evening',4=>'Night'];
        return $this->db->select('pickup_time')->where(['slot_type'=>$booktype[$slot],'college_id'=>  $college_id])
                ->get('tbl_slot_type')->row()->pickup_time;
    }
    
    function get_prating_order($user_id)
    {
        $this->db->select('a.id,book_date,order_type,book_slot')
                ->join('tbl_ratings b','a.id=b.order_id','LEFT')
                ->where(['a.user_id'=>$user_id,'a.status'=>5])->where('rating is NULL')
                ->order_by('a.id','DESC');
        $res = $this->db->get('tbl_order a');
        return $res->row();
    }
    
    function check_valid_order($order_id,$user_id)
    {
        $res = $this->db->select('id')->where(['user_id'=>$user_id,'id'=>$order_id])->get('tbl_order');
        if($res->num_rows()>0)
        {
            return TRUE;
        }
    }
    
    function check_no_of_coupon_applied($coupon_code,$user_id)
    {
        return $this->db->select('count(id) as total')->where(['coupon_applied'=>$coupon_code,'user_id'=>$user_id])
                ->get('tbl_order')->row()->total;
    }
    
    function get_cod_status($collage_id)
    {
        return $this->db->select('value')->where(['college_id'=>$collage_id,'options'=>'cod'])->get('tbl_settings')->row()->value;
    }
    
    function sales_report($where,$where2)
    {
        $this->db->select("a.id,a.book_slot,a.pickup_type,a.status,a.payment_type,a.created,a.book_slot,a.discount,a.coupon_applied,a.total_amount ,b.id as user_id,b.firstname,b.lastname,b.phone_no,b.room_no,c.hostel_name,book_date,d.id as invoice_id,d.dropoff_time,d.extra_amount,d.iron_cost,d.pickup_cost,d.gst,d.total_amount as final_amount,d.token_no,d.weight,d.no_of_items,d.dropoff_time,e.college_name");
        $this->db->join('tbl_users b','a.user_id=b.id');
        $this->db->join('tbl_hostel c','b.hostel_id=c.id');
        $this->db->join('tbl_college e','b.college_id=e.id');
        $this->db->join('tbl_order_details d','a.id=d.order_id','left');
        if($where!='')
        $this->db->where($where);
        $this->db->where($where2);
        $this->db->order_by('a.status','ASC');
        $this->db->order_by('a.id','DESC');
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            $arr = [];
            foreach($res->result() as $data)
            {
                $data->dropoff_time = date('d-m-Y H:i',$data->dropoff_time);
                $items = $this->db->select('items,quantity,cost')->where(['order_id'=>$data->id])->get('tbl_order_items');
                if($items->num_rows()>0)
                {
                    $data->items = $items->result();
                }else{
                    $data->items =[];
                }
                $arr[] = $data;
            }
            return $arr;
        }
    }
	
	function order_perday($where,$from,$to)
    {
        $data =[];
        while($from<=$to)
        {
            $report_data = '';
            $report_data->date = $from;
			$nfrom=strtotime($from." 00:00");
			$nto=strtotime($from." 23:59");
			$where2= "(a.created >= '". $nfrom."' and a.created <= '". $nto."' ) ";
			$this->db->select("count(a.id) as total_order,sum(a.total_amount) as total_amount,from_unixtime(a.created,'%Y-%m-%d') as datetime");
            $this->db->join('tbl_users c','a.user_id=c.id');
			
            if(!empty($where))
            {
                $this->db->where($where);
            }
            $this->db->where($where2);
            $this->db->where('a.status <>',0);
            $res =  $this->db->get('tbl_order a');
            if($res->num_rows()>0)
            {

				$report_data->total_order = $res->row()->total_order;
                $report_data->total_amount = $res->row()->total_amount;
            }else{
         
				 $report_data->total_order = 0;
                $report_data->total_amount = 0;
            }
			 
            //recharge
			$this->db->select("SUM(case when a.payment_type = '1' then a.total_amount else 0 end) as online_data,SUM(case when a.payment_type = '2' then a.total_amount else 0 end) as offline_data,from_unixtime(a.created,'%Y-%m-%d') as datetime");
            $this->db->join('tbl_users c','a.user_id=c.id');
            if(!empty($where))
            {
                $this->db->where($where);
            }
			$this->db->where($where2);
            $this->db->where('a.status <>',0);
            $res1 =  $this->db->get('tbl_order a');
            if($res1->num_rows()>0)
            {
                $report_data->offline_data = $res1->row()->offline_data;
                $report_data->online_data = $res1->row()->online_data;
            }else{
                $report_data->offline_data = 0;
                $report_data->online_data = 0;
            }
            $data[] =$report_data;
            $from = date('Y-m-d', strtotime($from . ' +1 day'));
        }
        return $data;
    }
    
	function order_perdayOld($where,$from,$to)
    {
        $data =[];
        while($from<=$to)
        {
            $report_data = '';
            $report_data->date = $from;
            $this->db->select("count(a.id) as total_order,sum(a.total_amount) as total_amount,from_unixtime(a.created,'%Y-%m-%d') as datetime");
            $this->db->join('tbl_users c','a.user_id=c.id');
            if(!empty($where))
            {
                $this->db->where($where);
            }
            $this->db->where("from_unixtime(a.created,'%Y-%m-%d')",$from);
            $this->db->where('a.status <>',0);
            $this->db->group_by('datetime');
            $res =  $this->db->get('tbl_order a');
            if($res->num_rows()>0)
            {
                $report_data->total_order = $res->row()->total_order;
                $report_data->total_amount = $res->row()->total_amount;
            }else{
                $report_data->total_order = 0;
                $report_data->total_amount = 0;
            }
            //recharge
            $this->db->select("SUM(CASE when payment_method = 'offline' then amount else 0 end) as offline_data , SUM(CASE when payment_method <> 'offline' then amount else 0 end) as online_data,from_unixtime(a.created,'%Y-%m-%d') as datetime");
            $this->db->join('tbl_users c','a.user_id=c.id');
            $this->db->where($where);
            $this->db->where('payment_status',1);
            $this->db->where("from_unixtime(a.created,'%Y-%m-%d')",$from);
            $this->db->group_by('datetime');
            $res1 =  $this->db->get('tbl_transcations a');
            if($res1->num_rows()>0)
            {
                $report_data->offline_data = $res1->row()->offline_data;
                $report_data->online_data = $res1->row()->online_data;
            }else{
                $report_data->offline_data = 0;
                $report_data->online_data = 0;
            }
            $data[] =$report_data;
            $from = date('Y-m-d', strtotime($from . ' +1 day'));
        }
        return $data;
    }
	
	function searchOderExcel($where,$where2)
    {
        $this->db->select("a.id,a.total_amount,a.order_type,a.book_slot,a.pickup_type,a.status,a.payment_type ,a.iron,b.id as user_id,b.college_id,b.firstname,b.lastname,b.phone_no,b.room_no,c.hostel_name,book_date,d.token_no,d.weight,d.no_of_items,d.dropoff_time,e.college_name");
        $this->db->join('tbl_users b','a.user_id=b.id');
        $this->db->join('tbl_hostel c','b.hostel_id=c.id');
		$this->db->join('tbl_college e','b.college_id=e.id');
        $this->db->join('tbl_order_details d','a.id=d.order_id','left');
        if($where!='')
        $this->db->where($where);
        $this->db->where($where2);
        $this->db->order_by('a.book_date','ASC');
        $this->db->order_by('a.id','DESC');
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            $newarr = [];
			$wash_type="Bulk Wash";
			$order_current_status="Order recieved";
            foreach($res->result() as $data)
            {
                $data->book_date = date('d-m-Y',$data->book_date);
                $data->dropoff_time = date('d-m-Y H:i',$data->dropoff_time);
				if($data->order_type==1){$wash_type='Bulk Wash';}
				else if($data->order_type==4){$wash_type='Individual Wash';}
				else if($data->order_type==3){$wash_type='Dry Cleaning';}
				else if($data->order_type==2){$wash_type='Premium Wash';}
				$data->wash_type=$wash_type;
				if($data->status==2){$order_current_status='Order processed';}
				else if($data->status==3){$order_current_status='Clothes collected';}
				else if($data->status==4){$order_current_status='Out/Ready for Delivery';}
				else if($data->status==5){$order_current_status='Completed';}
				else if($data->status==6){$order_current_status='Cancelled';}
				$data->order_current_status=$order_current_status;
                $newarr[]=$data;
            }
            return ['res'=>TRUE,'data'=>$newarr];
        }else{
            return ['res'=>FALSE];
        }
    }
	
	
	function newpickuporders($where,$where2,$start,$limit)
    {
        $this->db->select("a.id,a.order_type,a.book_slot,a.pickup_type,a.status,a.payment_type ,a.iron,b.id as user_id,b.college_id,b.firstname,b.lastname,b.phone_no,b.room_no,c.hostel_name,book_date,d.token_no,d.weight,d.no_of_items,d.dropoff_time,e.college_name,i.quantity");
        $this->db->join('tbl_users b','a.user_id=b.id');
        $this->db->join('tbl_hostel c','b.hostel_id=c.id');
		$this->db->join('tbl_college e','b.college_id=e.id');
        $this->db->join('tbl_order_details d','a.id=d.order_id','left');
		$this->db->join('tbl_order_items i','a.id=i.order_id','left');
        if($where!='')
        $this->db->where($where);
        $this->db->where($where2);
		$this->db->group_by('a.id');
        $this->db->order_by('a.book_date','ASC');
        $this->db->order_by('a.id','DESC');
        if($limit>0)
        {
            $this->db->limit($limit,$start);
        }
        $res = $this->db->get('tbl_order a');
        if($res->num_rows()>0)
        {
            $newarr = [];
			$wash_type="Bulk Wash";
            foreach($res->result() as $data)
            {
                $data->book_date = date('d-m-Y',$data->book_date);
                $data->dropoff_time = date('d-m-Y H:i',$data->dropoff_time);
				if($data->order_type==1){$wash_type='Bulk Wash';}
				else if($data->order_type==4){$wash_type='Individual Wash';}
				else if($data->order_type==3){$wash_type='Dry Cleaning';}
				else if($data->order_type==2){$wash_type='Premium Wash';}
				$data->wash_type=$wash_type;
                $newarr[]=$data;
            }
            return ['res'=>TRUE,'rows'=>$newarr];
        }else{
            return ['res'=>FALSE];
        }
    }
    
    
}