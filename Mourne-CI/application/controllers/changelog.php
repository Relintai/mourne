<?php

class Changelog extends MO_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show()
    {
        $this->load->model('changelog_model');

        $data['versions'] = $this->changelog_model->get_versions();
        $data['commits'] = $this->changelog_model->get_commits();
        $data['userlevel'] = $this->userlevel;
        $data['required_userlevel'] = 4;

        $this->headers();
        $this->load->view('changelog/changelog', $data);
        $this->footer();
    }

    public function add_new_version()
    {
        if (!$this->userlevel > 4) {
            show404();
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('text', 'Text', 'required');

        if (!$this->form_validation->run()) {
            $this->load->view('changelog/new_version');
        } else {
            $this->load->model('changelog_model');

            $text = $this->input->post('text');
            $this->changelog_model->new_version($text);

            $this->load->helper('url');
            redirect('changelog/show');
        }
    }

    public function add_new_commit()
    {
        if (!$this->userlevel > 4) {
            show404();
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('text', 'Text', 'required');

        if (!$this->form_validation->run()) {
            $this->load->view('changelog/new_commit');
        } else {
            $this->load->model('changelog_model');

            $text = $this->input->post('text');
            $this->changelog_model->new_commit($text);

            $this->load->helper('url');
            redirect('changelog/show');
        }
    }
}

//nowhitesp
