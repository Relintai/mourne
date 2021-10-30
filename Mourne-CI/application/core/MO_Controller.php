<?php

class MO_Controller extends CI_Controller
{
  public $userid;
  public $username;
  public $language;
  public $userlevel;
  public $villageid;
  public $village_name;
  public $resources;
  public $events;
  public $building;
  public $village_data;
  public $weather;

  //hero stuff
  public $hero;

  public $new_mail;
  public $new_log;
	

  function __construct($page = 'village')
  {
    parent::__construct();
    $this->weather = FALSE;
    $this->resources = FALSE;
    $this->hero = FALSE;

    $this->_manage_session($page);
  }

  public function _manage_session($page)
  {
    $this->userid = 0;

    //this should be solved with db!
//    if (!$this->session->userdata('language'))
//      $this->session->set_userdata('language', 'english');

//      $this->language = $this->session->userdata('language');

    $this->language = 'english';

    if ($this->session->userdata('userid'))
      $this->userid = $this->session->userdata('userid');

    $this->load->model('mo_common_model');

    if ($this->userid)
    {
      $data = $this->mo_common_model->get_userdata($this->userid);

      $this->userlevel = $data['userlevel'];
      $this->username = $data['username'];
      $this->new_mail = $data['new_mail'];

      if ($page == 'village')
      {
	$mdata = $this->mo_common_model->get_village_data($this->userid);

	$this->villageid = $mdata['id'];
	$this->villagename = $mdata['name'];
	$this->new_log = $mdata['new_log'];

	$this->village_data = $mdata;
      }

      if ($page == 'hero')
      {
	$this->hero = $this->mo_common_model->get_hero_data($this->userid);
      }
    }
  }

  public function check_login()
  {
    if ($this->userid == 0)
    {
      $this->load->helper('url');
      redirect('user/login');
    }

    return TRUE;
  }

  public function headers($page = 'village', $slotid = 0)
  {
    $data['username'] = $this->username;
    $data['userid'] = $this->userid;
    $data['userlevel'] = $this->userlevel;
    $data['newmail'] = $this->new_mail;
    $data['page'] = $page;

    if ($page != 'hero')
    {
      $data['villagename'] = $this->villagename;
      $data['newlog'] = $this->new_log;

      if ($page == 'building' || $page == 'village' || $page == 'build' || $page == 'build_in_progress' ||
	  $page == 'mail')
      {
	$this->_update();
      }

      //this has to be done like this, since this function will redirect if nothing in the slot
      if ($page == 'building')
	$this->_get_slot_building($slotid);

      if ($page != 'do')
      {
	$data['weather'] = $this->weather;
	$data['resources'] = $this->_prep_res_js();
	$this->load->view('parts/header', $data);
	$this->load->view('menu', $data);
	$this->load->view('parts/js_res', $data);
      }

      if ($page == 'building' || $page == 'village' || $page == 'build' || $page == 'build_in_progress' ||
	  $page == 'mail')
      {
	$res['res'] = $this->resources;
	$this->load->view('village/resources', $res);
      }

      if ($page == 'mail')
      {
	$this->load->view('mail/menu');
      }

      if ($page == 'village')
      {
	$this->load->view('village/menu');
      }

      if ($page == 'building')
      {
	$data['building'] = $this->building;
	$data['slotid'] = $slotid;

	$this->load->view('building/header', $data);
	$this->load->view('building/menu', $data);
      }

      if ($page == 'do')
      {
	$this->_update();

	if ($slotid)
	  $this->_get_slot_building($slotid);
      }
    }
    elseif ($page == 'hero')
    {
      if (!$this->hero && !$slotid)
      {
	$this->load->helper('url');
	redirect('hero/create');
	return;
      }

      $data['hero'] = $this->hero;
      $data['weather'] = FALSE;
      $data['resources'] = FALSE;
      $this->load->view('parts/header', $data);
      $this->load->view('menu', $data);
      $this->load->view('hero/menu', $data);
    }
  }

  public function _get_slot_building($slotid = 0)
  {
    if (!$slotid)
      return;

    if ($this->building)
      return;

    $this->load->model('building_model');
    $this->building = $this->building_model->get_slot_building($slotid, $this->villageid);

    //this is commented out, because get_slot_building cannot return FALSE lol
    //	if (!$this->building)
    //	{
    //	$this->load->helper('url');
    //	redirect('village/selected');
    //}
  }

  public function _get_resources()
  {
    if ($this->resources)
      return;

    $this->load->model('resource_model');
    $this->resources = $this->resource_model->get_resources($this->villageid);
  }

