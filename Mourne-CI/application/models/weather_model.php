<?php
class Weather_model extends MO_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function get_weathers_drop_admin()
  {
    $sql = "SELECT * FROM weathers";
    $q = $this->db->query($sql);

    $res = $q->result_array();

    $data[] = 'Nothing';

    foreach ($res as $row)
    {
      $data[] = $row['name'];
    }

    return $data;
  }

  function get_weather_effects_drop_admin()
  {
    $data[0] = 'No Effect';
    $data[1] = 'Fires';
    
    return $data;
  }

  function list_weathers_admin()
  {
    $sql = "SELECT * FROM weathers";
    $q = $this->db->query($sql);

    return $q->result_array();
  }

  function get_weather_admin($id)
  {
    $sql = "SELECT * FROM weathers WHERE id='$id'";
    $q = $this->db->query($sql);

    return $q->row_array();
  }

  function edit_weather_admin($data)
  {

    $sql = "UPDATE weathers
			SET name='" . $data['name'] . "',
			description='" . $data['description'] . "',
			art='" . $data['art'] . "',
			css='" . $data['css'] . "',
			effect='" . $data['effect'] . "',
			mod_max_food='" . $data['mod_max_food'] . "',
			mod_max_wood='" . $data['mod_max_wood'] . "',
			mod_max_stone='" . $data['mod_max_stone'] . "',
			mod_max_iron='" . $data['mod_max_iron'] . "',
			mod_max_mana='" . $data['mod_max_mana'] . "',
			mod_percent_food='" . $data['mod_percent_food'] . "',
			mod_percent_wood='" . $data['mod_percent_wood'] . "',
			mod_percent_stone='" . $data['mod_percent_stone'] . "',
			mod_percent_iron='" . $data['mod_percent_iron'] . "',
			mod_percent_mana='" . $data['mod_percent_mana'] . "'	
			WHERE id='" . $data['id'] . "'";

    $this->db->query($sql);

    $this->_create_sql($sql);
  }

  function add_weather_admin($data)
  {
    $sql = "INSERT INTO weathers VALUES(default,
			'" . $data['name'] . "',
			'" . $data['description'] . "',
			'" . $data['art'] . "',
			'" . $data['css'] . "',
			'" . $data['effect'] . "',
			'" . $data['mod_max_food'] . "',
			'" . $data['mod_max_wood'] . "',
			'" . $data['mod_max_stone'] . "',
			'" . $data['mod_max_iron'] . "',
			'" . $data['mod_max_mana'] . "',
			'" . $data['mod_percent_food'] . "',
			'" . $data['mod_percent_wood'] . "',
			'" . $data['mod_percent_stone'] . "',
			'" . $data['mod_percent_iron'] . "',
			'" . $data['mod_percent_mana'] . "')";

    $this->db->query($sql);

    $this->_create_sql($sql);
  }

}
//nowhitesp