<?php
class Cron extends CI_Controller
{
    //no session stuff needed for this class, so it extends from CI_Controller.

    public function __construct()
    {
        parent::__construct();
    }

    public function aiattack()
    {
        //check for useragent and stuff like that

        $this->load->model('ai_model');

        $a = $this->ai_model->attack();

        echo $a;
    }
}
//nowhitesp
