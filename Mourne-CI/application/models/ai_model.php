<?php
class Ai_model extends MO_Model
{
  protected $settings;

  function __construct()
  {
    parent::__construct();
  }

  function attack()
  {
    $this->parse_settings();

    if (!$this->settings['on'])
      return 'AI is off';

    $sql = "SELECT * FROM ai_villages WHERE attacked='0'";

    $q = $this->db->query($sql);

    $ai_village_not_attacked = $q->num_rows();

    $log = "ai_villages query returned " . $ai_village_not_attacked . " rows. \n";

    $ai_villages = $q->result_array();

    $attacking_num = $this->settings['max_attack_village_limit'];

    //determining how much will attack
    if ($this->settings['attack_village_rand'])
    {
      $a = rand(0, $this->settings['attack_village_rand']);
			
      $attacking_num -= $a;
    }

    $log .= $attacking_num . " villages attacking. \n";
		
    $reset = FALSE;

    //resetting ai_villages's attack field if everything will be set to attacked
    if ($ai_village_not_attacked < $attacking_num)
    {
      $attacking_num = $ai_village_not_attacked;

      $reset = TRUE;
    }

    //determining which villages are going to attack
    for ($i = 0; $i < $attacking_num; $i++)
    {
      $found = FALSE;

      while (!$found)
      {
	foreach ($ai_villages as $row)
	{
	  $r = rand(1, 100);

	  if ($r > 50 && !isset($s[$row['id']]))
	  {
	    $s[$row['id']] = TRUE;
	    $data[] = $row;
	    $found = TRUE;
	    break;
	  }
	}
      }
    }

    //saving to the db that they are attacked
    if (!$reset)
    {
      $sql = "UPDATE ai_villages SET attacked='1' WHERE ";

      $first = TRUE;
      foreach ($data as $row)
      {
	if ($first)
	  $first = FALSE;
	else
	  $sql .= " OR ";
	
	$sql .= "id='" . $row['id'] . "'";
      }

      $this->db->query($sql);
    }
    else
    {
      $sql = "UPDATE ai_villages SET attacked='0'";
      $this->db->query($sql);
      $log .= "ai_villages's attacked field reseted.\n";
    }

    //getting ai_units
    $sql = "SELECT * FROM ai_units";
    $q = $this->db->query($sql);
    $num_ai_units = $q->num_rows();
    $res = $q->result_array();

    if ($this->settings['ai_unit_max_diff'] < $num_ai_units)
    {
      $num = 0;
      $d = FALSE;

      while ($num != $this->settings['ai_unit_max_diff'])
      {
	foreach ($res as $row)
	{
	  if (!isset($d[$row['id']]))
	  {
	    $r = rand(1,50);
	    if ($r > 50)
	    {
	      $ai_units[] = $row;
	      $d[$row['id']] = TRUE;
	      $num++;
	      break;
	    }
	  }
	}
      }
			
    }
    else
    {
      $ai_units = $res;
    }

    //adding villages to log
    $log .= "Attacking villages: \n";
    foreach ($data as $row)
    {
      $log .= $row['name'] . "(" .$row['X'] . " " .  $row['Y'] . ") \n";
    }

    //sending attackers
    foreach ($data as $row)
    {
      $sql = "SELECT map.X,map.Y,villages.*
	      FROM map
	      LEFT JOIN villages ON (map.villageid=villages.id AND map.type='3')
	      WHERE (map.type = 3 AND
	      map.X > '" . ($row['X'] - 24) . "' 
	      AND map.X < '" . ($row['X'] + 24) . "'
	      AND map.Y > '" . ($row['Y'] - 24) . "'
	      AND map.Y < '" . ($row['Y'] + 24) . "')";

      $q = $this->db->query($sql);

      //no villages in range
      if (!$q->num_rows())
	continue;

      $log .= $row['name'] . " is attacking: \n";

      $res = $q->result_array();
			
      //sending attackers
      foreach ($res as $rrow)
      {
	if ($rrow['ai_on'] || $rrow['ai_flagged'])
	{
	  $log .= "Sending attackers to: " . $rrow['name'] . "[" . $rrow['id'] . "]";
	  $log .= " (S: " . $rrow['score'] . ")\n";
	  $log .= "Sent: \n";

	  foreach ($ai_units as $unit)
	  {
	    $a = ($rrow['score'] / $unit['rate']) / $unit['per_score'];
	    $num = floor($a);

	    $log .= $unit['name'] . "->" . $num . "\n";

	    $send[] = array('unitid' => $unit['id'], 
			    'num' => $num);
	  }

	  $this->send_attack($send, $row, $rrow);
	}
      }
    }

    $this->load->helper('file');

    $f = './logs/ai_log/log_' . time() . '.txt';

    write_file($f, $log);

    return $log;

  }

