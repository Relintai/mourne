<?php

class Alliance extends MO_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    }

    public function alliance_menu()
    {
        $this->headers('alliance');

        $this->footer();
    }
}
//nowhitesp
