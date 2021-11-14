<?php

class MO_Model extends CI_Model
{
    const EVENT_BUILD = 0;
    const EVENT_UPGRADE = 1;
    const EVENT_CREATE = 2;
    const EVENT_SPELL_END = 3;
    const EVENT_RESEARCH_END = 4;
    const EVENT_ATTACK = 5;

    const ATTACK_UP = 1;
    const ATTACK_LEFT = 2;
    const ATTACK_RIGHT = 3;
    const ATTACK_DOWN = 4;

    const TOTAL_BUILDINGS = 209;
    const BUILDING_CULOMN = 19;
    const BUILDING_ROW = 11;

    //hero
    const INVENTORY_MAX = 100; //0-99!

  //Resource manipulations
    public $resources;
    public $resources_changed;
    public $modifiers_changed;
    public $score;

    //unit manipulations
    public $unitq_initialized;
    public $unitq_village_units; //stores units which are in the db
    public $unitq_changes; //the changes
    public $unitq_units; //the changed units data

    public $villageid;
    public $userid;

    //hero
    public $hero;
    public $hero_stat_changed;
    public $hero_exp_changed;
    public $hero_hpmp_changed;

    public function __construct()
    {
        parent::__construct();
        $this->resources = false;
        $this->resources_changed = false;
        $this->modifiers_changed = false;
        $this->score = 0;

        $this->unitq_initialized = false;
        $this->unitq_village_units = false;
        $this->unitq_changes = false;
        $this->unitq_units = false;

        $this->villageid = false;
        $this->userid = false;

        $this->hero = false;
        $this->hero_stat_changed = false;
        $this->hero_exp_changed = false;
        $this->hero_hpmp_changed = false;
    }

    /*
      This doesn't work with codeigniter, gives a bunch of errors.
      function __destruct()
      {
        $this->write_resources();
      }
    */
    //event
    public function add_event($data)
    {
        if (!isset($data['data1'])) {
            $data['data1'] = 0;
        }
        if (!isset($data['data2'])) {
            $data['data2'] = 0;
        }

        $end = (time() + $data['time']);

        $sql = "INSERT INTO events
			VALUES(default, 
			'" . $data['villageid'] . "',
			'" . $data['slotid'] . "',
			'" . $data['type'] . "',
			'$end',
			'" . $data['data1'] . "',
			'" . $data['data2'] . "')";

        $this->db->query($sql);
    }

    //event end

    //resources
    public function check_resources($res, $data)
    {
        if ($res['food'] >= $data['cost_food'] &&
    $res['wood'] >= $data['cost_wood'] &&
    $res['stone'] >= $data['cost_stone'] &&
    $res['iron'] >= $data['cost_iron'] &&
    $res['mana'] >= $data['cost_mana']) {
            return true;
        }

        return false;
    }

    public function set_resources($res)
    {
        $this->resources = $res;
    }

    //adds modifiers from the building
    public function add_modifiers($id, $villageid, $type = 'building', $num = 1, $noquery = false)
    {
        if (!$this->resources) {
            $this->get_resources($villageid);
        }

        if (!$noquery) {
            if ($type == 'building') {
                $sql = "SELECT * FROM buildings WHERE id='$id'";
            }

            if ($type == 'unit') {
                $sql = "SELECT * FROM units WHERE id='$id'";
            }

            if ($type == 'assignment') {
                $sql = "SELECT * FROM assignments WHERE id='$id'";
            }

            if ($type == 'spell') {
                $sql = "SELECT * FROM spells WHERE id='$id'";
            }

            if ($type == 'technology') {
                $sql = "SELECT * FROM technologies WHERE id='$id'";
            }

            if ($type == 'weather') {
                $sql = "SELECT * FROM weathers WHERE id='$id'";
            }

            $q = $this->db->query($sql);
            $data = $q->row_array();
        } else {
            $data = $id;
        }

        //if everything is 0 don't do anything
        if ($type == 'building' || $type == 'assignment' || $type == 'spell' ||
    $type == 'technology') {
            if (!($data['mod_max_food'] || $data['mod_max_wood'] || $data['mod_max_stone'] ||
        $data['mod_max_iron'] || $data['mod_max_mana'] || $data['mod_rate_food'] ||
        $data['mod_rate_wood'] || $data['mod_rate_stone'] || $data['mod_rate_iron'] ||
        $data['mod_rate_mana'] || $data['mod_percent_food'] || $data['mod_percent_wood'] ||
        $data['mod_percent_stone'] || $data['mod_percent_iron'] || $data['mod_percent_mana'])) {
                return;
            }
        }

        if ($type == 'weather') {
            if (!($data['mod_max_food'] || $data['mod_max_wood'] || $data['mod_max_stone'] ||
        $data['mod_max_iron'] || $data['mod_max_mana'] || $data['mod_percent_food'] ||
        $data['mod_percent_wood'] || $data['mod_percent_stone'] || $data['mod_percent_iron'] ||
        $data['mod_percent_mana'])) {
                return;
            }
        }

        if ($type == 'unit') {
            if (!($data['mod_rate_food'] || $data['mod_rate_wood'] ||
        $data['mod_rate_stone'] || $data['mod_rate_iron'] ||
        $data['mod_rate_mana'])) {
                return;
            }
        }

        //this is sure at this point
        $this->modifiers_changed = true;
        $res = $this->resources;


        if ($type == 'building' || $type == 'assignment' || $type == 'spell' || $type == 'technology') {
            $res['max_food'] += ($data['mod_max_food'] * $num);
            $res['max_wood'] += ($data['mod_max_wood'] * $num);
            $res['max_stone'] += ($data['mod_max_stone'] * $num);
            $res['max_iron'] += ($data['mod_max_iron'] * $num);
            $res['max_mana'] += ($data['mod_max_mana'] * $num);

            $res['rate_nm_food'] += ($data['mod_rate_food'] * $num);
            $res['rate_nm_wood'] += ($data['mod_rate_wood'] * $num);
            $res['rate_nm_stone'] += ($data['mod_rate_stone'] * $num);
            $res['rate_nm_iron'] += ($data['mod_rate_iron'] * $num);
            $res['rate_nm_mana'] += ($data['mod_rate_mana'] * $num);

            $res['percent_food'] += ($data['mod_percent_food'] * $num);
            $res['percent_wood'] += ($data['mod_percent_wood'] * $num);
            $res['percent_stone'] += ($data['mod_percent_stone'] * $num);
            $res['percent_iron'] += ($data['mod_percent_iron'] * $num);
            $res['percent_mana'] += ($data['mod_percent_mana'] * $num);
        }

        if ($type == 'unit') {
            $res['rate_nm_food'] += ($data['mod_rate_food'] * $num);
            $res['rate_nm_wood'] += ($data['mod_rate_wood'] * $num);
            $res['rate_nm_stone'] += ($data['mod_rate_stone'] * $num);
            $res['rate_nm_iron'] += ($data['mod_rate_iron'] * $num);
            $res['rate_nm_mana'] += ($data['mod_rate_mana'] * $num);
        }

        //has to be done this way, because this doesn't have flat rate modifiers
        //so adding it to spells (etc) above could error out
        if ($type == 'weather') {
            $res['max_food'] += ($data['mod_max_food'] * $num);
            $res['max_wood'] += ($data['mod_max_wood'] * $num);
            $res['max_stone'] += ($data['mod_max_stone'] * $num);
            $res['max_iron'] += ($data['mod_max_iron'] * $num);
            $res['max_mana'] += ($data['mod_max_mana'] * $num);

            $res['percent_food'] += ($data['mod_percent_food'] * $num);
            $res['percent_wood'] += ($data['mod_percent_wood'] * $num);
            $res['percent_stone'] += ($data['mod_percent_stone'] * $num);
            $res['percent_iron'] += ($data['mod_percent_iron'] * $num);
            $res['percent_mana'] += ($data['mod_percent_mana'] * $num);
        }

        $res['rate_food'] = ($res['rate_nm_food'] * ($res['percent_food'] / 100));
        $res['rate_wood'] = ($res['rate_nm_wood'] * ($res['percent_wood'] / 100));
        $res['rate_stone'] = ($res['rate_nm_stone'] * ($res['percent_stone'] / 100));
        $res['rate_iron'] = ($res['rate_nm_iron'] * ($res['percent_iron'] / 100));
        $res['rate_mana'] = ($res['rate_nm_mana'] * ($res['percent_mana'] / 100));

        $this->resources = $res;

        //add score
        if ($type == 'building' || $type == 'unit' || $type == 'technology') {
            $this->score += ($data['score'] * $num);
        }
    }

