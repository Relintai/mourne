<?php

class User_model extends MO_Model
{
  function __construct()
  {
    parent::__construct();
  }
	
  function login_check($data)
  {
    $sql = "SELECT passkey FROM users WHERE username=" . $this->db->escape($data['username']);

    $q = $this->db->query($sql);

    if ($q->num_rows > 0)
    {
      $row = $q->row_array();

      if ($row['passkey'] == $data['password'])
      {
	return TRUE;
      }
      else
      {
	return FALSE;
      }
    }
    else
    {
      return FALSE;
    }
  }

  function get_userid($username)
  {
    $sql = "SELECT id FROM users WHERE username=" . $this->db->escape($username);
    $q = $this->db->query($sql);
    $res = $q->row_array();

    return $res['id'];
  }

  function reg_username_check($uname)
  {
    $sql = "SELECT username FROM users WHERE username=" . $this->db->escape($uname);

    $q = $this->db->query($sql);
		
    if ($q->num_rows() == 0)
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }
  }

  function reg_write($data)
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
