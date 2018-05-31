<?php
class Functions {
    
    public function __construct()
    {
            $this->ci =& get_instance();

            $this->ci->load->library('session');
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.sendgrid.net',
                'smtp_port' => '2525',
               	'smtp_user' => 'adminXL',
                'smtp_pass' => 'Xpress@2017',
                'mailtype'  => 'html',
                'charset'   => 'iso-8859-1',
                'newline' => "\r\n",
                'crlf' =>   "\r\n"
            );
            $this->ci->load->library('email',$config);
    }
        
    function _curl_request($url,$data=array())
    {
        $channel = curl_init();
        curl_setopt( $channel, CURLOPT_URL, $url );
        curl_setopt( $channel, CURLOPT_RETURNTRANSFER, 1 );
        //curl_setopt($channel,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $da=  empty($data);
        if(!$da){
        curl_setopt( $channel, CURLOPT_POST, 1 );
        curl_setopt( $channel, CURLOPT_POSTFIELDS, $data );
        }
        $re= curl_exec ( $channel );
        curl_close ( $channel );
        return $re;
    }
     function _multi_upload_files($userfile,$image_path,$allowed,$max_size)
    {
        $this->ci->load->library('upload');
        if(!is_dir($image_path))
            {
		mkdir($image_path);
            }
        $files = $_FILES;
        $error=[];
        $cpt = count($_FILES[$userfile]['name']);
        for($i=0; $i<$cpt; $i++)
        {
           if($files[$userfile]['tmp_name'][$i]!='')
           {

                $_FILES[$userfile]['name']= $files[$userfile]['name'][$i];
                $_FILES[$userfile]['type']= $files[$userfile]['type'][$i];
                $_FILES[$userfile]['tmp_name']= $files[$userfile]['tmp_name'][$i];
                $_FILES[$userfile]['error']= $files[$userfile]['error'][$i];
                $_FILES[$userfile]['size']= $files[$userfile]['size'][$i];    

                $config['upload_path'] = $image_path;
                $config['allowed_types'] = $allowed;
                $config['max_size'] = $max_size;
                $img=$_FILES[$userfile]['name'][$i];
                $random_digit=rand(00,99999);
                $ext = strtolower(substr($img, strpos($img,'.'), strlen($img)-1));
                $file_name=$random_digit.$ext;
                $config['file_name'] = $file_name;

                $this->ci->upload->initialize($config);
                if($this->ci->upload->do_upload($userfile))
                {
                    //$this->do_resize($this->ci->upload->file_name);
                    $newfile[]=$this->ci->upload->file_name;
                }
                else
                { 
                    $error[]=$this->ci->upload->display_errors('<span>','</span>');
                    
                }
                
           }

        }
        return ['status'=>TRUE,'filename'=>$newfile];
    }
    function _upload_image($userfile,$image_path,$allowed,$max_size)
    {
        //print_r($userfile);die;
	    if($_FILES[$userfile]['name']!='')
	    {
            if(!is_dir($image_path))
            {
                mkdir($image_path);
            }
	        $config['upload_path'] = $image_path;
            $config['allowed_types'] = $allowed;
            $config['max_size'] = $max_size;
	        $img=$_FILES[$userfile]['name'];
            $random_digit=rand(00,99999);
            $ext = strtolower(substr($img, strpos($img,'.'), strlen($img)-1));
            $file_name=$random_digit.$ext;
            $config['file_name'] = $file_name;
            $this->ci->load->library('upload', $config);
	
	    if($this->ci->upload->do_upload($userfile))
            {
                //$this->do_resize($this->ci->upload->file_name);
                return array('status'=>TRUE,'filename'=>$this->ci->upload->file_name);
            }
            else {return array('status'=>FALSE,'error'=>$this->ci->upload->display_errors('<span>','</span>'));}
	    }
    }
    
    public function do_resize($filename)
    {
        $source_path = 'assets/img/offers/' . $filename;
        $target_path =  'assets/img/offers/thumbs/';
        if(!is_dir($target_path))
            {
		mkdir($target_path);
            }
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => TRUE,
            'create_thumb' => TRUE,
            'thumb_marker' => '',
            'width' => 150,
            'height' => 150
        );
        $this->ci->load->library('image_lib', $config_manip);
        if (!$this->ci->image_lib->resize()) {
            echo $this->ci->image_lib->display_errors();
        }
        // clear //
        $this->ci->image_lib->clear();
    }
    
    function _email($email)
    {       
        $email['from']='info@xpresslaundromat.in';
        $this->ci->load->helper('email');
        $this->ci->email->from($email['from'], 'Xpress Laundromat');
        $this->ci->email->set_newline("\r\n");
        $this->ci->email->to($email['to']);
        $this->ci->email->subject($email['subject']);
        $this->ci->email->message($this->ci->load->view('email_vw', $email, TRUE));
        return $this->ci->email->send();
    }
    
    function invoice_email($email)
    {
        $email['from']='info@xpresslaundromat.in';
        $this->ci->load->helper('email');
        $this->ci->email->from($email['from'], 'Xpress Laundromat');
        $this->ci->email->set_newline("\r\n");
        $this->ci->email->to($email['to']);
		$this->ci->email->cc($email['cc']); 
        $this->ci->email->subject($email['subject']);
        $this->ci->email->message($this->ci->load->view('panel/orders/invoice_email_vw', $email['message'], TRUE));
        return $this->ci->email->send();
    }
    
    function _email_attach($email)
    {
        $email['from']='support@poolwallet.com';
        $this->ci->load->helper('email');
        $this->ci->email->set_newline("\r\n");
        $this->ci->email->from($email['from']);
        $this->ci->email->to($email['to']);
        $this->ci->email->subject($email['subject']);
        $this->ci->email->message($email['message']);
        $this->ci->email->attach($email['file_path'].$email['filename']);
	return $this->ci->email->send();
    }
    
    function _csv_import($path,$table)
    {
        $this->ci->load->library('csvreader');
        
        $result =   $this->ci->csvreader->parse_file($path);//path to csv file
        
        $i=0;
        foreach($result as $rows)
        {
          //  $rows=explode(',',$rows[$i]);
            
            $data['val']=   $rows;
          echo '<pre>';  print_r($data['val']);
          $data['table']=$table;
          return $this->ci->common->add_data($data);
            
        }
    }
    
    function import_csv($file)
    {
        $filename = $this->_upload_image($file,'assets/csv','*','10000');
        if($filename['status'])
        {
            $new =[];
            $csv = array_map('str_getcsv', file('assets/csv/'.$filename['filename']));
            $i=1;
            foreach($csv as $data)
            {
                if($i==1)
                {
                    $key = $data;
                }else{
                    $arr = [];
                    if($data[0]!='')
                    {
                        foreach($data as $d=>$v)
                        {
                            $arr[$key[$d]]=  trim($v);
                        }
                        $new[] = $arr;
                    }
                }
                $i++;
            }
            unlink('assets/csv/'.$filename['filename']);
            return ['status'=>TRUE,'data'=>$new];
        }else{
            return ['status'=>FALSE,'error'=>$filename['error']];
        }
    }
   
    function time_elapsed_string($datetime, $full = false) 
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    
    function conver_to_time($conv_fr_zon=0,$conv_fr_time="",$conv_to_zon=0)
    {
       //echo $conv_fr_zon."<br>";
        $cd = strtotime($conv_fr_time); 
        $gmdate = date('Y-m-d H:i:s', mktime(date('H',$cd)-$conv_fr_zon,date('i',$cd),date('s',$cd),date('m',$cd),date('d',$cd),date('Y',$cd)));
           //echo $gmdate."<br>";
        $gm_timestamp = strtotime($gmdate);
        $finaldate = date('d-m-Y H:i', mktime(date('H',$gm_timestamp )+$conv_to_zon,date('i',$gm_timestamp ),date('s',$gm_timestamp ),date('m',$gm_timestamp ),date('d',$gm_timestamp ),date('Y',$gm_timestamp ))); 
        return $finaldate;
    }
    
    function get_alldate_byday($start_date,$end_date,$day)
    {
        $startDate = new DateTime($start_date);
        $endDate = new DateTime($end_date);

        $dates = array();

        while ($startDate <= $endDate) {
            if ($startDate->format('w') == $day) {
                $dates[] = $startDate->format('Y-m-d');
            }

            $startDate->modify('+1 day');
        }
        return $dates;
    }
	
	function send_auto_email($email)
    {      
		$email['from']='info@xpresslaundromat.in';
        $this->ci->load->helper('email');
        $this->ci->email->from($email['from'], 'Xpress Laundromat');
        $this->ci->email->set_newline("\r\n");
        $this->ci->email->to($email['to']);
        $this->ci->email->subject($email['subject']);
        $this->ci->email->message($this->ci->load->view('email_vw', $email, TRUE));
        return $this->ci->email->send();
        
    }
	
	function send_auto_email_with_attach($email)
    { 
		$attched_file= "uploads/".$email['filename'];
        $email['from']='info@xpresslaundromat.in';
        $this->ci->load->helper('email');
        $this->ci->email->from($email['from'], 'Xpress Laundromat');
        $this->ci->email->set_newline("\r\n");
        $this->ci->email->to($email['to']);
        $this->ci->email->subject($email['subject']);
        $this->ci->email->message($this->ci->load->view('email_vw', $email, TRUE));
		$this->ci->email->attach($attched_file);
		return $this->ci->email->send();
		
        
    }
	
	function registration_email($email)
    {       
        $email['from']='info@xpresslaundromat.in';
        $this->ci->load->helper('email');
        $this->ci->email->from($email['from'], 'Xpress Laundromat');
        $this->ci->email->set_newline("\r\n");
        $this->ci->email->to($email['to']);
        $this->ci->email->subject($email['subject']);
        $this->ci->email->message($this->ci->load->view('registration_email_vw', $email, TRUE));
        return $this->ci->email->send();
    }
	
	function upload_reminder_doc($userfile,$image_path,$max_size,$allowed)
    {
        //print_r($userfile);die;
	    if($_FILES[$userfile]['name']!='')
	    {
            if(!is_dir($image_path))
            {
                mkdir($image_path);
            }
	        $config['upload_path'] = $image_path;
            $config['allowed_types'] = $allowed;
            $config['max_size'] = $max_size;
	        $img=$_FILES[$userfile]['name'];
            $random_digit=rand(00,99999);
            $ext = strtolower(substr($img, strpos($img,'.'), strlen($img)-1));
            $file_name=$random_digit.$ext;
            $config['file_name'] = $file_name;
            $this->ci->load->library('upload', $config);
	
	    if($this->ci->upload->do_upload($userfile))
            {
                //$this->do_resize($this->ci->upload->file_name);
                return array('status'=>TRUE,'filename'=>$this->ci->upload->file_name);
            }
            else {return array('status'=>FALSE,'error'=>$this->ci->upload->display_errors('<span>','</span>'));}
	    }
    }

}
