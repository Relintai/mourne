<?php

class News_model extends MO_Model
{

  function get_news($page)
  {
    $p = ($page - 1) * 5;

    $sql = "SELECT * FROM news LIMIT $p, 5";

    $q = $this->db->query($sql);

    return $q->result_array();
  }

  function add_news($text, $uname)
  {
    $sql = "INSERT INTO news VALUES(default, '$uname', '$text')";
		
    return $this->db->query($sql);
  }

  function del_news($id)
  {
    $sql = "";
    return $this->db->query($sql);
  }

}

//nowhitesp
