<?php

class Village extends MO_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  function index()
  {
    $this->load->helper('url');
    redirect('village/selected');
  }

  //function for testing, this will be handled when registering, and with npcs
  function create_village()
  {
    $this->load->model('village_model');

    $this->village_model->create_village($this->userid, $this->username);
  }

  function selected()
  {
    $this->load->model('village_model');

    $this->headers('village');

    $build['buildings'] = $this->village_model->get_buildings($this->villageid);

    $event['event'] = $this->_filter_events('next', 'all');

    $this->load->view('village/next_event', $event);
    $this->load->view('village/grid', $build);
    $this->footer();
  }

  function map($x = FALSE, $y = FALSE)
  {
    $this->load->model('map_model');
    $action = $this->input->post('action');

    if ($action == 'xy')
    {
      $px = $this->input->post('x');
      $py = $this->input->post('y');

      if (is_numeric($px) && is_numeric($py))
      {
	$x = $px;
	$y = $py;
      }
				
    }
    elseif ($action == 'name')
    {
      $name = $this->input->post('name');

      $rep = array(';', "\"", "'", ',', '(', ')'); 

      $name = str_replace($rep, ' ', $name);

      if ($name)
      {
	$co = $this->map_model->get_village_by_name($name);
			
	if ($co)
	{
	  $x = $co['X'];
	  $y = $co['Y'];
	}
      }
    }

    $this->load->model('map_model');

    if (!$x && !$y)
    {
      $coords = $this->map_model->get_village_coords($this->villageid);
      $x = $coords['X'];
      $y = $coords['Y'];
    }
    else
    {
      if ($x < 7)
	$x = 7;

      if ($y < 7)
	$y = 7;

      if ($x > 235)
	$x = 235;

      if ($y > 235)
	$y = 235;
    }

    $data['x'] = $x;
    $data['y'] = $y;
    $data['map'] = $this->map_model->get_map($x, $y);
			
    $this->headers('village');

    $this->load->view('village/map', $data);

    $this->footer();
  }

  function units()
  {
    $this->load->model('unit_model');

    $data['units'] = $this->unit_model->get_village_units($this->villageid);

    $this->headers('village');

    $this->load->view('village/units', $data);

    $this->footer();
  }

  function log($action = 'list', $id = 0)
  {
    if ($action != 'list' && $action != 'view' && $action != 'delete')
      $action = 'list';

    if (!is_numeric($id))
    {
      $action = 'list';
      $id = 0;
    }

    $this->load->model('log_model');

    if ($action == 'list')
    {
      $this->headers('village');

      $data['logs'] = $this->log_model->get_combat_logs($this->villageid);
      $this->load->view('village/log/list', $data);

      $this->footer();
    }

    if ($action == 'view')
    {
      $this->headers('village');

      $data['log'] = $this->log_model->get_combat_log($id, $this->villageid);
      $this->load->view('village/log/combat', $data);

      $this->footer();
    }

    if ($action == 'delete')
    {
      $this->log_model->delete_combat_log($id, $this->villageid);

      $this->load->helper('url');
      redirect('village/log');
    }
  }

  function select()
  {
    $this->load->model('village_model');
    $this->load->library('form_validation');

    $this->form_validation->set_rules('id', 'ID', 'is_natural|required');

    if (!$this->form_validation->run())
    {
      $this->headers('village');

      $data['villages'] = $this->village_model->get_villages($this->userid);

      $this->load->view('village/select', $data);

      $this->footer();
    }
    else
    {
      $id = $this->input->post('id');

      $this->village_model->select_village($id, $this->userid);

      $this->load->helper('url');
      redirect('village/selected');
    }
  }

  function events()
  {
    $this->headers('village');

    $data['event'] = $this->_filter_events('all', 'all');

    $this->load->view('village/events', $data);

    $this->footer();
  }

  function settings($id = 0)
  {
    $this->load->model('village_model');

    if (!is_numeric($id) || !$id)
    {
      $this->load->heper('url');
      redirect('village/selected');
    }

    $village = $this->village_model->get_village($id);

    if ($village['userid'] != $this->userid)
    {
      $this->load->heper('url');
      redirect('village/selected');
    }

    $this->load->library('form_validation');

    $this->form_validation->set_rules('name', 'Name', 
				      'required|alpha|is_unique[ai_villages.name]');

    if (!$this->form_validation->run())
    {
      $this->headers('village');

      $data['id'] = $id;
      $data['village'] = $village; 

      $this->load->view('village/settings', $data);
      $this->footer();
    }
    else
    {
      $data['id'] = $id;
      $name = $this->input->post('name');
      $data['ai'] = $this->input->post('ai');

      $data['name'] = ucfirst(strtolower($name));

      $this->village_model->apply_settings($data);
      
      $this->load->helper('url');
      redirect('village/select');
    }
  }

  function event_update()
  {
    //TODO for ajax, but maybe it will be solved with APE
  }

  function list_all()
  {
  }

}
//nowhitesp