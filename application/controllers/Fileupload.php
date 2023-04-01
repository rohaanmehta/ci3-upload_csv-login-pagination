<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fileupload extends CI_Controller
{
    public function file_view()
    {
        $this->load->helper('url');
        $name = $this->session->userdata();
        if(isset($name['id']) && !empty($name['id'])){
			$this->load->view('fileupload');
        }else{
			$this->load->view('login');
		}
    }

    public function file_upload()
    {

        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png|csv|xlsx';
        $config['max_size']             = 999999999999;

        $filename = $_FILES['file']['name'];

        $this->load->library('upload', $config);
        $skiprow = 0;

        if ($this->upload->do_upload('file')) {
            $arr = array(array(), array());
            $num = 0;
            $row = 0;
            $handle = fopen("uploads/" . $filename, "r");

            //remove all commas
            while ($data = fgetcsv($handle, 1000, ",")) {
                $num = count($data);
                for ($c = 0; $c < $num; $c++) {
                    $str = str_replace(',', ' ', $data[$c]);
                    $arr[$row][$c] = $str;
                }
                $row++;
            }
            $name = $this->session->userdata();
            $id = $name['id'][0]['id'];
            foreach ($arr as $str) {
                // print_r($arr);
                $in_db = array(
                    'AWBNo' => $str[0],
                    'BookingDate' => $str[1],
                    'ForwardinNo' => $str[2],
                    'tracking_no' => $str[2],
                    'Origin' => $str[3],
                    'Destination' => $str[4],
                    'ConsigneeName' => $str[5],
                    'CustomerName' => $str[6],
                    'ShipperName' => $str[7],
                    'VendorCode' => $str[8],
                );
                // $this->db->table('csv')->insert($in_db);
                if (isset($in_db['AWBNo']) && !empty($in_db['AWBNo'] && $in_db['AWBNo'] != '' && $skiprow != 0)) {
                    $match['AWBNo'] = $in_db['AWBNo'];
                    $data = array(
                        'AWBNo' => $in_db['AWBNo'],
                        'BookingDate' => $in_db['BookingDate'],
                        'ForwardinNo' => $in_db['ForwardinNo'],
			            'tracking_no' => $in_db['tracking_no'],
                        'Origin' => $in_db['Origin'],
                        'Destination' => $in_db['Destination'],
                        'ConsigneeName' => $in_db['ConsigneeName'],
                        'CustomerName' => $in_db['CustomerName'],
                        'ShipperName' =>  $in_db['ShipperName'],
                        'VendorCode' => $in_db['VendorCode'],
                        'userId' => $id
                    );
                    // echo '<pre>';print_r($in_db);
                    $count = $this->db->get_where('tracking_details', $match)->num_rows();
                    if ($count != 0) {
                        $this->db->set($data)->where($match)->update('tracking_details');
                    } else {
                        $this->db->insert('tracking_details', $data);
                    }
                }
                $skiprow++;
            }

            unlink("uploads/" . $filename);
            $result = 400;
            echo json_encode($result);
        }
    }
}
