#ifndef ASSIGNMENT_H
#define ASSIGNMENT_H

#include "core/string.h"

#include "core/resource.h"

class Assignment : public Resource {
	RCPP_OBJECT(Assignment, Resource);

public:
	int unitid;
	int max;
	int bonus_per_assigned;
	int spellid;
	int req_tech;

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

	String description;

	void set_strings(const String &p_description);
	void set_base_data(int p_unitid, int p_max, int p_bonus_per_assigned, int p_spellid, int p_req_tech);
	void set_mod_max(int p_mod_max_food, int p_mod_max_wood, int p_mod_max_stone, int p_mod_max_iron, int p_mod_max_mana);
	void set_mod_rate(double p_mod_rate_food, double p_mod_rate_wood, double p_mod_rate_stone, double p_mod_rate_iron, double p_mod_rate_mana);
	void set_mod_percent(int p_mod_percent_food, int p_mod_percent_wood, int p_mod_percent_stone, int p_mod_percent_iron, int p_mod_percent_mana);

	void set_all(
			const String &p_description,
			int p_unitid, int p_max, int p_bonus_per_assigned, int p_spellid, int p_req_tech,
			int p_mod_max_food, int p_mod_max_wood, int p_mod_max_stone, int p_mod_max_iron, int p_mod_max_mana,
			double p_mod_rate_food, double p_mod_rate_wood, double p_mod_rate_stone, double p_mod_rate_iron, double p_mod_rate_mana,
			int p_mod_percent_food, int p_mod_percent_wood, int p_mod_percent_stone, int p_mod_percent_iron, int p_mod_percent_mana);

	Assignment();
	~Assignment();
};

#endif