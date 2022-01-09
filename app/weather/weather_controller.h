#ifndef WEATHER_CONTROLLER_H
#define WEATHER_CONTROLLER_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "modules/admin_panel/admin_node.h"

#include "weather.h"

class Request;
class FormValidator;

class WeatherController : public AdminNode {
	RCPP_OBJECT(WeatherController, AdminNode);
	
public:
	void handle_request_default(Request *request);

	void admin_handle_request_main(Request *request);
	String admin_get_section_name();
	void admin_add_section_links(Vector<AdminSectionLinkInfo> *links);
	bool admin_full_render();

	void admin_render_weather_list(Request *request);
	void admin_render_weather(Request *request, Ref<Weather> weather);

	void migrate();
	virtual void add_default_data();

	static WeatherController *get_singleton();

	WeatherController();
	~WeatherController();

protected:
	static WeatherController *_self;
};

#endif