<?php


class Aman extends CI_Controller{
 


    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('Brand_Model', 'brand');
        $this->load->database();
        if ($this->session->userdata['loggedIn'] == TRUE) {
            //do something
        } else {
            redirect('login'); //if session is not there, redirect to login page
        }

    }


    
    
    public function index()
    {
        $this->load->library('session');
        $data = $this->db->get_where('adminlogin',array('username'=>$this->session->username))->row();
        $this->load->view('Admin_profile_view',array('data'=>$data));
    }
    


    public function submit_now()
    {
        
        $name = time() . $_FILES['profile_img']['name'];
        $abcvdhg = move_uploaded_file($_FILES['profile_img']['tmp_name'], './adminimage/'.$name);
        if($abcvdhg){
            echo 'ok';
            unlink('./adminimage/' .$this->session->image );
            $_SESSION['image'] = $name;
        }
        $data = array(
            'name'=>$this->input->post('name'),
            'gender'=>$this->input->post('gender'),
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('mobile'),
            'username'=>$this->input->post('username'),
            'image'=>$name
        );
        if($_FILES['profile_img']['name'] == null){
            unset($data['image']);
        }
        $this->db->where(['username'=>$this->session->username]);
        $this->db->update('adminlogin',$data);
        $this->session->username = $this->input->post('username');
        redirect(base_url('Admin_profile'));
    }
}