    public function substract_modifiers($id, $villageid, $type = 'building', $num = 1, $noquery = false)
    {
        if (!$this->resources) {
            $this->get_resources($villageid);
        }

        if (!$noquery) {
            if ($type == 'building') {
                $sql = "SELECT * FROM buildings WHERE id='$id'";
            }

            if ($type == 'unit') {
                $sql = "SELECT * FROM units WHERE id='$id'";
            }

            if ($type == 'assignment') {
                $sql = "SELECT * FROM assignments WHERE id='$id'";
            }

            if ($type == 'spell') {
                $sql = "SELECT * FROM spells WHERE id='$id'";
            }

            if ($type == 'technology') {
                $sql = "SELECT * FROM technologies WHERE id='$id'";
            }

            if ($type == 'weather') {
                $sql = "SELECT * FROM weathers WHERE id='$id'";
            }

            $q = $this->db->query($sql);
            $data = $q->row_array();
        } else {
            $data = $id;
        }

        //if everything is 0 don't do anything
        if ($type == 'building' || $type == 'assignment' || $type == 'spell' ||
    $type == 'technology') {
            if (!($data['mod_max_food'] || $data['mod_max_wood'] || $data['mod_max_stone'] ||
        $data['mod_max_iron'] || $data['mod_max_mana'] || $data['mod_rate_food'] ||
        $data['mod_rate_wood'] || $data['mod_rate_stone'] || $data['mod_rate_iron'] ||
        $data['mod_rate_mana'] || $data['mod_percent_food'] || $data['mod_percent_wood'] ||
        $data['mod_percent_stone'] || $data['mod_percent_iron'] || $data['mod_percent_mana'])) {
                return;
            }
        }

        if ($type == 'weather') {
            if (!($data['mod_max_food'] || $data['mod_max_wood'] || $data['mod_max_stone'] ||
        $data['mod_max_iron'] || $data['mod_max_mana'] || $data['mod_percent_food'] ||
        $data['mod_percent_wood'] || $data['mod_percent_stone'] || $data['mod_percent_iron'] ||
        $data['mod_percent_mana'])) {
                return;
            }
        }

        if ($type == 'unit') {
            if (!($data['mod_rate_food'] || $data['mod_rate_wood'] ||
        $data['mod_rate_stone'] || $data['mod_rate_iron'] ||
        $data['mod_rate_mana'])) {
                return;
            }
        }

        //this is sure at this point
        $this->modifiers_changed = true;
        $res = $this->resources;

        if ($type == 'building' || $type == 'assignment' || $type == 'spell' || $type == 'technology') {
            $res['max_food'] -= ($data['mod_max_food'] * $num);
            $res['max_wood'] -= ($data['mod_max_wood'] * $num);
            $res['max_stone'] -= ($data['mod_max_stone'] * $num);
            $res['max_iron'] -= ($data['mod_max_iron'] * $num);
            $res['max_mana'] -= ($data['mod_max_mana'] * $num);

            $res['rate_nm_food'] -= ($data['mod_rate_food'] * $num);
            $res['rate_nm_wood'] -= ($data['mod_rate_wood'] * $num);
            $res['rate_nm_stone'] -= ($data['mod_rate_stone'] * $num);
            $res['rate_nm_iron'] -= ($data['mod_rate_iron'] * $num);
            $res['rate_nm_mana'] -= ($data['mod_rate_mana'] * $num);

            $res['percent_food'] -= ($data['mod_percent_food'] * $num);
            $res['percent_wood'] -= ($data['mod_percent_wood'] * $num);
            $res['percent_stone'] -= ($data['mod_percent_stone'] * $num);
            $res['percent_iron'] -= ($data['mod_percent_iron'] * $num);
            $res['percent_mana'] -= ($data['mod_percent_mana'] * $num);
        }

        if ($type == 'unit') {
            $res['rate_nm_food'] -= ($data['mod_rate_food'] * $num);
            $res['rate_nm_wood'] -= ($data['mod_rate_wood'] * $num);
            $res['rate_nm_stone'] -= ($data['mod_rate_stone'] * $num);
            $res['rate_nm_iron'] -= ($data['mod_rate_iron'] * $num);
            $res['rate_nm_mana'] -= ($data['mod_rate_mana'] * $num);
        }

        //has to be done this way, because this doesn't have flat rate modifiers
        //so adding it to spells (etc) above could error out
        if ($type == 'weather') {
            $res['max_food'] -= ($data['mod_max_food'] * $num);
            $res['max_wood'] -= ($data['mod_max_wood'] * $num);
            $res['max_stone'] -= ($data['mod_max_stone'] * $num);
            $res['max_iron'] -= ($data['mod_max_iron'] * $num);
            $res['max_mana'] -= ($data['mod_max_mana'] * $num);

            $res['percent_food'] -= ($data['mod_percent_food'] * $num);
            $res['percent_wood'] -= ($data['mod_percent_wood'] * $num);
            $res['percent_stone'] -= ($data['mod_percent_stone'] * $num);
            $res['percent_iron'] -= ($data['mod_percent_iron'] * $num);
            $res['percent_mana'] -= ($data['mod_percent_mana'] * $num);
        }

        $res['rate_food'] = ($res['rate_nm_food'] * ($res['percent_food'] / 100));
        $res['rate_wood'] = ($res['rate_nm_wood'] * ($res['percent_wood'] / 100));
        $res['rate_stone'] = ($res['rate_nm_stone'] * ($res['percent_stone'] / 100));
        $res['rate_iron'] = ($res['rate_nm_iron'] * ($res['percent_iron'] / 100));
        $res['rate_mana'] = ($res['rate_nm_mana'] * ($res['percent_mana'] / 100));

        $this->resources = $res;

        //add score
        if ($type == 'building' || $type == 'unit' || $type == 'technology') {
            $this->score -= ($data['score'] * $num);
        }
    }

