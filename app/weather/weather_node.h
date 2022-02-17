#ifndef WEATHER_NODE_H
#define WEATHER_NODE_H

#include "core/containers/vector.h"
#include "core/string.h"

#include "web_modules/admin_panel/admin_node.h"

#include "weather.h"

class Request;
class FormValidator;
class QueryResult;

class WeatherNode : public AdminNode {
	RCPP_OBJECT(WeatherNode, AdminNode);

public:
	void handle_request_default(Request *request);

	void admin_handle_request_main(Request *request);
	String admin_get_section_name();
	void admin_add_section_links(Vector<AdminSectionLinkInfo> *links);
	bool admin_full_render();

	void admin_render_weather_list(Request *request);
	void admin_render_weather(Request *request, Ref<Weather> weather);

	virtual Ref<Weather> db_get_weather(const int id);
	virtual Vector<Ref<Weather> > db_get_all();
	virtual void db_save_weather(Ref<Weather> &weather);

	virtual void db_parse_row(Ref<QueryResult> &result, Ref<Weather> &weather);

	void create_table();
	void drop_table();
	void create_default_entries();

	static WeatherNode *get_singleton();

	WeatherNode();
	~WeatherNode();

protected:
	static WeatherNode *_self;
};

#endif