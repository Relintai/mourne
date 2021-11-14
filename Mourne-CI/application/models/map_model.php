<?php

class Map_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_village_by_name($name)
    {
        $sql = "SELECT id FROM villages WHERE name LIKE '%" . $name . "%'";

        $q = $this->db->query($sql);

        if (!$q->num_rows()) {
            return false;
        }

        $res = $q->row_array();

        return $this->get_village_coords($res['id']);
    }

    public function get_village_coords($vid)
    {
        $sql = "SELECT * FROM map WHERE type='3' AND villageid='$vid'";
        $q = $this->db->query($sql);

        return $q->row_array();
    }

    public function get_map($x, $y)
    {
        if ($x < 7) {
            $x = 7;
        }

        if ($y < 7) {
            $y = 7;
        }

        if ($x > 235) {
            $x = 235;
        }

        if ($y > 235) {
            $y = 235;
        }

        $minx = $x - 6;
        $maxx = $x + 6;
        $miny = $y - 6;
        $maxy = $y + 6;

        //< at max so it gets 12 rows and cols
        $sql = "SELECT map.*,ai_villages.name AS ai_name,villages.name FROM map
			LEFT JOIN ai_villages ON map.villageid=ai_villages.id AND map.type='4'
			LEFT JOIN villages ON map.villageid=villages.id AND map.type='3'
			WHERE ((map.X >= '$minx') AND (map.X < '$maxx')
			AND (map.Y >= '$miny') AND (map.Y < '$maxy'))";

        $q = $this->db->query($sql);

        $res =  $q->result_array();

        //preprocess it, so view only have to do a foreach
        for ($sy = $miny; $sy < ($miny + 12); $sy++) {
            for ($sx = $minx; $sx < ($minx + 12); $sx++) {
                foreach ($res as $row) {
                    if (($row['X'] == $sx) && ($row['Y'] == $sy)) {
                        $data[] = $row;
                        break;
                    }
                }
            }
        }

        return $data;
    }

    public function get_map_list_admin()
    {
        $this->load->helper('directory');

        $map = directory_map('./sql/map/', 1);

        foreach ($map as $row) {
            $a = explode('.', $row);

            if (isset($a[1])) {
                if ($a[1] == 'sql') {
                    $data[] = $row;
                }
            }
        }
       
        if (isset($data)) {
            return $data;
        } else {
            return false;
        }
    }

    public function generate_map_admin()
    {
        //process ai village names (in different table) here
        //they will be saved into a different file until everything here works correctly
        //add .!
        $a = "DROP TABLE IF EXISTS ai_villages; \n";

        //create table
        $a .= "CREATE TABLE IF NOT EXISTS `ai_villages` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` text NOT NULL,
			  `attacked` tinyint(4) NOT NULL,
			  `X` int(11) NOT NULL,
			  `Y` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

        $i = 1;
        for ($x = 1; $x <= 240; $x++) {
            for ($y = 1; $y <= 240; $y++) {
                //if ai village space
                if (!((($x + 24) % 48) || (($y + 24) % 48))) {
                    $name = $this->_rand_ai_name();
                    
                    $a .= "INSERT INTO ai_villages 
						VALUES('$i', '$name', '0', '$x', '$y'); \n";

                    $i++;
                }
            }
        }

        $a .= "DROP TABLE IF EXISTS map; \n";

        $a .= "CREATE TABLE IF NOT EXISTS `map` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`X` int(11) NOT NULL,
				`Y` int(11) NOT NULL,
				`type` tinyint(4) NOT NULL,
				`villageid` int(11) NOT NULL,
				PRIMARY KEY (`id`),
				KEY `X` (`X`,`Y`,`type`,`villageid`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

        $a .= "\n";

        $sql = "SELECT * FROM villages";
        $q = $this->db->query($sql);
        $villages = $q->result_array();

        if ($villages) {
            foreach ($villages as $row) {
                $found = false;

                while (!$found) {
                    $vx = mt_rand(1, 240);
                    $vy = mt_rand(1, 240);

                    if (((($vx + 24) % 48) && (($vy + 24) % 48))) {
                        //not in ai space
                        $vdata[] = array(
          'id' => $row['id'],
          'x' => $vx,
          'y' => $vy);

                        $found = true;
                    }
                }
            }
        } else {
            $vdata = false;
        }

        $villageid = 0;
        $ai = 1;
        $found = false;

        $i = 1;
        for ($x = 1; $x <= 240; $x++) {
            for ($y = 1; $y <= 240; $y++) {
                //if not ai village space
                if (((($x + 24) % 48) || (($y + 24) % 48))) {
                    if ($vdata) {
                        foreach ($vdata as $row) {
                            if ($row['x'] == $x && $row['y'] == $y) {
                                $villageid = $row['id'];
                                $type = 3;
                                $found = true;
                            }
                        }
                    }

                    if (!$found) {
                        //check for village here, dont let this run when true
                        $r = rand(0, 100);
                        if ($r < 70) {
                            $type = 0;
                        } elseif ($r >= 70 && $r < 85) {
                            $type = 1;
                        } else {
                            $type = 2;
                        }
                    }
                    
                    $found = false;
                } else {
                    //ai village space
                    $type = 4;
                    $villageid = $ai;
                    $ai++;
                }

                $a .= "INSERT INTO map VALUES('$i', '$x', '$y', '$type', '$villageid');\n";
                $villageid = 0;
                $i++;
            }
        }

        $this->load->helper('file');

        $f = './sql/map/map' . time() . '.sql';

        write_file($f, $a);
    }

    public function apply_map_admin($file)
    {
        $this->load->helper('file');

        $f = readfile(('./sql/map/' . $file));

        $sql = explode(';', $f);

        foreach ($sql as $row) {
            $this->db->query($row);
        }
    }

    public function _rand_ai_name()
    {
        //they are in keyboard order from left to right, and top to bottom

        //21 entries
        $a = array('q', 'w', 'r', 't', 'z', 'p', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'y', 'x',
           'c', 'v', 'b', 'n', 'm');

        //5 entries
        $b = array('e', 'u', 'i', 'o', 'a');

        //ai village names should be between 4-6 chars
        $length = rand(4, 6);

        $str = '';
        for ($i = 1; $i <= $length; $i++) {
            //start with $a
            if ($i % 2) {
                if ($i == 1) {
                    $str .= strtoupper($a[mt_rand(0, 20)]);
                } else {
                    $str .= $a[mt_rand(0, 20)];
                }
            } else {
                $str .= $b[mt_rand(0, 4)];
            }
        }

        return $str;
    }
}
//nowhitesp
