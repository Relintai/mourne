<?php

class Event_model extends MO_Model
{
    public $weather;
    public $weathers;
    public $weather_change;
    public $village_data;

    public function __construct()
    {
        parent::__construct();
        $this->weather = false;
        $this->weathers = false;
        $this->weather_change = false;

        $this->village_data = false;
    }

    public function update($vdata, $d = false)
    {
        //TODO make helpers for get_next_event and alike functions and remove this if
        if ($d) {
            $villageid = $vdata['id'];
            $this->village_data = $vdata;
        } else {
            $villageid = $vdata;
            $sql = "SELECT * FROM villages WHERE id='$villageid'";
            $q = $this->db->query($sql);
            $this->village_data = $q->row_array();
        }

        $this->get_resources($villageid);

        $this->get_weathers();

        $sql = "SELECT * FROM events WHERE villageid='$villageid' ORDER BY end ASC";
        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            $this->update_resources(time());
            $this->update_weather(time());
            $this->write_weather();
            $this->write_resources();
            $data['resources'] = $this->resources;
            $data['events'] = false;
            $data['weather'] = $this->weather;
            return $data;
        }

        $events = $q->result_array();

        $time = time();
        $log = "";
        $i = 0;
        foreach ($events as $row) {
            if ($row['end'] < $time) {
                switch ($row['type']) {
    case (parent::EVENT_BUILD):
      $this->update_resources($row['end']);
      $this->update_weather($row['end']);
      $this->_build_finished($row);
      $this->delete_event($row['id']);
      unset($events[$i]);
      break;
    case (parent::EVENT_UPGRADE):
      $this->update_resources($row['end']);
      $this->update_weather($row['end']);
      $this->_upgrade_finished($row);
      $this->delete_event($row['id']);
      unset($events[$i]);
      break;
    case (parent::EVENT_CREATE):
      $this->update_resources($row['end']);
      $this->update_weather($row['end']);
      $this->_create_finished($row);
      $this->delete_event($row['id']);
      unset($events[$i]);
      break;
    case (parent::EVENT_SPELL_END):
      $this->update_resources($row['end']);
      $this->update_weather($row['end']);
      $this->_spell_end($row);
      $this->delete_event($row['id']);
      unset($events[$i]);
      break;
    case (parent::EVENT_RESEARCH_END):
      $this->update_resources($row['end']);
      $this->update_weather($row['end']);
      $this->_research_end($row);
      $this->delete_event($row['id']);
      unset($events[$i]);
      break;
    case (parent::EVENT_ATTACK):
      $this->update_resources($row['end']);
      $this->update_weather($row['end']);
      $this->_attack($row);
      $this->delete_event($row['id']);
      unset($events[$i]);
      break;
    default:
      $this->update_resources($row['end']);
      $this->update_weather($row['end']);
      $this->delete_event($row['id']);
      unset($events[$i]);
      break;
    }
            }

            $i++;
        }

        $this->update_resources(time());
        $this->update_weather(time());

        $this->unitq_write();
        $this->write_resources();
        $this->write_weather();

        //TODO this can probably simplified, need some research if the array will be unsetted when all of its
        //content is unsetted
        if (isset($events)) {
            if ($events) {
                //this is to start at index 0
                foreach ($events as $row) {
                    $fevents[] = $row;
                }

                $data['events'] = $fevents;
            } else {
                $data['events'] = false;
            }
        } else {
            $data['events'] = false;
        }

        $data['resources'] = $this->resources;
        $data['weather'] = $this->weather;

