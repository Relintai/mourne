<?php
class Image_model extends MO_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function apply_menu_images($data)
    {
        $path = './img/generated/';

        $this->load->library('image_lib');

        if ($data['apply_all']) {
            $this->prepare_dir('menu', $data['file'], $data['menu_group']);
        } else {
            $this->prepare_dir('menu', $data['file'], false, $data['wm_text']);
        }

    
        if (!$data['apply_all']) {
            $data['source_image'] = $path . $data['wm_text'] . '.png';

            $this->image_lib->initialize($data);

            $this->image_lib->watermark();

            return;
        }

        //apply all is set
        $menu_list = $this->get_menu_list($data['menu_group']);
        $menu_file_list = $this->get_menu_file_list($data['menu_group']);

        for ($i = 0; $i < sizeof($menu_list); $i++) {
            $data['source_image'] = $path . $menu_file_list[$i] . '.png';
            $data['wm_text'] = $menu_list[$i];

            $this->image_lib->initialize($data);
            $this->image_lib->watermark();
            $this->image_lib->clear();
        }
    }

    public function prepare_dir($for, $sourcefile, $group = 1, $filename = false)
    {
        $path = './img/generated/';
        $source = './img/imggen/' . $sourcefile;

        $this->load->helper('file');

        delete_files($path, false);

        if ($for == 'menu') {
            $img = read_file($source);

            if (!$filename) {
                $menu_list = $this->get_menu_file_list($group);

                foreach ($menu_list as $row) {
                    $file = $path . $row . '.png';

                    write_file($file, $img);
                }
            } else {
                $file = $path . $filename . '.png';

                write_file($file, $img);
            }
        }
    }

    public function get_menu_list($group = 1)
    {
        if ($group == 1) {
            //select village vill be omitted since it will need a different style button with a ˇ
            $data[] = 'News';
            $data[] = 'Village';
            $data[] = 'Select Village';
            $data[] = 'Forum';
            $data[] = 'Changelog';
            $data[] = 'Settings';
            $data[] = 'Logout';
            $data[] = 'Forum Mod Panel';
            $data[] = 'GM Panel';
            $data[] = 'Admin Panel';
        }
        
        if ($group == 2) {
            $data[] = 'Stats';
        }

        return $data;
    }

    public function get_menu_file_list($group = 1)
    {
        if ($group == 1) {
            //select village vill be omitted since it will need a different style button with a ˇ
            $data[] = 'news';
            $data[] = 'village';
            $data[] = 'select_village';
            $data[] = 'forum';
            $data[] = 'changelog';
            $data[] = 'settings';
            $data[] = 'logout';
            $data[] = 'forum_mod_panel';
            $data[] = 'gm_panel';
            $data[] = 'admin_panel';
        }
        
        if ($group == 2) {
            $data[] = 'stats';
        }

        return $data;
    }

    public function get_menu_group_list_drop()
    {
        $data = array(
      '1' => 'main',
      '2' => 'alt1');

        return $data;
    }

    public function apply_slot_images($data)
    {
        $path = './img/generated/';

        $this->load->library('image_lib');

        $this->prepare_dir('menu', $data['file'], false, 'gen');

        $data['source_image'] = $path . 'gen.png';

        $this->image_lib->initialize($data);
        $this->image_lib->watermark();
        $this->image_lib->clear();

        $data['wm_type'] = 'text';
        $data['wm_text'] = $data['rank_text'];
        $data['wm_font_size'] = $data['rank_font_size'];
        $data['wm_vrt_alignment'] = $data['rank_v_align'];
        $data['wm_hor_alignment'] = $data['rank_h_align'];
        $data['wm_hor_offset'] = $data['rank_h_offset'];
        $data['wm_vrt_offset'] = $data['rank_v_offset'];
        $data['padding'] = $data['rank_padding'];

        $this->image_lib->initialize($data);
        $this->image_lib->watermark();
    }

    public function get_file_list_drop()
    {
        $this->load->helper('directory');

        $dir = directory_map('./img/imggen/', 1);

        foreach ($dir as $row) {
            $a = explode('.', $row);
            if (isset($a[1])) {
                if ($a[1] == 'png' || $a[1] == 'PNG') {
                    $data[$row] = $row;
                }
            }
        }

        return $data;
    }

    public function get_font_list_drop()
    {
        $this->load->helper('directory');

        $dir = directory_map('./system/fonts', 1);

        foreach ($dir as $row) {
            $a = explode('.', $row);

            if ($a[1] == 'ttf' || $a['1'] == 'TTF') {
                $data[$row] = $row;
            }
        }

        return $data;
    }

    public function get_v_align_drop()
    {
        $data = array(
      'top' => 'top',
      'middle' => 'middle',
      'bottom' => 'bottom');

        return $data;
    }

    public function get_h_align_drop()
    {
        $data = array(
      'left' => 'left',
      'center' => 'center',
      'right' => 'right');

        return $data;
    }
    
    public function get_overlay_list_drop()
    {
        $this->load->helper('directory');

        $dir = directory_map('./img/imggen/overlay/', 1);

        foreach ($dir as $row) {
            $data[$row] = $row;
        }

        return $data;
    }

    public function save_menu_data($data)
    {
        $a = 'type : ' . $data['wm_type'] . "\n";
        $a .= 'quality: ' . $data['quality'] . "\n";
        $a .= 'file: ' . $data['file'] . "\n";
        $a .= 'padding: ' . $data['padding'] . "\n";
        $a .= 'vert alignment: ' . $data['wm_vrt_alignment'] . "\n";
        $a .= 'hor alignment: ' . $data['wm_hor_alignment'] . "\n";
        $a .= 'hor offset: ' . $data['wm_hor_offset'] . "\n";
        $a .= 'vert offset: ' . $data['wm_vrt_offset'] . "\n";
        $a .= 'text: ' . $data['wm_text'] . "\n";
        $a .= 'font path: ' . $data['wm_font_path'] . "\n";
        $a .= 'font size: ' . $data['wm_font_size'] . "\n";
        $a .= 'font color: ' . $data['wm_font_color'] . "\n";
        $a .= 'shadow color: ' . $data['wm_shadow_color'] . "\n";
        $a .= 'shadow_distance: ' . $data['wm_shadow_distance'] . "\n";
        $a .= 'apply all: ' . $data['apply_all'] . "\n";
        $a .= 'Menu Group: ' . $data['menu_group'] . "\n";

        $this->load->helper('file');

        write_file('./img/generated/settings.txt', $a);
    }

    public function save_slot_data($data)
    {
        $a = 'type : ' . $data['wm_type'] . "\n";
        $a .= 'quality: ' . $data['quality'] . "\n";
        $a .= 'file: ' . $data['file'] . "\n";
        $a .= 'padding: ' . $data['padding'] . "\n";
        $a .= 'vert alignment: ' . $data['wm_vrt_alignment'] . "\n";
        $a .= 'hor alignment: ' . $data['wm_hor_alignment'] . "\n";
        $a .= 'hor offset: ' . $data['wm_hor_offset'] . "\n";
        $a .= 'vert offset: ' . $data['wm_vrt_offset'] . "\n";
        $a .= 'text: ' . $data['wm_text'] . "\n";
        $a .= 'font path: ' . $data['wm_font_path'] . "\n";
        $a .= 'font size: ' . $data['wm_font_size'] . "\n";
        $a .= 'font color: ' . $data['wm_font_color'] . "\n";
        $a .= 'shadow color: ' . $data['wm_shadow_color'] . "\n";
        $a .= 'shadow_distance: ' . $data['wm_shadow_distance'] . "\n";
        $a .= '------------------------image---------------------------' . "\n";
        $a .= 'overlay image: ' . $data['wm_overlay_path'] . "\n";
        $a .= 'opacity: ' . $data['wm_opacity'] . "\n";
        $a .= 'x transp: ' . $data['wm_x_transp'] . "\n";
        $a .= 'y transp: ' . $data['wm_y_transp'] . "\n";
        $a .= '------------------------rank----------------------------' . "\n";
        $a .= 'text: ' . $data['rank_text'] . "\n";
        $a .= 'font size: ' . $data['rank_font_size'] . "\n";
        $a .= 'V align: ' . $data['rank_v_align'] . "\n";
        $a .= 'H align: ' . $data['rank_h_align'] . "\n";
        $a .= 'H offset: ' . $data['rank_h_offset'] . "\n";
        $a .= 'V offset: ' . $data['rank_v_offset'] . "\n";
        $a .= 'padding: ' . $data['rank_padding'] . "\n";

        $this->load->helper('file');

        write_file('./img/generated/settings.txt', $a);
    }
}
//nowhitesp
