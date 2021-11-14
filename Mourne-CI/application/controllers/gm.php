<?php

class Gm extends MO_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function gm_panel()
    {
        $this->headers('gm');

        $this->footer();
    }
}
//nowhitesp