    //substractes resources, $data has to have cost_* fields!
    public function substract_resources($data, $villageid = 0, $num = 1)
    {
        //can only happen if not called from events, but shouldn't
        if (!$this->resources) {
            $this->get_resources($villageid);
            $this->update_resources();
            //$this->_create_sql_debug('sub_resources got called wo $this->resources!');
        }

        $res = $this->resources;

        $res['food'] -= ($data['cost_food'] * $num);
        $res['wood'] -= ($data['cost_wood'] * $num);
        $res['stone'] -= ($data['cost_stone'] * $num);
        $res['iron'] -= ($data['cost_iron'] * $num);
        $res['mana'] -= ($data['cost_mana'] * $num);

        if ($res['food'] < 0 || $res['wood'] < 0 || $res['stone'] < 0 ||
    $res['iron'] < 0 || $res['mana'] < 0) {
            return false;
        }

        $this->resources = $res;
        $this->resources_changed = true;

        return true;
    }

    /*
      //probably nothing uses it TODO remove
      function set_resources($data, $villageid)
      {
        $sql = "UPDATE resources
            SET food='" . $data['food'] . "',
            wood='" . $data['wood'] . "',
            stone='" . $data['stone'] . "',
            iron='" . $data['iron'] . "',
            mana='" . $data['mana'] . "'
            WHERE villageid='$villageid'";

        $this->db->query($sql);
      }
    */
    //despite the name it updates the resources first, then returns them.
    public function get_resources($vid)
    {
        //to not break existing functionality TODO remove returning
        if ($this->resources) {
            return $this->resources;
        }

        //getting resources
        $sql = "SELECT * FROM resources WHERE villageid='$vid'";
        $q = $this->db->query($sql);

        $this->resources = $q->row_array();

        //to not break existing functions, should be removed
        return $this->resources;
    }

    public function update_resources($time = false)
    {
        if ($time === false) {
            $time = time();
        }

        $res = $this->resources;

        //if already at maximum
        //we still have to update last_time, because it will screw up things.
        if (($res['food'] == $res['max_food']) &&
    ($res['wood'] == $res['max_wood']) &&
    ($res['stone'] == $res['max_stone']) &&
    ($res['iron'] == $res['max_iron']) &&
    ($res['mana'] == $res['max_mana'])) {
            //do not set $this->resources_changed here, so write only updates the time in the db
            $this->resources['last_updated'] = $time;
            return;
        }

        $ticks = ($time - $res['last_updated']);

        //if more than one event end at the same time this could happen
        if (!$ticks) {
            return;
        }

        $res['food'] += ($res['rate_food'] * $ticks);
        $res['wood'] += ($res['rate_wood'] * $ticks);
        $res['stone'] += ($res['rate_stone'] * $ticks);
        $res['iron'] += ($res['rate_iron'] * $ticks);
        $res['mana'] += ($res['rate_mana'] * $ticks);

        //check if over the limit
        if ($res['food'] > $res['max_food']) {
            $res['food'] = $res['max_food'];
        }
        if ($res['wood'] > $res['max_wood']) {
            $res['wood'] = $res['max_wood'];
        }
        if ($res['stone'] > $res['max_stone']) {
            $res['stone'] = $res['max_stone'];
        }
        if ($res['iron'] > $res['max_iron']) {
            $res['iron'] = $res['max_iron'];
        }
        if ($res['mana'] > $res['max_mana']) {
            $res['mana'] = $res['max_mana'];
        }

        $res['last_updated'] = $time;

        //update the db
        $this->resources_changed = true;
        $this->resources = $res;
    }

