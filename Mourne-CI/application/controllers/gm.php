<?php

class Gm extends MO_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  function gm_panel()
  {
    $this->headers('gm');

    $this->footer();
  }
}
//nowhitesp