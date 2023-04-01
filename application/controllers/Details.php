<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Details extends CI_Controller {

	public function view($offset)
	{
        if(isset($_GET['per_page'])){
            $offset = $_GET['per_page'];
        }else{
            $offset = 0;
        }
        
        $name = $this->session->userdata();
        $id = $name['id'][0]['id'];

        if(isset($_GET['search'])){
            $this->db->like('AWBNo', $_GET['search']);
            $this->db->or_like('BookingDate', $_GET['search']);
            $this->db->or_like('Destination', $_GET['search']);
            $this->db->or_like('ForwardinNo', $_GET['search']);
            $this->db->or_like('Origin', $_GET['search']);
            $this->db->or_like('ConsigneeName', $_GET['search']);
            $this->db->or_like('CustomerName', $_GET['search']);
            $this->db->or_like('ShipperName', $_GET['search']);
            $this->db->or_like('tracking_no', $_GET['search']);
            $this->db->or_like('tracking_no', $_GET['search']);
            $data['data'] = $this->db->get('tracking_details')->result_array();
        }else{
            $match['userId'] = $id;
            $num = 15;
            $data['data'] = $this->db->get_where('tracking_details',$match,$num, $offset)->result_array();
        }

        $count = $this->db->where('userId',$id)->count_all_results('tracking_details');
        $this->load->helper('url');

        if(isset($name['id']) && !empty($name['id'])){

            // print_r($count);
            $config['base_url'] = base_url('/details');
            $config['total_rows'] = $count;
            $config['per_page'] = 15;
            $config['page_query_string'] = true;
            $config['enable_query_strings'] = true;

            //css
            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li  class="page_Btn">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li style="margin-top:6px"><a href="#" class="page_Btn_Active">';
            $config['cur_tag_close'] = '</a></li>';
            $config['prev_tag_open'] = '<li  class="page_Btn">';
            $config['prev_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li  class="page_Btn">';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';

            $config['next_link'] = 'Next Page';
            $config['next_tag_open'] = '<li><i class="fa fa-long-arrow-right"></i>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = 'Previous Page';
            $config['prev_tag_open'] = '<li><i class="fa fa-long-arrow-left"></i>';
            $config['prev_tag_close'] = '</li>';

            $this->pagination->initialize($config);
			$this->load->view('details',$data);
        }else{
			$this->load->view('login');
		}    
    }


    public function delete(){
        $this->db->where('id',$_POST['id']);
        if($this->db->delete('tracking_details'))
        {
            $result = 200;
        }else{
            $result = 400;
        }
        echo json_encode($result);
    }
}