  function send_attack($send, $ai_village, $village)
  {
    $villageid = $village['id'];

    $sql = "SELECT max(attackid) AS attackid FROM attacks WHERE villageid='$villageid'";
    $q = $this->db->query($sql);

    $res = $q->row_array();

    if ($res['attackid'])
    {
      $atkid = ($res['attackid'] + 1);
    }
    else
      $atkid = 1;

    $first = TRUE;
    $sql = "INSERT INTO attacks VALUES";
    foreach ($send as $row)
    {
      if ($first)
	$first = FALSE;
      else
	$sql .= ',';

      $sql .= "(default, '$villageid', '$atkid', '" . $row['unitid'] . "', '" . $row['num']. "')";
    }

    $sql .= ";";

    $this->db->query($sql);

    //calculate distance
    $dist = sqrt(pow($ai_village['X'] - $village['X'], 2) + pow($ai_village['Y'] - $village['Y'], 2));

    //15 min 1 square
    $time = $dist * 900;
    $r = rand(3600, 10800);
    $end = $time + $r;

    //todo remove
    $end = 20;

    //attack random sides
    $dir = rand(1, 4);

    $ev['villageid'] = $villageid;
    $ev['slotid'] = 0;
    $ev['type'] = parent::EVENT_ATTACK;
    $ev['time'] = $end;
    $ev['data1'] = $atkid;
    $ev['data2'] = $dir;

    $this->add_event($ev);

  }

  function parse_settings()
  {
    $sql = "SELECT * FROM ai_settings";

    $q = $this->db->query($sql);

    $res = $q->result_array();

    foreach ($res as $row)
    {
      $data[$row['setting']] = $row['value'];
    }

    $this->settings =  $data;
  }

  function get_unit_list_drop_admin()
  {
    $sql = "SELECT * FROM ai_units";

    $q = $this->db->query($sql);

    $res = $q->result_array();

    $data[0] = 'Nothing';

    foreach ($res as $row)
    {
      $data[$row['id']] = $row['name'];
    }

    return $data;
  }

  function list_units_admin()
  {
    $sql = "SELECT * FROM ai_units";

    $q = $this->db->query($sql);

    return $q->result_array();
  }

  function get_unit_admin($id)
  {
    $sql = "SELECT * FROM ai_units WHERE id='$id'";
    $q = $this->db->query($sql);

    return $q->row_array();
  }

  function add_unit_admin($data)
  {
    $sql = "INSERT INTO ai_units
		VALUES(default,
		'" . $data['name'] . "',
		'" . $data['icon'] . "',
		'" . $data['ability'] . "',
		'" . $data['can_carry'] . "',
		'" . $data['attack'] . "',
		'" . $data['defense'] . "',
		'" . $data['rate'] . "',
		'" . $data['per_score'] . "',
		'" . $data['turn'] . "',
		'" . $data['strong_against'] . "',
		'" . $data['weak_against'] . "')";

    $this->db->query($sql);

    $this->_create_sql($sql);
  }

  function edit_unit_admin($data)
  {
    $sql = "UPDATE ai_units
		SET name='" . $data['name'] . "',
		icon='" . $data['icon'] . "',
		ability='" . $data['ability'] . "',
		can_carry='" . $data['can_carry'] . "',
		attack='" . $data['attack'] . "',
		defense='" . $data['defense'] . "',
		rate='" . $data['rate'] . "',
		per_score='" . $data['per_score'] . "',
		turn='" . $data['turn'] . "',
		strong_against='" . $data['strong_against'] . "',
		weak_against='" . $data['weak_against'] . "'
		WHERE id='" . $data['id'] . "'";

    $this->db->query($sql);

    $this->_create_sql($sql);
  }

  function get_settings_list_admin()
  {
    $sql = "SELECT * FROM ai_settings";

    $q = $this->db->query($sql);

    return $q->result_array();
  }

  function get_setting_admin($id)
  {
    $sql = "SELECT * FROM ai_settings WHERE id='$id'";
    $q = $this->db->query($sql);

    return $q->row_array();
  }

  function edit_setting_admin($data)
  {
    $sql = "UPDATE ai_settings
		SET setting='" . $data['setting'] . "',
		value='" . $data['value'] . "',
		description='" . $data['description'] . "'
		WHERE id='" . $data['id'] . "'";

    $this->db->query($sql);

    $this->_create_sql($sql);
  }

  function add_setting_admin($data)
  {
    $sql = "INSERT INTO ai_settings 
		VALUES(default, 
		'" . $data['setting'] . "', 
		'" . $data['value'] . "' , 
		'" . $data['description'] . "')";

    $this->db->query($sql);

    $this->_create_sql($sql);
  }
}
//nowhitesp