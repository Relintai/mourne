#include "mourne_root.h"

#include "web/http/request.h"

#include <iostream>

#include "web/file_cache.h"

#include "core/os/arg_parser.h"
#include "core/os/platform.h"

#include "database/database_manager.h"

#include "web/html/html_builder.h"
#include "web/http/http_session.h"
#include "web/http/session_manager.h"

#include "web_modules/admin_panel/admin_panel.h"
#include "web_modules/users/user.h"
#include "web_modules/users/user_controller.h"

#include "mourne_user_controller.h"

#include "weather/weather_initializer.h"

#include "assignments/assignment_node.h"
#include "buildings/building_node.h"
#include "village/village_node.h"

void MourneRoot::handle_request_main(Request *request) {
	if (process_middlewares(request)) {
		return;
	}

	if (try_send_wwwroot_file(request)) {
		return;
	}

	// this is a hack, until I have a simple index node, or port contentcontroller.
	if (request->get_path_segment_count() == 0) {
		index(request);
		return;
	}

	WebNode *handler = get_request_handler_child(request);

	if (!handler) {
		request->send_error(404);
		return;
	}

	add_menu(request, MENUENTRY_NEWS);
	request->push_path();
	handler->handle_request_main(request);
}

bool MourneRoot::is_logged_in(Request *request) {
	if (!request->session.is_valid()) {
		return false;
	}

	Ref<User> u = request->reference_data["user"];

	return u.is_valid();
}

void MourneRoot::index(Request *request) {
	ENSURE_LOGIN(request);

	add_menu(request, MENUENTRY_NEWS);

	/*
	<?php if (isset($hero)): ?>
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/hero.css'); ?>">
	<?php endif; ?>

	<?php if ($userlevel > 2): ?>
		<link rel="stylesheet" type="text/css" href="<?=base_url('css/admin.css'); ?>">
	<?php endif; ?>

	<?php if ($page == 'mail'): ?>
		<link rel="stylesheet" type="text/css" href="<?=base_url('css/mail.css'); ?>">
	<?php endif; ?>

	<?php if ($resources): ?>
		<script src="<?=base_url('js/resource.js'); ?>"></script>
	<?php endif; ?>
	*/

	// dynamic_cast<ListPage *>(instance)->index(request);
	request->body += "test";
	request->compile_and_send_body();
}

void MourneRoot::add_menu(Request *request, const MenuEntries index) {
	request->head += menu_head;

	HTMLBuilder b;

	HTMLTag *t;

	int userlevel = 0;

	if (request->session.is_valid()) {
		Ref<User> user = request->reference_data["user"];

		if (user.is_valid()) {
			userlevel = user->rank;
		}
	}

	if (userlevel > 4) {
		request->head += admin_headers;
	}

	/*
	<?php if ($weather): ?>
	<div class="menu_base <?=$weather['css']; ?>">
	<?php else: ?>
	<div class="menu_base">
	<?php endif; ?>
*/

	b.div()->cls("menu_base");
	{
		b.div()->cls("left");
		{
			b.div()->cls("menu_news");
			{
				b.a()->href("/news/index");
				b.w("News");
				b.ca();
			}
			b.cdiv();

			b.div()->cls("menu_mail");
			{
				b.a()->href("/mail/inbox");
				b.w("Mails");
				// if ($newmail) echo '!';
				b.ca();
			}
			b.cdiv();

			b.div()->cls("menu_hero");
			{
				b.a()->href("/hero/selected");
				b.w("Hero");
				b.ca();
			}
			b.cdiv();

			b.div()->cls("menu_village");
			{
				b.a()->href("/village/selected");
				b.w("Village"); // villagename
				b.ca();
			}
			b.cdiv();

			b.div()->cls("menu_sel_village");
			{
				b.a()->href("/village/select");
				b.w("v");
				b.ca();
			}
			b.cdiv();

			/*
			<?php if ($alliancename): ?>
			<div class="menu_alliance">
			<a href="<?=site_url($menu_alliance); ?>">[<?=$alliancename; ?>]</a>
			</div>
			<?php endif; ?>
			*/

			/*
			<?php if ($weather): ?>
			<div class="weather">
			<abbr title="<?=$weather['description']; ?>"><?=$weather['name']; ?></abbr>
			</div>
			<?php endif; ?>
			*/
		}
		b.cdiv();

		b.div()->cls("right");
		{
			if (userlevel > 4) {
				b.div()->cls("menu_gm");
				{
					b.a()->href("/gm")->f()->w("GM")->ca();
				}
				b.cdiv();
			}

			if (userlevel > 5) {
				b.div()->cls("menu_admin");
				{
					b.a()->href("/admin")->f()->w("Admin")->ca();
				}
				b.cdiv();
			}

			b.div()->cls("menu_alliance_menu");
			{
				b.a()->href("/alliance/alliance_menu");
				b.w("Alliances");
				b.ca();
			}
			b.cdiv();

			b.div()->cls("menu_forum");
			{
				b.a()->href("/forum/index");
				b.w("Forum");
				b.ca();
			}
			b.cdiv();

			b.div()->cls("menu_settings");
			{
				b.a()->href("/user/settings");
				b.w("Settings");
				b.ca();
			}
			b.cdiv();

			b.div()->cls("menu_logout");
			{
				b.a()->href("/user/logout");
				b.w("Logout");
				b.ca();
			}
			b.cdiv();
		}
		b.cdiv();

		b.div()->cls("nofloat");
		b.cdiv();
	}

	b.cdiv();
	b.div()->cls("main");
	b.write_tag();

	request->body += b.result;

	request->footer = footer;
}

