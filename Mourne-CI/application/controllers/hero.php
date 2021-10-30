<?php

class Hero extends MO_Controller
{
  function __construct()
  {
    parent::__construct('hero');
  }

  function index()
  {
    $this->load->helper('url');
    redirect('hero/selected');
  }

  function selected($page = 'stats', $d1 = FALSE, $d2 = FALSE, $d3 = FALSE, $d4 = FALSE)
  {
    $this->headers('hero');

    if ($page != 'stats' && $page != 'inventory' && $page != 'talents' && $page != 'spells' &&
	$page != 'actionbars')
    {
      $page = 'stats';
    }

    $this->load->view('hero/hero_menu');
    
    if ($page == 'stats')
    {
      $data['hero'] = $this->hero;
      
      $data['hpp'] = floor(($this->hero['health'] / $this->hero['max_health']) * 100);
      $data['mpp'] = floor(($this->hero['mana'] / $this->hero['max_mana']) * 100);
      $data['exp'] = floor(($this->hero['experience'] /1000) * 100);

      //STUB!
      $data['experience'] = 10000;

      $this->load->view('hero/stats', $data);
    }
    elseif ($page == 'inventory')
    {
      $this->load->model('item_model');
      
      if ($d1 !== FALSE && $d2 !== FALSE && $d3 !== FALSE && $d4 !== FALSE)
      {
	$this->item_model->set_hero($this->hero);

	$res['message'] = $this->item_model->swap($d1, $d2, $d3, $d4);

	if ($res['message'] === TRUE)
	  $this->hero = $this->item_model->get_hero();

	$d1 = FALSE;
	$d2 = FALSE;
	//we doesn't care about d3,d4 that isn't used in views
      }


      $data = $this->item_model->get_inventory($this->hero['id']);

      $data['hero'] = $this->hero;

      $data['d1'] = $d1;
      $data['d2'] = $d2;

      $res['inventory'] = $this->load->view('hero/inventory', $data, TRUE);
      $res['equipment'] = $this->load->view('hero/character', $data, TRUE);

      $this->load->view('hero/inventory_view', $res);
    }
    elseif ($page == 'talents')
    {
    }
    elseif ($page == 'spells')
    {
    }
    elseif ($page == 'actionbars')
    {
    }

    $this->footer();
  }

  function create()
  {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('name', 'Name', 'required|alpha|callback_chhn');
    $this->form_validation->set_rules('gender', 'Gender', 'required|greater_than[0]|less_than[3]|integer');
    //less than!
    $this->form_validation->set_rules('class', 'Class', 'required|integer|greater_than[0]|less_than[10]');

    if (!$this->form_validation->run())
    {
      $this->headers('hero', 1);
      
      $this->load->view('hero/create');

      $this->footer();
    }
    else
    {
      $this->load->model('hero_model');

      $data['name'] = $this->input->post('name');
      $data['gender'] = $this->input->post('gender');
      $data['class'] = $this->input->post('class');
      
      $this->hero_model->create($data, $this->userid);

      $this->load->helper('url');
      redirect('hero/selected');
    }
  }

  function select()
  {
    $this->load->model('hero_model');
    $this->load->library('form_validation');

    $this->form_validation->set_rules('heroid', 'Heroid', 'required');

    if (!$this->form_validation->run())
    {
      $this->headers('hero');

      $data['heroes'] = $this->hero_model->get_heroes($this->userid);

      $this->load->view('hero/select', $data);

      $this->footer();
    }
    else
    {
      $heroid = $this->input->post('heroid');

      $this->hero_model->select_hero($heroid, $this->userid);

      $this->load->helper('url');
      redirect('hero/selected');
    }
  }

  function delete($id = FALSE)
  {
    $this->load->helper('url');

    if (!$id || !is_numeric($id))
      redirect('hero/select');

    $this->load->model('hero_model');
    $this->load->library('form_validation');

    $this->form_validation->set_rules('confirm', 'Confirm', 'required|callback_delete_check');

    if (!$this->form_validation->run())
    {
      $data['id'] = $id;
      $data['hero'] = $this->hero_model->get_hero($id, $this->userid);

      if (!$data['hero'])
	redirect('hero/select');

      $this->headers('hero');

      $this->load->view('hero/delete_confirm', $data);

      $this->footer();
    }
    else
    {
      $this->hero_model->delete_hero($id, $this->userid);

      redirect('hero/select');
    }
  }

  function addstat()
  {
    //hero's stat view calls this with a form the hidden field's name is attrid
    //1 agi, 2 str, 3 stam, 4 int, 5 spirit
  }

  function chhn($name)
  {
    $this->load->model('hero_model');

    $a = $this->hero_model->hero_name_is_unique($name);

    if (!$a)
    {
      $this->form_validation->set_message('chhn', 'Name already taken.');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }

  function delete_check($chk)
  {
    if ($chk == "DELETE")
      return TRUE;

    $this->form_validation->set_message('delete_check', 'You have to spell DELETE, exactly, and uppercase.');

    return FALSE;
  }

}
//nowhitesp