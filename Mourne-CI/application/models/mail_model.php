<?php

class Mail_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save_draft($data, $userid)
    {
        //values id, userid, friend, name, X, Y, time, subject, body
        $sql = "INSERT INTO mail_drafts 
		VALUES(default, '$userid', ?, ?, ?, ?, '" . time() . "', ?, ?)";

        //friend, name, X, Y, subject, body
        $this->db->query($sql, array(0, $data['name'], 0, 0, $data['subject'], $data['message']));
    }

    public function get_drafts($userid)
    {
        $sql = "SELECT * FROM mail_drafts WHERE userid='$userid'";

        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            return false;
        }

        return $q->result_array();
    }

    public function get_draft($id, $userid)
    {
        $sql = "SELECT * FROM mail_drafts WHERE id = ?";

        $q = $this->db->query($sql, array($id));

        if (!$q->num_rows()) {
            return false;
        }

        $res = $q->row_array();

        if ($res['userid'] != $userid) {
            return false;
        }

        return $res;
    }

    public function delete_draft($id, $userid)
    {
        $sql = "DELETE FROM mail_drafts WHERE id = ? AND userid = ?";

        $this->db->query($sql, array($id, $userid));
    }

    public function get_inbox($userid, $new)
    {
        $sql = "SELECT mails.*,users.username FROM mails
		LEFT JOIN users on mails.sender=users.id
		WHERE owner='$userid'
		ORDER BY time DESC";

        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            return false;
        }

        $res = $q->result_array();

        if (!$new) {
            return $res;
        }

        $found = false;
        foreach ($res as $row) {
            if ($row['new']) {
                $found = true;
                break;
            }
        }

        if ($found) {
            return $res;
        }

        $sql = "UPDATE users SET new_mail='0' WHERE id='$userid'";

        $this->db->query($sql);

        return $res;
    }

    public function send_message($data, $userid)
    {
        $sql = "SELECT * FROM users WHERE username = ?";

        $q = $this->db->query($sql, array($data['name']));

        if (!$q->num_rows()) {
            return;
        }

        $res = $q->row_array();

        $data['subject'] = htmlspecialchars($data['subject'], ENT_HTML5, 'UTF-8');

        if (strlen($data['subject']) >= 45) {
            $data['subject'] = (substr($data['subject'], 0, 45) . '...');
        }

        //determining line endings
        $w = substr_count($data['message'], "\r\n");

        if ($w) {
            $exp = "\r\n";
        } else {
            $exp = "\n";
        }

        $message = explode($exp, $data['message']);

        if ($message) {
            $d = "";
            foreach ($message as $row) {
                if (strlen($row) > 70) {
                    //split into multiple lines
                    for ($i = 0; $i <= (floor(strlen($row) / 70)); $i++) {
                        $sub = substr($row, (0 + ($i * 70)), 70);

                        $d .= $sub;

                        if (strlen($sub) == 70) {
                            $d .= "«";
                        }

                        $d .= "\r\n";
                    }
                } else {
                    $d .= $row . "\r\n";
                }
            }

            $data['message'] = $d;
        }

        $data['message'] = htmlspecialchars($data['message'], ENT_HTML5, 'UTF-8');

        $breaks = array("\r\n", "\n");
        $text = str_ireplace($breaks, "<br />", $data['message']);

        $sql = "INSERT INTO mails VALUES(default, 
		'" . $res['id'] . "', '$userid', '" . time() . "', ?, ?, '1')";

        $this->db->query($sql, array($data['subject'], $text));

        $sql = "UPDATE users SET new_mail='1' WHERE id='" . $res['id'] . "'";

        $this->db->query($sql);

        //saving mail to sent
        //id, userid, to_id, to, time, subject, body
        $sql = "INSERT INTO mail_sent VALUES(default, ?, ?, ?, " . time(). ", ?, ?)";

        $sent = array($userid, $res['id'], $res['username'], $data['subject'], $data['message']);

        $this->db->query($sql, $sent);
    }

    public function get_mail($id, $userid, $edit = false)
    {
        //querying userid here, so if the user types a random id into the browser bar, it won't return anything
        $sql = "SELECT mails.*,users.username FROM mails 
		LEFT JOIN users ON mails.sender=users.id
		WHERE mails.id = ? AND mails.owner = ?";

        $q = $this->db->query($sql, array($id, $userid));

        if (!$q->num_rows()) {
            return false;
        }

        $res = $q->row_array();

        if ($res['new']) {
            //userid is correct we can query with just the id
            $sql = "UPDATE mails SET new='0' WHERE id = ?";

            $this->db->query($sql, array($id));
        }

        if ($edit) {
            //just in case
            $breaks = array("<br />","<br>","<br/>");

            $data['body'] = str_ireplace($breaks, "\r\n", $data['body']);

            $data['body'] = htmlspecialchars_decode($data['body'], ENT_HTML5, 'UTF-8');
            $data['subject'] = htmlspecialchars_decode($data['subject'], ENT_HTML5, 'UTF-8');
        }

        return $res;
    }

    public function get_sent($id, $userid)
    {
        //querying userid here, so if the user types a random id into the browser bar, it won't return anything
        $sql = "SELECT * FROM mail_sent WHERE id = ? AND userid = ?";

        $q = $this->db->query($sql, array($id, $userid));

        if (!$q->num_rows()) {
            return false;
        }

        return $q->row_array();
    }


    public function get_all_sent($userid)
    {
        $sql = "SELECT * FROM mail_sent WHERE userid = ?";

        $q = $this->db->query($sql, array($userid));

        if (!$q->num_rows()) {
            return false;
        }

        return $q->result_array();
    }
}
//nowhitesp
