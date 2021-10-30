<?php

class Sql_model extends MO_Model
{
  function __construct()
  {
    parent::__construct();
  }

  //updates the db version, to current time, only used when saving a change as sql which already in db
  //like changes from phpmyadmin
  //dummy function to call the inherited _update_db_version($time);
  function update_db_version($time)
  {
    $this->_update_db_version($time);
  }

  //dummy function which uses inherited _create_sql($sql);
  function create_sql($sql)
  {
    $this->_create_sql($sql);
  }

  function get_db_version()
  {
    $sql = "SELECT version FROM db_version WHERE id='1'";

    $q = $this->db->query($sql);

    $res = $q->row_array();

    return $res['version'];
  }

  function get_appliable_files()
  {
    $this->load->helper('file');
    //$full_list = get_filenames('./sql');
    
    $this->load->helper('directory');
    $full_list = directory_map('./sql', 1);

    //get out the full db dumps
    foreach ($full_list as $row)
    {
      if (substr_compare($row, 'db', 0, 2, TRUE) && substr_compare($row, 'map', 0, 3, TRUE) && 
      substr_compare($row, 'old', 0, 3, TRUE) && substr_compare($row, 'index', 0, 5, TRUE))
      {
        $list[] = $row;
      }
    }

    if (!isset($list))
      return 0;

    $ver = $this->get_db_version();

    foreach ($list as $row)
    {
      $l = explode('.', $row);

      if ($l[0] > $ver)
      {
        $data[] = $row;
      }
    }

    if (!isset($data))
      return 0;

    //getting the max
    $max = 0;

    foreach ($data as $row)
    {
      $l = explode('.', $row);

      if ($l[0] > $max)
      {
        $max = $l[0];
      }
    }

    $smallest = $max;
    $last_found = 0;

    $ordered[] = $max . ".sql";

    for ($i = 0; $i < (sizeof($data) - 1); $i++)
    {
      foreach ($data as $row)
      {
        $l = explode('.', $row);

        if (($l[0] < $smallest) && ($l[0] > $last_found))
        {
            $smallest = $l[0];
            $ord = $row;
        }
      }

      $last_found = $smallest;
      $smallest = $max;
      $ordered[$i] = $ord;
    }

    if (isset($ordered))
    {
      return $ordered;
    }
    else
    {
      return 0;
    }
		
  }

  function apply_all_sql()
  {
    $this->load->helper('file');

    $list = $this->get_appliable_files();

    if (!$list)
      return;

    for ($i = 0; $i < sizeof($list); $i++)
    {
      //reading file, then applying it to the db
      $loc = './sql/' . $list[$i];
      $sql = read_file($loc);
      
      var_dump($loc);

      $this->db->query($sql);

      //TODO check if error happened, then stop everything
      //check is not needed, it just throws the error
      
      //update db_version
      $ver = explode('.', $list[$i]);
      $sqlv = "UPDATE db_version SET version='" . $ver[0] . "' WHERE id='1'";
      $this->db->query($sqlv);
    }
  }

}
//nowhitesp
