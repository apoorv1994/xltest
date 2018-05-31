<?php
class Reports extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users');
        $this->load->model('report');
        $this->users->_valid_admin();
    }
    
    function index()
    {
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/reports/index_vw');
        $this->load->view('panel/footer');
    }

    function user_report()
    {
        $where = ['status'=>1];
        if($this->session->user_type==2)
        {
            $where['id'] = $this->session->a_college_id;
        }
        $pagedata['colleges'] = $this->db->get_where('tbl_college',$where)->result();
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/reports/user_report_vw');
        $this->load->view('panel/footer');
    }
            
    function get_users_total($page='0',$search='',$college='',$type='',$limit=20)
    {
        $where2=[];
        $where = '';
        if($search!='')
        $where = '(concat(firstname, " ",lastname) like "'.$search.'%" or email_id like "'.$search.'%" or roll_no like "'.$search.'%" )';
        if($college!='')
        {
            $where2['a.college_id']=$college;
        }
        if($type=='wallet')
        {
            $where2['a.wallet_balance <='] = 100;
        }
        if(empty($where2)){$where2='';}
        $count_data=['val'=>'count(a.id) as total','table'=>'tbl_users a','orderby'=>'','where'=>$where, 'where2'=>$where2,'orderas'=>'','start'=>'','limit'=>''];
        $join=['table'=>'tbl_college b','on'=>'a.college_id=b.id','join_type'=>''];
        $res_count=$this->common->get_join2($count_data,$join);
        $this->load->library("pagination");
        $config = array();
        if($type=='wallet'){$url='wallet_less_ajax';}else{$url='user-ajax';}
        $config["base_url"] = BASE . "panel/reports/".$url."/";
        $config["total_rows"] = $res_count['rows']->total;
        if($limit!='full'){
        $perpage=$config["per_page"] = 20;
        }
        else{
            $perpage='';
        }
        $config["uri_segment"] = 4;
 
        $this->pagination->initialize($config);
        $data=['val'=>'a.*,b.college_name','table'=>'tbl_users a','orderby'=>'firstname','where'=>$where, 'where2'=>$where2,'orderas'=>'ASC','start'=>$page,'limit'=>$perpage];
        $join=['table'=>'tbl_college b','on'=>'a.college_id=b.id','join_type'=>''];
        $res=$this->common->get_join($data,$join);
        if($res['res'])
        {
            if($type=='wallet')
            {
                $data = $res['rows'];
            }else{
                
                $data = [];
                foreach($res['rows'] as $user)
                {
                    $user->avg_weight=$user->total_amount=$user->get_avg_cloths_wash=$user->avg_order=0;
                    $u_data = $this->report->get_avg_order($user->id);
                    if($u_data)
                    {
                        $user->avg_order = round($u_data->avg_order,2);
                        $user->get_avg_cloths_wash = floor($u_data->avg_no);
                        $user->total_amount = round($u_data->total_amount,2);
                        $user->avg_weight = round($u_data->avg_weight,2);
                    }
                    $user->avg_timediff = $this->report->get_timediff($user->id);
                    $last_orderday = $this->londury->get_lastorder_day($user->id);
                    $user->last_order_day = 'NA';
                    if($last_orderday)
                    {
                        $diff = time()-$last_orderday;
                        $user->last_order_day = floor($diff/(3600*24));
                    }
                    $user->washtype_freq = $this->report->get_washtype_freq($user->id);
                    $user->avg_rating = $this->report->get_avg_rating($user->id);
                    $user->avg_recharge = $this->report->get_avg_recharge($user->id);
                    //$user->created = $this->report->get_created_time($user->id);
                    $data[] = $user;
                }
            }
            return ['data'=>$data,'paginate'=>$this->pagination->create_links()];
        }
    }
    
    function user_ajax($id='')
    {
        if($this->input->post('search')!='')
        {
            $search = $this->input->post('search');
        }
        if($this->session->user_type==1)
        {
            $college ='';
            if($this->input->post('college')!='All')
            {
                $college = $this->input->post('college');
            }
        }else{
            $college = $this->session->a_college_id;
        }
        if($id==''){$id='0';}
        $query=  $this->get_users_total($id,$search,$college);
        if($query['data'])
        {$i=$id+1;
            foreach($query['data'] as $users)
            {
            ?>
            <tr>
                <td><?=$users->firstname.' '.$users->lastname?></td>
                <td><?=$users->college_name?></td>
                <td class="col-bl"><i class="fa fa-inr"></i> <?=$users->avg_order?></td>
                <td><?=$users->avg_timediff?></td>
                <td> <?=$users->last_order_day?></td>
<!--                <td> <?=$users->last_order_day?></td>-->
                <td> <table class="table table-striped table-hover" style="margin: 0px;">
                        <tbody>
                            <tr>
                                <td><?=$users->washtype_freq[1]?$users->washtype_freq[1]:0?></td>
                                <td><?=$users->washtype_freq[4]?$users->washtype_freq[4]:0?></td>
                                <td><?=$users->washtype_freq[2]?$users->washtype_freq[2]:0?></td>
                                <td><?=$users->washtype_freq[3]?$users->washtype_freq[3]:0?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td> <?=$users->get_avg_cloths_wash?></td>
                <td> <?=$users->total_amount?></td>
                <td> <?=$users->avg_rating?></td>
                <td> <?=$users->avg_recharge?></td>
                <td> <?=$users->avg_weight?></td>
                <td> <?= date('m/d/Y H:i:s', $users->created) ?> </td>
        </tr>
            <?php $i++;}?>
                <tr><td id="paginate"  colspan="12">
                        <ul class="pagination"><?=$query['paginate']?></ul>
                    </td></tr>
                <?php }else{?>
                <tr><td id="paginate"  colspan="12">No Records Found</td></tr>
                <?php }
    }
    
    function export_user()
    {
        if($this->input->post('search')!='')
        {
            $search = $this->input->post('search');
        }

        if($this->session->user_type==1)
        {
            $college ='';
            if($this->input->get('clg')!='')
            {
                $college = $this->input->get('clg');
            }
        }else{
            $college = $this->session->a_college_id;
        }
        if($id==''){$id='0';}
        $query =  $this->get_users_total($id,$search,$college,'','full');
        if($query['data'])
        {
            $this->load->library("excel");
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Report');
            $this->excel->getActiveSheet()->setCellValue('A1', 'S.No.');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Name');
            $this->excel->getActiveSheet()->setCellValue('C1', 'College Name');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Avg Order Value');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Avg Repeat Order Time');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Last Order (Days)');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Bulk');
            $this->excel->getActiveSheet()->setCellValue('H1', 'Individual');
            $this->excel->getActiveSheet()->setCellValue('I1', 'Premium');
            $this->excel->getActiveSheet()->setCellValue('J1', 'Dry');
            $this->excel->getActiveSheet()->setCellValue('K1', 'Avg no of cloths/wash');
            $this->excel->getActiveSheet()->setCellValue('L1', 'Total Order amount');
            $this->excel->getActiveSheet()->setCellValue('M1', 'Avg Rating');
            $this->excel->getActiveSheet()->setCellValue('N1', 'Avg Recharge Amount');
            $this->excel->getActiveSheet()->setCellValue('O1', 'Avg Weight of Clothes');
            $this->excel->getActiveSheet()->setCellValue('P1', 'Contact no.');
            $this->excel->getActiveSheet()->setCellValue('Q1', 'Email Id');
            $this->excel->getActiveSheet()->setCellValue('R1', 'Account Created');
            
            $i = 1;$j = 2;
            foreach($query['data'] as $product)
            {
                $in = $product->washtype_freq[1]?$product->washtype_freq[1]:'0';
                $pre = $product->washtype_freq[4]?$product->washtype_freq[4]:'0';
                $indi = $product->washtype_freq[2]?$product->washtype_freq[2]:'0';
                $dry = $product->washtype_freq[3]?$product->washtype_freq[3]:'0';
                $this->excel->getActiveSheet()->setCellValue('A'.$j, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$j, $product->firstname.' '.$product->lastname);
                $this->excel->getActiveSheet()->setCellValue('C'.$j, $product->college_name);
                $this->excel->getActiveSheet()->setCellValue('D'.$j, $product->avg_order);
                $this->excel->getActiveSheet()->setCellValue('E'.$j, $product->avg_timediff);
                $this->excel->getActiveSheet()->setCellValue('F'.$j, $product->last_order_day);
                $this->excel->getActiveSheet()->setCellValue('G'.$j, $in );
                $this->excel->getActiveSheet()->setCellValue('H'.$j, $pre );
                $this->excel->getActiveSheet()->setCellValue('I'.$j, $indi );
                $this->excel->getActiveSheet()->setCellValue('J'.$j, $dry );
                $this->excel->getActiveSheet()->setCellValue('K'.$j, $product->get_avg_cloths_wash);
                $this->excel->getActiveSheet()->setCellValue('L'.$j, $product->total_amount);
                $this->excel->getActiveSheet()->setCellValue('M'.$j, $product->avg_rating);
                $this->excel->getActiveSheet()->setCellValue('N'.$j, $product->avg_recharge);
                $this->excel->getActiveSheet()->setCellValue('O'.$j, $product->avg_weight);
                $this->excel->getActiveSheet()->setCellValue('P'.$j, $product->phone_no);
                $this->excel->getActiveSheet()->setCellValue('Q'.$j, $product->email_id);
                $this->excel->getActiveSheet()->setCellValue('R'.$j, date('m/d/Y H:i:s', $product->created));    
                $i++;$j++;
            }
            $this->excel->stream('report.xls');
        }
    }
    
    function wallet_report()
    {
        $where = ['status'=>1];
        if($this->session->user_type==2)
        {
            $where['id'] = $this->session->a_college_id;
        }
        $pagedata['colleges'] = $this->db->get_where('tbl_college',$where)->result();
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/reports/transaction_vw');
        $this->load->view('panel/footer');
    }
    
    function ajax_transcation($id=0)
    {
        if($this->input->post('search')!='')
        {
            $search = $this->input->post('search');
        }
        $college ='';
        if($this->session->user_type==1)
        {
            if($this->input->post('college_id')!='All')
            {
                $college = $this->input->post('college_id');
            }
        }else{
            $college = $this->session->a_college_id;
        }
        $count = 0;
        $where = ['a.payment_status'=>1];
        $where2 = '';
        if($college!='')
        {
            $where['b.college_id'] = $college;
        }
        
        $from = strtr($this->input->post('date_from'), '/', '-');
        $to = strtr($this->input->post('date_to'), '/', '-');
        if($from != $to)
        {
            $where2 .= "(from_unixtime(a.created,'%m-%d-%Y') >= '". $from."' and from_unixtime(a.created,'%m-%d-%Y') <= '". $to."' ) ";
        }else{
            $where2 .= "(from_unixtime(a.created,'%m-%d-%Y') = '". $from."' ) ";
        }
        if($this->input->post('r_type')!='All')
        {
            if($this->input->post('r_type')=='online')
            {
                $where2 .= ' and (payment_method="Payu" or payment_method="Paytm")';
            }else{
                $where2 .= ' and payment_method="offline"';
            }
        }
        if($search)
        $where2 .= ' and (b.firstname like "'.$search.'%" or a.transcation_id like "'.$search.'%")';
        $data=['val'=>'count(b.id) as total','table'=>'tbl_transcations a','where'=>$where,'where2'=>$where2];
        $join=['table'=>'tbl_users b','on'=>'a.user_id=b.id','join_type'=>''];
        $res=$this->common->get_join2($data,$join);//echo $this->db->last_query();die;
        if($res['res'])
        {
           $count = $res['rows']->total;
        }
        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = BASE . "panel/reports/ajax-transcation/";
        $config["total_rows"] = $count;
        $perpage=$config["per_page"] = 20;
        $config["uri_segment"] = 4;
 
        $this->pagination->initialize($config);
        
        $data=['val'=>'a.*,b.id as user_id,b.firstname as name,b.college_id,c.college_name','table'=>'tbl_transcations a','where'=>$where,'where2'=>$where2,'orderby'=>'id','orderas'=>'DESC','start'=>$id,'limit'=>$perpage];
        $join=['table'=>'tbl_users b','on'=>'a.user_id=b.id','join_type'=>''];
		$join1=['table'=>'tbl_college c','on'=>'b.college_id=c.id','join_type'=>''];
        $res = $this->common->get_join($data,$join,$join1);//echo $this->db->last_query();die;
        if($res['res'])
        {
            $i=1+$id;
            foreach($res['rows'] as $trans){?>
            <tr class="odd gradeX">
                    <td><?=$i?></td>
                    <td><a href="<?=BASE?>panel/user/user-detail/<?=$trans->user_id?>" target="_blank" title="<?=$trans->name?>"><?=$trans->name?></a></td>
                    <td><?=$trans->college_name?></td>
					 <td><?=date('d M Y',$trans->created)?></td>
					 <td><?=$trans->amount?></td>
                    <td><?=$trans->transcation_id?></td>
                    <td><?=$trans->payment_method=='Payu' || $trans->payment_method=='Paytm'?'Online':'Offline'?></td>
                    <td><?=$trans->description?></td>
<!--                    <td><?=$trans->payment_status==1?'<span class="label label-success">Success</span>':'<span class="label label-danger">Fail</span>'?></td>-->
<!--                    <td><?php if($trans->payment_status==2){echo $trans->fail_reason;}elseif($trans->payment_status==3){echo 'Incompelete Payment';}?></td>-->
                </tr>
        <?php    
            $i++;}?>
            <tr><td id="paginate"  colspan="8">
                        <ul class="pagination"><?=$this->pagination->create_links()?></ul>
                    </td></tr>
      <?php  }else{?>
                <tr><td id="paginate"  colspan="8">No transaction Found</td></tr>
                <?php }
    }
    
    function export_wallet()
    {
        if($this->input->post('search')!='')
        {
            $search = $this->input->post('search');
        }
        $college ='';
        if($this->session->user_type==1)
        {
            if($this->input->post('college_id')!='All')
            {
                $college = $this->input->post('college_id');
            }
        }else{
            $college = $this->session->a_college_id;
        }
        $count = 0;
        $where = ['a.payment_status'=>1];
        $where2 = '';
        if($college!='')
        {
            $where['b.college_id'] = $college;
        }
        
        $from = strtr($this->input->post('date_from'), '/', '-');
        $to = strtr($this->input->post('date_to'), '/', '-');
        if($from != $to)
        {
            $where2 .= "(from_unixtime(a.created,'%m-%d-%Y') >= '". $from."' and from_unixtime(a.created,'%m-%d-%Y') <= '". $to."' ) ";
        }else{
            $where2 .= "(from_unixtime(a.created,'%m-%d-%Y') = '". $from."' ) ";
        }
        if($this->input->post('r_type')!='All')
        {
            if($this->input->post('r_type')=='online')
            {
                $where2 .= ' and (payment_method="payu" or payment_method="paytm")';
            }else{
                $where2 .= ' and payment_method="offline"';
            }
        }
        if($search)
        $where2 .= ' and (b.firstname like "'.$search.'%" or a.transcation_id like "'.$search.'%")';
        $data=['val'=>'a.*,b.id as user_id,b.firstname as name,b.college_id,c.college_name','table'=>'tbl_transcations a','where'=>$where,'where2'=>$where2,'orderby'=>'id','orderas'=>'DESC','start'=>$id,'limit'=>$perpage];
        $join=['table'=>'tbl_users b','on'=>'a.user_id=b.id','join_type'=>''];
        $join1=['table'=>'tbl_college c','on'=>'b.college_id=c.id','join_type'=>''];
        $res = $this->common->get_join($data,$join,$join1);
        //echo $this->db->last_query();die;
        if($res['res'])
        {
            $this->load->library("excel");
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Report');
            $this->excel->getActiveSheet()->setCellValue('A1', 'S.No.');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Credited To');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Transaction Date');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Amount');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Transaction ID');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Payment Description');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Payment Type');
            $this->excel->getActiveSheet()->setCellValue('H1', 'College Name');
            
            $i = 1;$j = 2;
            foreach($res['rows'] as $product)
            {
                $this->excel->getActiveSheet()->setCellValue('A'.$j, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$j, $product->name);
                $this->excel->getActiveSheet()->setCellValue('C'.$j, date('d M Y',$product->created));
                $this->excel->getActiveSheet()->setCellValue('D'.$j, $product->amount);
                $this->excel->getActiveSheet()->setCellValue('E'.$j, $product->transcation_id);
                $this->excel->getActiveSheet()->setCellValue('F'.$j, $product->description);
                $this->excel->getActiveSheet()->setCellValue('G'.$j, $product->payment_method=='Payu'?'Online':'Offline');
                $this->excel->getActiveSheet()->setCellValue('H'.$j, $product->college_name);
                $i++;$j++;
            }
            $this->excel->stream('report.xls');
        }
    }
            
    function wallet_less()
    {
        $where = ['status'=>1];
        if($this->session->user_type==2)
        {
            $where=['id' => $this->session->a_college_id];
        }
        $pagedata['colleges'] = $this->db->get_where('tbl_college',$where)->result();
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/reports/wallet_less_vw');
        $this->load->view('panel/footer');
    }
    
    function wallet_less_ajax($id)
    {
        if($this->input->post('search')!='')
        {
            $search = $this->input->post('search');
        }
        if($this->session->user_type==1)
        {
            $college ='';
            if($this->input->post('college')!='All')
            {
                $college = $this->input->post('college');
            }
        }else{
            $college = $this->session->a_college_id;
        }
        if($id==''){$id='0';}
        $query=  $this->get_users_total($id,$search,$college,'wallet');
        if($query['data'])
        {
            $i=$id+1;
            foreach($query['data'] as $users)
            {
            ?>
            <tr>
                <td><?=$users->firstname.' '.$users->lastname?></td>
                <td><?=$users->college_name?></td>
                <td class="col-bl"><?=$users->email_id?></td>
                <td><?=$users->phone_no?></td>
                <td> <?=$users->gender==1?'Male':'Female'?></td>
                <td> <?=$users->roll_no?></td>
                <td> <?=$users->room_no?></td>
                <td> <?=$users->wallet_balance?></td>
        </tr>
            <?php $i++;}?>
                <tr><td id="paginate"  colspan="8">
                        <ul class="pagination"><?=$query['paginate']?></ul>
                    </td></tr>
                <?php }else{?>
                <tr><td id="paginate"  colspan="8">No Records Found</td></tr>
                <?php }
    }
    
    function export_wallet_less()
    {
        if($this->input->post('search')!='')
        {
            $search = $this->input->post('search');
        }
        if($this->session->user_type==1)
        {
            $college ='';
            if($this->input->post('college')!='All')
            {
                $college = $this->input->post('college');
            }
        }else{
            $college = $this->session->a_college_id;
        }
        if($id==''){$id='0';}
        $query =  $this->get_users_total($id,$search,$college,'wallet','full');
        if($query['data'])
        {
            $this->load->library("excel");
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Report');
            $this->excel->getActiveSheet()->setCellValue('A1', 'S.No.');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Name');
            $this->excel->getActiveSheet()->setCellValue('C1', 'College Name');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Email');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Phone No');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Gender');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Roll No');
            $this->excel->getActiveSheet()->setCellValue('H1', 'Room No');
            $this->excel->getActiveSheet()->setCellValue('I1', 'Wallet Balance');
            
            $i = 1;$j = 2;
            foreach($query['data'] as $product)
            {
                $row = array();
                $this->excel->getActiveSheet()->setCellValue('A'.$j, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$j, $product->firstname.' '.$product->lastname);
                $this->excel->getActiveSheet()->setCellValue('C'.$j, $product->college_name);
                $this->excel->getActiveSheet()->setCellValue('D'.$j, $product->email_id);
                $this->excel->getActiveSheet()->setCellValue('E'.$j, $product->phone_no);
                $this->excel->getActiveSheet()->setCellValue('F'.$j, $product->gender==1?'Male':'Female');
                $this->excel->getActiveSheet()->setCellValue('G'.$j, $product->roll_no);
                $this->excel->getActiveSheet()->setCellValue('H'.$j, $product->room_no);
                $this->excel->getActiveSheet()->setCellValue('I'.$j, $product->wallet_balance);
                $i++;$j++;
            }
            $this->excel->stream('report.xls');
        }
    }
    
    function sales_report()
    {
        $where = ['status'=>1];
        if($this->session->user_type==2)
        {
            $where=['id' => $this->session->a_college_id];
        }
        $pagedata['colleges'] = $this->db->get_where('tbl_college',$where)->result();
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/reports/sales_report_vw');
        $this->load->view('panel/footer');
    }
    
    function export_sales()
    {
        $where = ['a.status <>'=>'0'];
        $college_id='';
        if($this->input->post('college_id')!='All'){
            $college_id = $this->input->post('college_id');
        }
        if($this->session->user_type==2)
        {
            $college_id = $this->session->a_college_id;
        }
        if($college_id!='')
        {
            $where['b.college_id']=$college_id;
        }
        
		$from = explode('/',$this->input->post('date_from'));
        $from_date = $from[2].'-'.$from[0].'-'.$from[1];
        $to = explode('/',$this->input->post('date_to'));
        $to_date = $to[2].'-'.$to[0].'-'.$to[1];
		//$where2 .= "(from_unixtime(a.created,'%Y-%m-%d') >= '". $from_date."' and from_unixtime(a.created,'%Y-%m-%d') < '". date('Y-m-d', strtotime($to_date . ' +1 day'))."' ) ";
		$where2 .= "(a.orderDate >= '". $from_date."' and a.orderDate <= '". $to_date ."' ) ";
        $res = $this->londury->sales_report($where,$where2);
        if($res)
        {
            $this->load->library("excel");
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Report');
            $this->excel->getActiveSheet()->setCellValue('A1', 'S.No.');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Order ID');
            $this->excel->getActiveSheet()->setCellValue('C1', 'User Details');
            $this->excel->getActiveSheet()->setCellValue('D1', 'College name');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Booked Slot');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Pickup type');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Booked Date');
            $this->excel->getActiveSheet()->setCellValue('H1', 'Payment Type');
            $this->excel->getActiveSheet()->setCellValue('I1', 'Order Date');
            $this->excel->getActiveSheet()->setCellValue('J1', 'Coupon Applied');
            $this->excel->getActiveSheet()->setCellValue('K1', 'Discount');
            $this->excel->getActiveSheet()->setCellValue('L1', 'Invoice ID');
            $this->excel->getActiveSheet()->setCellValue('M1', 'Extra Amount');
            $this->excel->getActiveSheet()->setCellValue('N1', 'Iron Cost');
            $this->excel->getActiveSheet()->setCellValue('O1', 'Pick up Cost');
            $this->excel->getActiveSheet()->setCellValue('P1', 'GST');
            $this->excel->getActiveSheet()->setCellValue('Q1', 'SUBTOTAL');
            
            $this->excel->getActiveSheet()->setCellValue('R1', 'Token No');
            $this->excel->getActiveSheet()->setCellValue('S1', 'Weight');
            $this->excel->getActiveSheet()->setCellValue('T1', 'No of Clothes');
            $this->excel->getActiveSheet()->setCellValue('U1', 'Cloth Details');
            $this->excel->getActiveSheet()->setCellValue('V1', 'Order Status');
            $this->excel->getActiveSheet()->setCellValue('W1', 'Delivery Time');
            $this->excel->getActiveSheet()->setCellValue('X1', 'Hostel');
            $this->excel->getActiveSheet()->setCellValue('Y1', 'Total Amount');
            $slot = [1=>'Morning',2=>'Afternoon',3=>'Evening',4=>'Night'];
            $order_type = [1=>'Bulk Wash',2=>'Premium',3=>'Dry Cleaning',4=>'Individual Wash'];
            $i = 1;$j = 2;
            foreach($res as $product)
            {
                $iron_detail='';
                if($product->iron_cost)
                {
                    $iron = json_decode($product->iron_cost);
                    $iron_detail = "No of Clothes: ".$iron->iron_no." \n"." Cost for iron: ".$iron->total_iron_price;
                }
                $p_detail='';
                if(!empty($product->items)){
                    foreach($product->items as $item)
                    {
                        $p_detail .= $item->items.": ".$item->quantity." | Cost: ".$item->cost."per cloth \n";
                    }
                }
                switch ($product->status)
                {
                    case 1:
                        $text = 'Order recieved';
                        break;
                    case 2:
                        $text = 'Order processed';
                        break;
                    case 3:
                        $text ='Clothes collected';
                        break;
                    case 4:
                        $text = 'Out/Ready for Delivery';
                        break;
                    case 5:
                        $text = 'Completed';
                        break;
                }
                $user_details = $product->firstname." ".$product->lastname;
		$hostel_name = $product->hostel_name."\n".$product->room_no;
                $this->excel->getActiveSheet()->setCellValue('A'.$j, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$j, $product->id);
                $this->excel->getActiveSheet()->setCellValue('C'.$j, $user_details);
                $this->excel->getActiveSheet()->getStyle('C'.$j)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->setCellValue('D'.$j, $product->college_name);
                $this->excel->getActiveSheet()->setCellValue('E'.$j, $slot[$product->book_slot]);
                $this->excel->getActiveSheet()->setCellValue('F'.$j, $product->pickup_type==1?'Self':'Avail');
                $this->excel->getActiveSheet()->setCellValue('G'.$j, date('d-m-Y',$product->book_date));
                $this->excel->getActiveSheet()->setCellValue('H'.$j, $product->payment_type==1?'Wallet':'COD');
                $this->excel->getActiveSheet()->setCellValue('I'.$j, $product->orderDate." ".date('h:i a',$product->created));
                $this->excel->getActiveSheet()->setCellValue('J'.$j, $product->coupon_applied?$product->coupon_applied:'NA');
                $this->excel->getActiveSheet()->setCellValue('K'.$j, $product->discount);
                $this->excel->getActiveSheet()->setCellValue('L'.$j, $product->invoice_id);
                $this->excel->getActiveSheet()->setCellValue('M'.$j, $product->extra_amount);
                $this->excel->getActiveSheet()->setCellValue('N'.$j, $iron_detail);
                $this->excel->getActiveSheet()->getStyle('N'.$j)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->setCellValue('O'.$j, $product->pickup_cost);
                $this->excel->getActiveSheet()->setCellValue('P'.$j, $product->gst);
                $this->excel->getActiveSheet()->setCellValue('Q'.$j, $product->total_amount );
                $this->excel->getActiveSheet()->setCellValue('R'.$j, $product->token_no);
                $this->excel->getActiveSheet()->setCellValue('S'.$j, $product->weight);
                $this->excel->getActiveSheet()->setCellValue('T'.$j, $product->no_of_items);
                $this->excel->getActiveSheet()->setCellValue('U'.$j, $p_detail);
                $this->excel->getActiveSheet()->getStyle('U'.$j)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->setCellValue('V'.$j, $text);
		$this->excel->getActiveSheet()->setCellValue('W'.$j, $product->dropoff_time);
		$this->excel->getActiveSheet()->setCellValue('X'.$j, $hostel_name);
                $this->excel->getActiveSheet()->setCellValue('Y'.$j, ($product->extra_amount + $product->total_amount) );
                
                $i++;$j++;
            }
            $this->excel->stream('sales_report.xls');
        }
    }
    
    function admin_report()
    {
        $this->users->restrict_subadmin();
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/reports/admin_report_vw');
        $this->load->view('panel/footer');
    }
    
    function download_report()
    {
        $this->users->restrict_subadmin();
        $where = ['status'=>1];
        if($this->session->user_type==2)
        {
            $where=['id' => $this->session->a_college_id];
        }
        $colleges = $this->db->get_where('tbl_college',$where)->result();
        $where='';
        $where2='';
        $from = explode('/',$this->input->post('date_from'));
        $from_date = $from[2].'-'.$from[0].'-'.$from[1];
        $to = explode('/',$this->input->post('date_to'));
        $to_date = $to[2].'-'.$to[0].'-'.$to[1];
        $m=0;
		//$where2 .= "(from_unixtime(a.created,'%Y-%m-%d') >= '". $from_date."' and from_unixtime(a.created,'%Y-%m-%d') < '". date('Y-m-d', strtotime($to_date . ' +1 day'))."' ) ";
		$where2 .= "(a.orderDate >= '". $from_date."' and a.orderDate <= '". $to_date ."' ) ";
        $this->load->library("excel");
        foreach($colleges as $college)
        {
            $where =['c.college_id'=>$college->id];
            $avg_rating = $this->report->get_avg_rating_bysetup($where);
            $avg_clothes = $this->report->get_avg_clothes_bysetup($where);
            //$res = $this->londury->order_perday_modify('',$from_date,$to_date,$college->id);
			$res = $this->londury->order_perday_modify_final($where2,$from_date,$to_date,$college->id);
           if(!empty($res))
            {
               
				
                if($m>0)
                {
                    $this->excel->createSheet();
                    $this->excel->setActiveSheetIndex($m);
                }else{
                    $this->excel->setActiveSheetIndex(0);
                }
				
                $this->excel->getActiveSheet()->setTitle("$college->college_name");
                $this->excel->getActiveSheet()->setCellValue('A1', 'Avarage Rating');
                $this->excel->getActiveSheet()->setCellValue('B1', $avg_rating);
                $this->excel->getActiveSheet()->setCellValue('C1', '');
                $this->excel->getActiveSheet()->setCellValue('D1', 'Average number of clothes');
                $this->excel->getActiveSheet()->setCellValue('E1', floor($avg_clothes));
                $this->excel->getActiveSheet()->setCellValue('A2', 'S.No.');
                $this->excel->getActiveSheet()->setCellValue('B2', 'Date');
                $this->excel->getActiveSheet()->setCellValue('C2', 'College Name');
                $this->excel->getActiveSheet()->setCellValue('D2', 'Total Orders');
                $this->excel->getActiveSheet()->setCellValue('E2', 'SUBTOTAL');
                $this->excel->getActiveSheet()->setCellValue('F2', 'Total Online');
                $this->excel->getActiveSheet()->setCellValue('G2', 'Total Offline');
                $this->excel->getActiveSheet()->setCellValue('H2', 'Extra amount');
                $this->excel->getActiveSheet()->setCellValue('I2', 'Total Order Value');

                $i = 1;$j = 3;
                foreach($res as $product)
                {
					$overall_extra_amount=0;
					if(isset($product->overall_extra_amount) && $product->overall_extra_amount!="")
					{
						$overall_extra_amount=$product->overall_extra_amount;
					}
                    $this->excel->getActiveSheet()->setCellValue('A'.$j, $i);
                    $this->excel->getActiveSheet()->setCellValue('B'.$j, $product->date);
                    $this->excel->getActiveSheet()->setCellValue('C'.$j, $college->college_name);
                    $this->excel->getActiveSheet()->setCellValue('D'.$j, $product->total_order);
                    $this->excel->getActiveSheet()->setCellValue('E'.$j, $product->overall_amount );
                    $this->excel->getActiveSheet()->setCellValue('F'.$j, $product->online_data);
                    $this->excel->getActiveSheet()->setCellValue('G'.$j, $product->offline_data);
                    $this->excel->getActiveSheet()->setCellValue('H'.$j, $overall_extra_amount);
                    $this->excel->getActiveSheet()->setCellValue('I'.$j, ($product->overall_amount + $overall_extra_amount));
                    $i++;$j++;
                }
            }
            $m++;
        }
      $this->excel->stream('sales_setup_report.xls');
    } 
	
	function download_reportOld()
    {
        $this->users->restrict_subadmin();
        $where = ['status'=>1];
        if($this->session->user_type==2)
        {
            $where=['id' => $this->session->a_college_id];
        }
        $colleges = $this->db->get_where('tbl_college',$where)->result();
        $where='';
        $where2='';
        $from = explode('/',$this->input->post('date_from'));
        $from_date = $from[2].'-'.$from[0].'-'.$from[1];
        $to = explode('/',$this->input->post('date_to'));
        $to_date = $to[2].'-'.$to[0].'-'.$to[1];
        $m=0;
        $this->load->library("excel");
        foreach($colleges as $college)
        {
            $where =['c.college_id'=>$college->id];
            $avg_rating = $this->report->get_avg_rating_bysetup($where);
            $avg_clothes = $this->report->get_avg_clothes_bysetup($where);
            $res = $this->londury->order_perday($where,$from_date,$to_date);
            if(!empty($res))
            {
                
                if($m>0)
                {
                    $this->excel->createSheet();
                    $this->excel->setActiveSheetIndex($m);
                }else{
                    $this->excel->setActiveSheetIndex(0);
                }
                $this->excel->getActiveSheet()->setTitle("$college->college_name");
                $this->excel->getActiveSheet()->setCellValue('A1', 'Avarage Rating');
                $this->excel->getActiveSheet()->setCellValue('B1', $avg_rating);
                $this->excel->getActiveSheet()->setCellValue('C1', '');
                $this->excel->getActiveSheet()->setCellValue('D1', 'Average number of clothes');
                $this->excel->getActiveSheet()->setCellValue('E1', floor($avg_clothes));
                $this->excel->getActiveSheet()->setCellValue('A2', 'S.No.');
                $this->excel->getActiveSheet()->setCellValue('B2', 'Date');
                $this->excel->getActiveSheet()->setCellValue('C2', 'College Name');
                $this->excel->getActiveSheet()->setCellValue('D2', 'Total Orders');
                $this->excel->getActiveSheet()->setCellValue('E2', 'Total Order Value');
                $this->excel->getActiveSheet()->setCellValue('F2', 'Total Online Recharge');
                $this->excel->getActiveSheet()->setCellValue('G2', 'Total Offline Recharge');

                $i = 1;$j = 3;
                foreach($res as $product)
                {
                    $this->excel->getActiveSheet()->setCellValue('A'.$j, $i);
                    $this->excel->getActiveSheet()->setCellValue('B'.$j, $product->date);
                    $this->excel->getActiveSheet()->setCellValue('C'.$j, $college->college_name);
                    $this->excel->getActiveSheet()->setCellValue('D'.$j, $product->total_order);
                    $this->excel->getActiveSheet()->setCellValue('E'.$j, $product->total_amount);
                    $this->excel->getActiveSheet()->setCellValue('F'.$j, $product->online_data);
                    $this->excel->getActiveSheet()->setCellValue('G'.$j, $product->offline_data);
                    $i++;$j++;
                }
            }
            $m++;
        }
        $this->excel->stream('report.xls');
    }

