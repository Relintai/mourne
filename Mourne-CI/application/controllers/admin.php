<?php
class Admin extends MO_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function admin_panel()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->headers('admin');
        $this->load->view('admin/panel.php');
        $this->footer();
    }

    public function building_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('building_model');

        $data['buildings'] = $this->building_model->list_buildings_admin();

        $this->headers('admin');
        $this->load->view('admin/building_tool/list.php', $data);
        $this->footer();
    }

    public function building($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('building_model');
        $this->load->model('unit_model');
        $this->load->model('assignment_model');
        $this->load->model('technology_model');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'alphanumeric');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
        $this->form_validation->set_rules('rank', 'Rank', 'integer');
        $data['nextr'] = $this->input->post('next_rank'); //has to be done like this :(
        $data['optnr'] = $this->building_model->get_building_ranks_admin();

        $this->form_validation->set_rules('time_to_build', 'Time to Build', 'integer');

        //creates
        $data['screate'] = $this->input->post('creates');
        $data['optcre'] = $this->unit_model->get_unit_list_dropdown_admin();

        $this->form_validation->set_rules('num_creates', 'Num Creates', 'integer');

        $this->form_validation->set_rules('score', 'Score', 'integer');
        $this->form_validation->set_rules('defense', 'Defense', 'integer');

        $data['sability'] = $this->input->post('ability');

        $this->form_validation->set_rules('cost_food', 'cost_food', 'integer');
        $this->form_validation->set_rules('cost_wood', 'cost_wood', 'integer');
        $this->form_validation->set_rules('cost_stone', 'cost_stone', 'integer');
        $this->form_validation->set_rules('cost_iron', 'cost_iron', 'integer');
        $this->form_validation->set_rules('cost_mana', 'cost_mana', 'integer');

        $this->form_validation->set_rules('mod_max_food', 'Mod Max Food', 'integer');
        $this->form_validation->set_rules('mod_max_wood', 'Mod Max Wood', 'integer');
        $this->form_validation->set_rules('mod_max_stone', 'Mod Max Stone', 'integer');
        $this->form_validation->set_rules('mod_max_iron', 'Mod Max Iron', 'integer');
        $this->form_validation->set_rules('mod_max_mana', 'Mod Max Mana', 'integer');

        $this->form_validation->set_rules('mod_rate_food', 'Mod Rate Food', 'numeric');
        $this->form_validation->set_rules('mod_rate_wood', 'Mod Rate Wood', 'numeric');
        $this->form_validation->set_rules('mod_rate_stone', 'Mod Rate Stone', 'numeric');
        $this->form_validation->set_rules('mod_rate_iron', 'Mod Rate Iron', 'numeric');
        $this->form_validation->set_rules('mod_rate_mana', 'Mod Rate Mana', 'numeric');

        $this->form_validation->set_rules('mod_percent_food', 'Mod Percent Food', 'integer');
        $this->form_validation->set_rules('mod_percent_wood', 'Mod Percent Wood', 'integer');
        $this->form_validation->set_rules('mod_percent_stone', 'Mod Percent Stone', 'integer');
        $this->form_validation->set_rules('mod_percent_iron', 'Mod Percent Iron', 'integer');
        $this->form_validation->set_rules('mod_percent_mana', 'Mod Percent Mana', 'integer');

        //assignments
        $data['optass'] = $this->assignment_model->get_assignment_list_drop_admin();
        $data['assign1'] = $this->input->post('assign1');
        $data['assign2'] = $this->input->post('assign2');
        $data['assign3'] = $this->input->post('assign3');
        $data['assign4'] = $this->input->post('assign4');
        $data['assign5'] = $this->input->post('assign5');

        $data['optreqtech'] = $this->technology_model->get_tech_list_drop_admin();
        $data['selreqtech'] = $this->input->post('req_tech');

        $data['opttechgroup'] = $this->technology_model->get_tech_group_list_drop_admin();

        $data['seltechgroup'] = $this->input->post('tech_group');
        $data['seltechsecgroup'] = $this->input->post('tech_secondary_group');

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                //making new
                $data['new'] = true;

                $this->load->view('admin/building_tool/building', $data);
            } else {
                //editing
                $data['new'] = false;

                $data['building'] = $this->building_model->get_building_admin($id);

                $this->load->view('admin/building_tool/building', $data);
            }

            $this->footer();
        } else {
            $data['id'] = $id;
            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['icon'] = $this->input->post('icon');
            $data['rank'] = $this->input->post('rank');
            $data['next_rank'] = $this->input->post('next_rank');
            $data['time_to_build'] = $this->input->post('time_to_build');

            $data['creates'] = $this->input->post('creates');
            $data['num_creates'] = $this->input->post('num_creates');

            $data['score'] = $this->input->post('score');
            $data['defense'] = $this->input->post('defense');
            $data['ability'] = $this->input->post('ability');

            $data['cost_food'] = $this->input->post('cost_food');
            $data['cost_wood'] = $this->input->post('cost_wood');
            $data['cost_stone'] = $this->input->post('cost_stone');
            $data['cost_iron'] = $this->input->post('cost_iron');
            $data['cost_mana'] = $this->input->post('cost_mana');

            $data['mod_max_food'] = $this->input->post('mod_max_food');
            $data['mod_max_wood'] = $this->input->post('mod_max_wood');
            $data['mod_max_stone'] = $this->input->post('mod_max_stone');
            $data['mod_max_iron'] = $this->input->post('mod_max_iron');
            $data['mod_max_mana'] = $this->input->post('mod_max_mana');

            $data['mod_rate_food'] = $this->input->post('mod_rate_food');
            $data['mod_rate_wood'] = $this->input->post('mod_rate_wood');
            $data['mod_rate_stone'] = $this->input->post('mod_rate_stone');
            $data['mod_rate_iron'] = $this->input->post('mod_rate_iron');
            $data['mod_rate_mana'] = $this->input->post('mod_rate_mana');

            $data['mod_percent_food'] = $this->input->post('mod_percent_food');
            $data['mod_percent_wood'] = $this->input->post('mod_percent_wood');
            $data['mod_percent_stone'] = $this->input->post('mod_percent_stone');
            $data['mod_percent_iron'] = $this->input->post('mod_percent_iron');
            $data['mod_percent_mana'] = $this->input->post('mod_percent_mana');

            $data['assignment1'] = $this->input->post('assign1');
            $data['assignment2'] = $this->input->post('assign2');
            $data['assignment3'] = $this->input->post('assign3');
            $data['assignment4'] = $this->input->post('assign4');
            $data['assignment5'] = $this->input->post('assign5');

            $data['req_tech'] = $this->input->post('req_tech');

            $data['tech_group'] = $this->input->post('tech_group');
            $data['tech_secondary_group'] = $this->input->post('tech_secondary_group');

            $this->load->model('building_model');

            if ($id == -1) {
                //making new
                $this->building_model->add_building_admin($data);
            } else {
                //editing
                $this->building_model->edit_building_admin($data);
            }

            $this->load->helper('url');

            redirect('admin/building_tool');
        }
    }

    //unit tool
    public function unit_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('unit_model');

        $data['units'] = $this->unit_model->list_units_admin();

        $this->headers('admin');
        $this->load->view('admin/unit_tool/list.php', $data);
        $this->footer();
    }

    public function unit($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('unit_model');
        $this->load->model('ai_model');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
        $this->form_validation->set_rules('type', 'Type', 'integer');

        $this->form_validation->set_rules('score', 'Score', 'integer');

        $data['scd'] = $this->input->post('can_defend');

        $this->form_validation->set_rules('defense', 'Type', 'numeric');
        $this->form_validation->set_rules('attack', 'Type', 'numeric');

        $data['sstrong'] = $this->input->post('strong_against');
        $data['sweak'] = $this->input->post('weak_against');

        $data['optaiu'] = $this->ai_model->get_unit_list_drop_admin();

        $this->form_validation->set_rules('turn', 'Turn', 'integer');
        $this->form_validation->set_rules('ability', 'Ability', 'integer');

        $this->form_validation->set_rules('time_to_create', 'Time to Create', 'integer');

        $data['costu'] = $this->input->post('cost_unit'); //has to be done like this :(
        $data['optu'] = $this->unit_model->get_unit_list_dropdown_admin();

        $this->form_validation->set_rules('cost_num_unit', 'Cost Number of Units', 'integer');

        $this->form_validation->set_rules('cost_food', 'cost_food', 'integer');
        $this->form_validation->set_rules('cost_wood', 'cost_wood', 'integer');
        $this->form_validation->set_rules('cost_stone', 'cost_stone', 'integer');
        $this->form_validation->set_rules('cost_iron', 'cost_iron', 'integer');
        $this->form_validation->set_rules('cost_mana', 'cost_mana', 'integer');

        $this->form_validation->set_rules('mod_rate_food', 'Mod Rate Food', 'numeric');
        $this->form_validation->set_rules('mod_rate_wood', 'Mod Rate Wood', 'numeric');
        $this->form_validation->set_rules('mod_rate_stone', 'Mod Rate Stone', 'numeric');
        $this->form_validation->set_rules('mod_rate_iron', 'Mod Rate Iron', 'numeric');
        $this->form_validation->set_rules('mod_rate_mana', 'Mod Rate Mana', 'numeric');

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                //making new
                $data['new'] = true;

                $this->load->view('admin/unit_tool/unit', $data);
            } else {
                //editing
                $data['new'] = false;

                $data['unit'] = $this->unit_model->get_unit_admin($id);

                $this->load->view('admin/unit_tool/unit', $data);
            }

            $this->footer();
        } else {
            $data['id'] = $id;
            $data['type'] = $this->input->post('type');
            $data['name'] = $this->input->post('name');
            $data['icon'] = $this->input->post('icon');
            $data['score'] = $this->input->post('score');

            $data['can_defend'] = $this->input->post('can_defend');
            $data['defense'] = $this->input->post('defense');
            $data['attack'] = $this->input->post('attack');
            $data['weak_against'] = $this->input->post('weak_against');
            $data['strong_against'] = $this->input->post('strong_against');
            $data['turn'] = $this->input->post('turn');
            $data['ability'] = $this->input->post('ability');

            $data['time_to_create'] = $this->input->post('time_to_create');

            $data['cost_unit'] = $this->input->post('cost_unit');
            $data['cost_num_unit'] = $this->input->post('cost_num_unit');

            $data['cost_food'] = $this->input->post('cost_food');
            $data['cost_wood'] = $this->input->post('cost_wood');
            $data['cost_stone'] = $this->input->post('cost_stone');
            $data['cost_iron'] = $this->input->post('cost_iron');
            $data['cost_mana'] = $this->input->post('cost_mana');

            $data['mod_rate_food'] = $this->input->post('mod_rate_food');
            $data['mod_rate_wood'] = $this->input->post('mod_rate_wood');
            $data['mod_rate_stone'] = $this->input->post('mod_rate_stone');
            $data['mod_rate_iron'] = $this->input->post('mod_rate_iron');
            $data['mod_rate_mana'] = $this->input->post('mod_rate_mana');

            $this->load->model('unit_model');

            if ($id == -1) {
                //making new
                $this->unit_model->add_unit_admin($data);
            } else {
                //editing
                $this->unit_model->edit_unit_admin($data);
            }

            $this->load->helper('url');

            redirect('admin/unit_tool');
        }
    }

    //assignment tool
    public function assignment_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('assignment_model');

        $data['assignments'] = $this->assignment_model->get_assignments_admin();

        $this->headers('admin');
        $this->load->view('admin/assignment_tool/list.php', $data);
        $this->footer();
    }

    public function assignment($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('assignment_model');
        $this->load->model('unit_model');
        $this->load->model('spell_model');
        $this->load->model('technology_model');

        //assign
        $data['sassign'] = $this->input->post('unitid');
        $data['optass'] = $this->unit_model->get_unit_list_dropdown_admin();

        $this->form_validation->set_rules('max', 'Max Assign', 'is_natural|required');
        $this->form_validation->set_rules(
            'bonus_per_assigned',
            'Assigned/bonus',
            'integer'
        );

        $data['ssp'] = $this->input->post('spellid');
        $data['optsp'] = $this->spell_model->get_spell_list_drop_admin();

        $data['srtech'] = $this->input->post('req_tech');
        $data['optrtech'] = $this->technology_model->get_tech_list_drop_admin();

        $this->form_validation->set_rules('mod_max_food', 'Mod Max Food', 'integer');
        $this->form_validation->set_rules('mod_max_wood', 'Mod Max Wood', 'integer');
        $this->form_validation->set_rules('mod_max_stone', 'Mod Max Stone', 'integer');
        $this->form_validation->set_rules('mod_max_iron', 'Mod Max Iron', 'integer');
        $this->form_validation->set_rules('mod_max_mana', 'Mod Max Mana', 'integer');

        $this->form_validation->set_rules('mod_rate_food', 'Mod Rate Food', 'numeric');
        $this->form_validation->set_rules('mod_rate_wood', 'Mod Rate Wood', 'numeric');
        $this->form_validation->set_rules('mod_rate_stone', 'Mod Rate Stone', 'numeric');
        $this->form_validation->set_rules('mod_rate_iron', 'Mod Rate Iron', 'numeric');
        $this->form_validation->set_rules('mod_rate_mana', 'Mod Rate Mana', 'numeric');

        $this->form_validation->set_rules('mod_percent_food', 'Mod Percent Food', 'numeric');
        $this->form_validation->set_rules('mod_percent_wood', 'Mod Percent Wood', 'numeric');
        $this->form_validation->set_rules('mod_percent_stone', 'Mod Percent Stone', 'numeric');
        $this->form_validation->set_rules('mod_percent_iron', 'Mod Percent Iron', 'numeric');
        $this->form_validation->set_rules('mod_percent_mana', 'Mod Percent Mana', 'numeric');

        $this->form_validation->set_rules('description', 'Description', 'alphanumeric');

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                //making new
                $data['new'] = true;

                $this->load->view('admin/assignment_tool/assignment', $data);
            } else {
                //editing
                $data['new'] = false;

                $data['assignment'] = $this->assignment_model->get_assignment_admin($id);

                $this->load->view('admin/assignment_tool/assignment', $data);
            }

            $this->footer();
        } else {
            $data['id'] = $id;
            $data['unitid'] = $this->input->post('unitid');
            $data['max'] = $this->input->post('max');
            $data['bonus_per_assigned'] = $this->input->post('bonus_per_assigned');
            $data['spellid'] = $this->input->post('spellid');
            $data['req_tech'] = $this->input->post('req_tech');

            $data['mod_max_food'] = $this->input->post('mod_max_food');
            $data['mod_max_wood'] = $this->input->post('mod_max_wood');
            $data['mod_max_stone'] = $this->input->post('mod_max_stone');
            $data['mod_max_iron'] = $this->input->post('mod_max_iron');
            $data['mod_max_mana'] = $this->input->post('mod_max_mana');

            $data['mod_rate_food'] = $this->input->post('mod_rate_food');
            $data['mod_rate_wood'] = $this->input->post('mod_rate_wood');
            $data['mod_rate_stone'] = $this->input->post('mod_rate_stone');
            $data['mod_rate_iron'] = $this->input->post('mod_rate_iron');
            $data['mod_rate_mana'] = $this->input->post('mod_rate_mana');

            $data['mod_percent_food'] = $this->input->post('mod_percent_food');
            $data['mod_percent_wood'] = $this->input->post('mod_percent_wood');
            $data['mod_percent_stone'] = $this->input->post('mod_percent_stone');
            $data['mod_percent_iron'] = $this->input->post('mod_percent_iron');
            $data['mod_percent_mana'] = $this->input->post('mod_percent_mana');

            $data['description'] = $this->input->post('description');

            $this->load->model('assignment_model');

            if ($id == -1) {
                //making new
                $this->assignment_model->add_assignment_admin($data);
            } else {
                //editing
                $this->assignment_model->edit_assignment_admin($data);
            }

            $this->load->helper('url');

            redirect('admin/assignment_tool');
        }
    }

    //technology tool
    public function technology_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('technology_model');

        $data['technologies'] = $this->technology_model->list_technologies_admin();

        $this->headers('admin');
        $this->load->view('admin/technology_tool/list.php', $data);
        $this->footer();
    }

    public function technology($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('technology_model');
        $this->load->model('spell_model');
        $this->load->model('unit_model');

        $this->form_validation->set_rules('description', 'Description', 'required');

        $this->form_validation->set_rules('time', 'Time', 'integer');

        $this->form_validation->set_rules('score', 'Score', 'integer');
    
        $this->form_validation->set_rules('cost_food', 'cost_food', 'integer');
        $this->form_validation->set_rules('cost_wood', 'cost_wood', 'integer');
        $this->form_validation->set_rules('cost_stone', 'cost_stone', 'integer');
        $this->form_validation->set_rules('cost_iron', 'cost_iron', 'integer');
        $this->form_validation->set_rules('cost_mana', 'cost_mana', 'integer');

        $this->form_validation->set_rules('mod_max_food', 'Mod Max Food', 'integer');
        $this->form_validation->set_rules('mod_max_wood', 'Mod Max Wood', 'integer');
        $this->form_validation->set_rules('mod_max_stone', 'Mod Max Stone', 'integer');
        $this->form_validation->set_rules('mod_max_iron', 'Mod Max Iron', 'integer');
        $this->form_validation->set_rules('mod_max_mana', 'Mod Max Mana', 'integer');

        $this->form_validation->set_rules('mod_rate_food', 'Mod Rate Food', 'numeric');
        $this->form_validation->set_rules('mod_rate_wood', 'Mod Rate Wood', 'numeric');
        $this->form_validation->set_rules('mod_rate_stone', 'Mod Rate Stone', 'numeric');
        $this->form_validation->set_rules('mod_rate_iron', 'Mod Rate Iron', 'numeric');
        $this->form_validation->set_rules('mod_rate_mana', 'Mod Rate Mana', 'numeric');

        $this->form_validation->set_rules('mod_percent_food', 'Mod Percent Food', 'integer');
        $this->form_validation->set_rules('mod_percent_wood', 'Mod Percent Wood', 'integer');
        $this->form_validation->set_rules('mod_percent_stone', 'Mod Percent Stone', 'integer');
        $this->form_validation->set_rules('mod_percent_iron', 'Mod Percent Iron', 'integer');
        $this->form_validation->set_rules('mod_percent_mana', 'Mod Percent Mana', 'integer');


        //mod_spell_id dropdown
        $data['mspidopt'] = $this->spell_model->get_spell_mod_drop_admin();
        $data['sspid'] = $this->input->post('mod_spell_id');

        //mod_create_id dropdown
        $data['mcidopt'] = $this->unit_model->list_create_mod_drop_admin();
        $data['smcid'] = $this->input->post('mod_create_id');

        $data['sflai'] = $this->input->post('flag_ai');

        $data['selissec'] = $this->input->post('is_secondary');

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                //making new
                $data['new'] = true;

                $this->load->view('admin/technology_tool/technology', $data);
            } else {
                //editing
                $data['new'] = false;

                $data['technology'] = $this->technology_model->get_technology_admin(
                    $id
                );

                $this->load->view('admin/technology_tool/technology', $data);
            }

            $this->footer();
        } else {
            $data['id'] = $id;
            $data['description'] = $this->input->post('description');

            $data['time'] = $this->input->post('time');

            $data['score'] = $this->input->post('score');

            $data['cost_food'] = $this->input->post('cost_food');
            $data['cost_wood'] = $this->input->post('cost_wood');
            $data['cost_stone'] = $this->input->post('cost_stone');
            $data['cost_iron'] = $this->input->post('cost_iron');
            $data['cost_mana'] = $this->input->post('cost_mana');

            $data['mod_max_food'] = $this->input->post('mod_max_food');
            $data['mod_max_wood'] = $this->input->post('mod_max_wood');
            $data['mod_max_stone'] = $this->input->post('mod_max_stone');
            $data['mod_max_iron'] = $this->input->post('mod_max_iron');
            $data['mod_max_mana'] = $this->input->post('mod_max_mana');

            $data['mod_rate_food'] = $this->input->post('mod_rate_food');
            $data['mod_rate_wood'] = $this->input->post('mod_rate_wood');
            $data['mod_rate_stone'] = $this->input->post('mod_rate_stone');
            $data['mod_rate_iron'] = $this->input->post('mod_rate_iron');
            $data['mod_rate_mana'] = $this->input->post('mod_rate_mana');

            $data['mod_percent_food'] = $this->input->post('mod_percent_food');
            $data['mod_percent_wood'] = $this->input->post('mod_percent_wood');
            $data['mod_percent_stone'] = $this->input->post('mod_percent_stone');
            $data['mod_percent_iron'] = $this->input->post('mod_percent_iron');
            $data['mod_percent_mana'] = $this->input->post('mod_percent_mana');

            $data['mod_create_id'] = $this->input->post('mod_create_id');
            $data['mod_spell_id'] = $this->input->post('mod_spell_id');

            $data['flag_ai'] = $this->input->post('flag_ai');
        
            $data['is_secondary'] = $this->input->post('is_secondary');

            $this->load->model('building_model');

            if ($id == -1) {
                //making new
                $this->technology_model->add_technology_admin($data);
            } else {
                //editing
                $this->technology_model->edit_technology_admin($data);
            }

            $this->load->helper('url');

            redirect('admin/technology_tool');
        }
    }

    //technology_group_tool
    public function technology_group_desc($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('technology_model');

        $this->form_validation->set_rules('group_name', 'Group Name', 'required');
    
        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                //making new
                $data['new'] = true;

                $this->load->view(
                    'admin/technology_group_tool/tech_group_desc',
                    $data
                );
            } else {
                //editing
                $data['new'] = false;

                $data['group'] = $this->technology_model->get_tech_group_desc_admin(
                    $id
                );

                $this->load->view(
                    'admin/technology_group_tool/tech_group_desc',
                    $data
                );
            }

            $this->footer();
        } else {
            $data['id'] = $id;
            $data['group_name'] = $this->input->post('group_name');

            $this->load->model('technology_model');

            if ($id == -1) {
                //making new
                $this->technology_model->add_tech_group_desc_admin($data);
            } else {
                //editing
                $this->technology_model->edit_tech_group_desc_admin($data);
            }

            $this->load->helper('url');

            redirect('admin/technology_group_tool');
        }
    }

    //technology group tool
    public function technology_group_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('technology_model');

        $data['groups'] = $this->technology_model->list_tech_groups_admin();

        $this->headers('admin');
        $this->load->view('admin/technology_group_tool/list.php', $data);
        $this->footer();
    }

    public function technology_group($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('technology_model');

        $this->form_validation->set_rules('action', 'Action', 'required');
    
        if (!$this->form_validation->run()) {
            $this->headers('admin');

            $data['id'] = $id;
            $data['group'] = $this->technology_model->get_group_admin($id);
            $data['opttech'] = $this->technology_model->list_tech_drop_admin();
            $data['seltech'] = $this->input->post('add');

            $this->load->view('admin/technology_group_tool/tech_groups', $data);

            $this->footer();
        } else {
            $action = $this->input->post('action');
        
            $this->load->model('technology_model');

            if ($action == 'add') {
                $techid = $this->input->post('add');

                $this->technology_model->add_tech_to_group_admin($id, $techid);
            } elseif ($action == 'delete') {
                $techid = $this->input->post('id');
                $this->technology_model->remove_tech_from_group_admin($id, $techid);
            }
            $this->load->helper('url');

            redirect('admin/technology_group/' . $id);
        }
    }

    //technology requirements tool
    public function technology_requirements_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('technology_model');

        $data['technologies'] = $this->technology_model->list_tech_have_req_admin();

        $this->headers('admin');
        $this->load->view('admin/technology_requirements_tool/list.php', $data);
        $this->footer();
    }

    public function have_technology_requirement($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        if (!$id) {
            $this->load->helper('url');
            redirect('admin/admin_panel');
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('action', 'Action', 'required');

        $this->load->model('technology_model');

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                $data['opts'] = $this->technology_model->list_tech_drop_admin();

                $this->load->view(
                    'admin/technology_requirements_tool/add_to_list',
                    $data
                );
            } else {
                $data['id'] = $id;
                $data['tech'] = $this->technology_model->get_req_list_item_admin(
                    $id
                );

                $this->load->view(
                    'admin/technology_requirements_tool/remove_conf',
                    $data
                );
            }

            $this->footer();
        } else {
            $action = $this->input->post('action');

            if ($action == 'new') {
                $data['technologyid'] = $this->input->post('technologyid');
                $data['comment'] = $this->input->post('comment');

                $this->technology_model->add_to_req_list_admin($data);
            }

            if ($action == 'delete') {
                $id = $this->input->post('technologyid');

                $this->technology_model->remove_from_req_list_admin($id);
            }

            $this->load->helper('url');
            redirect('admin/technology_requirements_tool');
        }
    }

    public function technology_requirements($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('technology_model');

        $this->form_validation->set_rules('action', 'Action', 'required');
    
        if (!$this->form_validation->run()) {
            $this->headers('admin');

            $data['id'] = $id;
            

            $data['technology'] = $this->technology_model->get_tech_by_req_id_admin(
                $id
            );
            $data['required'] = $this->technology_model->get_tech_requirements_admin(
                $data['technology']['id']
            );

            $data['opttech'] = $this->technology_model->list_tech_drop_admin();
            $data['seltech'] = $this->input->post('add');

            $this->load->view('admin/technology_requirements_tool/tech_req', $data);

            $this->footer();
        } else {
            $action = $this->input->post('action');
        
            if ($action == 'add') {
                $techid = $this->input->post('technologyid');
                $addtechid = $this->input->post('add');

                $this->technology_model->add_tech_req_admin($techid, $addtechid);
            } elseif ($action == 'delete') {
                $tid = $this->input->post('id');
                $this->technology_model->remove_tech_req_admin($tid);
            }
            $this->load->helper('url');

            redirect('admin/technology_requirements/' . $id);
        }
    }

    //spell_tool
    public function spell_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('spell_model');

        $data['spells'] = $this->spell_model->list_spells_admin();

        $this->headers('admin');
        $this->load->view('admin/spell_tool/list.php', $data);
        $this->footer();
    }

    public function spell($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('spell_model');
        $this->load->model('weather_model');

        //spell effects
        $data['seff'] = $this->input->post('effect');
        $data['opteff'] = $this->spell_model->get_spell_effects_admin();

        $this->form_validation->set_rules('duration', 'Duration', 'required|is_natural');
        $this->form_validation->set_rules('cooldown', 'Cooldown', 'required|is_natural');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('description_admin', 'Desc Admin', 'required');

        $data['sweather'] = $this->input->post('weather_change_to');
        $data['optweather'] = $this->weather_model->get_weathers_drop_admin();
 
        $this->form_validation->set_rules('cost_food', 'cost_food', 'integer');
        $this->form_validation->set_rules('cost_wood', 'cost_wood', 'integer');
        $this->form_validation->set_rules('cost_stone', 'cost_stone', 'integer');
        $this->form_validation->set_rules('cost_iron', 'cost_iron', 'integer');
        $this->form_validation->set_rules('cost_mana', 'cost_mana', 'integer');

        $this->form_validation->set_rules('mod_max_food', 'Mod Max Food', 'integer');
        $this->form_validation->set_rules('mod_max_wood', 'Mod Max Wood', 'integer');
        $this->form_validation->set_rules('mod_max_stone', 'Mod Max Stone', 'integer');
        $this->form_validation->set_rules('mod_max_iron', 'Mod Max Iron', 'integer');
        $this->form_validation->set_rules('mod_max_mana', 'Mod Max Mana', 'integer');

        $this->form_validation->set_rules('mod_rate_food', 'Mod Rate Food', 'numeric');
        $this->form_validation->set_rules('mod_rate_wood', 'Mod Rate Wood', 'numeric');
        $this->form_validation->set_rules('mod_rate_stone', 'Mod Rate Stone', 'numeric');
        $this->form_validation->set_rules('mod_rate_iron', 'Mod Rate Iron', 'numeric');
        $this->form_validation->set_rules('mod_rate_mana', 'Mod Rate Mana', 'numeric');

        $this->form_validation->set_rules('mod_percent_food', 'Mod Percent Food', 'integer');
        $this->form_validation->set_rules('mod_percent_wood', 'Mod Percent Wood', 'integer');
        $this->form_validation->set_rules('mod_percent_stone', 'Mod Percent Stone', 'integer');
        $this->form_validation->set_rules('mod_percent_iron', 'Mod Percent Iron', 'integer');
        $this->form_validation->set_rules('mod_percent_mana', 'Mod Percent Mana', 'integer');

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                //making new
                $data['new'] = true;

                $this->load->view('admin/spell_tool/spell', $data);
            } else {
                //editing
                $data['new'] = false;

                $data['spell'] = $this->spell_model->get_spell_admin($id);

                $this->load->view('admin/spell_tool/spell', $data);
            }

            $this->footer();
        } else {
            $data['id'] = $id;
            $data['effect'] = $this->input->post('effect');
            $data['duration'] = $this->input->post('duration');
            $data['cooldown'] = $this->input->post('cooldown');
            $data['description'] = $this->input->post('description');
            $data['description_admin'] = $this->input->post('description_admin');

            $data['weather_change_to'] = $this->input->post('weather_change_to');

            $data['cost_food'] = $this->input->post('cost_food');
            $data['cost_wood'] = $this->input->post('cost_wood');
            $data['cost_stone'] = $this->input->post('cost_stone');
            $data['cost_iron'] = $this->input->post('cost_iron');
            $data['cost_mana'] = $this->input->post('cost_mana');

            $data['mod_max_food'] = $this->input->post('mod_max_food');
            $data['mod_max_wood'] = $this->input->post('mod_max_wood');
            $data['mod_max_stone'] = $this->input->post('mod_max_stone');
            $data['mod_max_iron'] = $this->input->post('mod_max_iron');
            $data['mod_max_mana'] = $this->input->post('mod_max_mana');

            $data['mod_rate_food'] = $this->input->post('mod_rate_food');
            $data['mod_rate_wood'] = $this->input->post('mod_rate_wood');
            $data['mod_rate_stone'] = $this->input->post('mod_rate_stone');
            $data['mod_rate_iron'] = $this->input->post('mod_rate_iron');
            $data['mod_rate_mana'] = $this->input->post('mod_rate_mana');

            $data['mod_percent_food'] = $this->input->post('mod_percent_food');
            $data['mod_percent_wood'] = $this->input->post('mod_percent_wood');
            $data['mod_percent_stone'] = $this->input->post('mod_percent_stone');
            $data['mod_percent_iron'] = $this->input->post('mod_percent_iron');
            $data['mod_percent_mana'] = $this->input->post('mod_percent_mana');

            $this->load->model('spell_model');

            if ($id == -1) {
                //making new
                $this->spell_model->add_spell_admin($data);
            } else {
                //editing
                $this->spell_model->edit_spell_admin($data);
            }

            $this->load->helper('url');

            redirect('admin/spell_tool');
        }
    }

    //weather_tool
    public function weather_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('weather_model');

        $data['weathers'] = $this->weather_model->list_weathers_admin();

        $this->headers('admin');
        $this->load->view('admin/weather_tool/list.php', $data);
        $this->footer();
    }

    public function weather($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('weather_model');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('art', 'Art', 'required');
        $this->form_validation->set_rules('css', 'CSS', 'required');

        //spell effects
        $data['seff'] = $this->input->post('effect');
        $data['opteff'] = $this->weather_model->get_weather_effects_drop_admin();

        $this->form_validation->set_rules('mod_max_food', 'Mod Max Food', 'integer');
        $this->form_validation->set_rules('mod_max_wood', 'Mod Max Wood', 'integer');
        $this->form_validation->set_rules('mod_max_stone', 'Mod Max Stone', 'integer');
        $this->form_validation->set_rules('mod_max_iron', 'Mod Max Iron', 'integer');
        $this->form_validation->set_rules('mod_max_mana', 'Mod Max Mana', 'integer');

        $this->form_validation->set_rules('mod_percent_food', 'Mod Percent Food', 'integer');
        $this->form_validation->set_rules('mod_percent_wood', 'Mod Percent Wood', 'integer');
        $this->form_validation->set_rules('mod_percent_stone', 'Mod Percent Stone', 'integer');
        $this->form_validation->set_rules('mod_percent_iron', 'Mod Percent Iron', 'integer');
        $this->form_validation->set_rules('mod_percent_mana', 'Mod Percent Mana', 'integer');

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                //making new
                $data['new'] = true;

                $this->load->view('admin/weather_tool/weather', $data);
            } else {
                //editing
                $data['new'] = false;

                $data['weather'] = $this->weather_model->get_weather_admin($id);

                $this->load->view('admin/weather_tool/weather', $data);
            }

            $this->footer();
        } else {
            $data['id'] = $id;

            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['art'] = $this->input->post('art');
            $data['css'] = $this->input->post('css');

            $data['effect'] = $this->input->post('effect');

            $data['cost_food'] = $this->input->post('cost_food');
            $data['cost_wood'] = $this->input->post('cost_wood');
            $data['cost_stone'] = $this->input->post('cost_stone');
            $data['cost_iron'] = $this->input->post('cost_iron');
            $data['cost_mana'] = $this->input->post('cost_mana');

            $data['mod_max_food'] = $this->input->post('mod_max_food');
            $data['mod_max_wood'] = $this->input->post('mod_max_wood');
            $data['mod_max_stone'] = $this->input->post('mod_max_stone');
            $data['mod_max_iron'] = $this->input->post('mod_max_iron');
            $data['mod_max_mana'] = $this->input->post('mod_max_mana');

            $data['mod_rate_food'] = $this->input->post('mod_rate_food');
            $data['mod_rate_wood'] = $this->input->post('mod_rate_wood');
            $data['mod_rate_stone'] = $this->input->post('mod_rate_stone');
            $data['mod_rate_iron'] = $this->input->post('mod_rate_iron');
            $data['mod_rate_mana'] = $this->input->post('mod_rate_mana');

            $data['mod_percent_food'] = $this->input->post('mod_percent_food');
            $data['mod_percent_wood'] = $this->input->post('mod_percent_wood');
            $data['mod_percent_stone'] = $this->input->post('mod_percent_stone');
            $data['mod_percent_iron'] = $this->input->post('mod_percent_iron');
            $data['mod_percent_mana'] = $this->input->post('mod_percent_mana');

            $this->load->model('weather_model');

            if ($id == -1) {
                //making new
                $this->weather_model->add_weather_admin($data);
            } else {
                //editing
                $this->weather_model->edit_weather_admin($data);
            }

            $this->load->helper('url');

            redirect('admin/weather_tool');
        }
    }

    //HERO TOOLS

    //hero templates
    public function hero_template_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('hero_model');

        $data['templates'] = $this->hero_model->all_hero_templates_admin();

        $this->headers('admin');
        $this->load->view('admin/hero_template_tool/list.php', $data);
        $this->footer();
    }

    public function hero_templates($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('hero_model');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('classname', 'Classname', 'required|alpha');
 
        $this->form_validation->set_rules('nomod_max_health', 'Nomod Health', 'required|is_natural');
        $this->form_validation->set_rules('nomod_max_mana', 'Nomod Mana', 'required|is_natural');

        $this->form_validation->set_rules('agility', 'Agility', 'integer');
        $this->form_validation->set_rules('strength', 'Strength', 'integer');
        $this->form_validation->set_rules('stamina', 'Stamina', 'integer');
        $this->form_validation->set_rules('intellect', 'Intellect', 'integer');
        $this->form_validation->set_rules('spirit', 'Spirit', 'integer');

        $this->form_validation->set_rules('nomod_attackpower', 'Nomod Attackpower', 'integer');

        $this->form_validation->set_rules('nomod_dodge', 'Nomod Dodge', 'numeric');
        $this->form_validation->set_rules('nomod_parry', 'Nomod Parry', 'numeric');
        $this->form_validation->set_rules('hit', 'Hit', 'numeric');
        $this->form_validation->set_rules('nomod_crit', 'Nomod Crit', 'numeric');

        $this->form_validation->set_rules('nomod_damage_min', 'Nomod Damage Min', 'integer');
        $this->form_validation->set_rules('nomod_damage_max', 'Nomod Damage Max', 'integer');

        $this->form_validation->set_rules('nomod_ranged_damage_min', 'Nomod Damage Min', 'integer');
        $this->form_validation->set_rules('nomod_ranged_damage_max', 'Nomod Damage Max', 'integer');

        $this->form_validation->set_rules('nomod_heal_min', 'Nomod Heal Min', 'integer');
        $this->form_validation->set_rules('nomod_heal_max', 'Nomod Heal Max', 'integer');

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                //making new
                $data['new'] = true;

                $this->load->view('admin/hero_template_tool/hero', $data);
            } else {
                //editing
                $data['new'] = false;

                $data['template'] = $this->hero_model->get_template_admin($id);

                $this->load->view('admin/hero_template_tool/hero', $data);
            }

            $this->footer();
        } else {
            $data['id'] = $id;

            $data['classname'] = $this->input->post('classname');

            $data['nomod_max_health'] = $this->input->post('nomod_max_health');
            $data['nomod_max_mana'] = $this->input->post('nomod_max_mana');

            $data['agility'] = $this->input->post('agility');
            $data['strength'] = $this->input->post('strength');
            $data['stamina'] = $this->input->post('stamina');
            $data['intellect'] = $this->input->post('intellect');
            $data['spirit'] = $this->input->post('spirit');

            $data['nomod_attackpower'] = $this->input->post('nomod_attackpower');

            $data['nomod_dodge'] = $this->input->post('nomod_dodge');
            $data['nomod_parry'] = $this->input->post('nomod_parry');
            $data['hit'] = $this->input->post('hit');
            $data['nomod_crit'] = $this->input->post('nomod_crit');

            $data['nomod_damage_min'] = $this->input->post('nomod_damage_min');
            $data['nomod_damage_max'] = $this->input->post('nomod_damage_max');

            $data['nomod_ranged_damage_min'] = $this->input->post('nomod_ranged_damage_min');
            $data['nomod_ranged_damage_max'] = $this->input->post('nomod_ranged_damage_max');

            $data['nomod_heal_min'] = $this->input->post('nomod_heal_min');
            $data['nomod_heal_max'] = $this->input->post('nomod_heal_max');

            if ($id == -1) {
                //making new
                $this->hero_model->add_template_admin($data);
            } else {
                //editing
                $this->hero_model->edit_template_admin($data);
            }

            $this->load->helper('url');

            redirect('admin/hero_template_tool');
        }
    }

    //technology requirements tool
    public function hero_inventory_template_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('hero_model');

        $data['classes'] = $this->hero_model->all_hero_templates_admin();

        $this->headers('admin');
        $this->load->view('admin/hero_inventory_template_tool/list.php', $data);
        $this->footer();
    }

    public function hero_inventory_templates($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('item_model');

        $this->form_validation->set_rules('action', 'Action', 'required');
    
        if (!$this->form_validation->run()) {
            $this->headers('admin');

            $data['id'] = $id;

            $this->load->model('hero_model');

            $data['hero'] = $this->hero_model->get_template_admin($id);
            $data['items'] = $this->item_model->get_class_item_templates($id);

            $data['optitems'] = $this->item_model->all_items_drop_admin();
            $data['selitems'] = $this->input->post('add');

            $this->load->view('admin/hero_inventory_template_tool/items', $data);

            $this->footer();
        } else {
            $action = $this->input->post('action');
        
            if ($action == 'add') {
                $classid = $this->input->post('classid');
                $additemid = $this->input->post('add');

                $this->item_model->add_hero_item_template_admin($classid, $additemid);
            } elseif ($action == 'delete') {
                $iid = $this->input->post('id');
                $this->item_model->remove_hero_item_template_admin($iid);
            }
            $this->load->helper('url');

            redirect('admin/hero_inventory_templates/' . $id);
        }
    }

    //item tool
    public function item_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('item_model');

        $data['items'] = $this->item_model->all_items_admin();

        $this->headers('admin');
        $this->load->view('admin/item_tool/list.php', $data);
        $this->footer();
    }

    public function items($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('item_model');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        $data['selquality'] = $this->input->post('quality');
 
        $this->form_validation->set_rules('itemlevel', 'Itemlevel', 'integer');
        $this->form_validation->set_rules('stack', 'Stack', 'integer');

        $data['seltype'] = $this->input->post('type');
        $data['selsubtype'] = $this->input->post('subtype');
        $data['selsubsubtype'] = $this->input->post('subsubtype');

        $this->form_validation->set_rules('sell_price', 'Sell Price', 'integer');
        $this->form_validation->set_rules('buy_price', 'Buy Price', 'integer');

        $this->form_validation->set_rules('text', 'Text', 'alphanumeric');

        $data['selsoulbound'] = $this->input->post('soulbound');

        $data['optspell'] = array('0' => 'NYI!');
        $data['selspell'] = $this->input->post('spell');

        $data['optproc'] = array('0' => 'NYI!');
        $data['selproc'] = $this->input->post('proc');

        $this->form_validation->set_rules('req_level', 'Req Level', 'integer');

        $data['selreqclass'] = $this->input->post('req_class');

        $this->form_validation->set_rules('nomod_max_health', 'Nomod Max Health', 'is_natural');
        $this->form_validation->set_rules('nomod_max_mana', 'Nomod Max Mana', 'is_natural');

        $this->form_validation->set_rules('percent_max_health', 'Percent Max Health', 'is_natural');
        $this->form_validation->set_rules('percent_max_mana', 'Percent Max Mana', 'is_natural');


        $this->form_validation->set_rules('nomod_agility', 'Nomod Agility', 'integer');
        $this->form_validation->set_rules('nomod_strength', 'Nomod Strength', 'integer');
        $this->form_validation->set_rules('nomod_stamina', 'Nomod Stamina', 'integer');
        $this->form_validation->set_rules('nomod_intellect', 'Nomod Intellect', 'integer');
        $this->form_validation->set_rules('nomod_spirit', 'Nomod Spirit', 'integer');

        $this->form_validation->set_rules('percent_agility', 'Percent Agility', 'integer');
        $this->form_validation->set_rules('percent_strength', 'Percent Strength', 'integer');
        $this->form_validation->set_rules('percent_stamina', 'Percent Stamina', 'integer');
        $this->form_validation->set_rules('percent_intellect', 'Percent Intellect', 'integer');
        $this->form_validation->set_rules('percent_spirit', 'Percent Spirit', 'integer');

        $this->form_validation->set_rules('nomod_attackpower', 'Nomod Attackpower', 'integer');
        $this->form_validation->set_rules('percent_attackpower', 'Percent Attackpower', 'integer');

        $this->form_validation->set_rules('nomod_armor', 'Nomod Armor', 'integer');
        $this->form_validation->set_rules('percent_armor', 'Percent Armor', 'integer');

        $this->form_validation->set_rules('nomod_dodge', 'Nomod Dodge', 'numeric');
        $this->form_validation->set_rules('nomod_parry', 'Nomod Parry', 'numeric');
        $this->form_validation->set_rules('hit', 'Hit', 'numeric');
        $this->form_validation->set_rules('nomod_crit', 'Nomod Crit', 'numeric');

        $this->form_validation->set_rules('nomod_damage_min', 'Nomod Damage Min', 'integer');
        $this->form_validation->set_rules('nomod_damage_max', 'Nomod Damage Max', 'integer');
        $this->form_validation->set_rules('percent_damage_min', 'Percent Damage Min', 'integer');
        $this->form_validation->set_rules('percent_damage_max', 'Percent Damage Max', 'integer');

        $this->form_validation->set_rules('nomod_ranged_damage_min', 'Nomod Ranged Damage Min', 'integer');
        $this->form_validation->set_rules('nomod_ranged_damage_max', 'Nomod Ranged Damage Max', 'integer');
        $this->form_validation->set_rules('percent_ranged_damage_min', 'Percent Ranged Damage Min', 'integer');
        $this->form_validation->set_rules('percent_ranged_damage_max', 'Percent Ranged Damage Max', 'integer');

        $this->form_validation->set_rules('nomod_heal_min', 'Nomod Heal Min', 'integer');
        $this->form_validation->set_rules('nomod_heal_max', 'Nomod Heal Max', 'integer');
        $this->form_validation->set_rules('percent_heal_min', 'Percent Heal Min', 'integer');
        $this->form_validation->set_rules('percent_heal_max', 'Percent Heal Max', 'integer');

        $this->form_validation->set_rules('life_leech', 'Life Leech', 'integer');
        $this->form_validation->set_rules('mana_leech', 'Mana Leech', 'integer');

        $this->form_validation->set_rules('level_modifier', 'Level Modifier', 'integer');
        $this->form_validation->set_rules('level_modifier_max', 'Level Modifier Max', 'integer');

        $this->form_validation->set_rules('data1', 'Data1', 'integer');
        $this->form_validation->set_rules('data2', 'Data2', 'integer');

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                //making new
                $data['new'] = true;

                $this->load->view('admin/item_tool/item', $data);
            } else {
                //editing
                $data['new'] = false;

                $data['item'] = $this->item_model->get_item_admin($id);

                $this->load->view('admin/item_tool/item', $data);
            }

            $this->footer();
        } else {
            $data['id'] = $id;

            $data['name'] = $this->input->post('name');
            $data['icon'] = $this->input->post('icon');

            $data['quality'] = $this->input->post('quality');
 
            $data['itemlevel'] = $this->input->post('itemlevel');
            $data['stack'] = $this->input->post('stack');

            $data['type'] = $this->input->post('type');
            $data['subtype'] = $this->input->post('subtype');
            $data['subsubtype'] = $this->input->post('subsubtype');

            $data['sell_price'] = $this->input->post('sell_price');
            $data['buy_price'] = $this->input->post('buy_price');

            $data['text'] = $this->input->post('text');

            $data['soulbound'] = $this->input->post('soulbound');

            $data['spell'] = $this->input->post('spell');

            $data['proc'] = $this->input->post('proc');

            $data['req_level'] = $this->input->post('req_level');

            $data['req_class'] = $this->input->post('req_class');

            $data['nomod_max_health'] = $this->input->post('nomod_max_health');
            $data['nomod_max_mana'] = $this->input->post('nomod_max_mana');

            $data['percent_max_health'] = $this->input->post('percent_max_health');
            $data['percent_max_mana'] = $this->input->post('percent_max_mana');

            $data['nomod_agility'] = $this->input->post('nomod_agility');
            $data['nomod_strength'] = $this->input->post('nomod_strength');
            $data['nomod_stamina'] = $this->input->post('nomod_stamina');
            $data['nomod_intellect'] = $this->input->post('nomod_intellect');
            $data['nomod_spirit'] = $this->input->post('nomod_spirit');

            $data['percent_agility'] = $this->input->post('percent_agility');
            $data['percent_strength'] = $this->input->post('percent_strength');
            $data['percent_stamina'] = $this->input->post('percent_stamina');
            $data['percent_intellect'] = $this->input->post('percent_intellect');
            $data['percent_spirit'] = $this->input->post('percent_spirit');

            $data['nomod_attackpower'] = $this->input->post('nomod_attackpower');
            $data['percent_attackpower'] = $this->input->post('percent_attackpower');

            $data['nomod_armor'] = $this->input->post('nomod_armor');
            $data['percent_armor'] = $this->input->post('percent_armor');

            $data['nomod_dodge'] = $this->input->post('nomod_dodge');
            $data['nomod_parry'] = $this->input->post('nomod_parry');
            $data['hit'] = $this->input->post('hit');
            $data['nomod_crit'] = $this->input->post('nomod_crit');

            $data['nomod_damage_min'] = $this->input->post('nomod_damage_min');
            $data['nomod_damage_max'] = $this->input->post('nomod_damage_max');

            $data['percent_damage_min'] = $this->input->post('percent_damage_min');
            $data['percent_damage_max'] = $this->input->post('percent_damage_max');

            $data['nomod_ranged_damage_min'] = $this->input->post('nomod_ranged_damage_min');
            $data['nomod_ranged_damage_max'] = $this->input->post('nomod_ranged_damage_max');

            $data['percent_ranged_damage_min'] = $this->input->post('percent_ranged_damage_min');
            $data['percent_ranged_damage_max'] = $this->input->post('percent_ranged_damage_max');

            $data['nomod_heal_min'] = $this->input->post('nomod_heal_min');
            $data['nomod_heal_max'] = $this->input->post('nomod_heal_max');

            $data['percent_heal_min'] = $this->input->post('percent_heal_min');
            $data['percent_heal_max'] = $this->input->post('percent_heal_max');

            $data['life_leech'] = $this->input->post('life_leech');
            $data['mana_leech'] = $this->input->post('mana_leech');

            $data['level_modifier'] = $this->input->post('level_modifier');
            $data['level_modifier_max'] = $this->input->post('level_modifier_max');

            $data['data1'] = $this->input->post('data1');
            $data['data2'] = $this->input->post('data2');

            if ($id == -1) {
                //making new
                $this->item_model->add_item_admin($data);
            } else {
                //editing
                $this->item_model->edit_item_admin($data);
            }

            $this->load->helper('url');

            redirect('admin/item_tool');
        }
    }


    //AI Units
    public function ai_unit_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('ai_model');

        $data['units'] = $this->ai_model->list_units_admin();

        $this->headers('admin');
        $this->load->view('admin/ai_unit_tool/list.php', $data);
        $this->footer();
    }

    public function ai_unit($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('unit_model');
        $this->load->model('ai_model');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
        $this->form_validation->set_rules('ability', 'Ability', 'integer');
        $this->form_validation->set_rules('can_carry', 'Can Carry', 'integer');
        $this->form_validation->set_rules('attack', 'Attack', 'numeric');
        $this->form_validation->set_rules('Defense', 'Defense', 'numeric');
        $this->form_validation->set_rules('rate', 'Rate', 'numeric');
        $this->form_validation->set_rules('per_score', 'Per Score', 'integer');
        $this->form_validation->set_rules('turn', 'Turn', 'integer');

        $data['sstrong'] = $this->input->post('strong_against');
        $data['sweak'] = $this->input->post('weak_against');

        $data['optu'] = $this->unit_model->get_unit_list_dropdown_admin();

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                //making new
                $data['new'] = true;

                $this->load->view('admin/ai_unit_tool/unit', $data);
            } else {
                //editing
                $data['new'] = false;

                $data['unit'] = $this->ai_model->get_unit_admin($id);

                $this->load->view('admin/ai_unit_tool/unit', $data);
            }

            $this->footer();
        } else {
            $data['id'] = $id;
            $data['name'] = $this->input->post('name');
            $data['icon'] = $this->input->post('icon');
            $data['ability'] = $this->input->post('ability');

            $data['can_carry'] = $this->input->post('can_carry');
            $data['attack'] = $this->input->post('attack');
            $data['defense'] = $this->input->post('defense');

            $data['rate'] = $this->input->post('rate');
            $data['per_score'] = $this->input->post('per_score');
            $data['turn'] = $this->input->post('turn');
            $data['strong_against'] = $this->input->post('strong_against');
            $data['weak_against'] = $this->input->post('weak_against');

            $this->load->model('ai_model');

            if ($id == -1) {
                //making new
                $this->ai_model->add_unit_admin($data);
            } else {
                //editing
                $this->ai_model->edit_unit_admin($data);
            }

            $this->load->helper('url');

            redirect('admin/ai_unit_tool');
        }
    }


    //AI Settings
    public function ai_settings_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('ai_model');

        $data['settings'] = $this->ai_model->get_settings_list_admin();

        $this->headers('admin');
        $this->load->view('admin/ai_settings_tool/list.php', $data);
        $this->footer();
    }


    public function ai_settings($id = -1)
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');
        $this->load->model('ai_model');

        $this->form_validation->set_rules('setting', 'Setting', 'required');
        $this->form_validation->set_rules('value', 'Value', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            if ($id == -1) {
                //making new
                $data['new'] = true;

                $this->load->view('admin/ai_settings_tool/settings', $data);
            } else {
                //editing
                $data['new'] = false;

                $data['setting'] = $this->ai_model->get_setting_admin($id);

                $this->load->view('admin/ai_settings_tool/settings', $data);
            }

            $this->footer();
        } else {
            $data['id'] = $id;
            $data['setting'] = $this->input->post('setting');
            $data['value'] = $this->input->post('value');
            $data['description'] = $this->input->post('description');

            $this->load->model('ai_model');

            if ($id == -1) {
                //making new
                $this->ai_model->add_setting_admin($data);
            } else {
                //editing
                $this->ai_model->edit_setting_admin($data);
            }

            $this->load->helper('url');

            redirect('admin/ai_settings_tool');
        }
    }


    //map tools
    public function map_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }
        $this->load->model('map_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('action', 'Action', 'required');

        if (!$this->form_validation->run()) {
            $this->headers('admin');

            $data['files'] = $this->map_model->get_map_list_admin();
            $this->load->view('admin/map_tool/list', $data);

            $this->footer();
        } else {
            $action = $this->input->post('action');

            if ($action == 'apply') {
                $file = $this->input->post('filename');

                $this->map_model->apply_map_admin($file);
            }


            $this->load->helper('url');
            redirect('admin/map_tool');
        }
    }

    public function map_generator()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('map_model');
        $this->map_model->generate_map_admin();

        $this->load->helper('url');
        redirect('admin/map_tool');
    }

    //image tool
    public function menu_image()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('image_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('submit', 'Submit', 'required');

        $data['optimg'] = $this->image_model->get_file_list_drop();
        $data['optfont'] = $this->image_model->get_font_list_drop();
        $data['optvalign'] = $this->image_model->get_v_align_drop();
        $data['opthalign'] = $this->image_model->get_h_align_drop();
        $data['optgroup'] = $this->image_model->get_menu_group_list_drop();

        $this->headers('admin');

        if (!$this->form_validation->run()) {
            $this->load->view('admin/image_tool/menu_image', $data);
        } else {
            $data['wm_type'] = 'text';
            $data['quality'] = '100%';
            
            $data['file'] = $this->input->post('file');

            $data['padding'] = $this->input->post('padding');
            $data['wm_vrt_alignment'] = $this->input->post('v_align');
            $data['wm_hor_alignment'] = $this->input->post('h_align');
            $data['wm_hor_offset'] = $this->input->post('h_offset');
            $data['wm_vrt_offset'] = $this->input->post('v_offset');
            
            $data['wm_text'] = $this->input->post('text');
            $data['wm_font_path'] = './system/fonts/' . $this->input->post('font');
            $data['wm_font_size'] = $this->input->post('font_size');
            $data['wm_font_color'] = $this->input->post('font_color');
            $data['wm_shadow_color'] = $this->input->post('shadow_color');
            $data['wm_shadow_distance'] = $this->input->post('shadow_distance');

            $data['apply_all'] = $this->input->post('apply_all');
            $data['menu_group'] = $this->input->post('menu_group');

            $this->image_model->apply_menu_images($data);

            $this->image_model->save_menu_data($data);

            $view['applyall'] = $data['apply_all'];
            $view['list'] = $this->image_model->get_menu_file_list($data['menu_group']);
            $view['text'] = $data['wm_text'];

            $this->load->view('admin/image_tool/menu_image_view', $view);
        }

        $this->footer();
    }

    public function slot_image()
    {
        if ($this->userlevel < 5) {
            show_404();
        }


        $this->load->model('image_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('submit', 'Submit', 'required');

        $data['optimg'] = $this->image_model->get_file_list_drop();
        $data['optfont'] = $this->image_model->get_font_list_drop();
        $data['optvalign'] = $this->image_model->get_v_align_drop();
        $data['opthalign'] = $this->image_model->get_h_align_drop();
        $data['optgroup'] = $this->image_model->get_menu_group_list_drop();
        $data['optoverlay'] = $this->image_model->get_overlay_list_drop();

        $this->headers('admin');

        if (!$this->form_validation->run()) {
            $this->load->view('admin/image_tool/slot_image', $data);
        } else {
            $path = './img/imggen/overlay/';

            $data['wm_type'] = $this->input->post('wm_type');
            $data['quality'] = '100%';
            
            $data['file'] = $this->input->post('file');

            $data['padding'] = $this->input->post('padding');
            $data['wm_vrt_alignment'] = $this->input->post('v_align');
            $data['wm_hor_alignment'] = $this->input->post('h_align');
            $data['wm_hor_offset'] = $this->input->post('h_offset');
            $data['wm_vrt_offset'] = $this->input->post('v_offset');
            
            $data['wm_text'] = $this->input->post('text');
            $data['wm_font_path'] = './system/fonts/' . $this->input->post('font');
            $data['wm_font_size'] = $this->input->post('font_size');
            $data['wm_font_color'] = $this->input->post('font_color');
            $data['wm_shadow_color'] = $this->input->post('shadow_color');
            $data['wm_shadow_distance'] = $this->input->post('shadow_distance');

            $data['wm_overlay_path'] = $path . $this->input->post('wm_overlay_path');
            $data['wm_opacity'] = $this->input->post('wm_opacity');
            $data['wm_x_transp'] = $this->input->post('wm_x_transp');
            $data['wm_y_transp'] = $this->input->post('wm_y_transp');

            $data['rank_text'] = $this->input->post('rank_text');
            $data['rank_font_size'] = $this->input->post('rank_font_size');
            $data['rank_v_align'] = $this->input->post('rank_v_align');
            $data['rank_h_align'] = $this->input->post('rank_h_align');
            $data['rank_h_offset'] = $this->input->post('rank_h_offset');
            $data['rank_v_offset'] = $this->input->post('rank_v_offset');
            $data['rank_padding'] = $this->input->post('rank_padding');
             
            $this->image_model->apply_slot_images($data);

            $this->image_model->save_slot_data($data);

            $this->load->view('admin/image_tool/slot_image_view');
        }

        $this->footer();
    }

    //sql_tool begin
    public function sql_tool()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('sql_model');

        $data['list'] = $this->sql_model->get_appliable_files();

        $this->headers('admin');
        $this->load->view('admin/sql_tool/list', $data);
        $this->footer();
    }

    //sql_tool
    public function sql_new()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('sql', 'SQL', 'required');

        if (!$this->form_validation->run()) {
            $this->headers('admin');
            $this->load->view('admin/sql_tool/new');
            $this->footer();
        } else {
            $sql = $this->input->post('sql');

            $this->load->model('sql_model');

            $this->sql_model->create_sql($sql);

            $this->load->helper('url');

            redirect('admin/sql_tool');
        }
    }
    //sql_tool

    public function sql_apply_all()
    {
        if ($this->userlevel < 5) {
            show_404();
        }

        $this->load->model('sql_model');

        $this->sql_model->apply_all_sql();

        $this->load->helper('url');

        redirect('admin/sql_tool');
    }
    //sql_tool end
}
//nowhitesp
