<?php

class Forum extends MO_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  function index()
  {
    $this->headers('forum');

    $this->load->view('forum/notimpl');

    $this->footer();
  }

}
//nowhitesp