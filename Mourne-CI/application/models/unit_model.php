<?php
class Unit_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_village_units($villageid)
    {
        $sql = "SELECT users.username,units.*,village_units.userid,village_units.unitcount
			FROM village_units
			LEFT JOIN users ON village_units.userid=users.id
			LEFT JOIN units ON village_units.unitid=units.id
			WHERE villageid='$villageid'";

        $q = $this->db->query($sql);

        //TODO order it!

        return $q->result_array();
    }

    public function get_unit($id)
    {
        $sql = "SELECT * FROM units WHERE id='$id'";
        $q = $this->db->query($sql);

        return $q->row_array();
    }

    //calculates how many units can be created (by lookin at events)
    //nothing gets queried
    public function calc_max_unit_ev($unit_max, $unit_res, $event)
    {
        $in_progress = 0;

        if ($event) {
            foreach ($event as $row) {
                $in_progress += $row['data2'];
            }
        }

        //if more are in progress that the building can make
        if ($in_progress >= $unit_max) {
            return 0;
        }

        //calc how many can be made overall
        $max = $unit_max - $in_progress;

        //if less can be made because of events than the resources allow
        if ($max <= $unit_res) {
            return $max;
        }

        //if events allow more than resources
        if ($max > $unit_res) {
            return $unit_res;
        }

        return $max;
    }

    public function list_create_mod_drop_admin()
    {
        //STUB
        return array('0' => 'Nothing');
    }

    public function list_units_admin()
    {
        $sql = "SELECT * FROM units";
        $q = $this->db->query($sql);

        return $q->result_array();
    }

    public function get_unit_list_dropdown_admin()
    {
        $sql = "SELECT * FROM units";
        $q = $this->db->query($sql);

        $res = $q->result_array();

        $data[0] = 'Nothing';


        foreach ($res as $row) {
            $data[$row['id']] = $row['name'];
        }

        return $data;
    }

    public function add_unit_admin($data)
    {
        $sql = "INSERT INTO units 
			VALUES(default,
			'" . $data['type'] . "',
			'" . $data['name'] . "',
			'" . $data['icon'] . "',
			'" . $data['score'] . "',
			'" . $data['can_defend'] . "',
			'" . $data['defense'] . "',
			'" . $data['attack'] . "',
			'" . $data['weak_against'] . "',
			'" . $data['strong_against'] . "',
			'" . $data['turn'] . "',
			'" . $data['ability'] . "',
			'" . $data['time_to_create'] . "',
			'" . $data['cost_unit'] . "',
			'" . $data['cost_num_unit'] . "',
			'" . $data['cost_food'] . "',
			'" . $data['cost_wood'] . "',
			'" . $data['cost_stone'] . "',
			'" . $data['cost_iron'] . "',
			'" . $data['cost_mana'] . "',
			'" . $data['mod_rate_food'] . "',
			'" . $data['mod_rate_wood'] . "',
			'" . $data['mod_rate_stone'] . "',
			'" . $data['mod_rate_iron'] . "',
			'" . $data['mod_rate_mana'] . "')";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function get_unit_admin($id)
    {
        $sql = "SELECT * FROM units WHERE id='$id'";
        $q = $this->db->query($sql);

        return $q->row_array();
    }

    public function edit_unit_admin($data)
    {
        $sql = "UPDATE units 
			SET type='" . $data['type'] . "',
			name='" . $data['name'] . "',
			icon='" . $data['icon'] . "',
			score='" . $data['score'] . "',
			can_defend='" . $data['can_defend'] . "',
			defense='" . $data['defense'] . "',
			attack='" . $data['attack'] . "',
			weak_against='" . $data['weak_against'] . "',
			strong_against='" . $data['strong_against'] . "',
			turn='" . $data['turn'] . "',
			ability='" . $data['ability'] . "',
			time_to_create='" . $data['time_to_create'] . "',
			cost_unit='" . $data['cost_unit'] . "',
			cost_num_unit='" . $data['cost_num_unit'] . "',
			cost_food='" . $data['cost_food'] . "',
			cost_wood='" . $data['cost_wood'] . "',
			cost_stone='" . $data['cost_stone'] . "',
			cost_iron='" . $data['cost_iron'] . "',
			cost_mana='" . $data['cost_mana'] . "',
			mod_rate_food='" . $data['mod_rate_food'] . "',
			mod_rate_wood='" . $data['mod_rate_wood'] . "',
			mod_rate_stone='" . $data['mod_rate_stone'] . "',
			mod_rate_iron='" . $data['mod_rate_iron'] . "',
			mod_rate_mana='" . $data['mod_rate_mana'] . "'
			WHERE id='" . $data['id'] . "'";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }
}
//nowhitesp
