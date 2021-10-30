<?php

class Assignment_model extends MO_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function assign_unit($assid, $num, $slotid, $res, $villageid, $userid)
  {
    $this->set_resources($res);

    //check if there is building in that slot
    $sql = "SELECT buildings.* FROM village_buildings
		INNER JOIN buildings ON village_buildings.buildingid=buildings.id
		WHERE slotid='$slotid' AND villageid='$villageid'";

    $q = $this->db->query($sql);

    if (!$q->num_rows())
      return 1;

    $building = $q->row_array();

    //check if there is already an assignment in which case we just deassign
    //in this case num will be 0 unless they play with the form, 
    //but we shouldn't care about that since the user can write 0 into the form
    $sql = "SELECT * FROM building_assignments
	        WHERE assignmentid='$assid'
		AND slotid='$slotid'
		AND villageid='$villageid'";
    $q = $this->db->query($sql);

    if ($q->num_rows())
    {
      //the user wants to just deassign
      $ass = $q->row_array();

      //delete assignment
      $sql = "DELETE FROM building_assignments WHERE id='" . $ass['id'] . "'";
      $this->db->query($sql);

      //giving back units
			
      //getting units
      $sql = "SELECT * FROM village_units 
		    WHERE villageid='$villageid'
	       	    AND userid='$userid'";
      $q = $this->db->query($sql);

      if ($q->num_rows())
      {
	$units = $q->result_array();
      }
      else
      {
	$units = FALSE;
      }

      $found = FALSE;

      if ($units)
      {
	foreach ($units as $row)
	{
	  if ($row['unitid'] == $ass['unitid'])
	  {
	    $found = TRUE;
	    $fdata = $row['id'];
	  }
	}
      }

      if ($found)
      {
	$sql = "UPDATE village_units
			SET unitcount = unitcount + '". $ass['num_unit'] . "'
			WHERE id='$fdata'";
      }
      else
      {
	$sql = "INSERT INTO village_units
			VALUES(default, '$userid', '$villageid', 
			'" . $ass['unitid'] . "', '" . $ass['num_unit'] . "')";
      }

      $this->db->query($sql);

      //substract the bonuses
      $this->substract_modifiers($assid, $villageid, 'assignment', 
				 $ass['num_bonus']);

      $this->write_resources();

      //taking away spells
      $sql = "DELETE FROM building_spells 
				WHERE assignmentid='$assid'
				AND slotid='$slotid'
				AND villageid='$villageid'";

      $this->db->query($sql);

      return 0;
    }

    //check if assignment exists
    $sql = "SELECT * FROM assignments WHERE id='$assid'";
    $q = $this->db->query($sql);

    if (!$q->num_rows())
      return 2;

    $ass = $q->row_array();

    //checking technology
    if ($ass['req_tech'])
      if (!$this->has_req_tech($ass['req_tech'], $villageid, $slotid))
	return 3;
		
    //check if building has that assignment
    if (!($building['assignment1'] == $ass['id'] ||
	  $building['assignment2'] == $ass['id'] ||
	  $building['assignment3'] == $ass['id'] ||
	  $building['assignment4'] == $ass['id'] ||
	  $building['assignment5'] == $ass['id']))
      return 3;

    //getting unit
    $sql = "SELECT * FROM village_units 
			WHERE unitid='" . $ass['unitid'] . "'
			AND userid='$userid'";
    $q = $this->db->query($sql);

    if (!$q->num_rows())
      return 4;

    $unit = $q->row_array();

    //it probably shouldn't happen but who knows
    if (!$unit['unitcount'])
      return 5;

    //if the user just clicks on the assign we should assign max
    if (!$num)
      $num = $ass['max'];

    //we shouldn't assign more than allowed
    if ($ass['max'] < $num)
      $num = $ass['max'];

    //determining how much can be assigned
    if ($unit['unitcount'] < $num)
      $num = $unit['unitcount'];

    //determining number of bonuses granted
    $num_bonus = floor(($num / $ass['bonus_per_assigned']));

    $count = ($unit['unitcount'] - $num);

    //updating unit field in db
    if ($count <= 0)
    {
      $sql = "DELETE FROM village_units WHERE id='" . $unit['id'] . "'";
    }
    else
    {
      $sql = "UPDATE village_units
				SET unitcount=unitcount - '$num'
				WHERE id='" . $unit['id'] . "'";
    }

    $this->db->query($sql);

    //adding assignment
    $sql = "INSERT INTO building_assignments
			VALUES(default, '$villageid', '$slotid', '" . $unit['unitid'] . "', 
				'$num', '" . $assid . "', '$num_bonus')";

    $this->db->query($sql);

    //grant resource bonus
    $this->add_modifiers($assid, $villageid, 'assignment', $num_bonus);
    $this->write_resources();

    //assignment has spell
    if (!$ass['spellid'])
      return 0;

    /*
    //only give spells if bonus is granted
    if (!$num_bonus)
    return 0;
    */

    //only give spell if max unit assigned
    if (!($ass['max'] == $num))
      return 0;

    //granting spell
    $sql = "INSERT INTO building_spells
			VALUES(default, '$villageid', '$slotid', '$assid', 
			'" . $ass['spellid'] . "')";

    $this->db->query($sql);

    return 0;
  }

  function get_assignments($slotid, $villageid, $userid)
  {
    if ($slotid > parent::TOTAL_BUILDINGS)
      return 1; //that shouldn't happen

    $sql = "SELECT buildings.* FROM village_buildings
			INNER JOIN buildings ON village_buildings.buildingid = buildings.id
			WHERE village_buildings.slotid='$slotid' 
			AND village_buildings.villageid='$villageid'";

    $q = $this->db->query($sql);

    if (!$q->num_rows())
      return 2; //nothing in that slot

    $res = $q->row_array();

    //getting assignment data
    $sql = "SELECT assignments.*,units.name 
			FROM assignments
			INNER JOIN units ON assignments.unitid=units.id
			WHERE assignments.id='" . $res['assignment1'] . "'
			OR assignments.id='" . $res['assignment2'] . "'
			OR assignments.id='" . $res['assignment3'] . "'
			OR assignments.id='" . $res['assignment4'] . "'
			OR assignments.id='" . $res['assignment5'] . "'";

    $q = $this->db->query($sql);


    if (!$q->num_rows())
    {
      $data['assigndata'] = FALSE; //building doesn't have assignments
      return $data;
    }

    $adata = $q->result_array();

    $tech = $this->get_village_technologies($villageid, $slotid);

    foreach ($adata as $row)
    {
      if ($this->have_technology($tech, $row['req_tech']))
	$data['assigndata'][] = $row;
    }

    if (!isset($data['assigndata']))
    {
      $data['assigndata'] = FALSE;
      return $data;
    }

    //getting assigned data
    $sql = "SELECT * FROM building_assignments
			WHERE slotid='$slotid' 
			AND villageid='$villageid'";

    $q = $this->db->query($sql);

    if (!$q->num_rows())
    {
      $data['assigned'] = FALSE;
    }
    else
    {
      $data['assigned'] = $q->result_array();
    }

    $data['building'] = $res;

    //getting units
    $sql = "SELECT * FROM village_units 
			WHERE villageid='$villageid' 
			AND userid='$userid'";
    $q = $this->db->query($sql);

    if ($q->num_rows)
    {
      $data['units'] = $q->result_array();
    }
    else
    {
      $data['units'] = FALSE;
    }

    return $data;

  }

  function get_assignment_list_drop_admin()
  {
    $sql = "SELECT * FROM assignments";
    $q = $this->db->query($sql);

    $res = $q->result_array();

    $data[0] = 'Nothing';

    foreach ($res as $row)
    {
      $data[$row['id']] = $row['description'];
    }

    return $data;
  }

  function get_assignments_admin()
  {
    $sql = "SELECT * FROM assignments";

    $q = $this->db->query($sql);

    return $q->result_array();
  }

  function add_assignment_admin($data)
  {
    $sql = "INSERT INTO assignments
			VALUES (default,
			'" . $data['unitid'] . "',
			'" . $data['max'] . "',
			'" . $data['bonus_per_assigned'] . "',
			'" . $data['spellid'] . "',
			'" . $data['req_tech'] . "',
			'" . $data['mod_max_food'] . "',
			'" . $data['mod_max_wood'] . "',
			'" . $data['mod_max_stone'] . "',
			'" . $data['mod_max_iron'] . "',
			'" . $data['mod_max_mana'] . "',
			'" . $data['mod_rate_food'] . "',
			'" . $data['mod_rate_wood'] . "',
			'" . $data['mod_rate_stone'] . "',
			'" . $data['mod_rate_iron'] . "',
			'" . $data['mod_rate_mana'] . "',
			'" . $data['mod_percent_food'] . "',
			'" . $data['mod_percent_wood'] . "',
			'" . $data['mod_percent_stone'] . "',
			'" . $data['mod_percent_iron'] . "',
			'" . $data['mod_percent_mana'] . "',
			'" . $data['description'] . "')";

    $this->db->query($sql);

    $this->_create_sql($sql);
  }

  function edit_assignment_admin($data)
  {
    $sql = "UPDATE assignments
			SET unitid='" . $data['unitid'] . "',
			max='" . $data['max'] . "',
			bonus_per_assigned='" . $data['bonus_per_assigned'] . "',
			spellid='" . $data['spellid'] . "',
			req_tech='" . $data['req_tech'] . "',
			mod_max_food='" . $data['mod_max_food'] . "',
			mod_max_wood='" . $data['mod_max_wood'] . "',
			mod_max_stone='" . $data['mod_max_stone'] . "',
			mod_max_iron='" . $data['mod_max_iron'] . "',
			mod_max_mana='" . $data['mod_max_mana'] . "',
			mod_rate_food='" . $data['mod_rate_food'] . "',
			mod_rate_wood='" . $data['mod_rate_wood'] . "',
			mod_rate_stone='" . $data['mod_rate_stone'] . "',
			mod_rate_iron='" . $data['mod_rate_iron'] . "',
			mod_rate_mana='" . $data['mod_rate_mana'] . "',
			mod_percent_food='" . $data['mod_percent_food'] . "',
			mod_percent_wood='" . $data['mod_percent_wood'] . "',
			mod_percent_stone='" . $data['mod_percent_stone'] . "',
			mod_percent_iron='" . $data['mod_percent_iron'] . "',
			mod_percent_mana='" . $data['mod_percent_mana'] . "',
			description='" . $data['description'] . "'
			WHERE id='" . $data['id'] . "'";

    $this->db->query($sql);

    $this->_create_sql($sql);
  }

  function get_assignment_admin($id)
  {
    $sql = "SELECT * FROM assignments WHERE id='$id'";

    $q = $this->db->query($sql);

    return $q->row_array();
  }
}
//nowhitesp
