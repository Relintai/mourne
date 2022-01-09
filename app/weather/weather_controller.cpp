#include "weather_controller.h"

#include "core/html/form_validator.h"
#include "core/html/html_builder.h"
#include "core/http/cookie.h"
#include "core/http/http_enums.h"
#include "core/http/http_session.h"
#include "core/http/request.h"
#include "core/http/session_manager.h"

#include "weather_model.h"

#include "../html_macros.h"

void WeatherController::handle_request_default(Request *request) {
}

void WeatherController::admin_handle_request_main(Request *request) {
	String seg = request->get_current_path_segment();

	if (seg == "") {
		admin_render_weather_list(request);
		return;
	} else if (seg == "new") {
		request->push_path();
		Ref<Weather> b;
		b.instance();

		admin_render_weather(request, b);
		return;
	} else if (seg == "edit") {
		request->push_path();

		String seg_weather_id = request->get_current_path_segment();

		if (!seg_weather_id.is_int()) {
			request->send_error(HTTP_STATUS_CODE_404_NOT_FOUND);
			return;
		}

		int bid = seg_weather_id.to_int();

		Ref<Weather> b = WeatherModel::get_singleton()->get_weather(bid);

		if (!b.is_valid()) {
			request->send_error(HTTP_STATUS_CODE_404_NOT_FOUND);
			return;
		}

		admin_render_weather(request, b);
		return;
	}

	request->send_error(404);
}
String WeatherController::admin_get_section_name() {
	return "Weathers";
}
void WeatherController::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- Weather Editor", ""));
}
bool WeatherController::admin_full_render() {
	return false;
}

void WeatherController::admin_render_weather_list(Request *request) {
	Vector<Ref<Weather> > weathers = WeatherModel::get_singleton()->get_all();

	HTMLBuilder b;

	b.div("back")->fa(request->get_url_root_parent(), "<--- Back")->cdiv();
	b.br();
	b.fdiv("Weather Editor", "top_menu");
	b.br();
	b.div("top_menu")->fa(request->get_url_root("new"), "Create New")->cdiv();
	b.br();

	b.div("list_container");

	for (int i = 0; i < weathers.size(); ++i) {
		Ref<Weather> weather = weathers[i];

		if (!weather.is_valid()) {
			continue;
		}

		if (i % 2 == 0) {
			b.div("row");
		} else {
			b.div("row second");
		}
		{
			b.fdiv(String::num(weather->id), "attr_box");
			b.fdiv(weather->name, "name");

			b.div("actionbox")->fa(request->get_url_root("edit/" + String::num(weather->id)), "Edit")->cdiv();
		}
		b.cdiv();
	}

	b.cdiv();

	request->body += b.result;
}

void WeatherController::admin_render_weather(Request *request, Ref<Weather> weather) {
	if (!weather.is_valid()) {
		RLOG_ERR("admin_render_weather: !weather.is_valid()\n");
		request->send_error(HTTP_STATUS_CODE_500_INTERNAL_SERVER_ERROR);
		return;
	}

	Vector<Ref<Weather> > weathers = WeatherModel::get_singleton()->get_all();

	HTMLBuilder b;

	b.div("back")->fa(request->get_url_root_parent(), "<--- Back")->cdiv();
	b.br();
	b.fdiv("Weather Editor", "top_menu");
	b.br();

	b.form_post(request->get_url_root());

	bool show_post = false; //request->get_method() == HTTP_METHOD_POST && validation errors;

	ADMIN_EDIT_INPUT_TEXT("Name:", "name", show_post, weather->name, request->get_parameter("name"));
	ADMIN_EDIT_INPUT_TEXTAREA("Description:", "description", show_post, weather->description, request->get_parameter("description"));
	//I think this was supposed to be an icon
	ADMIN_EDIT_INPUT_TEXT("Art:", "art", show_post, weather->art, request->get_parameter("art"));
	ADMIN_EDIT_INPUT_TEXT("CSS:", "css", show_post, weather->css, request->get_parameter("css"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Effect:", "effect", show_post, String::num(weather->effect), request->get_parameter("effect"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Mod Max Food:", "mod_max_food", show_post, String::num(weather->mod_max_food), request->get_parameter("mod_max_food"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Wood:", "mod_max_wood", show_post, String::num(weather->mod_max_wood), request->get_parameter("mod_max_wood"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Stone:", "mod_max_stone", show_post, String::num(weather->mod_max_stone), request->get_parameter("mod_max_stone"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Iron:", "mod_max_iron", show_post, String::num(weather->mod_max_iron), request->get_parameter("mod_max_iron"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Mana:", "mod_max_mana", show_post, String::num(weather->mod_max_mana), request->get_parameter("mod_max_mana"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Mod Percent Food:", "mod_percent_food", show_post, String::num(weather->mod_percent_food), request->get_parameter("mod_percent_food"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Wood:", "mod_percent_wood", show_post, String::num(weather->mod_percent_wood), request->get_parameter("mod_percent_wood"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Stone:", "mod_percent_stone", show_post, String::num(weather->mod_percent_stone), request->get_parameter("mod_percent_stone"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Iron:", "mod_percent_iron", show_post, String::num(weather->mod_percent_iron), request->get_parameter("mod_percent_iron"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Mana:", "mod_percent_mana", show_post, String::num(weather->mod_percent_mana), request->get_parameter("mod_percent_mana"));

	b.div("edit_submit")->input_submit("Save", "submit")->cdiv();

	b.cform();

	request->body += b.result;
}

void WeatherController::migrate() {
	WeatherModel::get_singleton()->migrate();
}
void WeatherController::add_default_data() {
	WeatherModel::get_singleton()->add_default_data();
}

WeatherController *WeatherController::get_singleton() {
	return _self;
}

WeatherController::WeatherController() :
		AdminNode() {

	if (_self) {
		printf("WeatherController::WeatherController(): Error! self is not null!/n");
	}

	_self = this;
}

WeatherController::~WeatherController() {
	if (_self == this) {
		_self = nullptr;
	}
}

WeatherController *WeatherController::_self = nullptr;
