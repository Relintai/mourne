<?php
class Spell_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function use_spell($spellid, $slotid, $res, $villageid)
    {
        $this->resources = $res;

        //getting spell
        $sql = "SELECT spells.*,building_spell_cooldowns.cooldown_end 
			FROM building_spells
			LEFT JOIN spells ON building_spells.spellid=spells.id
			LEFT JOIN building_spell_cooldowns
				ON (building_spells.spellid=building_spell_cooldowns.spellid
				AND building_spell_cooldowns.slotid='$slotid'
				AND building_spell_cooldowns.villageid='$villageid')
			WHERE building_spells.villageid='$villageid'
			AND building_spells.slotid='$slotid'
			AND building_spells.spellid='$spellid'";

        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            return 1;
        }

        $spell = $q->row_array();

        if ($spell['cooldown_end']) {
            return 2;
        }

        if (!$this->check_resources($res, $spell)) {
            return 3;
        }

        //everything is fine
        //substracting cost
        $this->substract_resources($spell, $villageid);

        //addign modofiers
        $this->add_modifiers($spell['id'], $villageid, 'spell');

        $this->write_resources();

        if ($spell['weather_change_to']) {
            $sql = "UPDATE villages 
		SET weather_change_to='" . $spell['weather_change_to'] . "' 
		WHERE id='$villageid'";

            $this->db->query($sql);
        }

        //do spelleffects here


        //adding cooldown
        $cd = $spell['cooldown'] + time();

        $sql = "INSERT INTO building_spell_cooldowns
			VALUES(default, '$villageid', '$slotid', 
			'" . $spell['id'] . "', '$cd')";
        $this->db->query($sql);

        //adding spell_effect_end to events
        $ev['type'] = 3;
        $ev['villageid'] = $villageid;
        $ev['slotid'] = $slotid;
        $ev['time'] = $spell['duration'];
        $ev['data1'] = $spell['id'];

        $this->add_event($ev);
    }

    public function get_spells($slotid, $villageid)
    {
        $this->update_spells($slotid, $villageid);

        $sql = "SELECT spells.*,building_spell_cooldowns.cooldown_end 
			FROM building_spells
			LEFT JOIN spells ON building_spells.spellid=spells.id
			LEFT JOIN building_spell_cooldowns
				ON (building_spells.spellid=building_spell_cooldowns.spellid
				AND building_spell_cooldowns.slotid='$slotid'
				AND building_spell_cooldowns.villageid='$villageid')
			WHERE building_spells.villageid='$villageid'
			AND building_spells.slotid='$slotid'";

        $q = $this->db->query($sql);

        return $q->result_array();
    }

    public function update_spells($slotid, $villageid)
    {
        $sql = "SELECT * FROM building_spell_cooldowns
			WHERE slotid='$slotid'
			AND villageid='$villageid'";

        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            return;
        }

        $spells = $q->result_array();
        $time = time();

        foreach ($spells as $row) {
            if ($row['cooldown_end'] <= $time) {
                $sql = "DELETE FROM building_spell_cooldowns
					WHERE id='" . $row['id'] . "'";
                $this->db->query($sql);
            }
        }
    }

    public function get_spell_mod_drop_admin()
    {
        //STUB
        $data = array('0' => 'Nothing');
        return $data;
    }

    public function list_spells_admin()
    {
        $sql = "SELECT * FROM spells";
        $q = $this->db->query($sql);

        return $q->result_array();
    }

    public function get_spell_list_drop_admin()
    {
        $sql = "SELECT * FROM spells";
        $q = $this->db->query($sql);
        $res = $q->result_array();

        $data[0] = 'No Spell';

        foreach ($res as $row) {
            $data[$row['id']] = $row['description_admin'];
        }

        return $data;
    }

    public function get_spell_admin($id)
    {
        $sql = "SELECT * FROM spells WHERE id='$id'";
        $q = $this->db->query($sql);

        return $q->row_array();
    }

    public function edit_spell_admin($data)
    {
        $sql = "UPDATE spells
			SET effect='" . $data['effect'] . "',
			duration='" . $data['duration'] . "',
			cooldown='" . $data['cooldown'] . "',
			description='" . $data['description'] . "',
			description_admin='" . $data['description_admin'] . "',
			weather_change_to='" . $data['weather_change_to'] . "',
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
			mod_percent_mana='" . $data['mod_percent_mana'] . "'	
			WHERE id='" . $data['id'] . "'";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function add_spell_admin($data)
    {
        $sql = "INSERT INTO spells VALUES(default,
			'" . $data['effect'] . "',
			'" . $data['duration'] . "',
			'" . $data['cooldown'] . "',
			'" . $data['description'] . "',
			'" . $data['description_admin'] . "',	
			'" . $data['weather_change_to'] . "',	
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
			'" . $data['mod_percent_mana'] . "')";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function get_spell_effects_admin()
    {
        //STUB!
        $data = array('0' => 'No Effect');

        return $data;
    }
}
//nowhitesp
