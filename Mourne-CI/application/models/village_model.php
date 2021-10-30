<?php

class Village_model extends MO_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function apply_settings($data)
  {
    if ($data['ai'])
      $ai = 1;
    else
      $ai = 0;

    $sql = "UPDATE villages
		SET name='" . $data['name'] . "',
		ai_on = '$ai'
		WHERE id='" . $data['id'] . "'";

    $this->db->query($sql);
  }

  function get_village($id)
  {
    $sql = "SELECT * FROM villages WHERE id='$id'";

    $q = $this->db->query($sql);

    return $q->row_array();
  }

  function select_village($id, $userid)
  {
    //first check if villageid belongs to user
    $sql = "SELECT * FROM villages WHERE id='$id'";

    $q = $this->db->query($sql);

    if (!$q->num_rows())
      return;

    $res = $q->row_array();

    if ($res['userid'] != $userid)
      return;

    if ($res['selected'])
      return;

    $sql = "UPDATE villages SET selected='0' WHERE userid='$userid'";

    $this->db->query($sql);

    $sql = "UPDATE villages SET selected='1' WHERE id='$id'";

    $this->db->query($sql);
  }

  function get_villages($userid)
  {
    $sql = "SELECT * FROM villages WHERE userid='$userid' ORDER BY score DESC";

    $q = $this->db->query($sql);

    return $q->result_array();
  }

  function create_village($userid, $username, $posx = -1, $posy = -1)
  {
    //make all village unselected
    $sql = "UPDATE villages
			SET selected='0'
			WHERE userid='$userid'";

    $this->db->query($sql);

    $villagename = $username . "\'s village";

    $sql = "INSERT INTO villages VALUES(default, '$userid', '$villagename', 
					default, '1', default, default, default, default, default, default)";

    $this->db->query($sql);

    //getting back id from newly created village
    $sql = "SELECT id FROM villages WHERE userid='$userid' AND selected='1'";
    $q = $this->db->query($sql);
    $res = $q->row_array();

    $id = $res['id'];

    //resources-> id, villageid, res[5], max_res[5], rate_res[5], last_updated
    $time = time();

    //make resources entry
    $sql = "INSERT INTO resources 
			VALUES(default, '$id', 
			default, default, default, default, default,
			default, default, default, default, default,
			default, default, default, default, default,
			default, default, default, default, default,
			default, default, default, default, default,
			'$time')";

    $this->db->query($sql);

    $found = FALSE;

    while(!$found)
    {
      //get a map coordinates
      //we should get 20x20 field
      //ids start with 1, max is 240
      $x_m_s = rand(1, 220);
      $y_m_s = rand(1, 220);

      $sql = "SELECT * FROM map
		WHERE (X >= '$x_m_s' AND X <= '" . ($x_m_s + 20) . "')
		AND (Y >= '$y_m_s' AND Y <= '" . ($y_m_s + 20) . "')";

      $q = $this->db->query($sql);

      $res = $q->result_array();

      foreach ($res as $row)
      {
	if ($row['type'] == 0)
	{
	  $found = TRUE;

	  $sql = "UPDATE map SET type='3', villageid='$id' WHERE id='" . $row['id'] . "'";

	  $this->db->query($sql);
	  break;
	}
      }

    }
  }

  //slotids range from 1 to parent::TOTAL_BUILDINGS!
  //slot 0 can be used for a wall or something
  function get_buildings($vid)
  {
    //tODO Empty slots

    //TODO query, get building info for empty spaces, and thats going to be pushed into empty
    //speces

    $sql = "SELECT * FROM buildings WHERE id='1'";
    $q = $this->db->query($sql);
    $space = $q->row_array();

    //this needs left join
    $sql = "SELECT * FROM village_buildings 
			INNER JOIN buildings ON village_buildings.buildingid=buildings.id 
			WHERE villageid='$vid' ORDER BY slotid ASC";
    $q = $this->db->query($sql);
    $res = $q->result_array();

    $new = FALSE;
    $j = 0;

    for ($i = 1; $i <= parent::TOTAL_BUILDINGS;$i++)
    {
      if (isset($res[$j]))
      {
	if ($res[$j]['slotid'] == $i)
	{
	  $data[] = $res[$j];
	  $j++;
	}
	else
	{
	  $new = TRUE;
	}
      }
      else
      {
	$new = TRUE;
      }

      if ($new)
      {
	$data[] = $space;
	$new = FALSE;
      }
    }

    return $data;
  }
}
//nowhitesp