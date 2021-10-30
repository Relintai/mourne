<?php

class Alliance extends MO_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  function index()
  {
  }

  function alliance_menu()
  {
    $this->headers('alliance');

    $this->footer();
  }

}
//nowhitesp