    public function write_resources()
    {
        //we only have to update last_time
        if (!$this->resources_changed && !$this->modifiers_changed) {
            $time = time();
            $sql = "UPDATE resources 
		SET last_updated='" . $this->resources['last_updated'] . "'
		WHERE villageid='" . $this->resources['villageid'] . "'";

            $this->db->query($sql);

            return;
        }

        $res = $this->resources;

        if ($this->modifiers_changed) {
            $sql = "UPDATE resources 
		SET food='" . $res['food'] . "',
		wood='" . $res['wood'] . "',
		stone='" . $res['stone'] . "',
		iron='" . $res['iron'] . "',
		mana='" . $res['mana'] . "',
		last_updated='" . $res['last_updated'] . "',
		max_food = '" . $res['max_food'] . "',
		max_wood = '" . $res['max_wood'] . "',
		max_stone = '" . $res['max_stone'] . "',
		max_iron = '" . $res['max_iron'] . "',
		max_mana = '" . $res['max_mana'] . "',
		rate_nm_food = '" . $res['rate_nm_food'] . "',
		rate_nm_wood = '" . $res['rate_nm_wood'] . "',
		rate_nm_stone = '" . $res['rate_nm_stone'] . "',
		rate_nm_iron = '" . $res['rate_nm_iron'] . "',
		rate_nm_mana = '" . $res['rate_nm_mana'] . "',
		rate_food = '" . $res['rate_food'] . "',
		rate_wood = '" . $res['rate_wood'] . "',
		rate_stone = '" . $res['rate_stone'] . "',
		rate_iron = '" . $res['rate_iron'] . "',
		rate_mana = '" . $res['rate_mana'] . "',
		percent_food = '" . $res['percent_food'] . "',
		percent_wood = '" . $res['percent_wood'] . "',
		percent_stone = '" . $res['percent_stone'] . "',
		percent_iron = '" . $res['percent_iron'] . "',
		percent_mana = '" . $res['percent_mana'] . "'
		WHERE villageid='" . $res['villageid'] . "'";

            $this->db->query($sql);
        }

        if ($this->resources_changed && !$this->modifiers_changed) {
            //update the db
            $sql = "UPDATE resources
		SET food='" . $res['food'] . "',
		wood='" . $res['wood'] . "',
		stone='" . $res['stone'] . "',
		iron='" . $res['iron'] . "',
		mana='" . $res['mana'] . "',
		last_updated='" . $res['last_updated'] . "'
		WHERE villageid='" . $res['villageid'] . "'";

            $this->db->query($sql);
        }

        if ($this->score) {
            $sql = "UPDATE villages 
		SET score = score + '" . $this->score . "'
		WHERE id='" . $this->resources['villageid'] . "'";

            $this->db->query($sql);
        }
    }

    //resources end

    //unit functions

    //Resource system have to be initialized!

    public function unitq_initialize($villageid, $userid = false, $data = false)
    {
        if ($this->unitq_initialized) {
            return;
        }

        $this->villageid = $villageid;

        //if we don't know it query it
        if (!$userid) {
            $sql = "SELECT userid FROM villages WHERE id='$villageid'";

            $q = $this->db->query($sql);

            $res = $q->row_array();

            $this->userid = $res['userid'];
        } else {
            $this->userid = $userid;
        }

        //if we had to query units for some reason don't query it again
        if (!$data) {
            $sql = "SELECT * FROM village_units WHERE villageid='$villageid'";

            $q = $this->db->query($sql);

            $this->unitq_village_units = $q->result_array();
        } else {
            $this->unitq_village_units = $q->result_array();
        }

        //getting unitdata
        $sql = "SELECT * FROM units";

        $q = $this->db->query($sql);

        $this->unitq_units = $q->result_array();

        $this->unitq_initialized = true;
    }

    public function unitq_change($action, $unitid, $num, $nomod = false)
    {
        if (!$this->unitq_initialized) {
            return;
        }

        //getting unitdata
        foreach ($this->unitq_units as $row) {
            if ($row['id'] == $unitid) {
                $unitd = $row;
                break;
            }
        }

        //error
        if (!$unitd) {
            return;
        }

        $index = false;

        //finding if that type of unit is in the village
        if ($this->unitq_village_units) {
            for ($i = 0; $i < sizeof($this->unitq_village_units); $i++) {
                if ($this->unitq_village_units[$i]['unitid'] == $unitid) {
                    $index = $i;
                    break;
                }
            }
        }

        $data['id'] = $unitid;

        if ($action == '+') {
            if ($index !== false) {
                $data['unitcount'] = ($this->unitq_village_units[$index]['unitcount'] + $num);
            } else {
                $data['unitcount'] = $num;
            }

            if (!$nomod) {
                $this->substract_modifiers($unitd, $this->villageid, 'unit', $num, true);
            }
        }

        if ($action == '-') {
            //this expression doesn't have any mean if we don't have that type of unit
            if ($index !== false) {
                $data['unitcount'] = ($this->unitq_village_units[$index]['unitcount'] - $num);

                if ($data['unitcount'] < 0) {
                    //adding -1 means substracting it
                    $num += $data['unitcount'];
                    $data['unitcount'] = 0;
                }

                if (!$nomod) {
                    $this->add_modifiers($unitd, $this->villageid, 'unit', $num, true);
                }
            }
        }

        if ($action == '+-') {
            if ($index !== false) {
                $data['unitcount'] = ($this->unitq_village_units[$index]['unitcount'] + $num);
            } else {
                $data['unitcount'] = $num;
            }

            if ($num > 0) {
                if (!$nomod) {
                    $this->substract_modifiers($unitd, $this->villageid, 'unit', $num, true);
                }
            } else {
                if (!$nomod) {
                    $this->add_modifiers($unitd, $this->villageid, 'unit', $num, true);
                }
            }
        }

        if ($action == '=') {
            if ($index !== false) {
                $data['unitcount'] = $num;
            }

            $number = $this->unitq_village_units[$index]['unitcount'] - $num;

            if ($num > 0) {
                if (!$nomod) {
                    $this->add_modifiers($unitd, $this->villageid, 'unit', $num, true);
                }
            } else {
                if (!$nomod) {
                    $this->substract_modifiers($unitd, $this->villageid, 'unit', $num, true);
                }
            }
        }

        //error
        if (!isset($data['unitcount'])) {
            return;
        }

        $indexc = false;

        //finding the index which contains our unit
        if ($this->unitq_changes) {
            for ($i = 0; $i < sizeof($this->unitq_changes); $i++) {
                if ($this->unitq_changes[$i]['id'] == $unitid) {
                    $indexc = $i;
                    break;
                }
            }
        }

        if ($indexc !== false) {
            $this->unitq_changes[$indexc]['unitcount'] = $data['unitcount'];
        } else {
            $this->unitq_changes[] = array('id' => $data['id'], 'unitcount' => $data['unitcount']);
        }
    }

    public function unitq_get_units()
    {
        return $this->unitq_units;
    }
  
    public function unitq_get_village_units()
    {
        $data = $this->unitq_village_units;

        if ($this->unitq_changes) {
            foreach ($this->unitq_changes as $row) {
                for ($i = 0; $i < sizeof($data); $i++) {
                    if ($row['id'] == $data[$i]['unitid']) {
                        $data[$i]['unitcount'] = $row['unitcount'];
                    }
                }
            }
        }

        return $data;
    }

