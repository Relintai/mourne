<?php
class Building_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_building($buildingid)
    {
        $sql = "SELECT * FROM buildings WHERE id='$buildingid'";
        $q = $this->db->query($sql);

        if ($q->num_rows()) {
            return $q->row_array();
        }

        return false;
    }

    public function set_build_in_progress($slotid, $villageid)
    {
        $sql = "INSERT INTO village_buildings 
			VALUES(default, '$villageid', '$slotid', '2')";
        $this->db->query($sql);
    }

    public function building_list($villageid)
    {
        $sql = "SELECT * FROM buildings
			WHERE rank='1'";

        $q = $this->db->query($sql);
        $res = $q->result_array();

        $sql = "SELECT * FROM village_buildings WHERE villageid='$villageid'";
        $q = $this->db->query($sql);
        $vb = $q->result_array();

        //checking requirements
        foreach ($res as $row) {
            if ($this->can_build($villageid, $row, $vb, false)) {
                $build[] = $row;
            }
        }

        //requirements are met
        $tech = $this->get_village_technologies($villageid);

        foreach ($build as $row) {
            if ($row['req_tech']) {
                foreach ($tech as $trow) {
                    if ($row['req_tech'] == $trow['technologyid']) {
                        $data[] = $row;
                        break;
                    }
                }
            } else {
                $data[] = $row;
            }
        }

        return $data;
    }

    //returns 0 if upgrade in progress
    //returns 1 if technology requirement not met
    //returns 2 if not enough resources
    //returns 3 if can be built
    public function can_be_upgraded($event, $res, $building, $villageid, $query = false)
    {
        if ($query) {
            //this means we have to get building from the db,
      //and $building is only the id
        }

        //check if upgrade in progress
        //we can just do this, since event is filtered to update events
        if ($event) {
            return 0;
        }

        if (!$this->has_req_tech($building['req_tech'], $villageid)) {
            return 1;
        }

        if ($res['food'] < $building['cost_food'] ||
            $res['wood'] < $building['cost_wood'] ||
            $res['stone'] < $building['cost_stone'] ||
            $res['iron'] < $building['cost_iron'] ||
            $res['mana'] < $building['cost_mana']) {
            return 2;
        }

        //can be built
        return 3;
    }

    public function can_build($villageid, $buildingid, $data = 0, $is_buildingid = true)
    {
        //STUB requirements aren't implemented
        return true;
    }

    public function is_valid_slot($slotid, $villageid)
    {
        if ($slotid > parent::TOTAL_BUILDINGS) {
            return false;
        }

        $sql = "SELECT id FROM village_buildings 
		WHERE villageid='$villageid' AND slotid='$slotid'";
        $q = $this->db->query($sql);

        if ($q->num_rows()) {
            return false;
        }

        return true;
    }

    public function get_building_ranks_admin()
    {
        $sql = "SELECT * FROM buildings WHERE id > 2";
        $q = $this->db->query($sql);

        $res = $q->result_array();

        $data[0] = 'Nothing';

        foreach ($res as $row) {
            if (!$row['next_rank']) {
                $name = $row['name'] . ' R: ' . $row['rank'];
                $data[$row['id']] = $name;
            }
        }

        return $data;
    }

    public function list_buildings_admin()
    {
        $sql = "SELECT * FROM buildings";
        $q = $this->db->query($sql);

        return $q->result_array();
    }

    public function get_building_admin($id)
    {
        $sql = "SELECT * FROM buildings WHERE id='$id'";
        $q = $this->db->query($sql);

        return $q->row_array();
    }

    public function edit_building_admin($data)
    {
        $sql = "UPDATE buildings
			SET name='" . $data['name'] . "',
			description='" . $data['description'] . "',
			icon='" . $data['icon'] . "',
			rank='" . $data['rank'] . "',
			next_rank='" . $data['next_rank'] . "',
			time_to_build='" . $data['time_to_build'] . "',
			creates='" . $data['creates'] . "',
			num_creates='" . $data['num_creates'] . "',
			score='" . $data['score'] . "',
			defense='" . $data['defense'] . "',
			ability='" . $data['ability'] . "',
			cost_food='" . $data['cost_food'] . "',
			cost_wood='" . $data['cost_wood'] . "',
			cost_stone='" . $data['cost_stone'] . "',
			cost_iron='" . $data['cost_iron'] . "',
			cost_mana='" . $data['cost_mana'] . "',
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
			assignment1='" . $data['assignment1'] . "',
			assignment2='" . $data['assignment2'] . "',
			assignment3='" . $data['assignment3'] . "',
			assignment4='" . $data['assignment4'] . "',
			assignment5='" . $data['assignment5'] . "',
			req_tech='" . $data['req_tech'] . "',
			tech_group='" . $data['tech_group'] . "',
			tech_secondary_group='" . $data['tech_secondary_group'] . "'
			WHERE id='" . $data['id'] . "'";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function add_building_admin($data)
    {
        $sql = "INSERT INTO buildings VALUES(default,
			'" . $data['name'] . "',
			'" . $data['description'] . "',
			'" . $data['icon'] . "',
			'" . $data['rank'] . "',
			'" . $data['next_rank'] . "',
			'" . $data['time_to_build'] . "',
			'" . $data['creates'] . "',
			'" . $data['num_creates'] . "',
			'" . $data['score'] . "',
			'" . $data['defense'] . "',
			'" . $data['ability'] . "',
			'" . $data['cost_food'] . "',
			'" . $data['cost_wood'] . "',
			'" . $data['cost_stone'] . "',
			'" . $data['cost_iron'] . "',
			'" . $data['cost_mana'] . "',
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
			'" . $data['assignment1'] . "',
			'" . $data['assignment2'] . "',
			'" . $data['assignment3'] . "',
			'" . $data['assignment4'] . "',
			'" . $data['assignment5'] . "',
			'" . $data['req_tech'] . "',
			'" . $data['tech_group'] . "',
			'" . $data['tech_secondary_group'] . "')";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }
}
//nowhitesp
