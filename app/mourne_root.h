#ifndef MOURNE_ROOT_H
#define MOURNE_ROOT_H

//#include "web/http/web_application.h"
#include "web/http/web_root.h"
#include "core/object.h"
#include "core/string.h"

class AdminPanel;
class RBACController;
class RBACModel;
class UserController;
class MenuNode;
class MourneUserController;
class VillageNode;

#define ENSURE_LOGIN(request)                  \
	if (!is_logged_in(request)) {              \
		request->send_redirect("/user/login"); \
		return;                                \
	}

class MourneRoot : public WebRoot {
	RCPP_OBJECT(MourneRoot, WebRoot);

public:
	enum MenuEntries {
		MENUENTRY_NEWS = 0,
		MENUENTRY_MAIL,
		MENUENTRY_HERO,
		MENUENTRY_VILLAGE,
		MENUENTRY_SELECT_VILLAGE,
		MENUENTRY_ALLIANCE,
		MENUENTRY_ALLIANCE_MENU,
		MENUENTRY_FORUM,
		MENUENTRY_CHANGELOG,
		MENUENTRY_SETTINGS,
		MENUENTRY_LOGOUT,

		MENUENTRY_MAX,
	};

public:
	void handle_request_main(Request *request);

	bool is_logged_in(Request *request);

	void add_menu(Request *request, const MenuEntries index);

	void index(Request *request);

	virtual void setup_middleware();

	void create_table();
	void drop_table();
	void udpate_table();
	void create_default_entries();

	void compile_menu();

	MourneRoot();
	~MourneRoot();

	AdminPanel *_admin_panel;
	MourneUserController *_user_controller;
	MenuNode *_menu;

	VillageNode *_village;

	static String menu_head;
	static String admin_headers;
	static String footer;
};

#endif