    //write changes to db
    public function unitq_write()
    {
        if (!$this->unitq_initialized) {
            return;
        }

        if (!$this->unitq_changes) {
            return;
        }

        foreach ($this->unitq_changes as $row) {
            $vu = false;

            //searching for village_units's row
            foreach ($this->unitq_village_units as $vurow) {
                if ($row['id'] == $vurow['unitid']) {
                    $vu = $vurow;
                    break;
                }
            }

            //its <= just in case
            //nothing to do here
            if (!$vu && $row['unitcount'] <= 0) {
                continue;
            }

            //nothing to do here
            if ($vu) {
                if ($row['unitcount'] == $vu['unitcount']) {
                    continue;
                }
            }

            //DELETING row
            if ($vu && $row['unitcount'] <= 0) {
                $sql = "DELETE FROM village_units WHERE id='" . $vu['id'] . "'";
                $this->db->query($sql);
                continue;
            }

            //other cases handled at this point, we only need to check for vu
            if ($vu) {
                $sql = "UPDATE village_units
		SET unitcount='" . $row['unitcount'] . "'
		WHERE id='" . $vu['id'] . "'";
            } else {
                $sql = "INSERT INTO village_units
		VALUES(default, '" . $this->userid . "', '" . $this->villageid . "', 
		'" . $row['id'] . "', '" . $row['unitcount'] . "')";
            }

            $this->db->query($sql);
        }
    }

    //unit functions end

    //building
    public function get_slot_building($slotid, $villageid)
    {
        $sql = "SELECT buildings.* FROM village_buildings 
		INNER JOIN buildings ON village_buildings.buildingid=buildings.id 
		WHERE village_buildings.villageid='$villageid' 
		AND village_buildings.slotid='$slotid'";
        $q = $this->db->query($sql);

        if ($q->num_rows()) {
            return $q->row_array();
        }

        $sql = "SELECT * FROM buildings WHERE id='1'";
        $q = $this->db->query($sql);

        return $q->row_array();
    }
    //building end

    //technologies
    public function add_technology($techid, $group, $tech, $slotid, $villageid)
    {
        //group == 0 primary, group == 1 secondary
        if (!$group) {
            $sql = "INSERT INTO village_technologies
		VALUES(default, '$villageid', '0', '$techid')";
        } else {
            $sql = "INSERT INTO village_technologies
		VALUES(default, '$villageid', '$slotid', '$techid')";
        }

        $this->db->query($sql);

        if ($tech['flag_ai']) {
            $sql = "UPDATE villages SET ai_flagged='1' WHERE id='$villageid'";

            $this->db->query($sql);
        }
    }

    public function get_village_technologies($villageid, $slotid = 0)
    {
        if ($slotid) {
            $sql = "SELECT * FROM village_technologies 
		WHERE villageid='$villageid'
		AND (slotid='0' OR slotid='$slotid')";
        } else {
            $sql = "SELECT * FROM village_technologies
		WHERE villageid='$villageid'
		AND slotid='0'";
        }

        $q = $this->db->query($sql);

        return $q->result_array();
    }

    //data is tecnology data
    public function have_technology($data, $techid)
    {
        if (!$techid) {
            return true;
        }

        foreach ($data as $row) {
            if ($row['technologyid'] == $techid) {
                return true;
            }
        }

        return false;
    }

    public function has_req_tech($techid, $villageid, $slotid = 0)
    {
        if (!$techid) {
            return true;
        }

        $tech = $this->get_village_technologies($villageid, $slotid);

        foreach ($tech as $row) {
            if ($row['technologyid'] == $techid) {
                return true;
            }
        }

        return false;
    }

    //technologies end

    //combat log
    public function add_combat_log($log, $villageid)
    {
        $sql = "INSERT INTO combat_logs
		VALUES(default, '$villageid', '" . time() . "', '1', '$log')";

        $this->db->query($sql);

        $sql = "UPDATE villages SET new_log='1' WHERE id='$villageid'";
    
        $this->db->query($sql);
    }

    //combat log end

    //Hero Functions

    //set hero
    public function set_hero($data)
    {
        $this->hero = $data;
    }

    //to be used with controllers after like equipping, and stat recalculations, combat etc
    public function get_hero()
    {
        return $this->hero;
    }

