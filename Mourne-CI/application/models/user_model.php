<?php

class User_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function login_check($data)
    {
        $sql = "SELECT passkey FROM users WHERE username=" . $this->db->escape($data['username']);

        $q = $this->db->query($sql);

        if ($q->num_rows > 0) {
            $row = $q->row_array();

            if ($row['passkey'] == $data['password']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_userid($username)
    {
        $sql = "SELECT id FROM users WHERE username=" . $this->db->escape($username);
        $q = $this->db->query($sql);
        $res = $q->row_array();

        return $res['id'];
    }

    public function reg_username_check($uname)
    {
        $sql = "SELECT username FROM users WHERE username=" . $this->db->escape($uname);

        $q = $this->db->query($sql);
        
        if ($q->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function reg_write($data)
    {
        $sql = "INSERT INTO users VALUES(default, "
      . $this->db->escape($data['username']) . ", '"
      . $data['password'] . "', '"
      . $data['email'] . "',
	default, default, default)";


        return $this->db->query($sql);
    }
}
//nowhitesp