        return $data;
    }

    public function get_weathers()
    {
        $sql = "SELECT * FROM weathers ORDER BY id ASC";
        $q = $this->db->query($sql);

        $this->weathers =  $q->result_array();

        foreach ($this->weathers as $row) {
            if ($this->village_data['weather'] == $row['id']) {
                $this->weather = $row;
                break;
            }
        }
    }

    public function update_weather($time = false)
    {
        if (!$time) {
            $time = time();
        }

        //first time weather calculation
        if (!$this->village_data['last_weather_change'] && !$this->village_data['weather']) {
            $r = rand(0, (sizeof($this->weathers) - 1));

            $this->weather = $this->weathers[$r];

            $this->add_modifiers($this->weather, $this->village_data['id'], 'weather', 1, true);

            $this->village_data['last_weather_change'] = $time;
            $this->village_data['weather'] = $this->weather['id'];

            $this->weather_change = true;
        }

        //if this happens its a spell, which means we have to only set this
        if ($this->village_data['weather_change_to'] && ($time == time() || ($time + 1) == time()
                             || ($time + 2) == time())) {
            //just making sure 1-2 sec delay can happen
            $w = $this->village_data['weather_change_to'];

            $this->substract_modifiers($this->weather, $this->village_data['id'], 'weather', 1, true);

            foreach ($this->weathers as $row) {
                if ($row['id'] == $w) {
                    $this->weather = $row;
                    break;
                }
            }

            $this->add_modifiers($this->weather, $this->village_data['id'], 'weather', 1, true);

            $this->village_data['last_weather_change'] = $time;
            $this->village_data['weather'] = $this->weather['id'];
            $this->village_data['weather_change_to'] = 0;

            $this->weather_change = true;
        }

        //changing weather every hour
        $nc = $this->village_data['last_weather_change'] + 3600;
    
        //if more than a hour
        if ($nc < $time) {
            $r = rand(0, (sizeof($this->weathers) - 1));

            $this->substract_modifiers($this->weather, $this->village_data['id'], 'weather', 1, true);

            $this->weather = $this->weathers[$r];

            $this->add_modifiers($this->weather, $this->village_data['id'], 'weather', 1, true);

            $this->village_data['last_weather_change'] = $time;
            $this->village_data['weather'] = $this->weather['id'];

            $this->weather_change = true;

            if ($time == time() || ($time + 1) == time() || ($time + 2) == time()) {
                //process abilities here like fires
            }
        }
    }

    public function write_weather()
    {
        if (!$this->weather_change) {
            return;
        }

        $sql = "UPDATE villages
		SET weather='" . $this->weather['id'] . "',
		last_weather_change='" . $this->village_data['last_weather_change'] . "',
		weather_change_to='" . $this->village_data['weather_change_to'] . "'
		WHERE id='" . $this->village_data['id'] . "'";

        $this->db->query($sql);
    }

    public function delete_event($evid)
    {
        $sql = "DELETE FROM events WHERE id='$evid'";
        $this->db->query($sql);
    }

    //gets events by slotid
    public function get_events($slotid, $villageid)
    {
        $this->update($villageid);

        $sql = "SELECT * FROM events WHERE villageid='$villageid' AND slotid='$slotid'";
        $q = $this->db->query($sql);

        if ($q->num_rows()) {
            return $q->result_array();
        }

        return false;
    }

    public function has_event($slotid, $villageid)
    {
        $this->update($villageid);

        $sql = "SELECT id FROM events  WHERE villageid='$villageid' AND slotid='$slotid'";
        $q = $this->db->query($sql);

        if ($q->num_rows()) {
            return true;
        }

        return false;
    }

    //gets the next event for display
    public function get_next_event($villageid)
    {
        $this->update($villageid);

        $sql = "SELECT * FROM events WHERE villageid='$villageid'";
        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            return false;
        }

        $res = $q->result_array();

        $min = 0;

        foreach ($res as $row) {
            if (!$min) {
                $min = $row;
            }

            if ($row['end'] < $min['end']) {
                $min = $row;
            }
        }

        return $min;
    }

    public function check_event($event, $type)
    {
        if (!$event) {
            return false;
        }

        if ($type == 'build') {
            $type = parent::EVENT_BUILD;
        } elseif ($type == 'upgrade') {
            $type = parent::EVENT_UPGRADE;
        } elseif ($type == 'create') {
            $type = parent::EVENT_CREATE;
        }

        foreach ($event as $row) {
            if ($row['type'] == $type) {
                return true;
            }
        }

        return false;
    }

    public function _build_finished($data)
    {
        //delete build_in progress tile
        $sql = "DELETE FROM village_buildings 
			WHERE villageid='" . $data['villageid'] . "' 
			AND slotid='" . $data['slotid'] . "'";
        $this->db->query($sql);

        //data1 should contain the buildingid
        $sql = "INSERT INTO village_buildings
			VALUES(default,
			'" . $data['villageid'] . "',
			'" . $data['slotid'] . "',
			'" . $data['data1'] . "')";

        $this->db->query($sql);

        $this->add_modifiers($data['data1'], $data['villageid']);
    }

    public function _upgrade_finished($data)
    {
        //initialize unitq
        $this->unitq_initialize($data['villageid']);

        //deassign everything
        $this->_deassign_all($data);

        //remove prev rank's modifier
        $this->substract_modifiers($data['data2'], $data['villageid']);

        //update entry
        $sql = "UPDATE village_buildings
			SET buildingid='" . $data['data1'] . "' 
			WHERE villageid='" . $data['villageid'] . "' 
			AND slotid='" . $data['slotid'] . "'";

        $this->db->query($sql);

        //add new modifiers
        $this->add_modifiers($data['data1'], $data['villageid']);
    }

    public function _create_finished($data)
    {
        $this->unitq_initialize($data['villageid']);

        $this->unitq_change('+', $data['data1'], $data['data2']);
    }

    public function _deassign_all($data)
    {
        $sql = "SELECT * FROM building_assignments
		LEFT JOIN assignments ON building_assignments.assignmentid=assignments.id
		WHERE slotid='" . $data['slotid'] . "'
		AND villageid='" . $data['villageid'] . "'";

        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            return;
        }
        
        $ass = $q->result_array();

        //deleting assignments
        $sql = "DELETE FROM building_assignments 
		WHERE slotid='" . $data['slotid'] . "' 
		AND villageid='" . $data['villageid'] . "'";

        $this->db->query($sql);

        foreach ($ass as $row) {
            $this->substract_modifiers($row, $data['villageid'], 'assignment', $row['num_bonus'], true);

            //giving units back
            $this->unitq_change('+', $row['unitid'], $row['num_unit'], true);
        }

        //take away spells
        $sql = "DELETE FROM building_spells
			WHERE villageid='" . $data['villageid'] . "'
			AND slotid='" . $data['slotid'] . "'";


        $this->db->query($sql);
    }

    public function _spell_end($data)
    {
        $this->substract_modifiers($data['data1'], $data['villageid'], 'spell');
    }

    public function _research_end($data)
    {
        $sql = "SELECT * FROM technologies WHERE id='" . $data['data1'] . "'";

        $q = $this->db->query($sql);
    
        if (!$q->num_rows()) {
            return;
        }

        $tech = $q->row_array();

        $this->add_modifiers($tech, $data['villageid'], 'technology', 1, true);

        $this->add_technology(
            $data['data1'],
            $data['data2'],
            $tech,
            $data['slotid'],
            $data['villageid']
        );
    }

    public function _attack($data)
    {
        $this->unitq_initialize($data['villageid']);
    
        //get village units who can defend
        $defenders = $this->_get_defenders();
        $userid = $this->userid;

        $attackers = $this->_get_attackers($data['data1'], $data['villageid']);
        $village = $this->_get_village($data['villageid']);

        $log = $this->_combat(
            $defenders,
            $attackers,
            $village,
            $data['data2'],
            $data['villageid'],
            $userid
        );

        $this->add_combat_log($log, $data['villageid']);

        //delete attack from the db
        $sql = "DELETE FROM attacks
	    WHERE villageid='" . $data['villageid'] . "'
	    AND attackid='" .$data['data1'] . "'";

        $this->db->query($sql);
    }

    public function _get_defenders()
    {
        $units = $this->unitq_get_units();
        $vu = $this->unitq_get_village_units();

        if (!$vu) {
            return false;
        }

        for ($i = 0; $i < sizeof($vu); $i++) {
            foreach ($units as $u) {
                if ($vu[$i]['unitid'] == $u['id']) {
                    $d[$i] = $u;
                    $d[$i]['unitcount'] = $vu[$i]['unitcount'];
                }
            }
        }

        if (!isset($d)) {
            return false;
        }

        foreach ($d as $row) {
            if ($row['can_defend']) {
                $data[] = $row;
            }
        }
    
        if (isset($data)) {
            return $data;
        } else {
            return false;
        }
    }

    public function _get_attackers($atkid, $villageid)
    {
        $sql = "SELECT attacks.ai_unitcount AS unitcount,ai_units.*
			FROM attacks
			LEFT JOIN ai_units ON attacks.ai_unitid=ai_units.id
			WHERE villageid='$villageid' AND attackid='$atkid'";

        $q = $this->db->query($sql);

        return $q->result_array();
    }

    public function _get_village($villageid)
    {
        $sql = "SELECT buildings.*,village_buildings.slotid 
			FROM village_buildings
			LEFT JOIN buildings on village_buildings.buildingid=buildings.id
			WHERE villageid='$villageid'";

        $q = $this->db->query($sql);

        $res = $q->result_array();

        $i = 1;
        for ($y = 1; $y <= parent::BUILDING_ROW; $y++) {
            for ($x = 1; $x <= parent::BUILDING_CULOMN; $x++) {
                $found = false;

                foreach ($res as $row) {
                    if ($row['slotid'] == $i) {
                        $found = true;
                        $data[$x][$y] = $row;
                    }
                }

                if (!$found) {
                    $data[$x][$y] = false;
                }

                $i++;
            }
        }

        return $data;
    }

    public function _combat($defenders, $attackers, $village, $dir, $villageid, $userid)
    {
        $this->load->helper('date');
        $datestring = "%Y.%m.%d - %H:%i:%s";

        $log = "Attack (" . mdate($datestring, time()) . "): <br /><br />";

        $log .= $this->_def_atk_list($defenders, $attackers);

        //combat with defenders
        if ($defenders) {
            //save some sizeof() calls
            $def_size = sizeof($defenders) - 1;
            $atk_size = sizeof($attackers) - 1;

            //using the smaller
            if ($def_size < $atk_size) {
                $iter = $defenders;
                $iter_t = 'def';
            } else {
                $iter = $attackers;
                $iter_t = 'atk';
            }

            //generating who fight with who
            for ($i = 0; $i < sizeof($iter); $i++) {
                $found = false;

                while (!$found) {
                    if ($iter_t == 'def') {
                        $r = rand(0, $atk_size);
                    } else {
                        $r = rand(0, $def_size);
                    }

                    if (!isset($d[$r])) {
                        if ($iter_t == 'def') {
                            $turn_a = $attackers[$r]['turn'];
                            $turn_p = $defenders[$i]['turn'];
                        } else {
                            $turn_a = $attackers[$i]['turn'];
                            $turn_p = $defenders[$r]['turn'];
                        }

                        if ($turn_a > $turn_p) {
                            $turn = 'pl';
                        } elseif ($turn_p > $turn_a) {
                            $turn = 'ai';
                        } else {
                            $turn = 'sa';
                        }

                        if ($iter_t == 'def') {
                            $unit_a = $attackers[$r];
                            $unit_p = $defenders[$i];
                        } else {
                            $unit_a = $attackers[$i];
                            $unit_p = $defenders[$r];
                        }

                        $hit = $this->_hit($unit_a, $unit_p, $turn);

                        $log .= $hit['log'];
                        $log .= "<br />";
                        
                        //write back hit
                        if ($iter_t == 'def') {
                            $attackers[$r]['unitcount'] -= $hit['ai'];
                            $defend = $defenders[$i];
                        } else {
                            $attackers[$i]['unitcount'] -= $hit['ai'];
                            $defend = $defenders[$r];
                        }

                        $d[$r] = true;
                        $found = true;
                    }
                }
            }
        } else {
            $log .= "You doesn\'t have any defenders, attackers attack your village. <br />";
        }

        //there is no unsetting in the above part, so this will always be true
        //leftover atackers go for the village
        //if ($attackers)
        //{
        //ability 1 means they can't stole
        //}

        $buildings = false;

        //create an array with these, containing the first building in every row or culomn
        //it has to be foreachable
        if ($dir == parent::ATTACK_UP) {
            for ($x = 1; $x <= parent::BUILDING_CULOMN; $x++) {
                $found = false;

                for ($y = 1; $y <= parent::BUILDING_ROW; $y++) {
                    $building = $village[$x][$y];

                    if ($building) {
                        $buildings[] = $building;
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $buildings[] = false;
                }
            }
        } elseif ($dir == parent::ATTACK_LEFT) {
            for ($y = 1; $y <= parent::BUILDING_ROW; $y++) {
                $found = false;

                for ($x = 1; $x <= parent::BUILDING_ROW; $x++) {
                    $building = $village[$x][$y];

                    if ($building) {
                        $buildings[] = $building;
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $buildings[] = false;
                }
            }
        } elseif ($dir == parent::ATTACK_RIGHT) {
            for ($y = 1; $y <= parent::BUILDING_ROW; $y++) {
                $found = false;

                for ($x = parent::BUILDING_ROW; $x >= 1; $x--) {
                    $building = $village[$x][$y];

                    if ($building) {
                        $buildings[] = $building;
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $buildings[] = false;
                }
            }
        } elseif ($dir == parent::ATTACK_DOWN) {
            for ($x = 1; $x <= parent::BUILDING_CULOMN; $x++) {
                $found = false;

                for ($y = parent::BUILDING_ROW; $y >= 1; $y--) {
                    $building = $village[$x][$y];

                    if ($building) {
                        $buildings[] = $building;
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $buildings[] = false;
                }
            }
        }

        //calc the enemy's remainder power, and how much they can steal
        //they should steal that much if they hit something without ability 1
        $remainder['pow'] = 0;
        $remainder['steal'] = 0;
        foreach ($attackers as $row) {
            $remainder['pow'] += ($row['unitcount'] * $row['attack']);
            $remainder['steal'] += ($row['unitcount'] * $row['can_carry']);
        }

        if ($remainder['pow'] || $remainder['steal']) {
            $log .= "The remainder of attackers attack your village from ";

            if ($dir == parent::ATTACK_UP) {
                $log .= "up";
            } elseif ($dir == parent::ATTACK_LEFT) {
                $log .= "left";
            } elseif ($dir == parent::ATTACK_RIGHT) {
                $log .= "right";
            } elseif ($dir == parent::ATTACK_DOWN) {
                $log .= "down";
            }

            $log .= ".<br /><br />";

            //hit buildings
            $log .= $this->_hit_building($buildings, $remainder, $villageid);
        }
        
        //ballists should attack here once
        $ballist = false;
        foreach ($attackers as $row) {
            if ($row['ability'] == 1) {
                $ballist = $row;
            }
        }

        if ($ballist) {
            if ($ballist['unitcount']) {
                $r_x = rand(1, parent::BUILDING_CULOMN);
                $r_y = rand(1, parent::BUILDING_ROW);

                $rem['pow'] = $ballist['unitcount'] * $ballist['attack'];
                $rem['steal'] = 0;

                //$log .= "<br />";

                $log .= $this->_hit_building_ability($village[$r_x][$r_y], $rem, $villageid);
            }
        }

        //return log for writing
        return $log;
    }

    public function _hit($ai, $pl, $turn)
    {
        if ($turn == 'ai') {
            $first = $ai;
            $second = $pl;
        } elseif ($turn == 'pl') {
            $first = $pl;
            $second = $ai;
        } else {
            $first = $ai;
            $second = $pl;
        }

        if ($turn == 'ai') {
            $log =  $first['name'] . "s (" . $first['unitcount'] . ")";
            $log .= " ambushes your " . $second['name'] . "s";
            $log .= " (" . $second['unitcount'] . "):<br />";
        } elseif ($turn == 'pl') {
            $log = "Your "  . $first['name'] . "s (" . $first['unitcount'] . ")";
            $log .= " ambushes " .  $second['name'] . "s";
            $log .= " (" . $second['unitcount'] . "):<br />";
        } else {
            $log = "Your " .  $pl['name'] . "s (" . $pl['unitcount'] . ")";
            $log .= " attacks " . $ai['name'] . "s";
            $log .= " (" . $ai['unitcount'] . ")<br />";
        }

        //calc stuff

        $first_atk = $first['attack'] * $first['unitcount'];

        if ($first['strong_against'] == $second['id']) {
            $first_atk *= 1.2;
        }

        if ($first['weak_against'] == $second['id']) {
            $first_atk *= 0.8;
        }

        //critical 5%
        if (rand(0, 100) > 95) {
            $first_atk *= 1.5;
            $first_crit = true;
        } else {
            $first_crit = false;
        }

        //abilities here too?
        
        //calc how much dies
        $second_d = floor($first_atk / $second['defense']);

        if ($second_d > $second['unitcount']) {
            $second_d = $second['unitcount'];
        }

        //if ambush
        if ($turn == 'ai' || $turn == 'pl') {
            $second['unitcount'] -= $second_d;
        }

        $second_atk = $second['attack'] * $second['unitcount'];

        if ($second['strong_against'] == $first['id']) {
            $second_atk *= 1.2;
        }

        if ($second['weak_against'] == $first['id']) {
            $second_atk *= 0.8;
        }

        //critical 5%
        if (rand(0, 100) > 95) {
            $second_atk *= 1.5;
            $second_crit = true;
        } else {
            $second_crit = false;
        }
        

        //some abilities can be processed here


        //calc how much dies
        $first_d = floor($second_atk / $first['defense']);

        if ($first_d > $first['unitcount']) {
            $first_d = $first['unitcount'];
        }

        //sa == same
        if ($turn == 'sa') {
            //in this case $first = $ai, $second = pl, but the order doesn't matters
            //players first
            $log .= "Your " . $second['name'] . "s hits for " . $second_atk;

            if ($second_crit) {
                $log .= " (critical)";
            }

            $log .= ", " . $first_d . " enemy dies.<br />";

            //now ai
            $log .= "Enemy " . $first['name'] . "s hits for " . $first_atk;
            if ($first_crit) {
                $log .= " (critical)";
            }

            $log .= ", " . $second_d . " of your units dies.<br />";
        } else {
            if ($turn == 'pl') {
                $log .= "Your " . $first['name'] . "s hits for " . $first_atk;

                if ($first_crit) {
                    $log .= " (critical)";
                }

                $log .= ", " . $second_d . " enemy dies.<br />";

                $log .= "Enemy " . $second['name'] . "s hits for " . $second_atk;
                if ($second_crit) {
                    $log .= " (critical)";
                }

                $log .= ", " . $first_d . " of your units dies.<br />";
            } else {
                $log .= "Enemy's " . $first['name'] . "s hits for " . $first_atk;
                if ($first_crit) {
                    $log .= " (critical)";
                }

                $log .= ", " . $second_d . " of your units dies.<br />";

                $log .= "Your " . $second['name'] . "s hits for " . $second_atk;

                if ($second_crit) {
                    $log .= " (critical)";
                }

                $log .= ", " . $first_d . " of your units dies.<br />";
            }
        }

        if ($turn == 'ai') {
            $ai_d = $first_d;
            $pl_d = $second_d;
            $uid = $second['id'];
        } elseif ($turn == 'pl') {
            $pl_d = $first_d;
            $ai_d = $second_d;
            $uid = $first['id'];
        } else {
            $ai_d = $first_d;
            $pl_d = $second_d;
            $uid = $second['id'];
        }

        $data['ai'] = $ai_d;
        $data['pl'] = $pl_d;
        $data['log'] = $log;

        //unitq is inialized already
        $this->unitq_change('-', $uid, $pl_d);

        return $data;
    }

    public function _hit_building($buildings, $remainder, $villageid)
    {
        $log = "";

        for ($i = 0; $i < 3; $i++) {
            $r = rand(0, (sizeof($buildings) -1));
        
            $b = $buildings[$r];

            if ($b) {
                $log .= "The enemy attacked your " . $b['name'];
                $log .= "(Slot " . $b['slotid'] .  ")<br />";

                if ($b['defense'] > $remainder['pow']) {
                    $log .= "They downgraded it.<br />";

                    //downgrade
                    $buildings[$r] = $this->_downgrade($b, $villageid);
                } else {
                    $log .= "They didn\'t do sufficient damage.<br />";
                }

                //steal if not ability 1 and steal is greated than 0
                if ($b['ability'] != 1 && $remainder['steal']) {
                    $s = ($remainder['steal'] / 5);
                    
                    $res['cost_food'] = $s;
                    $res['cost_wood'] = $s;
                    $res['cost_stone'] = $s;
                    $res['cost_iron'] = $s;
                    $res['cost_mana'] = $s;

                    $this->substract_resources($res, $villageid);

                    $log .= "They stole " . $s . " from all of your resources.<br />";
                } else {
                    $log .= "The enemy wasn\'t able to steal from your resources.<br />";
                }
            } else {
                if ($remainder['steal']) {
                    $s = ($remainder['steal'] / 5);
                
                    $res['cost_food'] = $s;
                    $res['cost_wood'] = $s;
                    $res['cost_stone'] = $s;
                    $res['cost_iron'] = $s;
                    $res['cost_mana'] = $s;

                    $this->substract_resources($res, $villageid);

                    $log .= "The enemy found an opening in your village\'s defenses,<br />";
                    $log .= "you lost " . $s . " from all resources!<br />";
                } else {
                    $log .= "The enemy found an opening in your village\'s defenses,<br />";
                    $log .= "but wasn\t able to steal resources.<br />";
                }
            }
            $log .= "<br />";
        }
    
        return $log;
    }

    public function _hit_building_ability($building, $remainder, $villageid)
    {
        $log = "";

        $b = $building;

        if ($b) {
            $log .= "Ballists attacked your " . $b['name'];
            $log .= "(Slot " . $b['slotid'] .  ")<br />";

            if ($b['defense'] > $remainder['pow']) {
                $log .= "They downgraded it.<br />";

                //downgrade
                //we don't need the return here, since this is the last function call in the event.
                $this->_downgrade($b, $villageid);
            } else {
                $log .= "They didn\'t do sufficient damage.<br />";
            }
        } else {
            $log .= "Ballists attacked your village, but they missed every building.";
        }
        
        return $log;
    }

    public function _downgrade($building, $villageid)
    {
        $slotid = $building['slotid'];

        $sql = "SELECT * FROM buildings WHERE next_rank='" . $building['id'] . "'";

        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            //means its rank1
            $this->substract_modifiers($building['id'], $villageid, 'building');
            //$this->delete_building($slotid, $villageid);

            //deassign all
            $d['villageid'] = $villageid;
            $d['slotid'] = $slotid;
            $this->_deassign_all($d);

            $sql = "DELETE FROM village_buildings
				WHERE villageid='$villageid'
				AND slotid='$slotid'";

            $this->db->query($sql);

            return;
        }

        $prev_r = $q->row_array();

        $this->substract_modifiers($building['id'], $villageid, 'building');

        //deassign all
        $d['villageid'] = $villageid;
        $d['slotid'] = $slotid;
        $this->_deassign_all($d);

        //change building
        $sql = "UPDATE village_buildings
			SET buildingid='" . $prev_r['id'] . "'
			WHERE villageid='$villageid'
			AND slotid='$slotid'";

        $this->db->query($sql);

        $this->add_modifiers($prev_r['id'], $villageid, 'building');

        $prev_r['slotid'] = $slotid;

        return $prev_r;
    }

    public function _def_atk_list($defenders, $attackers)
    {
        $log = "";

        if ($defenders) {
            $log .= "Your defenders:<br />";

            foreach ($defenders as $row) {
                $log .= $row['name'] . " x " . $row['unitcount'] . "<br />";
            }
        } else {
            $log .= "You don\'t have any defenders.<br />";
        }

        $log .= "<br />";
        $log .= "Attackers:<br />";

        foreach ($attackers as $row) {
            $log .= $row['name'] . " x " . $row['unitcount'] . "<br />";
        }

        $log .= "<br />";

        return $log;
    }
}
//nowhitesp