  public function _update()
  {
    $this->load->model('event_model');

    if ($this->resources || $this->events || $this->weather)
      return;

    //event model returns resources, and events, and weather
    $data = $this->event_model->update($this->village_data, TRUE);

    $this->resources = $data['resources'];
    $this->events = $data['events'];
    $this->weather = $data['weather'];
  }

  public function footer()
  {
    $this->load->view('parts/footer');
  }

  /*
    filter events, based on type and filter, and order it ASC
    type -> 'next', 'type', 'all'
      if type == 'type' you have to provide an event type
    filter -> 'all', 'slot'
      if filter == 'slot' you have to provide slotid 
    next -> TRUE/FALSE
      only return the next event, this is here, so every type can be asked to return the next one
      this is primarily here, so when events like EVENT_BUILD needed, since there aren't going to be 2      
   */

  public function _filter_events($type, $filter, $slotid = 0, $ev_type = 0, $next = FALSE)
  {
    //means no events
    if (!$this->events)
        return FALSE;

    $data = FALSE;

    if ($type == 'all')
    {
      if ($filter == 'slot')
      {
	foreach ($this->events as $row)
	{
	  if ($row['slotid'] == $slotid)
	  {
	    $data[] = $row;
	  }
	}
      }
      else
      {
	$data = $this->events;
      }
    }

    if ($type == 'type')
    {
      if ($filter == 'all')
      {
	foreach ($this->events as $row)
	{
	  if ($row['type'] == $ev_type)
	  {
	    $data[] = $row;
	  }
	}
      }
      else
      {
	foreach ($this->events as $row)
	{
	  if ($row['type'] == $ev_type && $row['slotid'] == $slotid)
	  {
	    $data[] = $row;
	  }
	}
      }
    }

    if ($type == 'next')
    {
      if ($filter == 'all')
      {
	$last_end = 99999999999;
	$smallest = FALSE;
	foreach ($this->events as $row)
	{
	  if ($row['end'] < $last_end)
	  {
	    $last_end = $row['end'];
	    $smallest = $row;
	  }
	}

	return $smallest;
      }
      else
      {
	$last_end = 99999999999;
	$smallest = FALSE;
	foreach ($this->events as $row)
	{
	  if ($row['end'] < $last_end && $row['slotid'] == $slotid)
	  {
	    $last_end = $row['end'];
	    $smallest = $row;
	  }
	}

	return $smallest;	
      }
    }

    //order it
    if ($data)
    {
      $last_end = 99999999999;
      $last['id'] = FALSE;
      $smallest = FALSE;

      for ($i = 0; $i < sizeof($data); $i++)
      {
	foreach ($data as $row)
	{
	  //accounting for events ending at the same time
	  if ($row['end'] <= $last_end && $last['id'] != $row['id'])
	  {
	    $smallest = $row;
	  }
	}

	$ret[] = $smallest;
	$last_end = $smallest['end'];
	$last = $smallest;
      }

      if (!$next)
	return $ret;
      else
	return $ret[0];
    }

    return FALSE;
  }

  function _prep_res_js()
  {
    if (!$this->resources)
      return FALSE;

    $res = $this->resources;

    //determining which have the lowest rate
    $a[] = $res['food'];
    $a[] = $res['wood'];
    $a[] = $res['stone'];
    $a[] = $res['iron'];
    $a[] = $res['mana'];

    $last = $a[0];
    $index = 0;

    for ($i = 0; $i < 5; $i++)
    {
      if ($a[$i] < $last)
      {
	$last = $a[$i];
	$index = $i;
      }
    }

    //comberting back numerical index
    switch ($index)
    {
      case 0:
	$s_index = 'food';
	break;
      case 1:
	$s_index = 'wood';
	break;
      case 2:
	$s_index = 'stone';
	break;
      case 3:
	$s_index = 'iron';
	break;
      case 4:
	$s_index = 'mana';
	break;
      default:
	$s_index = 'food';
	break;
    }

    //calculating the rate it brings 1 resource
    $num_tick = 0.1;
    $rate = 'rate_' . $s_index;

    while (TRUE)
    {
      if (($res[$rate] * $num_tick) > 1)
	break;
     
      $num_tick += 0.1;
    }

    $res['rate_food'] *= $num_tick;
    $res['rate_wood'] *= $num_tick;
    $res['rate_stone'] *= $num_tick;
    $res['rate_iron'] *= $num_tick;
    $res['rate_mana'] *= $num_tick;

    $res['timer_tick'] = (1000 * $num_tick);

    return $res;
  }

}//MO_Controller
//nowhitesp










