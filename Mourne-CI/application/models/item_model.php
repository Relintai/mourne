<?php

class Item_model extends MO_Model
{
    const MAX_EQUIPMENT = 20; //19, starts with zero

    public function __construct()
    {
        parent::__construct();
    }

    //this will equip too if needed!
    public function swap($d1, $d2, $d3, $d4)
    {
        //data validation
        if (!($d1 == 'iv' || $d1 == 'eq') || !($d3 == 'iv' || $d3 == 'eq') || !is_numeric($d2) ||
    !is_numeric($d4) || ($d2 < 0 || $d2 > (parent::INVENTORY_MAX - 1)) ||
    ($d4 < 0 || $d4 > (parent::INVENTORY_MAX - 1))) {
            return false;
        }

        //nothing needs to be done (same item twice)
        if (($d1 == $d3) && ($d2 == $d4)) {
            return true;
        }

        //hero has to be set from controller!
        if (!$this->hero) {
            return 'Internal error';
        }

        //just move in inventory
        if ($d1 == 'iv' && $d3 == 'iv') {
            $sql = "SELECT * FROM heros_inventory 
	WHERE container = 1 AND (slot = ? OR slot = ?) AND charid = ?";

            $q = $this->db->query($sql, array($d2, $d4, $this->hero['id']));

            $num = $q->num_rows();

            if (!$num) {
                return false;
            }

            $res = $q->result_array();

            $item1 = $res[0];

            if ($num == 2) {
                $item2 = $res[1];
            } else {
                $item2 = false;
            }

            if (!$item2) {
                $sql = "UPDATE heros_inventory
		SET slot = ?
		WHERE id = ?";

                if ($item1['slot'] == $d2) {
                    $to = $d4;
                } else {
                    $to = $d2;
                }

                $this->db->query($sql, array($to, $item1['id']));

                return true;
            }

            //we only get here it two items needs to be swapped
            $sql = "UPDATE heros_inventory SET slot = ? WHERE id = ?";

            $this->db->query($sql, array($item1['slot'], $item2['id']));
            $this->db->query($sql, array($item2['slot'], $item1['id']));

            return true;
        }

        //equipping has to be performed (iv/iv case already handled!)
        if ($d1 == 'iv') {
            $d1 = 1;
        } else {
            $d1 = 2;
        }

        if ($d3 == 'iv') {
            $d3 = 1;
        } else {
            $d3 = 2;
        }


        $sql = "SELECT heros_inventory.id AS invid,heros_inventory.is_soulbound,heros_inventory.stack_size,
		heros_inventory.container,heros_inventory.slot,hero_items.*
		FROM heros_inventory
		LEFT JOIN hero_items on heros_inventory.itemid = hero_items.id
		WHERE ((heros_inventory.container = ? AND heros_inventory.slot = ?) OR
		(heros_inventory.container = ? AND heros_inventory.slot = ?)) AND
		charid = ?";

        $q = $this->db->query($sql, array($d1, $d2, $d3, $d4, $this->hero['id']));

        $swap = false;

        $num = $q->num_rows();
    
        if ($num == 2) {
            $res = $q->result_array();

            if ($res[0]['container'] == 1) {
                //0 is in bag
                $equip = $res[0];
                $deequip = $res[1];
            } elseif ($res[1]['container'] == 1) {
                //1 is in bag
                $equip = $res[1];
                $deequip = $res[0];
            } else {
                //swap
                $equip = $res[0];
                $deequip = $res[1];
                $swap = true;
            }
        } else {
            $res = $q->row_array();

            if ($res['container'] == 1) {
                //not equipped, just equip it
                $equip = $res;
                $deequip = false;

                if ($d1 == 1) {
                    $equipslot = $d4;
                } else {
                    $equipslot = $d2;
                }
            } else {
                if ($d1 == 2 && $d3 == 2) {
                    //switching between 2 equipslots, but one of them is empty
                    $equip = $res;
                    $deequip = false;

                    if ($equip['slot'] == $d2) {
                        $equipslot = $d4;
                    } else {
                        $equipslot = $d2;
                    }

                    $swap = true;
                } else {
                    //equipped, just deequip it
                    $equip = false;
                    $deequip = $res;
      
                    if ($d1 == 2) {
                        $deequipslot = $d4;
                    } else {
                        $deequipslot = $d2;
                    }
                }
            }
        }
    
        $this->load->helper('equipment');

        if ($equip) {
            //$cbe = can be equipped
            $cbe = can_be_equipped($equip, $this->hero);

            if (!isset($cbe)) {
                return "Internal error! $cbe is not set!";
            }
        }

        //each of these functions has to return!

        //for switching items from inventory
        if ($equip && $deequip && !$swap) {
            if ($cbe['can'] === true) {
                if ($cbe['allowed_slot1'] == $deequip['slot'] || $cbe['allowed_slot2'] == $deequip['slot']) {
                    $equipslot = $deequip['slot'];
                }

                if (!isset($equipslot)) {
                    return "That item cannot be equipped into that slot.";
                }

                if ($cbe['two_handed']) {
                    $eq = $this->prep_two_hand();

                    if ($eq !== true) {
                        return $eq;
                    }
                }

                $this->hero_remove_stats($deequip);
                $this->hero_add_stats($equip);

                $sql = "UPDATE heros_inventory SET container = ?, slot = ? WHERE id = ?";

                //deequipping
                $this->db->query($sql, array(1, $equip['slot'], $deequip['invid']));

                //equip
                $this->db->query($sql, array(2, $equipslot, $equip['invid']));

                $this->calc_hero_stats();

                return true;
            } else {
                return $cbe['message'];
            }
        }

        //switching between 2 slots
        if ($equip && $deequip && $swap) {
            if (!(($cbe['allowed_slot1'] == $equip['slot'] || $cbe['allowed_slot2'] == $equip['slot']) &&
        ($cbe['allowed_slot1'] == $deequip['slot'] || $cbe['allowed_slot2'] == $deequip['slot']))) {
                return "Those items cannot be swapped";
            }

            $sql = "UPDATE heros_inventory SET slot = ? WHERE id = ?";

            $this->db->query($sql, array($equip['slot'], $deequip['invid']));
            $this->db->query($sql, array($deequip['slot'], $equip['invid']));

            return true;
        }

        //just deequip
        if ($deequip && !$swap) {
            $sql = "UPDATE heros_inventory SET container = 1, slot = ? WHERE id = ?";

            $this->db->query($sql, array($deequipslot, $deequip['invid']));

            $this->hero_remove_stats($deequip);
            $this->calc_hero_stats();

            return true;
        }

        //just equip
        if ($equip && !$swap) {
            if (!$cbe['can']) {
                return $cbe['message'];
            }

            if (!($cbe['allowed_slot1'] == $equipslot || $cbe['allowed_slot2'] == $equipslot)) {
                return 'That item cannot be equipped into that slot.';
            }

            if ($cbe['two_handed']) {
                $eq = $this->prep_two_hand();
    
                if ($eq !== true) {
                    return $eq;
                }
            }

            $sql = "UPDATE heros_inventory SET container = 2, slot = ? WHERE id = ?";

            $this->db->query($sql, array($equipslot, $equip['invid']));

            $this->hero_add_stats($equip);
            $this->calc_hero_stats();

            return true;
        }

        //switching between two equipslots, when one of the slots is empty
        if ($swap) {
            if (!($cbe['allowed_slot1'] == $equipslot || $cbe['allowed_slot2'] == $equipslot)) {
                return "That item cannot be equipped into that slot";
            }

            $sql = "UPDATE heros_inventory SET slot = ? WHERE id = ?";

            $this->db->query($sql, array($equipslot, $equip['invid']));

            return true;
        }

        return false;
    }

