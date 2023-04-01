<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function Auth(){
        // helper('cookie');
        // print_r($_POST);exit;
        $pass = md5($_POST['password']);
        $data = array(
            'email' => $_POST['username'],
            'password' => $pass,
        );
        // $time = array(
        //     'lastlogin'=> date('Y-m-d H:i:s')
        // );
        // $db = $this->load->database('default', TRUE);

        $count = $this->db->get_where('credentials',$data)->num_rows();
        if($count == 0){
            $result = 200;
        }else{
            $result = 400;
            $id['email'] = $_POST['username'];
            $userid =  $this->db->get_where('credentials',$id)->result_array();
            $this->session->set_userdata('id',$userid);
            // print_r($userid[0]['id']);exit;

            // $this->session->set('username',$_POST['username']);
            // if($_POST['rememberme'] == 'on'){
            //     set_cookie('email',$_POST['username'],'0');
            //     set_cookie('password',$_POST['password'],'0');
            // }else{
            //     delete_cookie('email');
            //     delete_cookie('password');
            // }
            // $db->table('credentials')->set($time)->where('email',$_POST['username'])->update();
        }
        // return $this->response->setJSON($result);
        echo json_encode($result);
    }

    public function logout(){
        session_destroy();
        $result = 400;
        echo json_encode($result);
    }
}
