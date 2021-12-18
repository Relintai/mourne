#include "weather.h"

void Weather::set_strings(const String &p_name, const String &p_description, const String &p_art, const String &p_css) {
	name = p_name;
	description = p_description;
	art = p_art;
	css = p_css;
}
void Weather::set_base_data(int p_effect) {
	effect = p_effect;
}

void Weather::set_mod_max(int p_mod_max_food, int p_mod_max_wood, int p_mod_max_stone, int p_mod_max_iron, int p_mod_max_mana) {
	mod_max_food = p_mod_max_food;
	mod_max_wood = p_mod_max_wood;
	mod_max_stone = p_mod_max_stone;
	mod_max_iron = p_mod_max_iron;
	mod_max_mana = p_mod_max_mana;
}
void Weather::set_mod_percent(int p_mod_percent_food, int p_mod_percent_wood, int p_mod_percent_stone, int p_mod_percent_iron, int p_mod_percent_mana) {
	mod_percent_food = p_mod_percent_food;
	mod_percent_wood = p_mod_percent_wood;
	mod_percent_stone = p_mod_percent_stone;
	mod_percent_iron = p_mod_percent_iron;
	mod_percent_mana = p_mod_percent_mana;
}

void Weather::set_all(
		const String &p_name, const String &p_description, const String &p_icon, const String &p_css,
			int p_effect,
			int p_mod_max_food, int p_mod_max_wood, int p_mod_max_stone, int p_mod_max_iron, int p_mod_max_mana,
			int p_mod_percent_food, int p_mod_percent_wood, int p_mod_percent_stone, int p_mod_percent_iron, int p_mod_percent_mana) {

	set_strings(p_name, p_description, p_icon, p_css);
	set_base_data(p_effect);
	set_mod_max(p_mod_max_food, p_mod_max_wood, p_mod_max_stone, p_mod_max_iron, p_mod_max_mana);
	set_mod_percent(p_mod_percent_food, p_mod_percent_wood, p_mod_percent_stone, p_mod_percent_iron, p_mod_percent_mana);
}

Weather::Weather() :
		Resource() {

	effect = 0;

	mod_max_food = 0;
	mod_max_wood = 0;
	mod_max_stone = 0;
	mod_max_iron = 0;
	mod_max_mana = 0;

	mod_percent_food = 0;
	mod_percent_wood = 0;
	mod_percent_stone = 0;
	mod_percent_iron = 0;
	mod_percent_mana = 0;
}

Weather::~Weather() {
}
