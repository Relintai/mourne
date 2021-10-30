<?php

class News extends MO_Controller
{
  public function index($page = 1)
  {
    if (!$this->check_login()) return;

    $this->load->model('news_model');
		
    $data['admin'] = FALSE;

    if ($this->userlevel > 3)
    {
      $data['admin'] = TRUE;
    }

    $data['news'] = $this->news_model->get_news($page);
		
    $this->headers();
    $this->load->view('news/news', $data);
    $this->footer();
  }

  public function add()
  {
    if ($this->userlevel < 3) show_404();

    $this->load->library('form_validation');

    $this->form_validation->set_rules('text', 'Text', 'required');

    if (!$this->form_validation->run())
    {
	
      $this->load->helper(array('form', 'url'));

      $this->headers();
      $this->load->view('news/add');
      $this->footer();
    }
    else
    {
      $this->load->model('news_model');
			
      if ($this->news_model->add_news($this->input->post('text'), $this->username))
      {
	$this->load->view('news/add_success');
      }
      else
      {
	$this->load->view('db_error');
      }
    }

  }

  public function delete($nid)
  {
    if (!$this->userlevel < 3) show_404();

		

  }

}

//nowhitesp
