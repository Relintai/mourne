<?php

class Forum extends MO_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->headers('forum');

        $this->load->view('forum/notimpl');

        $this->footer();
    }
}
//nowhitesp
