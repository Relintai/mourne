#ifndef RDN_APPLICATION_H
#define RDN_APPLICATION_H

//#include "core/http/web_application.h"
#include "core/object.h"
#include "modules/drogon/web_application.h"

#include "modules/list_page/list_page.h"
#include "modules/message_page/message_page.h"
#include "modules/paged_article/paged_article.h"
#include "modules/paged_list/paged_list.h"

#define ENSURE_LOGIN(request) \
	if (!ensure_login(request)) { \
		return;\
	}

class MourneApplication : public DWebApplication {
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
	static bool ensure_login(Request *request);

	static void index(Object *instance, Request *request);

	static void session_middleware_func(Object *instance, Request *request);

	static void add_menu(Request *request, const MenuEntries index);

	static void village_page_func(Object *instance, Request *request);
	static void user_page_func(Object *instance, Request *request);

	virtual void setup_routes();
	virtual void setup_middleware();

	virtual void migrate();

	void compile_menu();

	MourneApplication();
	~MourneApplication();

	static std::string menu_head;
	static std::string footer;
};

#endif