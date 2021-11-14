#ifndef BUILDING_H
#define BUILDING_H

#include "core/string.h"

#include "core/resource.h"

class Building : public Resource {
	RCPP_OBJECT(Building, Resource);

public:
	String name;
	String description;
	String icon;

	int rank;
	int next_rank;
	int time_to_build;
	int creates;
	int num_creates;
	int score;
	int defense;
	int ability;

	int cost_food;
	int cost_wood;
	int cost_stone;
	int cost_iron;
	int cost_mana;

	int mod_max_food;
	int mod_max_wood;
	int mod_max_stone;
	int mod_max_iron;
	int mod_max_mana;

	double mod_rate_food;
	double mod_rate_wood;
	double mod_rate_stone;
	double mod_rate_iron;
	double mod_rate_mana;

	int mod_percent_food;
	int mod_percent_wood;
	int mod_percent_stone;
	int mod_percent_iron;
	int mod_percent_mana;

	int assignment1;
	int assignment2;
	int assignment3;
	int assignment4;
	int assignment5;

	int req_tech;
	int tech_group;
	int tech_secondary_group;

	void set_strings(const String &p_name, const String &p_description, const String &p_icon);
	void set_base_data(int p_rank, int p_next_rank, int p_time_to_build, int p_creates, int p_num_creates, int p_score, int p_defense, int p_ability);
	void set_cost(int p_cost_food, int p_cost_wood, int p_cost_stone, int p_cost_iron, int p_cost_mana);
	void set_mod_max(int p_mod_max_food, int p_mod_max_wood, int p_mod_max_stone, int p_mod_max_iron, int p_mod_max_mana);
	void set_mod_rate(int p_mod_rate_food, int p_mod_rate_wood, int p_mod_rate_stone, int p_mod_rate_iron, int p_mod_rate_mana);
	void set_mod_percent(int p_mod_percent_food, int p_mod_percent_wood, int p_mod_percent_stone, int p_mod_percent_iron, int p_mod_percent_mana);
	void set_assignments(int p_assignment1, int p_assignment2, int p_assignment3, int p_assignment4, int p_assignment5);
	void set_technologies(int p_req_tech, int p_tech_group, int p_tech_secondary_group);

	Building();
	~Building();
};

#endif