<?php

class User extends MO_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function login()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');

    //is_unique[users.username]

    //xss_validation
    
    //TODO figure rules out
    $this->form_validation->set_rules('username', 'Username', 
				      'required');

    //password callback -> $this->input->post('username'), after xss filter
    $this->form_validation->set_rules('password', 'Password', 
				      'required|callback_login_check');

    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('login/login');
    }
    else
    {
      $this->load->helper('url');
      redirect('news/index');
      //$this->load->view('login/success');
    }
  }

  function register()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');

    //is_unique[users.username]
    //xss_clean
    $this->form_validation->set_rules('username', 'Username', 
				      'required|min_length[4]|max_length[32]|callback_register_username_check');

    $this->form_validation->set_rules('password', 'Password', 
				      'required|min_length[5]|matches[password_check]');

    $this->form_validation->set_rules('password_check', 'Password check', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|matches[email_check]');
    $this->form_validation->set_rules('email_check', 'Email_check', 'required');
    //$this->form_validation->set_rules('license', 'License', 'required');

    if ($this->form_validation->run() == FALSE)
    {
      $this->load->view('register/register');
    }
    else
    {
      if ($this->register_write())
      {
	$this->load->view('register/success');
      }
    }
  }

  function logout()
  {
    $this->session->unset_userdata('userid');

    $this->load->helper('url');
    redirect('user/login');

    //TODO make it look cool
    //$this->load->view('redirect_to_login');
  }

  function register_username_check($attr)
  {
    $this->load->model('user_model');

    if ($this->user_model->reg_username_check($attr))
    {
      return TRUE;
    }
    else
    {
      $this->form_validation->set_message('register_username_check', 'Username already exists!');
      return FALSE;
    }
  }

  function register_write()
  {
    $data['username'] = $this->input->post('username');
    $data['password'] = md5($this->input->post('password'));
    $data['email'] = $this->input->post('email');

    $this->load->model('user_model');
		
    return $this->user_model->reg_write($data);
  }

  function login_check($attr)
  {
    $data['username'] = $this->input->post('username');
    $data['password'] = md5($attr);

    $this->load->model('user_model');
	
    if ($this->user_model->login_check($data))
    {
      $this->session->set_userdata('userid', 
				   $this->user_model->get_userid($data['username']));

      return TRUE;
    }
    else
    {
      return FALSE;
    }	
  }

  function settings()
  {
    $this->headers('settings');

    

    $this->footer();
  }

}//login class

//nowhitesp