    //Hero db update function
    public function hero_write()
    {
        //if more than on flag set unset the not needed ones
        if ($this->hero_stat_changed) {
            $this->hero_hpmp_changed = false;
            $this->hero_exp_changed = false;
        } elseif ($this->hero_exp_changed) {
            $this->hero_hpmp_changed = false;
        }

        if ($this->hero_stat_changed) {
            $d = $this->hero;

            $sql = "UPDATE heroes
		SET level = '" . $d['level'] . "',
		experience = '" . $d['experience'] . "',
		health = '" . $d['health'] . "',
		mana = '" . $d['mana'] . "',
		max_health = '" . $d['max_health'] . "',
		max_mana = '" . $d['max_mana'] . "',
		percent_max_health = '" . $d['percent_max_health'] . "',
		percent_max_mana = '" . $d['percent_max_mana'] . "',
		nomod_max_health = '" . $d['nomod_max_health'] . "',
		nomod_max_mana = '" . $d['nomod_max_mana'] . "',
		points = '" . $d['points'] . "',
		agility = '" . $d['agility'] . "',
		strength = '" . $d['strength'] . "',
		stamina = '" . $d['stamina'] . "',
		intellect = '" . $d['intellect'] . "',
		spirit = '" . $d['spirit'] . "',
		percent_agility = '" . $d['percent_agility'] . "',
		percent_strength = '" . $d['percent_strength'] . "',
		percent_stamina = '" . $d['percent_stamina'] . "',
		percent_intellect = '" . $d['percent_intellect'] . "',
		percent_spirit = '" . $d['percent_spirit'] . "',
		nomod_agility = '" . $d['nomod_agility'] . "',
		nomod_strength = '" . $d['nomod_strength'] . "',
		nomod_stamina = '" . $d['nomod_stamina'] . "',
		nomod_intellect = '" . $d['nomod_intellect'] . "',
		nomod_spirit = '" . $d['nomod_spirit'] . "',
		points_agility = '" . $d['points_agility'] . "',
		points_strength = '" . $d['points_strength'] . "',
		points_stamina = '" . $d['points_stamina'] . "',
		points_intellect = '" . $d['points_intellect'] . "',
		points_spirit = '" . $d['points_spirit'] . "',		
		attackpower = '" . $d['attackpower'] . "',
		percent_attackpower = '" . $d['percent_attackpower'] . "',
		nomod_attackpower = '" . $d['nomod_attackpower'] . "',
		armor = '" . $d['armor'] . "',
		percent_armor = '" . $d['percent_armor'] . "',
		nomod_armor = '" . $d['nomod_armor'] . "',
		dodge = '" . $d['dodge'] . "',
		nomod_dodge = '" . $d['nomod_dodge'] . "',
		parry = '" . $d['parry'] . "',
		nomod_parry = '" . $d['nomod_parry'] . "',		
		hit = '" . $d['hit'] . "',
		crit = '" . $d['crit'] . "',
		nomod_crit = '" . $d['nomod_crit'] . "',
		damage_min = '" . $d['damage_min'] . "',
		damage_max = '" . $d['damage_max'] . "',
		percent_damage_min = '" . $d['percent_damage_min'] . "',
		percent_damage_max = '" . $d['percent_damage_max'] . "',
		nomod_damage_min = '" . $d['nomod_damage_min'] . "',
		nomod_damage_max = '" . $d['nomod_damage_max'] . "',
		ranged_damage_min = '" . $d['ranged_damage_min'] . "',
		ranged_damage_max = '" . $d['ranged_damage_max'] . "',
		percent_ranged_damage_min = '" . $d['percent_ranged_damage_min'] . "',
		percent_ranged_damage_max = '" . $d['percent_ranged_damage_max'] . "',
		nomod_ranged_damage_min = '" . $d['nomod_ranged_damage_min'] . "',
		nomod_ranged_damage_max = '" . $d['nomod_ranged_damage_max'] . "',
		heal_min = '" . $d['heal_min'] . "',
		heal_max = '" . $d['heal_max'] . "',
		percent_heal_min = '" . $d['percent_heal_min'] . "',
		percent_heal_max = '" . $d['percent_heal_max'] . "',
		nomod_heal_min = '" . $d['nomod_heal_min'] . "',
		nomod_heal_max = '" . $d['nomod_heal_max'] . "',
		life_leech = '" . $d['life_leech'] . "',
		mana_leech = '" . $d['mana_leech'] . "'
		WHERE id = '" . $d['id'] . "'";

            $this->db->query($sql);

            return true;
        }

        //exp, hp, mp
        if ($this->hero_exp_changed) {
            $d = $this->hero;

            $sql = "UPDATE heroes
		SET health='" . $d['health'] . "', 
		mana='" . $d['mana'] . "', 
		experience='" . $d['experience'] . "'
		WHERE id = '" . $d['id'] . "'";

            $this->db->query($sql);

            return true;
        }

        if ($this->hero_hpmp_changed) {
            $d = $this->hero;

            $sql = "UPDATE heroes
		SET health='" . $d['health'] . "', 
		mana='" . $d['mana'] . "', 
		WHERE id = '" . $d['id'] . "'";

            $this->db->query($sql);

            return true;
        }

        return false;
    }

    //Hero stat calc functions

    //thins calculates every char stats (like when equipping)
    public function calc_hero_stats()
    {
        $d = $this->hero;
        $c = $this->hero['class'];

        //base stats
        $d['agility'] = floor(($d['nomod_agility'] / 100) * $d['percent_agility']);
        $d['strength'] = floor(($d['nomod_strength'] / 100) * $d['percent_strength']);
        $d['stamina'] = floor(($d['nomod_stamina'] / 100) * $d['percent_stamina']);
        $d['intellect'] = floor(($d['nomod_intellect'] / 100) * $d['percent_intellect']);
        $d['spirit'] = floor(($d['nomod_spirit'] / 100) * $d['percent_spirit']);

        //health, mana
        $d['max_health'] = $this->hero_stat($c, 'max_health', $d);
        $d['max_mana'] = $this->hero_stat($c, 'max_mana', $d);

        $d['max_health'] = floor(($d['max_health'] / 100) * $d['percent_max_health']);
        $d['max_mana'] = floor(($d['max_mana'] / 100) * $d['percent_max_mana']);
    
        $d['health'] = $d['max_health'];
        $d['mana'] = $d['max_mana'];
    
        //ap
        $d['attackpower'] = $this->hero_stat($c, 'attackpower', $d);
        $d['attackpower'] = floor(($d['attackpower'] / 100) * $d['percent_attackpower']);

        //% stats
        $d['dodge'] = $this->hero_stat($c, 'dodge', $d);
        $d['parry'] = $this->hero_stat($c, 'parry', $d);
        $d['crit'] = $this->hero_stat($c, 'crit', $d);

        //damage
        $d['damage_min'] = $this->hero_stat($c, 'damage_min', $d);
        $d['damage_min'] = floor(($d['damage_min'] / 100) * $d['percent_damage_min']);
        $d['damage_max'] = $this->hero_stat($c, 'damage_max', $d);
        $d['damage_max'] = floor(($d['damage_max'] / 100) * $d['percent_damage_max']);

        //ranged damage
        $d['ranged_damage_min'] = $this->hero_stat($c, 'ranged_damage_min', $d);
        $d['ranged_damage_min'] = floor(($d['ranged_damage_min'] / 100) * $d['percent_ranged_damage_min']);
        $d['ranged_damage_max'] = $this->hero_stat($c, 'ranged_damage_max', $d);
        $d['ranged_damage_max'] = floor(($d['ranged_damage_max'] / 100) * $d['percent_ranged_damage_max']);

        //heal
        $d['heal_min'] = $this->hero_stat($c, 'heal_min', $d);
        $d['heal_min'] = floor(($d['heal_min'] / 100) * $d['percent_heal_min']);
        $d['heal_max'] = $this->hero_stat($c, 'heal_max', $d);
        $d['heal_max'] = floor(($d['heal_max'] / 100) * $d['percent_heal_max']);

        //armor
        $d['armor'] = floor(($d['nomod_armor'] / 100) * $d['percent_armor']);

        $this->hero = $d;
        $this->hero_stat_changed = true;

        $this->hero_write();
    }

