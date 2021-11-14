<?php

class Changelog_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function new_version($version)
    {
        $time = time();

        $sql = "INSERT INTO changelog_versions VALUES(default, '$version', '$time')";
        $this->db->query($sql);
        $this->_create_sql($sql);
    }

    public function new_commit($text)
    {
        $time = time();

        $sql = "SELECT id FROM changelog_versions ORDER BY id DESC LIMIT 1";
        $q = $this->db->query($sql);
        $res = $q->row_array();
        $versionid = $res['id'];

        $sql = "INSERT INTO changelog_commits VALUES(default, '$versionid', '$text', '$time')";
        $this->db->query($sql);
        $this->_create_sql($sql);
    }

    public function get_versions()
    {
        $sql = "SELECT * FROM changelog_versions ORDER BY timestamp DESC";
        $q = $this->db->query($sql);


        return $q->result_array();
    }

    public function get_commits()
    {
        $sql = "SELECT * FROM changelog_commits ORDER BY timestamp DESC";
        $q = $this->db->query($sql);


        return $q->result_array();
    }
}

//nowhitesp
