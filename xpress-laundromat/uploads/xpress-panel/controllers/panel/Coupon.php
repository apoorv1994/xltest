<?php
class Coupon extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users');
        $this->load->library('functions');
        $this->users->_valid_admin();
        $this->users->restrict_subadmin();
    }
    
    function index()
    {
        $data=['val'=>'*','table'=>'tbl_coupon','orderby'=>'id','orderas'=>'DESC'];
        $res=$this->common->get_where_all($data);
        if($res['res'])
        {
            $pagedata['coupons']=$res['rows'];
        }
        $this->load->view('panel/header',$pagedata);
        $this->load->view('panel/menu');
        $this->load->view('panel/coupon/index_vw');
        $this->load->view('panel/footer');
    }
    
    function get_coupon($id)
    {
        $res = $this->db->get_where('tbl_coupon',['id'=>$id]);
        if($res->num_rows()>0)
        {
            $data = $res->row();
            $data->valid_from = date('d-m-Y',$data->valid_from);
            $data->valid_to = date('d-m-Y',$data->valid_to);
            echo json_encode(['status'=>TRUE,'data'=>$data]);
        }else{
            echo json_encode(['status'=>FALSE]);
        }
    }
    
    function add()
    {
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|xss_clean|is_unique[tbl_coupon.coupon_code]');
//        $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
        $this->form_validation->set_rules('percent_discount', '% Discount', 'trim|xss_clean');
        $this->form_validation->set_rules('max_discount', 'Max Discount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('validfrom', 'Valid from', 'trim|required|xss_clean');
        $this->form_validation->set_rules('validto', 'Valid Up To', 'trim|required|xss_clean');
        $this->form_validation->set_rules('use_time', 'Max Use time', 'trim|xss_clean');
        if($this->form_validation->run())
        {
            $startdate = explode('/', $this->input->post('validfrom'));
            $e_start = strtotime($startdate[2].'-'.$startdate[1].'-'.$startdate[0]);
            $enddate = explode('/', $this->input->post('validto'));
            $e_end = strtotime($enddate[2].'-'.$enddate[1].'-'.$enddate[0]);
            $this->db->insert('tbl_coupon',['coupon_code'=>  $this->input->post('coupon_code'),'status'=>1,'percent_discount'=>$this->input->post('percent_discount'),
                'max_discount'=>$this->input->post('max_discount'),'repeat_times'=>$this->input->post('use_time'),'valid_from'=>$e_start,'valid_upto'=>$e_end]);
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['coupon_code_err'=>  form_error('coupon_code','<div class="err">','</div>'),'description_err'=>  form_error('description','<div class="err">','</div>'),
                'percent_discount_err'=>  form_error('percent_discount','<div class="err">','</div>'),'max_discount_err'=>  form_error('max_discount','<div class="err">','</div>'),
                'validfrom_err'=>  form_error('validfrom','<div class="err">','</div>'),'validto_err'=>  form_error('validto','<div class="err">','</div>'),'use_time_err'=>  form_error('use_time','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function edit()
    {
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('coupon_id', 'Coupon', 'trim|xss_clean');
//        $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
        $this->form_validation->set_rules('percent_discount', '% Discount', 'trim|xss_clean');
        $this->form_validation->set_rules('max_discount', 'Max Discount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('validfrom', 'Valid from', 'trim|required|xss_clean');
        $this->form_validation->set_rules('validto', 'Valid Up To', 'trim|required|xss_clean');
        $this->form_validation->set_rules('use_time', 'Max Use time', 'trim|xss_clean');
        if($this->form_validation->run())
        {
            $startdate = explode('/', $this->input->post('validfrom'));
            $e_start = strtotime($startdate[2].'-'.$startdate[1].'-'.$startdate[0]);
            $enddate = explode('/', $this->input->post('validto'));
            $e_end = strtotime($enddate[2].'-'.$enddate[1].'-'.$enddate[0]);
            $this->db->update('tbl_coupon',['coupon_code'=>  $this->input->post('coupon_code'),'status'=>1,'percent_discount'=>$this->input->post('percent_discount'),
                'max_discount'=>$this->input->post('max_discount'),'repeat_times'=>$this->input->post('use_time'),'valid_from'=>$e_start,'valid_upto'=>$e_end],['id'=>$this->input->post('coupon_id')]);
            echo json_encode(['status'=>TRUE]);
        }else{
            $error = ['coupon_code_err'=>  form_error('coupon_code','<div class="err">','</div>'),'description_err'=>  form_error('description','<div class="err">','</div>'),
                'percent_discount_err'=>  form_error('percent_discount','<div class="err">','</div>'),'max_discount_err'=>  form_error('max_discount','<div class="err">','</div>'),
                'validfrom_err'=>  form_error('validfrom','<div class="err">','</div>'),'validto_err'=>  form_error('validto','<div class="err">','</div>'),'use_time_err'=>  form_error('use_time','<div class="err">','</div>')];
            echo json_encode(['status'=>FALSE,'error'=>$error]);
        }
    }
    
    function status($id,$status)
    {
        $this->db->update('tbl_coupon',['status'=>  $status],['id'=>$id]);
        $this->session->set_flashdata('msg','Status Updated');
        redirect('panel/coupon');
    }
    function delete($id)
    {
        $this->users->restrict_subadmin();
        $this->db->where(['id'=>$id]);
        $this->db->delete('tbl_coupon');
        $this->session->set_flashdata('msg','Coupon Deleted');
        redirect('panel/coupon');
    }
}