    //the function which has all the class formulas
    //class can be string or id
    public function hero_stat($class, $type, $data = false)
    {
        if (!$data) {
            $data = $this->hero;
        }

        if ($class == 1 || $class == 'Warrior') {
            if ($type == 'attackpower') {
                $ATTACKPOWER_BASE = 0;
                $ATTACKPOWER_FACTOR_STR = 20;
                $ATTACKPOWER_FACTOR_AGI = 10;

                $c = $ATTACKPOWER_BASE;
                $c += ($data['strength'] * $ATTACKPOWER_FACTOR_STR);
                $c += ($data['agility'] * $ATTACKPOWER_FACTOR_AGI);
                $c += $data['nomod_attackpower'];
            } elseif ($type == 'crit') {
                $CRIT_BASE = 0;
                //how much of these stats give 1% crit
                $CRIT_FACTOR_AGI = 40;
                $CRIT_FACTOR_STR = 30;
                $CRIT_FACTOR_INT = 60;

                $c = $CRIT_BASE;
                $c += ($data['agility'] / $CRIT_FACTOR_AGI);
                $c += ($data['strength'] / $CRIT_FACTOR_STR);
                $c += ($data['intellect'] / $CRIT_FACTOR_INT);
                $c += $data['nomod_crit'];
            }
        } elseif ($class == 2 || $class == 'Rogue') {
            if ($type == 'attackpower') {
                $ATTACKPOWER_BASE = 0;
                $ATTACKPOWER_FACTOR_STR = 5;
                $ATTACKPOWER_FACTOR_AGI = 25;

                $c = $ATTACKPOWER_BASE;
                $c += ($data['strength'] * $ATTACKPOWER_FACTOR_STR);
                $c += ($data['agility'] * $ATTACKPOWER_FACTOR_AGI);
                $c += $data['nomod_attackpower'];
            } elseif ($type == 'crit') {
                $CRIT_BASE = 0;
                //how much of these stats give 1% crit
                $CRIT_FACTOR_AGI = 25;
                $CRIT_FACTOR_STR = 50;
                $CRIT_FACTOR_INT = 60;

                $c = $CRIT_BASE;
                $c += ($data['agility'] / $CRIT_FACTOR_AGI);
                $c += ($data['strength'] / $CRIT_FACTOR_STR);
                $c += ($data['intellect'] / $CRIT_FACTOR_INT);
                $c += $data['nomod_crit'];
            }
        } elseif ($class == 3 || $class == 'Archer') {
            if ($type == 'attackpower') {
                $ATTACKPOWER_BASE = 0;
                $ATTACKPOWER_FACTOR_STR = 10;
                $ATTACKPOWER_FACTOR_AGI = 20;

                $c = $ATTACKPOWER_BASE;
                $c += ($data['strength'] * $ATTACKPOWER_FACTOR_STR);
                $c += ($data['agility'] * $ATTACKPOWER_FACTOR_AGI);
                $c += $data['nomod_attackpower'];
            } elseif ($type == 'crit') {
                $CRIT_BASE = 0;
                //how much of these stats give 1% crit
                $CRIT_FACTOR_AGI = 30;
                $CRIT_FACTOR_STR = 60;
                $CRIT_FACTOR_INT = 40;

                $c = $CRIT_BASE;
                $c += ($data['agility'] / $CRIT_FACTOR_AGI);
                $c += ($data['strength'] / $CRIT_FACTOR_STR);
                $c += ($data['intellect'] / $CRIT_FACTOR_INT);
                $c += $data['nomod_crit'];
            }
        }

        if ($type == 'max_health') {
            $HEALTH_FACTOR = 10;

            $c = $data['stamina'] * $HEALTH_FACTOR;
            $c += $data['nomod_max_health'];
        } elseif ($type == 'max_mana') {
            $MANA_FACTOR = 10;

            $c = $data['intellect'] * $MANA_FACTOR;
            $c += $data['nomod_max_mana'];
        } elseif ($type == 'dodge') {
            $DODGE_BASE = 0;
            //how much agi gives 1% dodge
            $DODGE_FACTOR_AGI = 30;

            $c = $DODGE_BASE;
            $c += ($data['agility'] / $DODGE_FACTOR_AGI);
            $c += $data['nomod_dodge'];
        } elseif ($type == 'parry') {
            $PARRY_BASE = 0;
            //how much str gives 1% parry
            $PARRY_FACTOR_STR = 30;

            $c = $PARRY_BASE;
            $c += ($data['strength'] / $PARRY_FACTOR_STR);
            $c += $data['nomod_parry'];
        } elseif ($type == 'damage_min') {
            $DAMAGE_BASE = 0;
            //how much ap gives 1 dmg increase
            $DAMAGE_FACTOR = 100;

            $c = $DAMAGE_BASE;
            $c += floor($data['attackpower'] / $DAMAGE_FACTOR);
            $c += $data['nomod_damage_min'];
        } elseif ($type == 'damage_max') {
            $DAMAGE_BASE = 0;
            //how much ap gives 1 dmg increase
            $DAMAGE_FACTOR = 100;

            $c = $DAMAGE_BASE;
            $c += floor($data['attackpower'] / $DAMAGE_FACTOR);
            $c += $data['nomod_damage_max'];
        } elseif ($type == 'ranged_damage_min') {
            $DAMAGE_BASE = 0;
            //how much ap gives 1 dmg increase
            $DAMAGE_FACTOR = 100;

            $c = $DAMAGE_BASE;
            $c += floor($data['attackpower'] / $DAMAGE_FACTOR);
            $c += $data['nomod_ranged_damage_min'];
        } elseif ($type == 'ranged_damage_max') {
            $DAMAGE_BASE = 0;
            //how much ap gives 1 dmg increase
            $DAMAGE_FACTOR = 100;

            $c = $DAMAGE_BASE;
            $c += floor($data['attackpower'] / $DAMAGE_FACTOR);
            $c += $data['nomod_ranged_damage_max'];
        } elseif ($type == 'heal_min') {
            $c = 0;
        } elseif ($type == 'heal_max') {
            $c = 0;
        }

        if (isset($c)) {
            return $c;
        }

        return false;
    }

