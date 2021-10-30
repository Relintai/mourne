#include "mourne_application.h"

#include "core/http/request.h"

#include <iostream>

#include "core/file_cache.h"

#include "core/http/handler_instance.h"

#include "core/database/database_manager.h"

#include "core/html/html_builder.h"
#include "core/http/http_session.h"
#include "core/http/session_manager.h"

#include "modules/users/user.h"
#include "modules/users/user_controller.h"

void MourneApplication::index(Object *instance, Request *request) {
	add_menu(request, MENUENTRY_NEWS);

	//dynamic_cast<ListPage *>(instance)->index(request);
	request->body += "test";
	request->compile_and_send_body();
}

void MourneApplication::session_middleware_func(Object *instance, Request *request) {
	std::cout << "test: session_middleware_func called" << std::endl;

	//if fail
	//request->send(); in middleware

	request->next_stage();
}

void MourneApplication::add_menu(Request *request, const MenuEntries index) {
	request->head += menu_head;
	request->body += menu_strings[index];
	request->footer = footer;
}

void MourneApplication::village_page_func(Object *instance, Request *request) {
	add_menu(request, MENUENTRY_VILLAGE);

	//dynamic_cast<ListPage *>(instance)->index(request);
	request->body += "test";
	request->compile_and_send_body();
}

void MourneApplication::user_page_func(Object *instance, Request *request) {
	add_menu(request, MENUENTRY_SETTINGS);

	UserController::get_singleton()->handle_request_default(request);
}

void MourneApplication::setup_routes() {
	DWebApplication::setup_routes();

	index_func = HandlerInstance(index);
	main_route_map["village"] = HandlerInstance(village_page_func);
	main_route_map["user"] = HandlerInstance(user_page_func);
}

void MourneApplication::setup_middleware() {
	middlewares.push_back(HandlerInstance(::SessionManager::session_setup_middleware));
	middlewares.push_back(HandlerInstance(::UserController::user_session_setup_middleware));

	DWebApplication::setup_middleware();
}

void MourneApplication::migrate() {
}

void MourneApplication::compile_menu() {

	for (int i = 0; i < MENUENTRY_MAX; ++i) {
		HTMLBuilder b;

		HTMLTag *t;

		b.div()->cls("content");
		{

			b.ul()->cls("menu");
			{
				b.li();
				t = b.a()->href("/");

				if (i == MENUENTRY_NEWS) {
					t->cls("menu_active");
				}

				b.w("TSITE");
				b.ca();
				b.cli();

				b.li();
				t = b.a()->href("/village/selected");

				if (i == MENUENTRY_VILLAGE) {
					t->cls("menu_active");
				}

				b.w("Projects");
				b.ca();
				b.cli();

				b.li();
				{
					t = b.a()->href("/village/select");

					if (i == MENUENTRY_SELECT_VILLAGE) {
						t->cls("menu_active");
					}

					b.w("Classes");
					b.ca();
				}
				b.cli();

				b.li();
				{
					t = b.a()->href("/user/login");
					b.w("Login");
					b.ca();
				}
				b.cli();

				b.li();
				{
					t = b.a()->href("/user/register");
					b.w("Register");
					b.ca();
				}
				b.cli();

				b.li();
				{
					t = b.a()->href("/user/settings");
					b.w("Profile");
					b.ca();
				}
				b.cli();

				b.li();
				{
					t = b.a()->href("/user/logout");
					b.w("Logout");
					b.ca();
				}
				b.cli();
			}
			b.cul();
		}
		b.div()->cls("inner_content");
		b.write_tag();

		menu_strings.push_back(b.result);
	}

	HTMLBuilder bh;

	bh.meta()->charset_utf_8();

	bh.link()->rel_stylesheet()->href("/css/main.css");
	bh.write_tag();

	menu_head = bh.result;

	HTMLBuilder bf;

	bf.cdiv();
	bf.footer();
	bf.w("Powered by ");
	bf.a()->href("https://github.com/Relintai/rcpp_cms");
	bf.w("rcpp cms");
	bf.ca();
	bf.w(".");
	bf.cfooter();

	bf.cdiv();

	footer = bf.result;
}

MourneApplication::MourneApplication() :
		DWebApplication() {

	compile_menu();
}

MourneApplication::~MourneApplication() {
}

std::vector<std::string> MourneApplication::menu_strings;
std::string MourneApplication::menu_head = "";
std::string MourneApplication::footer = "";
