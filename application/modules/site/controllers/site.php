<?php

class Site extends MX_Controller 
{
	function __construct()
	{
		//parent::Controller();
		$this->is_logged_in();
	}

	function members_area()
	{
		$this->load->view('logged_in_area');
	}
	
	function another_page() // just for sample
	{
		echo 'good. you\'re logged in.';
	}
	
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';	
			die();		
			//$this->load->view('login_form');
		}		
	}	

	function messages()
	{
	    modules::run('login/is_logged_in');
	    $this->load->model('login/membership_model');
	    $user = $this->membership_model->get_member_details($this->uri->segment(3));
	    if( !$user )
	    {
	        // No user found
	        return false;
	    }
	    else
	    {
	        // display our widget
	        $this->load->view('member_messages', $user);
	    }               
	}

	function profile()
    {
        $this->load->model('login/membership_model');
        $user = $this->membership_model->get_member_details($this->uri->segment(3));
        if( !$user )
        {
            // No user found
            $data['main_content'] = 'member_profile';
            $data['notice'] = 'you need to view a profile id';
            $this->load->view('includes/template', $data);
        }
        else
        {
            // display our widget
            $user['main_content'] = 'member_profile';
            $this->load->view('includes/template', $user);
        }       
    }
}
