#include <string.h>
#include <iostream>
#include <string>

#include "core/file_cache.h"
#include "core/http/web_root.h"

#include "app/mourne_root.h"

#include "database/db_init.h"

#include "core/settings/settings.h"
#include "core/settings/db_settings.h"

#include "core/http/session_manager.h"

#include "modules/drogon/drogon_web_server.h"

//Backends
#include "backends/hash_hashlib/setup.h"

#include "modules/users/user.h"

#include "core/os/platform.h"
#include "platform/platform_initializer.h"

#include "core/database/database_manager.h"

void initialize_backends() {
	initialize_database_backends();
	backend_hash_hashlib_install_providers();
}

void create_databases() {
	DatabaseManager *dbm = DatabaseManager::get_singleton();

	uint32_t index = dbm->create_database("sqlite");
	Database *db = dbm->databases[index];
	db->connect("database.sqlite");
}

int main(int argc, char **argv, char **envp) {
	PlatformInitializer::allocate_all();
	PlatformInitializer::arg_setup(argc, argv, envp);

	initialize_backends();

	::SessionManager *session_manager = new ::SessionManager();

	DBSettings *settings = new DBSettings(true);
	// settings->parse_file("settings.json");

	FileCache *file_cache = new FileCache(true);
	file_cache->wwwroot = "./www";
	file_cache->wwwroot_refresh_cache();

	DatabaseManager *dbm = new DatabaseManager();

	create_databases();

	DrogonWebServer *app = new DrogonWebServer();
	MourneRoot *app_root = new MourneRoot();
	app_root->setup();

	app->set_root(app_root);

	bool migrate = Platform::get_singleton()->arg_parser.has_arg("-m");

	if (!migrate) {
		settings->load();
		session_manager->load_sessions();

		printf("Initialized!\n");
		app->add_listener("127.0.0.1", 8080);
		LOG_INFO << "Server running on 127.0.0.1:8080";

		app->run();
	} else {
		printf("Running migrations.\n");

		settings->migrate();
		session_manager->migrate();
		app_root->migrate();
	}

	delete app;
	delete dbm;
	delete file_cache;
	delete settings;
	delete session_manager;

	PlatformInitializer::free_all();

	return 0;
}