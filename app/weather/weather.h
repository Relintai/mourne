#ifndef WEATHER_H
#define WEATHER_H

#include "core/string.h"

#include "core/resource.h"

class Weather : public Resource {
	RCPP_OBJECT(Weather, Resource);

public:
	String name;
	String description;
	String art;
	String css;

	int effect;

	int mod_max_food;
	int mod_max_wood;
	int mod_max_stone;
	int mod_max_iron;
	int mod_max_mana;

	int mod_percent_food;
	int mod_percent_wood;
	int mod_percent_stone;
	int mod_percent_iron;
	int mod_percent_mana;

	void set_strings(const String &p_name, const String &p_description, const String &p_art, const String &p_css);
	void set_base_data(int p_effect);
	void set_mod_max(int p_mod_max_food, int p_mod_max_wood, int p_mod_max_stone, int p_mod_max_iron, int p_mod_max_mana);
	void set_mod_percent(int p_mod_percent_food, int p_mod_percent_wood, int p_mod_percent_stone, int p_mod_percent_iron, int p_mod_percent_mana);

	void set_all(
			const String &p_name, const String &p_description, const String &p_icon, const String &p_css,
			int p_effect,
			int p_mod_max_food, int p_mod_max_wood, int p_mod_max_stone, int p_mod_max_iron, int p_mod_max_mana,
			int p_mod_percent_food, int p_mod_percent_wood, int p_mod_percent_stone, int p_mod_percent_iron, int p_mod_percent_mana);

	Weather();
	~Weather();
};

#endif