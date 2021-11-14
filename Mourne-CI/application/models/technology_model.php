<?php
class Technology_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function do_research($techid, $res, $slotid, $villageid)
    {
        $this->set_resources($res);

        $technology = $this->get_technology($techid);

        //no such technology
        if (!$technology) {
            return 1;
        }

        if (!$this->check_resources($res, $technology)) {
            return 2;
        }

        $tech = $this->get_researchable($slotid, $villageid);

        $primary = $tech['primary'];
        $secondary = $tech['secondary'];

        $found = false;
        $group = false;
        foreach ($primary as $row) {
            if ($row['id'] == $techid) {
                $found = true;
                $group = 'primary';
                break;
            }
        }

        foreach ($secondary as $row) {
            if ($found) {
                break;
            }

            if ($row['id'] = $techid) {
                $found = true;
                $group = 'secondary';
                break;
            }
        }

        //building doesn't have this technology (or user already have it)
        if (!$found) {
            return 3;
        }

        //everything is fine
        //substract cost
        $this->substract_resources($technology, $villageid);

        $this->write_resources();

        //add event
        $ev['type'] = 4;
        $ev['villageid'] = $villageid;
        $ev['slotid'] = $slotid;
        $ev['time'] = $technology['time'];
        $ev['data1'] = $techid;

        if ($group == 'secondary') {
            $ev['data2'] = $slotid;
        }

        $this->add_event($ev);
    }

    public function get_researchable($slotid, $villageid)
    {
        $building = $this->get_slot_building($slotid, $villageid);

        if (!($building['tech_group'] && $building['tech_secondary_group'])) {
            $data['primary'] = false;
            $data['secondary'] = false;
            return $data;
        }

        //technologies a village has
        $technologies = $this->get_village_technologies($villageid, $slotid);

        //technologies a building can make
        $building_tech = $this->get_building_technologies(
            $building['tech_group'],
            $building['tech_secondary_group']
        );

        //technologies that a village (or building) doesn't have
        $av_tech = $this->select_technology_not_have($technologies, $building_tech);

        //getting technology requirements
        $requirements = $this->get_requirements($av_tech);

        if (!$requirements) {
            return $av_tech;
        }

        $data['primary'] = $this->apply_requirements(
            $av_tech['primary'],
            $requirements
        );

        $data['secondary'] = $this->apply_requirements(
            $av_tech['secondary'],
            $requirements
        );

        return $data;
    }

    public function apply_requirements($technologies, $requirements)
    {
        if (!$technologies) {
            return false;
        }

        if (!$requirements) {
            return $technologies;
        }

        foreach ($technologies as $row) {
            $found = false;
            foreach ($requirements as $req) {
                //if the technology's id matched the current requirement's techid
                if ($req['technologyid'] == $row['id']) {
                    //looking for the matching technology that is required
                    foreach ($technologies as $tech) {
                        if ($req['req_tech_id'] == $tech['id']) {
                            $found = true;
                            break;
                        }
                    }
                }
            }

            if (!$found) {
                $data[] = $row;
            }
        }

        if (isset($data)) {
            return $data;
        } else {
            return false;
        }
    }

    public function get_requirements($tech)
    {
        $primary = $tech['primary'];
        $secondary = $tech['secondary'];

        if (!$primary && !$secondary) {
            return false;
        }

        $sql = "SELECT * FROM technology_requirements
			WHERE (";

        $first = true;
        if ($primary) {
            foreach ($primary as $row) {
                if ($first) {
                    $first = false;
                } else {
                    $sql .= "OR ";
                }
    
                $sql .= "technologyid='" . $row['id'] . "' ";
            }
        }

        if ($secondary) {
            foreach ($secondary as $row) {
                if ($first) {
                    $first = false;
                } else {
                    $sql .= "OR ";
                }

                $sql .= "technologyid='" . $row['id'] . "' ";
            }
        }

        $sql .= ")";

        $q = $this->db->query($sql);

        if ($q->num_rows()) {
            return $q->result_array();
        } else {
            return false;
        }
    }

    //TODO better name?
    public function select_technology_not_have($village_tech, $building_technologies)
    {
        $primary = $building_technologies['primary'];
        $secondary = $building_technologies['secondary'];

        //adding only which village doesn't have (primary)
        if ($primary) {
            $found = false;
            foreach ($primary as $row) {
                foreach ($village_tech as $trow) {
                    if ($found) {
                        continue;
                    }
    
                    if ($trow['technologyid'] == $row['id']) {
                        $found = true;
                    }
                }
    
                if (!$found) {
                    $data['primary'][] = $row;
                }

                $found = false;
            }
        }
        if (!isset($data['primary'])) {
            $data['primary'] = false;
        }
        

        if ($secondary) {
            //same just with secondary
            $found = false;
            foreach ($secondary as $row) {
                foreach ($village_tech as $trow) {
                    if ($found) {
                        continue;
                    }

                    if ($trow['technologyid'] == $row['id']) {
                        $found = true;
                    }
                }

                if (!$found) {
                    $data['secondary'][] = $row;
                }

                $found = false;
            }
        }

        if (!isset($data['secondary'])) {
            $data['secondary'] = false;
        }

        return $data;
    }

    public function get_building_technologies($id, $secid = 0)
    {
        if ($secid) {
            $sql = "SELECT technologies.*,technology_groups.groupid
				FROM technology_groups
				INNER JOIN technologies
				ON technology_groups.technologyid=technologies.id
				WHERE (groupid='$id' OR groupid='$secid')";
        } else {
            $sql = "SELECT technologies.*
				FROM technology_groups
				INNER JOIN technologies
				ON technology_groups.technologyid=technologies.id
				WHERE groupid='$id'";
        }

        $q = $this->db->query($sql);

        if (!$secid) {
            $data['primary'] = $q->result_array();
            $data['secondary'] = false;

            return $data;
        }

        $res = $q->result_array();

        foreach ($res as $row) {
            if ($row['groupid'] == $id) {
                $data['primary'][] = $row;
            } else {
                $data['secondary'][] = $row;
            }
        }

        if (!isset($data['primary'])) {
            $data['primary'] = false;
        }

        if (!isset($data['secondary'])) {
            $data['secondary'] = false;
        }

        return $data;
    }

    public function get_technology($id)
    {
        $sql = "SELECT * FROM technologies WHERE id='$id'";
        $q = $this->db->query($sql);

        if ($q->num_rows()) {
            return $q->row_array();
        } else {
            return false;
        }
    }

    public function add_tech_req_admin($techid, $reqid)
    {
        //dont add if already added
        $sql = "SELECT * FROM technology_requirements
			WHERE technologyid='$techid'
			AND req_tech_id='$reqid'";

        $q = $this->db->query($sql);

        if ($q->num_rows()) {
            return;
        }

        $sql = "INSERT INTO technology_requirements
			VALUES(default, '$techid', '$reqid')";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function remove_tech_req_admin($id)
    {
        $sql = "DELETE FROM technology_requirements
			WHERE id='$id'";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function get_tech_by_req_id_admin($id)
    {
        $sql = "SELECT technologies.* 
			FROM technology_have_requirements
			INNER JOIN technologies 
			ON technology_have_requirements.technologyid=technologies.id
			WHERE technology_have_requirements.id='$id'";

        $q = $this->db->query($sql);

        return $q->row_array();
    }

    public function get_tech_requirements_admin($id)
    {
        $sql = "SELECT technology_requirements.*,technologies.description 
			FROM technology_requirements
			INNER JOIN technologies
			ON technology_requirements.req_tech_id=technologies.id
			WHERE technologyid='$id'";

        $q = $this->db->query($sql);

        return $q->result_array();
    }

    public function add_to_req_list_admin($data)
    {
        $sql = "SELECT * FROM technology_have_requirements
			WHERE technologyid='" . $data['technologyid'] . "'";

        $q = $this->db->query($sql);

        if ($q->num_rows) {
            return;
        }

        $sql = "INSERT INTO technology_have_requirements
			VALUES(default, 
			'" . $data['technologyid'] . "', 
			'" . $data['comment'] . "')";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function remove_from_req_list_admin($id)
    {
        $sql = "DELETE FROM technology_have_requirements
			WHERE id='$id'";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function get_req_list_item_admin($id)
    {
        $sql = "SELECT technology_have_requirements.*,technologies.description 
			FROM technology_have_requirements
			INNER JOIN technologies
			ON technology_have_requirements.technologyid=technologies.id
			WHERE technology_have_requirements.id='$id'";

        $q = $this->db->query($sql);

        return $q->row_array();
    }

    public function list_tech_have_req_admin()
    {
        $sql = "SELECT technology_have_requirements.*,technologies.description 
			FROM technology_have_requirements
			INNER JOIN technologies 
			ON technology_have_requirements.technologyid=technologies.id";

        $q = $this->db->query($sql);
        return $q->result_array();
    }

    public function add_tech_to_group_admin($gid, $techid)
    {
        $sql = "INSERT INTO technology_groups
			VALUES(default, '$gid', '$techid')";
        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function remove_tech_from_group_admin($gid, $techid)
    {
        $sql = "DELETE FROM technology_groups
			WHERE groupid='$gid'
			AND technologyid='$techid'";
        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function get_group_admin($id)
    {
        $sql = "SELECT technology_groups.*, technologies.description 
			FROM technology_groups
			INNER JOIN technologies ON technology_groups.technologyid=technologies.id
			WHERE groupid='$id'";
        
        $q = $this->db->query($sql);

        return $q->result_array();
    }

    public function get_tech_list_drop_admin()
    {
        $sql = "SELECT id,description FROM technologies";
        $q = $this->db->query($sql);

        $res = $q->result_array();

        $data[0] = 'Nothing';

        foreach ($res as $row) {
            $data[$row['id']] = $row['description'];
        }

        return $data;
    }

    public function list_tech_drop_admin()
    {
        $sql = "SELECT id,description FROM technologies";
        $q = $this->db->query($sql);

        $res = $q->result_array();

        foreach ($res as $row) {
            $data[$row['id']] = $row['description'];
        }

        if (isset($data)) {
            return $data;
        } else {
            return false;
        }
    }

    public function get_tech_group_list_drop_admin()
    {
        $sql = "SELECT * FROM technology_group_descriptions";

        $q = $this->db->query($sql);

        $res = $q->result_array();

        $data[0] = 'Nothing';

        foreach ($res as $row) {
            $data[$row['id']] = $row['group_name'];
        }

        return $data;
    }

    public function add_tech_group_desc_admin($data)
    {
        $sql = "INSERT INTO technology_group_descriptions
			VALUES(default, '" . $data['group_name'] . "')";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function edit_tech_group_desc_admin($data)
    {
        $sql = "UPDATE technology_group_descriptions
			SET group_name='" . $data['group_name'] . "'
			WHERE id='" . $data['id'] . "'";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function get_tech_group_desc_admin($id)
    {
        $sql = "SELECT * FROM technology_group_descriptions WHERE id='$id'";
        $q = $this->db->query($sql);

        return $q->row_array();
    }

    public function list_tech_groups_admin()
    {
        $sql = "SELECT * FROM technology_group_descriptions";
        $q = $this->db->query($sql);

        return $q->result_array();
    }

    public function list_technologies_admin()
    {
        $sql = "SELECT * FROM technologies";
        $q = $this->db->query($sql);

        return $q->result_array();
    }

    public function get_technology_admin($id)
    {
        $sql = "SELECT * FROM technologies WHERE id='$id'";
        $q = $this->db->query($sql);

        return $q->row_array();
    }

    public function edit_technology_admin($data)
    {
        $sql = "UPDATE technologies
			SET description='" . $data['description'] . "',
			time='" . $data['time'] . "',
			score='" . $data['score'] . "',
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
			mod_create_id='" . $data['mod_create_id'] . "',
			mod_spell_id='" . $data['mod_spell_id'] . "',
			flag_ai='" . $data['flag_ai'] . "',
			is_secondary='" . $data['is_secondary'] . "'
			WHERE id='" . $data['id'] . "'";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function add_technology_admin($data)
    {
        $sql = "INSERT INTO technologies VALUES(default,
			'" . $data['description'] . "',
			'" . $data['time'] . "',
			'" . $data['score'] . "',
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
			'" . $data['mod_create_id'] . "',
			'" . $data['mod_spell_id'] . "',
			'" . $data['flag_ai'] . "',
			'" . $data['is_secondary'] . "')";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }
}
//nowhitesp
