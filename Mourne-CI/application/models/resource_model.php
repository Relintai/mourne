<?php
class Resource_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //calculates how much unit can be created with the available resources
    //since where this is called I  display resources, its passed from there
    public function calc_max_unit($unit, $max_num, $res)
    {
        for ($i = 1; $i <= $max_num; $i++) {
            $res['food'] -= $unit['cost_food'];
            $res['wood'] -= $unit['cost_wood'];
            $res['stone'] -= $unit['cost_stone'];
            $res['iron'] -= $unit['cost_iron'];
            $res['mana'] -= $unit['cost_mana'];

            //not sure if this is needed
            if ($res['food'] < 0 && $res['wood'] < 0 &&
      $res['stone'] < 0 && $res['iron'] < 0 &&
      $res['mana'] < 0) {
                return ($i - 1);
            }
            

            if ($res['food'] < 0 || $res['wood'] < 0 ||
      $res['stone'] < 0 || $res['iron'] < 0 ||
      $res['mana'] < 0) {
                return ($i - 1);
            }
        }

        return $max_num;
    }


    public function have_enough_resources_building($buildingid, $villageid)
    {
        $res = $this->get_resources($villageid);

        $sql = "SELECT * FROM buildings WHERE id='$buildingid'";
        $q = $this->db->query($sql);
        $building = $q->row_array();

        if ($res['food'] >= $building['cost_food'] &&
    $res['wood'] >= $building['cost_wood'] &&
    $res['stone'] >= $building['cost_stone'] &&
    $res['iron'] >= $building['cost_iron'] &&
    $res['mana'] >= $building['cost_mana']) {
            return true;
        }

        return false;
    }
}
//nowhitesp