    public function hero_add_stats($data)
    {
        $d = $this->hero;

        if (isset($data['level_modifier'])) {
            $lvlmax = $data['level_modifier_max'];

            //this means no limit
            if (!$lvlmax) {
                $lvlmax = $this->hero['level'];
            }

            if ($lvlmax < $this->hero['level']) {
                $lvlmod = $lvlmax;
            } else {
                $lvlmod = $this->hero['level'];
            }

            $lvlmod *= $data['level_modifier'];
        } else {
            $lvlmod = 0;
        }

        $d['percent_max_health'] += $data['percent_max_health'];
        $d['percent_max_mana'] += $data['percent_max_mana'];

        $d['nomod_max_health'] += $data['nomod_max_health'];
        $d['nomod_max_mana'] += $data['nomod_max_mana'];

        $d['percent_agility'] += $data['percent_agility'];
        $d['percent_strength'] += $data['percent_strength'];
        $d['percent_stamina'] += $data['percent_stamina'];
        $d['percent_intellect'] += $data['percent_intellect'];
        $d['percent_spirit'] += $data['percent_spirit'];

        $d['nomod_agility'] += $data['nomod_agility'] + $lvlmod;
        $d['nomod_strength'] += $data['nomod_strength'] + $lvlmod;
        $d['nomod_stamina'] += $data['nomod_stamina'] + $lvlmod;
        $d['nomod_intellect'] += $data['nomod_intellect'] + $lvlmod;
        $d['nomod_spirit'] += $data['nomod_spirit'] + $lvlmod;

        $d['percent_attackpower'] += $data['percent_attackpower'];
        $d['nomod_attackpower'] += $data['nomod_attackpower'];

        $d['percent_armor'] += $data['percent_armor'];
        $d['nomod_armor'] += $data['nomod_armor'];

        $d['nomod_dodge'] += $data['nomod_dodge'];
        $d['nomod_parry'] += $data['nomod_parry'];
        $d['hit'] += $data['hit'];
        $d['nomod_crit'] += $data['nomod_crit'];

        $d['percent_damage_min'] += $data['percent_damage_min'];
        $d['percent_damage_max'] += $data['percent_damage_max'];
        $d['nomod_damage_min'] += $data['nomod_damage_min'];
        $d['nomod_damage_max'] += $data['nomod_damage_max'];

        $d['percent_ranged_damage_min'] += $data['percent_ranged_damage_min'];
        $d['percent_ranged_damage_max'] += $data['percent_ranged_damage_max'];
        $d['nomod_ranged_damage_min'] += $data['nomod_ranged_damage_min'];
        $d['nomod_ranged_damage_max'] += $data['nomod_ranged_damage_max'];

        $d['percent_heal_min'] += $data['percent_heal_min'];
        $d['percent_heal_max'] += $data['percent_heal_max'];

        $d['nomod_heal_min'] += $data['nomod_heal_min'];
        $d['nomod_heal_max'] += $data['nomod_heal_max'];

        $d['life_leech'] += $data['life_leech'];
        $d['mana_leech'] += $data['mana_leech'];

        $this->hero = $d;
    }

    public function hero_remove_stats($data)
    {
        $d = $this->hero;

        if (isset($data['level_modifier'])) {
            $lvlmax = $data['level_modifier_max'];

            //this means no limit
            if (!$lvlmax) {
                $lvlmax = $this->hero['level'];
            }

            if ($lvlmax < $this->hero['level']) {
                $lvlmod = $lvlmax;
            } else {
                $lvlmod = $this->hero['level'];
            }

            $lvlmod *= $data['level_modifier'];
        } else {
            $lvlmod = 0;
        }

        $d['percent_max_health'] -= $data['percent_max_health'];
        $d['percent_max_mana'] -= $data['percent_max_mana'];

        $d['nomod_max_health'] -= $data['nomod_max_health'];
        $d['nomod_max_mana'] -= $data['nomod_max_mana'];

        $d['percent_agility'] -= $data['percent_agility'];
        $d['percent_strength'] -= $data['percent_strength'];
        $d['percent_stamina'] -= $data['percent_stamina'];
        $d['percent_intellect'] -= $data['percent_intellect'];
        $d['percent_spirit'] -= $data['percent_spirit'];

        $d['nomod_agility'] -= $data['nomod_agility'] + $lvlmod;
        $d['nomod_strength'] -= $data['nomod_strength'] + $lvlmod;
        $d['nomod_stamina'] -= $data['nomod_stamina'] + $lvlmod;
        $d['nomod_intellect'] -= $data['nomod_intellect'] + $lvlmod;
        $d['nomod_spirit'] -= $data['nomod_spirit'] + $lvlmod;

        $d['percent_attackpower'] -= $data['percent_attackpower'];
        $d['nomod_attackpower'] -= $data['nomod_attackpower'];

        $d['percent_armor'] -= $data['percent_armor'];
        $d['nomod_armor'] -= $data['nomod_armor'];

        $d['nomod_dodge'] -= $data['nomod_dodge'];
        $d['nomod_parry'] -= $data['nomod_parry'];
        $d['hit'] -= $data['hit'];
        $d['nomod_crit'] -= $data['nomod_crit'];

        $d['percent_damage_min'] -= $data['percent_damage_min'];
        $d['percent_damage_max'] -= $data['percent_damage_max'];
        $d['nomod_damage_min'] -= $data['nomod_damage_min'];
        $d['nomod_damage_max'] -= $data['nomod_damage_max'];

        $d['percent_ranged_damage_min'] -= $data['percent_ranged_damage_min'];
        $d['percent_ranged_damage_max'] -= $data['percent_ranged_damage_max'];
        $d['nomod_ranged_damage_min'] -= $data['nomod_ranged_damage_min'];
        $d['nomod_ranged_damage_max'] -= $data['nomod_ranged_damage_max'];

        $d['percent_heal_min'] -= $data['percent_heal_min'];
        $d['percent_heal_max'] -= $data['percent_heal_max'];
        $d['nomod_heal_min'] -= $data['nomod_heal_min'];
        $d['nomod_heal_max'] -= $data['nomod_heal_max'];

        $d['life_leech'] -= $data['life_leech'];
        $d['mana_leech'] -= $data['mana_leech'];

        $this->hero = $d;
    }

    //Hero stat calc functions end

    public function hero_find_empty_bagspace($data, $key = 'id')
    {
        if (!$data) {
            return 0;
        }

        $found = false;
        for ($i = 0; $i < self::INVENTORY_MAX; $i++) {
            foreach ($data as $row) {
                if ($row[$key] == $i) {
                    $found = true;
                    break;
                }
            }

            if ($found) {
                $found = false;
            } else {
                return $i;
            }
        }

        return false;
    }

    //Hero Functions end

    //admin sql functions
    public function _create_sql($sql)
    {
        $this->load->helper('file');

        $time = time();

        $file = './sql/' .$time . '.sql';

        write_file($file, $sql);

        $this->_update_db_version($time);
    }

    public function _update_db_version($time)
    {
        $sql = "UPDATE db_version SET version='$time' WHERE id='1'";

        $this->db->query($sql);
    }

    public function _create_sql_debug($sql)
    {
        $this->load->helper('file');

        $time = time();

        $file = './sql/debug_' .$time . '.sql';

        write_file($file, $sql);
    }

    //admin sql functions end
}
//nowhitesp
