#include "assignment.h"

void Assignment::set_strings(const String &p_description) {
	description = p_description;
}
void Assignment::set_base_data(int p_unitid, int p_max, int p_bonus_per_assigned, int p_spellid, int p_req_tech) {
	unitid = p_unitid;
	max = p_max;
	bonus_per_assigned = p_bonus_per_assigned;
	spellid = p_spellid;
	req_tech = p_req_tech;
}

void Assignment::set_mod_max(int p_mod_max_food, int p_mod_max_wood, int p_mod_max_stone, int p_mod_max_iron, int p_mod_max_mana) {
	mod_max_food = p_mod_max_food;
	mod_max_wood = p_mod_max_wood;
	mod_max_stone = p_mod_max_stone;
	mod_max_iron = p_mod_max_iron;
	mod_max_mana = p_mod_max_mana;
}
void Assignment::set_mod_rate(double p_mod_rate_food, double p_mod_rate_wood, double p_mod_rate_stone, double p_mod_rate_iron, double p_mod_rate_mana) {
	mod_rate_food = p_mod_rate_food;
	mod_rate_wood = p_mod_rate_wood;
	mod_rate_stone = p_mod_rate_stone;
	mod_rate_iron = p_mod_rate_iron;
	mod_rate_mana = p_mod_rate_mana;
}
void Assignment::set_mod_percent(int p_mod_percent_food, int p_mod_percent_wood, int p_mod_percent_stone, int p_mod_percent_iron, int p_mod_percent_mana) {
	mod_percent_food = p_mod_percent_food;
	mod_percent_wood = p_mod_percent_wood;
	mod_percent_stone = p_mod_percent_stone;
	mod_percent_iron = p_mod_percent_iron;
	mod_percent_mana = p_mod_percent_mana;
}

void Assignment::set_all(
		const String &p_description,
			int p_unitid, int p_max, int p_bonus_per_assigned, int p_spellid, int p_req_tech,
			int p_mod_max_food, int p_mod_max_wood, int p_mod_max_stone, int p_mod_max_iron, int p_mod_max_mana,
			double p_mod_rate_food, double p_mod_rate_wood, double p_mod_rate_stone, double p_mod_rate_iron, double p_mod_rate_mana,
			int p_mod_percent_food, int p_mod_percent_wood, int p_mod_percent_stone, int p_mod_percent_iron, int p_mod_percent_mana) {

	set_strings(p_description);
	set_base_data(p_unitid, p_max, p_bonus_per_assigned, p_spellid, p_req_tech);
	set_mod_max(p_mod_max_food, p_mod_max_wood, p_mod_max_stone, p_mod_max_iron, p_mod_max_mana);
	set_mod_rate(p_mod_rate_food, p_mod_rate_wood, p_mod_rate_stone, p_mod_rate_iron, p_mod_rate_mana);
	set_mod_percent(p_mod_percent_food, p_mod_percent_wood, p_mod_percent_stone, p_mod_percent_iron, p_mod_percent_mana);
}

Assignment::Assignment() :
		Resource() {

	unitid = 0;
	max = 0;
	bonus_per_assigned = 0;
	spellid = 0;
	req_tech = 0;

	mod_max_food = 0;
	mod_max_wood = 0;
	mod_max_stone = 0;
	mod_max_iron = 0;
	mod_max_mana = 0;

	mod_rate_food = 0;
	mod_rate_wood = 0;
	mod_rate_stone = 0;
	mod_rate_iron = 0;
	mod_rate_mana = 0;

	mod_percent_food = 0;
	mod_percent_wood = 0;
	mod_percent_stone = 0;
	mod_percent_iron = 0;
	mod_percent_mana = 0;
}

Assignment::~Assignment() {
}
