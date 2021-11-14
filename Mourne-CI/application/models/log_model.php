<?php
class Log_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function delete_combat_log($id, $villageid)
    {
        $sql = "SELECT * FROM combat_logs WHERE id='$id'";

        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            return;
        }

        $res = $q->row_array();

        if ($res['villageid'] != $villageid) {
            return;
        }

        $sql = "DELETE FROM combat_logs WHERE id='$id'";

        $this->db->query($sql);
    }

    public function get_combat_log($id, $villageid)
    {
        $sql = "SELECT * FROM combat_logs WHERE id='$id'";

        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            return false;
        }

        $res = $q->row_array();
        
        if ($res['villageid'] != $villageid) {
            return false;
        }

        if ($res['new']) {
            $sql = "UPDATE combat_logs SET new='0' WHERE id='$id'";
            $this->db->query($sql);
        }

        return $res;
    }
    
    public function get_combat_logs($villageid)
    {
        $sql = "SELECT * FROM combat_logs WHERE villageid='$villageid' ORDER BY time DESC";

        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            return false;
        }

        $res = $q->result_array();

        $new = false;
        foreach ($res as $row) {
            if ($row['new']) {
                $new = true;
                break;
            }
        }

        if (!$new) {
            $sql = "UPDATE villages SET new_log='0' WHERE id='$villageid'";

            $this->db->query($sql);
        }

        return $res;
    }
}
//nowhitesp
