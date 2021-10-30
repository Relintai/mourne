<?php

class Mail extends MO_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  function index()
  {
    $this->load->helper('url');
    redirect('mail/inbox');
  }

  function inbox()
  {
    $this->headers('mail');

    $this->load->model('mail_model');

    $data['mails'] = $this->mail_model->get_inbox($this->userid, $this->new_mail);

    $this->load->view('mail/inbox', $data);

    $this->footer();
  }

  function compose($id = 0)
  {
    $this->headers('mail');
    $this->load->model('mail_model');
    $this->load->library('form_validation');

    $d['draft'] = FALSE;

    if ($id && is_numeric($id))
    {
      $d['draft'] = $this->mail_model->get_draft($id, $this->userid);
    }

    $this->form_validation->set_rules('name', 'Username', 'required');
    $this->form_validation->set_rules('subject', 'Subject', 'required');
    $this->form_validation->set_rules('message', 'Message', 'required');

    if (!$this->form_validation->run())
    {
      $this->load->view('mail/new', $d);
    }
    else
    {
      $send = $this->input->post('send');
      $draft = $this->input->post('draft');

      $data['name'] = $this->input->post('name');
      $data['subject'] = $this->input->post('subject');
      $data['message'] = $this->input->post('message');

      if ($send)
      {
	$this->mail_model->send_message($data, $this->userid);
      }
      else
      {
	$this->mail_model->save_draft($data, $this->userid);
      }
    }

    $this->footer();
  }

  function del_draft($id = 0)
  {
    if ($id && is_numeric($id))
    {
      $this->load->model("mail_model");
      $this->mail_model->delete_draft($id, $this->userid);
    }

    $this->load->helper('url');
    redirect('mail/drafts');
  }

  function drafts()
  {
    $this->load->model('mail_model');

    $this->headers('mail');

    $data['mails'] = $this->mail_model->get_drafts($this->userid);

    $this->load->view('mail/drafts', $data);

    $this->footer();
  }

  function read($id = 0)
  {
    if (!$id || !is_numeric($id))
    {
      $this->load->helper('url');
      redirect('mail/inbox');
    }

    $this->load->model('mail_model');

    $this->headers('mail');

    $data['mail'] = $this->mail_model->get_mail($id, $this->userid);

    $this->load->view('mail/read', $data);

    $this->footer();

  }

  function sent()
  {
    $this->headers('mail');

    $this->load->model('mail_model');

    $data['mails'] = $this->mail_model->get_all_sent($this->userid);

    $this->load->view('mail/sent', $data);

    $this->footer();
  }

  function sread($id = 0)
  {
    if (!$id || !is_numeric($id))
    {
      $this->load->helper('url');
      redirect('mail/inbox');
    }

    $this->load->model('mail_model');

    $this->headers('mail');

    $data['mail'] = $this->mail_model->get_sent($id, $this->userid);

    $this->load->view('mail/sread', $data);

    $this->footer();

  }

  function friends()
  {
    $this->headers('mail');

    $this->footer();
  }
}
//nowhitesp







