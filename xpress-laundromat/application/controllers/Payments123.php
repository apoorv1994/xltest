<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payments extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->users->_valid_user();
    }
    
    function index()
    {
        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
        $this->form_validation->set_rules('coupon','Coupon Code','trim|xss_clean');
        if($this->form_validation->run())
        {
            
            $amount = $this->input->post('amount');
			if($amount>=100)
			{
				$pagedata['userdata'] = $this->users->get_user('id,firstname,email_id,phone_no',$this->session->user_id);
				$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
            
                $pagedata['key']=KEY;
                $hash = HASH;
                $pagedata['payment_method']='payu_paisa';
                $posted = [];
                $productinfo = 'Recharge';
                $posted = ['key'=>$pagedata['key'],'txnid'=>$txnid,'amount'=>$amount,'productinfo'=>$productinfo,
                    'firstname'=>$pagedata['userdata']->firstname,'email'=>$pagedata['userdata']->email_id,'udf1'=>$pagedata['userdata']->id,
                    'udf2'=> '','udf3'=>  '','udf4'=>  ''];
                $hashSequence =     "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
                $hashVarsSeq = explode('|', $hashSequence);
                $hash_string = '';  
                foreach($hashVarsSeq as $hash_var) {
                  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                  $hash_string .= '|';
                }

                $hash_string .= $hash;
                $pagedata['hash'] = strtolower(hash('sha512', $hash_string));
                $pagedata['txn']=$txnid;
                $pagedata['hash_s'] = $hash_string;
                $pagedata['order_detail'] = ['pro_info'=>  $productinfo,'amount'=>$amount];
//                echo "<pre>";
//                print_r($pagedata);die;
                $this->load->view('home/payment_vw',$pagedata);
			}
			else
			{
				redirect('payments/recharge-fail');
			}  
        }
		else
		{
            redirect('home');
        }
    }
    
    function success_payment()
    {
        if($this->input->post('status')=='success')
        {
            $created = strtotime($this->input->post('addedon'));
            $val = ['mihpayid' => $this->input->post('mihpayid'),'transcation_id'=>  $this->input->post('txnid'),'amount'=>  $this->input->post('amount'),
               'user_id'=>  $this->input->post('udf1'),'payment_method'=>'Payu','recharge_by'=>  0,'payment_status'=>1,'created'=>$created];
            
            $verify = ['val'=>'id','table'=>'tbl_transcations','where'=>['transcation_id'=>$this->input->post('txnid')]];
            $res = $this->common->get_verify($verify);
            if(!$res['res'])
            {
                $data = ['val'=>$val,'table'=>'tbl_transcations'];
                $this->common->add_data($data);
                $balance = $this->users->get_user('wallet_balance',$this->session->user_id);
                $amount = $this->input->post('amount') + $balance->wallet_balance;
                $this->londury->update_wallet($amount);
            }
            redirect('home');
        }else{
            redirect('home');
        }
    }    
    
    function fail_payment()
    {
        if($this->input->post('status')=='failure')
        {
            $created = strtotime($this->input->post('addedon'));
            
                $val = ['mihpayid' => $this->input->post('mihpayid'),'transcation_id'=>  $this->input->post('txnid'),'amount'=>  $this->input->post('amount'),
               'user_id'=>  $this->input->post('udf1'),'recharge_by'=>  0,'payment_status'=>2,'payment_method'=>'Payu','fail_reason'=>  $this->input->post('field9'),'created'=>$created];
            $verify = ['val'=>'id','table'=>'tbl_transcations','where'=>['transcation_id'=>$this->input->post('txnid')]];
            $res = $this->common->get_verify($verify);
            if(!$res['res'])
            {
                $data = ['val'=>$val,'table'=>'tbl_transcations'];
                $this->common->add_data($data);
            }
            $pagedata['details'] = $this->users->get_user('firstname,wallet_balance',  $this->session->user_id);
            $pagedata['title'] = 'Payment Failed';
            $pagedata['resp'] = $this->input->post();
            $this->load->view('header_vw',$pagedata);
            $this->load->view('home/failpayment_vw');
            $this->load->view('footer_vw');
            
        }else{
            redirect('home');
        }
    }
	
	function make_payment()
    {
        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
        $this->form_validation->set_rules('coupon','Coupon Code','trim|xss_clean');
        if($this->form_validation->run())
        {
			 if($this->input->post('amount')>=100)
			 {
				 header("Pragma: no-cache");
				 header("Cache-Control: no-cache");
				 header("Expires: 0");

				 // following files need to be included
				 require_once(APPPATH . "/third_party/paytmlib/config_paytm.php");
				 require_once(APPPATH . "/third_party/paytmlib/encdec_paytm.php");

				 $checkSum = "";
				 $paramList = array();
				 $ORDER_ID = "ORDS" . rand(10000,99999999);
				 $CUST_ID = $this->session->user_id;
				 $INDUSTRY_TYPE_ID = $this->input->post('INDUSTRY_TYPE_ID');
				 $CHANNEL_ID = $this->input->post('CHANNEL_ID');
				 $TXN_AMOUNT = $this->input->post('amount');
				 //$TXN_AMOUNT = '1';
				 
				 $val = ['order_id' => $ORDER_ID,'cust_id'=> $CUST_ID,'txn_amount'=> $TXN_AMOUNT,'orderDate'=> date("Y-m-d"),'orderDateTime'=>date("Y-m-d h:i:s")];
				 $data = ['val'=>$val,'table'=>'tbl_paytm_oder'];
				 $this->common->add_data($data);
				 
				 $this->session->set_userdata('paytm_order_id',$ORDER_ID);

				// Create an array having all required parameters for creating checksum.
				 $paramList["MID"] = PAYTM_MERCHANT_MID;
				 $paramList["ORDER_ID"] = $ORDER_ID;
				 $paramList["CUST_ID"] = $CUST_ID;
				 $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
				 $paramList["CHANNEL_ID"] = $CHANNEL_ID;
				 $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
				 $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
				 $paramList["CALLBACK_URL"] = BASE."payments/response";

				 /*
				 $paramList["MSISDN"] = $MSISDN; //Mobile number of customer
				 $paramList["EMAIL"] = $EMAIL; //Email ID of customer
				 $paramList["VERIFIED_BY"] = "EMAIL"; //
				 $paramList["IS_USER_VERIFIED"] = "YES"; //

				 */

				//Here checksum string will return by getChecksumFromArray() function.
				 $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
				 echo "<html>
				<head>
				<title>Merchant Check Out Page</title>
				</head>
				<body>
					<center><h1>Please do not refresh this page...</h1></center>
						<form method='post' action='".PAYTM_TXN_URL."' name='f1'>
				<table border='1'>
				 <tbody>";

				 foreach($paramList as $name => $value) {
				 echo '<input type="hidden" name="' . $name .'" value="' . $value .         '">';
				 }

				 echo "<input type='hidden' name='CHECKSUMHASH' value='". $checkSum . "'>
				 </tbody>
				</table>
				<script type='text/javascript'>
				 document.f1.submit();
				</script>
				</form>
				</body>
				</html>";
					
				
			}
			else
			{
				redirect('payments/recharge-fail');
			}
		}else{
            redirect('home');
        }
    }
	
	function response()
	{
		$verify = ['val'=>'*','field'=>'id','sort'=>'desc','limit'=>'1','table'=>'tbl_paytm_oder','where'=>['cust_id'=>$this->session->user_id]];
        $res = $this->common->get_paytm_order_data($verify);
		if($res['res'])
		{
			header("Pragma: no-cache");
			header("Cache-Control: no-cache");
			header("Expires: 0");

			// following files need to be included
			require_once(APPPATH . "/third_party/paytmlib/config_paytm.php");
			require_once(APPPATH . "/third_party/paytmlib/encdec_paytm.php");

			$ORDER_ID = "";
			$requestParamList = array();
			$responseParamList = array();

			if (isset($res['rows']->order_id) && $res['rows']->order_id != "" && $res['rows']->order_id==$this->session->paytm_order_id) {
 
				// In Test Page, we are taking parameters from POST request. In actual implementation these can be collected from session or DB. 
				$ORDER_ID = $res['rows']->order_id;

				// Create an array having all required parameters for status query.
				$requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $ORDER_ID);  
				
				$StatusCheckSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
				
				$requestParamList['CHECKSUMHASH'] = $StatusCheckSum;

				// Call the PG's getTxnStatusNew() function for verifying the transaction status.
				$responseParamList = getTxnStatusNew($requestParamList);
				//$param=json_encode($requestParamList);
				//print_r($param);
				//$output=file_get_contents("https://pguat.paytm.com/oltp/HANDLER_INTERNAL/getTxnStatus?JsonData=".$param);
				//print_r($output);die;
				
			}
			if (isset($responseParamList) && count($responseParamList)>0)
			{
				if($responseParamList['STATUS']=='TXN_SUCCESS' && $responseParamList['RESPCODE']=='01')
				{
					$payment_status=1;
					$fail_reason="";
					$description=$responseParamList['RESPMSG'];
					$balance = $this->users->get_user('wallet_balance',$this->session->user_id);
					$amount = $responseParamList['TXNAMOUNT'] + $balance->wallet_balance;
					$this->londury->update_wallet(intval($amount));
				}
				else
				{
					$payment_status=2;
					$fail_reason=$responseParamList['RESPMSG'];
					$description="";
				}
				$val = ['mihpayid' => 0,'transcation_id'=> $responseParamList['TXNID'],'amount'=> intval($responseParamList['TXNAMOUNT']),'user_id'=> $this->session->user_id,'payment_method'=> 'Paytm','recharge_by'=> 0,'payment_status'=> $payment_status,'created'=> strtotime($responseParamList['TXNDATE']),'fail_reason'=> $fail_reason,'description'=> $description];
				$data = ['val'=>$val,'table'=>'tbl_transcations'];
                $this->common->add_data($data);
				$msg=$responseParamList['RESPMSG'];
			}
			else
			{
				$msg="Transaction Failed";
			}
		}
		else
		{
			$msg="No Transaction";
			
		}
		$this->session->unset_userdata('paytm_order_id');
		$res['msg']=$msg;
		$this->load->view('home/response_vw',$res);
	}
	
	function recharge_fail()
    {
            $this->load->view('header_vw');
            $this->load->view('home/recharge_fail_vw');
            $this->load->view('footer_vw');
            
    }
	function paytmResponse()
	{
		$output=file_get_contents(BASE."payments/paytmResponse");
		print_r($output);
	}
    
    
}