    //unequips the off hand, if the user wants to equip a two-hand wep
    public function prep_two_hand()
    {
        $sql = "SELECT heros_inventory.id AS invid,heros_inventory.is_soulbound,heros_inventory.stack_size,
	heros_inventory.container,heros_inventory.slot,hero_items.*
	FROM heros_inventory
	LEFT JOIN hero_items on heros_inventory.itemid = hero_items.id
	WHERE (heros_inventory.container = 2 AND heros_inventory.slot = 17) AND
	charid = ?";

        $q = $this->db->query($sql, array($this->hero['id']));

        if (!$q->num_rows()) {
            return true;
        }

        $res = $q->row_array();

        //find an empty place
        $sql = "SELECT * FROM heros_inventory WHERE container = 1 AND charid = ?";

        $q = $this->db->query($sql, array($this->hero['id']));

        $slot = false;

        if ($q->num_rows()) {
            $inv = $q->result_array();

            for ($i = 0; $i < parent::INVENTORY_MAX; $i++) {
                $found = false;

                foreach ($inv as $row) {
                    if ($row['slot'] == $i) {
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $slot = $i;
                    break;
                }
            }
        } else {
            $slot = 0;
        }

        if ($slot === false) {
            return "You don't have any space in your inventory, to unequip the off hand.";
        }

        $this->hero_remove_stats($res);

        $sql = "UPDATE heros_inventory SET slot = ?, container = 1 WHERE id = ?";

        $this->db->query($sql, array($slot, $res['invid']));

        return true;
    }

    //returns ['equipment'], ['money'], ['inventory']
    public function get_inventory($charid)
    {
        $sql = "SELECT heros_inventory.is_soulbound,heros_inventory.stack_size,heros_inventory.container,
		heros_inventory.slot,hero_items.* 
		FROM heros_inventory 
		LEFT JOIN hero_items ON heros_inventory.itemid=hero_items.id
		WHERE charid = ?";

        $q = $this->db->query($sql, array($charid));

        if ($q->num_rows()) {
            $res = $q->result_array();
        } else {
            $res = false;
        }

        $found = false;
        for ($i = 0; $i < parent::INVENTORY_MAX; $i++) {
            if ($res) {
                foreach ($res as $row) {
                    if ($row['container'] == 1 && $row['slot'] == $i) {
                        $data[] = $row;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $data[] = false;
                }

                $found = false;
            } else {
                $data[] = false;
            }
        }

        //sort it

        $r['inventory'] = $data;

        if ($res) {
            foreach ($res as $row) {
                if ($row['container'] == 0) {
                    $money = $row;
                    break;
                }
            }
        }

        if (isset($money)) {
            $r['money'] = $money;
        } else {
            $r['money'] = 0;
        }

        //equipment
        $found = false;
        for ($i = 0; $i < self::MAX_EQUIPMENT; $i++) {
            if ($res) {
                foreach ($res as $row) {
                    if ($row['container'] == 2 && $row['slot'] == $i) {
                        $eq[] = $row;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $eq[] = false;
                }

                $found = false;
            } else {
                $eq[] = false;
            }
        }

        $r['equipment'] = $eq;

        //sort it, if needed
        $found = false;
        if ($res) {
            for ($i = 0; $i < self::MAX_EQUIPMENT; $i++) {
                foreach ($eq as $row) {
                    if ($row && $row['slot'] == $i) {
                        $seq[] = $row;
                        $found = true;
                        break;
                    }
                }
      
                if (!$found) {
                    $seq[] = false;
                }

                $found = false;
            }

            $r['equipment'] = $seq;
        }

        return $r;
    }

    public function add_item_admin($data)
    {
        $sql = "INSERT INTO hero_items 
	VALUES(default,
	" . $this->db->escape($data['name']) . ",
	" . $this->db->escape($data['icon']) . ",
	'" . $data['quality'] . "',
	'" . $data['itemlevel'] . "',
	'" . $data['stack'] . "',
	'" . $data['type'] . "',
	'" . $data['subtype'] . "',
	'" . $data['subsubtype'] . "',
	'" . $data['sell_price'] . "',
	'" . $data['buy_price'] . "',
	" . $this->db->escape($data['text']) . ",
	'" . $data['soulbound'] . "',
	'" . $data['spell'] . "',
	'" . $data['proc'] . "',
	'" . $data['req_level'] . "',
	'" . $data['req_class'] . "',
	'" . $data['nomod_max_health'] . "',
	'" . $data['nomod_max_mana'] . "',
	'" . $data['percent_max_health'] . "',
	'" . $data['percent_max_mana'] . "',
	'" . $data['nomod_agility'] . "',
	'" . $data['nomod_strength'] . "',
	'" . $data['nomod_stamina'] . "',
	'" . $data['nomod_intellect'] . "',
	'" . $data['nomod_spirit'] . "',
	'" . $data['percent_agility'] . "',
	'" . $data['percent_strength'] . "',
	'" . $data['percent_stamina'] . "',
	'" . $data['percent_intellect'] . "',
	'" . $data['percent_spirit'] . "',
	'" . $data['nomod_attackpower'] . "',
	'" . $data['percent_attackpower'] . "',
	'" . $data['nomod_armor'] . "',
	'" . $data['percent_armor'] . "',
	'" . $data['nomod_dodge'] . "',
	'" . $data['nomod_parry'] . "',
	'" . $data['hit'] . "',
	'" . $data['nomod_crit'] . "',
	'" . $data['nomod_damage_min'] . "',
	'" . $data['nomod_damage_max'] . "',
	'" . $data['percent_damage_min'] . "',
	'" . $data['percent_damage_max'] . "',
	'" . $data['nomod_ranged_damage_min'] . "',
	'" . $data['nomod_ranged_damage_max'] . "',
	'" . $data['percent_ranged_damage_min'] . "',
	'" . $data['percent_ranged_damage_max'] . "',
	'" . $data['nomod_heal_min'] . "',
	'" . $data['nomod_heal_max'] . "',
	'" . $data['percent_heal_min'] . "',
	'" . $data['percent_heal_max'] . "',
	'" . $data['life_leech'] . "',
	'" . $data['mana_leech'] . "',
	'" . $data['level_modifier'] . "',
	'" . $data['level_modifier_max'] . "',
	'" . $data['data1'] . "',
	'" . $data['data2'] . "')";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function edit_item_admin($data)
    {
        $sql = "UPDATE hero_items
	SET name = " . $this->db->escape($data['name']) . ",
	icon = " . $this->db->escape($data['icon']) . ",
	quality = '" . $data['quality'] . "',
	itemlevel = '" . $data['itemlevel'] . "',
	stack = '" . $data['stack'] . "',
	type = '" . $data['type'] . "',
	subtype = '" . $data['subtype'] . "',
	subsubtype = '" . $data['subsubtype'] . "',
	sell_price = '" . $data['sell_price'] . "',
	buy_price = '" . $data['buy_price'] . "',
	text = " . $this->db->escape($data['text']) . ",
	soulbound = '" . $data['soulbound'] . "',
	spell = '" . $data['spell'] . "',
	proc = '" . $data['proc'] . "',
	req_level = '" . $data['req_level'] . "',
	req_class = '" . $data['req_class'] . "',
	nomod_max_health = '" . $data['nomod_max_health'] . "',
	nomod_max_mana = '" . $data['nomod_max_mana'] . "',
	percent_max_health = '" . $data['percent_max_health'] . "',
	percent_max_mana = '" . $data['percent_max_mana'] . "',
	nomod_agility = '" . $data['nomod_agility'] . "',
	nomod_strength = '" . $data['nomod_strength'] . "',
	nomod_stamina = '" . $data['nomod_stamina'] . "',
	nomod_intellect = '" . $data['nomod_intellect'] . "',
	nomod_spirit = '" . $data['nomod_spirit'] . "',
	percent_agility = '" . $data['percent_agility'] . "',
	percent_strength = '" . $data['percent_strength'] . "',
	percent_Stamina = '" . $data['percent_stamina'] . "',
	percent_intellect = '" . $data['percent_intellect'] . "',
	percent_spirit = '" . $data['percent_spirit'] . "',
	nomod_attackpower = '" . $data['nomod_attackpower'] . "',
	percent_attackpower = '" . $data['percent_attackpower'] . "',
	nomod_armor = '" . $data['nomod_armor'] . "',
	percent_armor = '" . $data['percent_armor'] . "',
	nomod_dodge = '" . $data['nomod_dodge'] . "',
	nomod_parry = '" . $data['nomod_parry'] . "',
	hit = '" . $data['hit'] . "',
	nomod_Crit = '" . $data['nomod_crit'] . "',
	nomod_damage_min = '" . $data['nomod_damage_min'] . "',
	nomod_damage_max = '" . $data['nomod_damage_max'] . "',
	percent_damage_min = '" . $data['percent_damage_min'] . "',
	percent_damage_max = '" . $data['percent_damage_max'] . "',
	nomod_ranged_damage_min = '" . $data['nomod_ranged_damage_min'] . "',
	nomod_ranged_damage_max = '" . $data['nomod_ranged_damage_max'] . "',
	percent_ranged_damage_min = '" . $data['percent_ranged_damage_min'] . "',
	percent_ranged_damage_max = '" . $data['percent_ranged_damage_max'] . "',
	nomod_heal_min = '" . $data['nomod_heal_min'] . "',
	nomod_heal_max = '" . $data['nomod_heal_max'] . "',
	percent_heal_min = '" . $data['percent_heal_min'] . "',
	percent_heal_max = '" . $data['percent_heal_max'] . "',
	life_leech = '" . $data['life_leech'] . "',
	mana_leech = '" . $data['mana_leech'] . "',
	level_modifier = '" . $data['level_modifier'] . "',
	level_modifier_max = '" . $data['level_modifier_max'] . "',
	data1 = '" . $data['data1'] . "',
	data2 = '" . $data['data2'] . "'
	WHERE id = '" . $data['id'] . "'";

        $this->db->query($sql);

        $this->_create_sql($sql);
    }

    public function get_item_admin($id)
    {
        $sql = "SELECT * FROM hero_items WHERE id = ?";

        $q = $this->db->query($sql, array($id));

        if ($q->num_rows()) {
            return $q->row_array();
        }

        return false;
    }

    public function all_items_admin()
    {
        $sql = "SELECT * FROM hero_items";

        $q = $this->db->query($sql);

        if ($q->num_rows()) {
            return $q->result_array();
        }

        return false;
    }

    public function all_items_drop_admin()
    {
        $sql = "SELECT * FROM hero_items";

        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            return false;
        }

        $res = $q->result_array();

        foreach ($res as $row) {
            $data[$row['id']] = $row['name'];
        }

        if (!isset($data)) {
            return false;
        }

        return $data;
    }

    public function get_class_item_templates($classid)
    {
        $sql = "SELECT * FROM hero_inventory_templates WHERE classid = ?";
    
        $q = $this->db->query($sql, array($classid));

        if ($q->num_rows()) {
            return $q->result_array();
        }

        return false;
    }
}
//nowhitesp