void MourneRoot::setup_middleware() {
	_middlewares.push_back(Ref<SessionSetupMiddleware>(new SessionSetupMiddleware()));
	_middlewares.push_back(Ref<UserSessionSetupMiddleware>(new UserSessionSetupMiddleware()));
}

void MourneRoot::create_table() {
	// TODO move these to the node system and remove from here
	WeatherController::get_singleton()->create_table();
}
void MourneRoot::drop_table() {
	WeatherController::get_singleton()->drop_table();
}
void MourneRoot::udpate_table() {
	// TODO move these to the node system and remove from here
	WeatherController::get_singleton()->udpate_table();
}
void MourneRoot::create_default_entries() {
	// TODO move these to the node system and remove from here
	WeatherController::get_singleton()->create_default_entries();
}

void MourneRoot::compile_menu() {
	HTMLBuilder bh;

	bh.meta()->charset_utf_8();
	bh.meta()->name("description")->content("RPG browsergame");
	bh.meta()->name("keywords")->content("RPG,browsergame,Mourne,game,play");
	bh.title();
	bh.w("Mourne");
	bh.ctitle();

	bh.link()->rel_stylesheet()->href("/css/base.css");
	bh.link()->rel_stylesheet()->href("/css/menu.css");
	bh.write_tag();

	menu_head = bh.result;

	bh.result = "";
	bh.link()->rel("stylesheet")->type("text/css")->href("/css/admin.css")->f()->f();

	admin_headers = bh.result;

	HTMLBuilder bf;

	bf.cdiv();
	bf.footer();
	bf.cfooter();

	footer = bf.result;
}

MourneRoot::MourneRoot() :
		WebRoot() {

	WeatherInitializer::allocate_all();

	_village = new VillageNode();
	_village->set_uri_segment("village");
	add_child(_village);

	_building = new BuildingNode();
	_building->set_uri_segment("building");
	add_child(_building);

	_assignments = new AssignmentNode();
	_assignments->set_uri_segment("assignments");
	add_child(_assignments);

	_admin_panel = new AdminPanel();
	_admin_panel->set_uri_segment("admin");
	_admin_panel->register_admin_controller("buildings", _building);
	_admin_panel->register_admin_controller("assignments", _assignments);
	_admin_panel->register_admin_controller("weather", WeatherController::get_singleton());

	_user_controller = new MourneUserController();
	_user_controller->set_uri_segment("user");
	// user_manager->set_path("./users/");
	add_child(_user_controller);

	add_child(_admin_panel);

	HTMLBuilder b;

	b.link()->rel("stylesheet")->type("text/css")->href("/css/base.css")->f()->f();
	b.link()->rel("stylesheet")->type("text/css")->href("/css/admin.css")->f()->f();

	_admin_panel->set_default_header(b.result);

	b.result = "";
	b.div()->cls("back")->f()->a()->href("/")->f()->w("<--- Back")->ca()->cdiv();
	b.br();

	_admin_panel->set_default_main_body_top(b.result);

	compile_menu();
}

MourneRoot::~MourneRoot() {
	WeatherInitializer::free_all();
}

String MourneRoot::menu_head = "";
String MourneRoot::admin_headers = "";
String MourneRoot::footer = "";
