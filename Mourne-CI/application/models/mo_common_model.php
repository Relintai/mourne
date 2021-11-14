<?php

class Mo_common_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get_hero_data($userid)
    {
        $sql = "SELECT * FROM heroes WHERE userid = ? AND selected = '1'";

        $q = $this->db->query($sql, array($userid));

        if (!$q->num_rows()) {
            return false;
        }

        return $q->row_array();
    }

    public function get_userlevel($uid)
    {
        $sql = "SELECT userlevel FROM users WHERE id=$uid";
        
        $q = $this->db->query($sql);

        $res = $q->row_array();
        
        return $res['userlevel'];
    }

    public function get_username($uid)
    {
        $sql = "SELECT username FROM users WHERE id=$uid";

        $q = $this->db->query($sql);

        $res = $q->row_array();

        return $res['username'];
    }

    public function get_userdata($id)
    {
        $sql = "SELECT * FROM users WHERE id='$id'";
        $q = $this->db->query($sql);

        return $q->row_array();
    }

    public function get_villageid($userid)
    {
        $sql = "SELECT id FROM villages WHERE userid='$userid' AND selected='1'";
        $q = $this->db->query($sql);
        $res = $q->row_array();

        return $res['id'];
    }

    public function get_village_data($uid)
    {
        $sql = "SELECT * FROM villages WHERE userid='$uid' AND selected='1'";
        $q = $this->db->query($sql);
        return $q->row_array();
    }
}

//nowhitesp