function cod_report()
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
        $this->load->view('panel/reports/cod_report_vw');
        $this->load->view('panel/footer');
    }
    
    function cod_report_call($id)
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
			if($this->input->post('payment_type')!='')
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
	
	function adminbookdate_report()
	{
		$this->users->restrict_subadmin();
		$this->load->view('panel/header',$pagedata);
		$this->load->view('panel/menu');
		$this->load->view('panel/reports/adminbookdate_report_vw');
		$this->load->view('panel/footer');
	}
	
	function salesbookdate_report()
    {
        $where = ['status'=>1];
        if($this->session->user_type==2)
        {
            $where=['id' => $this->session->a_college_id];
        }
        $pagedata['colleges'] = $this->db->get_where('tbl_college',$where)->result();
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/reports/salesbookdate_report_vw');
        $this->load->view('panel/footer');
    }
	
	function downloadbookdatewise_report()
    {
        $this->users->restrict_subadmin();
        $where = ['status'=>1];
        if($this->session->user_type==2)
        {
            $where=['id' => $this->session->a_college_id];
        }
        $colleges = $this->db->get_where('tbl_college',$where)->result();
        $where='';
        $where2='';
        $from = explode('/',$this->input->post('date_from'));
        $from_date = $from[2].'-'.$from[0].'-'.$from[1];
        $to = explode('/',$this->input->post('date_to'));
        $to_date = $to[2].'-'.$to[0].'-'.$to[1];
        $m=0;
        //$where2 .= "(from_unixtime(a.created,'%Y-%m-%d') >= '". $from_date."' and from_unixtime(a.created,'%Y-%m-%d') < '". date('Y-m-d', strtotime($to_date . ' +1 day'))."' ) ";
        $where2 .= "(a.bookDateON >= '". $from_date."' and a.bookDateON <= '". $to_date ."' ) ";
        $this->load->library("excel");
        foreach($colleges as $college)
        {
            $where =['c.college_id'=>$college->id];
            $avg_rating = $this->report->get_avg_rating_bysetup($where);
            $avg_clothes = $this->report->get_avg_clothes_bysetup($where);
            $res = $this->londury->book_date_wise_setup_perday_order($where2,$from_date,$to_date,$college->id);
           if(!empty($res))
            {
               
                
                if($m>0)
                {
                    $this->excel->createSheet();
                    $this->excel->setActiveSheetIndex($m);
                }else{
                    $this->excel->setActiveSheetIndex(0);
                }
                
                $this->excel->getActiveSheet()->setTitle("$college->college_name");
                $this->excel->getActiveSheet()->setCellValue('A1', 'Avarage Rating');
                $this->excel->getActiveSheet()->setCellValue('B1', $avg_rating);
                $this->excel->getActiveSheet()->setCellValue('C1', '');
                $this->excel->getActiveSheet()->setCellValue('D1', 'Average number of clothes');
                $this->excel->getActiveSheet()->setCellValue('E1', floor($avg_clothes));
                $this->excel->getActiveSheet()->setCellValue('A2', 'S.No.');
                $this->excel->getActiveSheet()->setCellValue('B2', 'Date');
                $this->excel->getActiveSheet()->setCellValue('C2', 'College Name');
                $this->excel->getActiveSheet()->setCellValue('D2', 'Total Orders');
                $this->excel->getActiveSheet()->setCellValue('E2', 'SUBTOTAL');
                $this->excel->getActiveSheet()->setCellValue('F2', 'Total Online');
                $this->excel->getActiveSheet()->setCellValue('G2', 'Total Offline');
                $this->excel->getActiveSheet()->setCellValue('H2', 'Extra amount');
                $this->excel->getActiveSheet()->setCellValue('I2', 'Total Order Value');

                $i = 1;$j = 3;
                foreach($res as $product)
                {
                    $overall_extra_amount=0;
                    if(isset($product->overall_extra_amount) && $product->overall_extra_amount!="")
                    {
                        $overall_extra_amount=$product->overall_extra_amount;
                    }
                    $this->excel->getActiveSheet()->setCellValue('A'.$j, $i);
                    $this->excel->getActiveSheet()->setCellValue('B'.$j, $product->date);
                    $this->excel->getActiveSheet()->setCellValue('C'.$j, $college->college_name);
                    $this->excel->getActiveSheet()->setCellValue('D'.$j, $product->total_order);
                    $this->excel->getActiveSheet()->setCellValue('E'.$j, $product->overall_amount );
                    $this->excel->getActiveSheet()->setCellValue('F'.$j, $product->online_data);
                    $this->excel->getActiveSheet()->setCellValue('G'.$j, $product->offline_data);
                    $this->excel->getActiveSheet()->setCellValue('H'.$j, $overall_extra_amount);
                    $this->excel->getActiveSheet()->setCellValue('I'.$j, ($product->overall_amount + $overall_extra_amount));
                    $i++;$j++;
                }
            }
            $m++;
        }
      $this->excel->stream('bookdate_wise_setup_report.xls');
    }
	
	function exportbookdate_sales()
    {
        $where = ['a.status <>'=>'0'];
        $college_id='';
        if($this->input->post('college_id')!='All'){
            $college_id = $this->input->post('college_id');
        }
        if($this->session->user_type==2)
        {
            $college_id = $this->session->a_college_id;
        }
        if($college_id!='')
        {
            $where['b.college_id']=$college_id;
        }
        
        $from = explode('/',$this->input->post('date_from'));
        $from_date = $from[2].'-'.$from[0].'-'.$from[1];
        $to = explode('/',$this->input->post('date_to'));
        $to_date = $to[2].'-'.$to[0].'-'.$to[1];
        //$where2 .= "(from_unixtime(a.created,'%Y-%m-%d') >= '". $from_date."' and from_unixtime(a.created,'%Y-%m-%d') < '". date('Y-m-d', strtotime($to_date . ' +1 day'))."' ) ";
        $where2 .= "(a.bookDateON >= '". $from_date."' and a.bookDateON <= '". $to_date ."' ) ";
        $res = $this->londury->book_date_wise_sales_report($where,$where2);
        if($res)
        {
            $this->load->library("excel");
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Report');
            $this->excel->getActiveSheet()->setCellValue('A1', 'S.No.');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Invoice ID');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Order ID');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Name');
            $this->excel->getActiveSheet()->setCellValue('E1', 'College name');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Hostel');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Moblie No');
            $this->excel->getActiveSheet()->setCellValue('H1', 'Order');
            $this->excel->getActiveSheet()->setCellValue('I1', 'Order type');
            $this->excel->getActiveSheet()->setCellValue('J1', 'Customer Booking Date');
            $this->excel->getActiveSheet()->setCellValue('K1', 'Order Date');
            $this->excel->getActiveSheet()->setCellValue('L1', 'Slot');
            $this->excel->getActiveSheet()->setCellValue('M1', 'Pickup');
            $this->excel->getActiveSheet()->setCellValue('N1', 'Token No'); 
            $this->excel->getActiveSheet()->setCellValue('O1', 'Weight');
            $this->excel->getActiveSheet()->setCellValue('P1', 'No of Clothes');
            $this->excel->getActiveSheet()->setCellValue('Q1', 'Order Status');
            $this->excel->getActiveSheet()->setCellValue('R1', 'Delivery Time');
            $this->excel->getActiveSheet()->setCellValue('S1', 'Payment Type');
            $this->excel->getActiveSheet()->setCellValue('T1', 'Coupon Applied');
            $this->excel->getActiveSheet()->setCellValue('U1', 'Discount');
            $this->excel->getActiveSheet()->setCellValue('V1', 'Extra Amount');
            $this->excel->getActiveSheet()->setCellValue('W1', 'Cloth Details');
            $this->excel->getActiveSheet()->setCellValue('X1', 'Iron Cost');
            $this->excel->getActiveSheet()->setCellValue('Y1', 'Pick up Cost');
            $this->excel->getActiveSheet()->setCellValue('Z1', 'GST');
            $this->excel->getActiveSheet()->setCellValue('AA1', 'SUBTOTAL');
            $this->excel->getActiveSheet()->setCellValue('AB1', 'Total Amount');
            $slot = [1=>'Morning',2=>'Afternoon',3=>'Evening',4=>'Night'];
            $order_type = [1=>'Bulk Wash',2=>'Premium',3=>'Dry Cleaning',4=>'Individual Wash'];
            $i = 1;$j = 2;
            foreach($res as $product)
            {
                $iron_detail='';
                if($product->iron_cost)
                {
                    $iron = json_decode($product->iron_cost);
                    $iron_detail = "No of Clothes: ".$iron->iron_no." \n"." Cost for iron: ".$iron->total_iron_price;
                }
                $p_detail='';
                if(!empty($product->items)){
                    foreach($product->items as $item)
                    {
                        $p_detail .= $item->items.": ".$item->quantity." | Cost: ".$item->cost."per cloth \n";
                    }
                }
                if($product->order_type == '1' && $product->iron =='0'  ){
                    $order_types = 'wash';
                }elseif ($product->order_type == '1' && $product->iron =='1') {
                     $order_types = 'wash + Iron';
                }
                elseif ($product->order_type == '4' && $product->iron =='0') {
                     $order_types = 'wash';
                }
                elseif ($product->order_type == '4' && $product->iron =='1') {
                     $order_types = 'Iron';
                } elseif ($product->order_type == '2' && $product->iron =='0') {
                     $order_types = 'Premium wash';
                }
                 elseif ($product->order_type == '3' && $product->iron =='0') {
                     $order_types = 'Dry Cleaning';
                }else{
                    $order_types = '0';
                }
                
                switch ($product->status)
                {
                    case 1:
                        $text = 'Order recieved';
                        break;
                    case 2:
                        $text = 'Order processed';
                        break;
                    case 3:
                        $text ='Clothes collected';
                        break;
                    case 4:
                        $text = 'Out/Ready for Delivery';
                        break;
                    case 5:
                        $text = 'Completed';
                        break;
                }
                $user_details = $product->firstname." ".$product->lastname;
                $hostel_name = $product->hostel_name."\n".$product->room_no;
                $this->excel->getActiveSheet()->setCellValue('A'.$j, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$j, $product->invoice_id);
                $this->excel->getActiveSheet()->setCellValue('C'.$j, $product->id);
                $this->excel->getActiveSheet()->setCellValue('D'.$j, $user_details);
                $this->excel->getActiveSheet()->getStyle('D'.$j)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->setCellValue('E'.$j, $product->college_name);
                $this->excel->getActiveSheet()->setCellValue('F'.$j, $hostel_name);
                $this->excel->getActiveSheet()->setCellValue('G'.$j, $product->phone_no);
                $this->excel->getActiveSheet()->setCellValue('H'.$j, $order_type[$product->order_type]);
                $this->excel->getActiveSheet()->setCellValue('I'.$j, $order_types);
                $this->excel->getActiveSheet()->setCellValue('J'.$j, $product->orderDate." ".date('h:i a',$product->created));
                $this->excel->getActiveSheet()->setCellValue('K'.$j, $product->bookDateON);
                $this->excel->getActiveSheet()->setCellValue('L'.$j, $slot[$product->book_slot]);
                $this->excel->getActiveSheet()->setCellValue('M'.$j, $product->pickup_type==1?'Self':'Avail');
                $this->excel->getActiveSheet()->setCellValue('N'.$j, $product->token_no);
                $this->excel->getActiveSheet()->setCellValue('O'.$j, $product->weight);
                $this->excel->getActiveSheet()->setCellValue('P'.$j, $product->no_of_items);
                $this->excel->getActiveSheet()->setCellValue('Q'.$j, $text);
                $this->excel->getActiveSheet()->setCellValue('R'.$j, $product->dropoff_time);
                $this->excel->getActiveSheet()->setCellValue('S'.$j, $product->payment_type==1?'Wallet':'COD');
                $this->excel->getActiveSheet()->setCellValue('T'.$j, $product->coupon_applied?$product->coupon_applied:'NA');
                $this->excel->getActiveSheet()->setCellValue('U'.$j, $product->discount);  
                $this->excel->getActiveSheet()->setCellValue('V'.$j, $product->extra_amount);
                $this->excel->getActiveSheet()->setCellValue('W'.$j, $p_detail);
                $this->excel->getActiveSheet()->getStyle('W'.$j)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->setCellValue('X'.$j, $iron_detail);
                $this->excel->getActiveSheet()->getStyle('X'.$j)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->setCellValue('Y'.$j, $product->pickup_cost);
                $this->excel->getActiveSheet()->setCellValue('Z'.$j, $product->gst);
                $this->excel->getActiveSheet()->setCellValue('AA'.$j, $product->total_amount );             
                $this->excel->getActiveSheet()->setCellValue('AB'.$j, ($product->extra_amount + $product->total_amount) );
                
                $i++;$j++;
            }
            $this->excel->stream('bookdate_wise_sales_report.xls');
        }
    }
}