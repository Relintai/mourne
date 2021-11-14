<?php

class Hero_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_heroes($userid)
    {
        $sql = "SELECT * FROM heroes WHERE userid = ? AND deleted = '0'";

        $q = $this->db->query($sql, array($userid));

        if ($q->num_rows()) {
            return $q->result_array();
        }

        return false;
    }

    public function select_hero($id, $userid)
    {
        $sql = "SELECT userid,deleted FROM heroes WHERE id = ?";

        $q = $this->db->query($sql, array($id));

        if (!$q->num_rows()) {
            return false;
        }

        $res = $q->row_array();

        if ($res['userid'] != $userid || $res['deleted']) {
            return false;
        }

        $sql = "UPDATE heroes SET selected = 0 WHERE userid = ?";

        $this->db->query($sql, array($userid));

        $sql = "UPDATE heroes SET selected = 1 WHERE id = ?";

        $this->db->query($sql, array($id));

        return true;
    }

    public function get_hero($id, $userid)
    {
        $sql = "SELECT * FROM heroes WHERE id = ?  AND userid = ?";

        $q = $this->db->query($sql, array($id, $userid));

        if ($q->num_rows()) {
            return $q->row_array();
        }

        return false;
    }

    public function delete_hero($id, $userid)
    {
        $sql = "SELECT * FROM heroes WHERE id = ?";

        $q = $this->db->query($sql, array($id));

        if (!$q->num_rows()) {
            return false;
        }

        $res = $q->row_array();

        if ($res['deleted']) {
            return false;
        }

        if ($userid != $res['userid']) {
            return false;
        }

        if ($res['selected']) {
            $sql = "SELECT * FROM heroes WHERE userid = ? AND deleted = '0'";

            $q = $this->db->query($sql, array($userid));

            if (!$q->num_rows()) {
                return true;
            }

            $data = $q->result_array();

            foreach ($data as $row) {
                if ($row['id'] != $id) {
                    $sql = "UPDATE heroes SET selected = '1' WHERE id = ?";
                    $this->db->query($sql, array($row['id']));

                    break;
                }
            }
        }

        $sql = "UPDATE heroes SET deleted='1', delete_name = '" . $res['name'] . "', name=''
		WHERE id = ?";

        $this->db->query($sql, array($id));

        return true;
    }

    //  function get_hero_admin($id)? or gm?

    public function create($data, $userid)
    {
        $name = ucfirst(mb_strtolower($data['name'], 'UTF-8'));

        if ($gender == 1) {
            $av = 'characters/base/male.png';
            $avt = 'characters/base/male_thumb.png';
        } else {
            $av = 'characters/base/female.png';
            $avt = 'characters/base/female_thumb.png';
        }

        $sql = "UPDATE heroes SET selected='0' WHERE userid = ?";

        $this->db->query($sql, array($userid));

        $sql = "SELECT * FROM hero_templates WHERE id = ?";

        $q = $this->db->query($sql, array($data['class']));

        if (!$q->num_rows()) {
            return false;
        }

        $cd = $q->row_array();

        //getting inventory template, and applying the stats
    



        $sql = "INSERT INTO heroes
	VALUES(default, '$userid', ?, default, default, 
	?, default, '" . $cd['max_health'] . "', '" . $cd['max_mana'] . "', '" . $cd['max_health'] . "',
	'" . $cd['max_mana'] . "', default, default, '" . $cd['nomod_max_health'] . "', 
	'". $cd['nomod_max_mana'] . "', 
	default, '" . $cd['agility'] . "', '" . $cd['strength'] . "', '" . $cd['stamina'] . "', 
	'" . $cd['intellect'] . "', 
	'" . $cd['spirit'] . "', default, default, default, default, 
	default, '" . $cd['agility'] . "', '" . $cd['strength'] . "', '" . $cd['stamina'] . "', 
	'" . $cd['intellect'] . "', 
	'" . $cd['spirit'] . "', default, default, default, default, 
	default, '" . $cd['attackpower'] . "', default, '" . $cd['nomod_attackpower'] . "', 
	'" . $cd['armor'] . "', 
	default, '" . $cd['armor'] . "', '" . $cd['dodge'] . "', '" . $cd['nomod_dodge'] . "', 
	'" . $cd['parry'] . "', 
	'" . $cd['nomod_parry'] . "', '" . $cd['hit'] . "', 
	'" . $cd['crit'] . "', '" . $cd['nomod_crit'] . "',  '" . $cd['damage_min'] . "', 
	'" . $cd['damage_max'] . "', default,  default, '" . $cd['nomod_damage_min'] . "', 
	'" . $cd['nomod_damage_max'] . "', 
	'" . $cd['ranged_damage_min'] . "', '" . $cd['ranged_damage_max'] . "', default,  default, 
	'" . $cd['nomod_ranged_damage_min'] . "', 
	'" . $cd['nomod_ranged_damage_max'] . "', '" . $cd['heal_min'] . "', 
	'" . $cd['heal_max'] . "', default, default, 
	'" . $cd['nomod_heal_min'] . "', '" . $cd['nomod_heal_max'] . "', default, default, ?, 
	default, ?, ?, default, '')";
    
        $this->db->query($sql, array($name, $data['class'], $data['gender'], $av, $avt));

        //add invertory here

    //add starter spells

    //make actionbar entry
    }

    public function hero_name_is_unique($name)
    {
        $name = ucfirst(mb_strtolower($name, 'UTF-8'));

        $sql = "SELECT * FROM heroes WHERE name = ? LIMIT 0, 1";

        $q = $this->db->query($sql, array($name));

        if ($q->num_rows()) {
            return false;
        } else {
            return true;
        }
    }

    public function all_hero_templates_admin()
    {
        $sql = "SELECT * FROM hero_templates";

        $q = $this->db->query($sql);

        if ($q->num_rows()) {
            return $q->result_array();
        } else {
            return false;
        }
    }

    public function get_template_admin($id)
    {
        $sql = "SELECT * FROM hero_templates WHERE id = '$id'";

        $q = $this->db->query($sql);

        if ($q->num_rows()) {
            return $q->row_array();
        } else {
            return false;
        }
    }

    public function edit_template_admin($d)
    {
        $c = $this->template_calc_stats($d, 'edit');

        $sql = "UPDATE hero_templates 
	SET classname = '" . $d['classname'] . "', 
	nomod_max_health = '" . $d['nomod_max_health'] . "', 
	nomod_max_mana = '" . $d['nomod_max_mana'] . "',
	max_health = '" . $c['max_health'] . "',
	max_mana = '" . $c['max_mana'] . "', 
	agility = '" . $d['agility'] . "', 
	strength = '" . $d['strength'] . "', 
	stamina = '" . $d['stamina'] . "', 
	intellect = '" . $d['intellect'] . "', 
	spirit = '" . $d['spirit'] . "', 
	nomod_attackpower = '" . $d['nomod_attackpower'] . "',
	attackpower = '" . $c['attackpower'] . "',
	armor = '" . $c['armor']. "', 
	dodge = '" . $c['dodge'] . "', 
	nomod_dodge = '" . $d['nomod_dodge'] . "',
	parry = '" . $c['parry'] . "', 
	nomod_parry = '" . $d['nomod_parry'] . "',
	hit = '" . $d['hit'] . "',
	crit = '" . $c['crit'] . "', 
	nomod_crit = '" . $d['nomod_crit'] . "',
	nomod_damage_min = '" . $c['nomod_damage_min'] . "', 
	nomod_damage_max = '" . $c['nomod_damage_max'] . "',
	damage_min = '" . $c['damage_min'] . "', 
	damage_max = '" . $c['damage_max'] . "',
	ranged_damage_min = '" . $c['ranged_damage_min'] . "',
	ranged_damage_max = '" . $c['ranged_damage_max'] . "',
	nomod_ranged_damage_min = '" . $c['nomod_ranged_damage_min'] . "',
	nomod_ranged_damage_max = '" . $c['nomod_ranged_damage_max'] . "',
	nomod_heal_min = '" . $c['nomod_heal_min'] . "', 
	nomod_heal_max = '" . $c['nomod_heal_max'] . "', 
	heal_min = '" . $c['heal_min'] . "',
	heal_max = '" . $c['heal_max'] . "'
	WHERE id = '" . $d['id'] . "'";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function add_template_admin($d)
    {
        //0 armor is being added, because when adding a new class, eqipments shouldn't exists in db

        //think about this!
        //maybe this is uniform in template and normal mode! or can be made uniform
        $c = $this->template_calc_stats($d, 'add');
    

        $sql = "INSERT INTO hero_templates 
	VALUES(default, '" . $d['classname'] . "', '" . $d['nomod_max_health'] . "', 
	'" . $d['nomod_max_mana'] . "', '" . $c['max_health'] . "',
	'" . $c['max_mana'] . "', '" . $d['agility'] . "', '" . $d['strength'] . "', 
	'" . $d['stamina'] . "', '" . $d['intellect'] . "', 
	'" . $d['nomod_attackpower'] . "', '" . $c['attackpower'] . "',
	'" . $d['spirit'] . "', '0', '" . $c['dodge'] . "', 
	'" . $d['nomod_dodge'] . "', '" . $c['parry'] . "', '" . $d['nomod_parry'] . "', 
	'" . $d['hit'] . "', '" . $c['crit'] . "', 
	'" . $d['nomod_crit'] . "', '" . $d['nomod_damage_min'] . "', '" . $d['nomod_damage_max'] . "', 
	'" . $c['damage_min'] . "', '" . $c['damage_max'] . "', 
	'" . $c['ranged_damage_min'] . "', '" . $c['ranged_damage_max'] . "', 
	'" . $d['nomod_ranged_damage_min'] . "', '" . $d['nomod_ranged_damage_max'] . "',
	'" . $d['nomod_heal_min'] . "', 
	'" . $d['nomod_heal_max'] . "', '" . $c['heal_min'] . "', '" . $c['heal_max'] . "')";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    //this is for templates (calculating all stats)
    //type can be add and edit -> edit does thing like armor calc, and damage
    public function template_calc_stats($d, $type)
    {
        $class = $d['classname'];

        $c['max_health'] = $this->hero_stat($class, 'max_health', $d);
        $c['max_mana'] = $this->hero_stat($class, 'max_mana', $d);

        $c['attackpower'] = $this->hero_stat($class, 'attackpower', $d);

        $c['crit'] = $this->hero_stat($class, 'crit', $d);
        $c['parry'] = $this->hero_stat($class, 'parry', $d);
        $c['dodge'] = $this->hero_stat($class, 'dodge', $d);

        $c['damage_min'] = $this->hero_stat($class, 'damage_min', $d);
        $c['damage_max'] = $this->hero_stat($class, 'damage_max', $d);

        $c['ranged_damage_min'] = $this->hero_stat($class, 'ranged_damage_min', $d);
        $c['ranged_damage_max'] = $this->hero_stat($class, 'ranged_damage_max', $d);

        $c['heal_min'] = $this->hero_stat($class, 'heal_min', $d);
        $c['heal_max'] = $this->hero_stat($class, 'heal_max', $d);
    
        if ($type == 'edit') {
            //STUB
            //armor, damage, heal from items
            $c['armor'] = 0;
            $c['nomod_damage_min'] = $d['nomod_damage_min'];
            $c['nomod_damage_max'] = $d['nomod_damage_max'];

            $c['nomod_ranged_damage_min'] = $d['nomod_ranged_damage_min'];
            $c['nomod_ranged_damage_max'] = $d['nomod_ranged_damage_max'];

            $c['nomod_heal_min'] = $d['nomod_heal_min'];
            $c['nomod_heal_max'] = $d['nomod_heal_max'];
        }

        return $c;
    }
}
//nowhitesp
