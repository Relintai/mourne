#include <string.h>
#include <iostream>
#include <string>

#include "core/bry_http/http_server.h"
#include "core/file_cache.h"
#include "core/http/web_application.h"

#include "app/mourne_application.h"

#include "database/db_init.h"

#include "core/settings.h"

#include "core/http/session_manager.h"

#include "modules/drogon/web_application.h"

//Backends
#include "backends/hash_hashlib/setup.h"

#include "app/mourne_user_controller.h"
#include "modules/users/user.h"
#include "modules/users/user_model.h"

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

	//todo init these in the module automatically
	UserController *user_controller = new MourneUserController();
	UserModel *user_model = new UserModel();
	//user_manager->set_path("./users/");

	Settings *settings = new Settings(true);
	//settings->parse_file("settings.json");

	FileCache *file_cache = new FileCache(true);
	file_cache->wwwroot = "./www";
	file_cache->wwwroot_refresh_cache();

	DatabaseManager *dbm = new DatabaseManager();

	create_databases();

	MourneApplication *app = new MourneApplication();

	app->load_settings();
	app->setup_routes();
	app->setup_middleware();

	bool migrate = Platform::get_singleton()->arg_parser.has_arg("-m");

	if (!migrate) {
		printf("Initialized!\n");
		session_manager->load_sessions();

		app->add_listener("127.0.0.1", 8080);
		LOG_INFO << "Server running on 127.0.0.1:8080";

		app->run();
	} else {
		printf("Running migrations.\n");

		session_manager->migrate();
		user_model->migrate();

		if (Platform::get_singleton()->arg_parser.has_arg("-u")) {
			printf("Creating test users.\n");
			user_model->create_test_users();
		}

		app->migrate();

		if (Platform::get_singleton()->arg_parser.has_arg("-d")) {
			printf("Adding data.\n");
			app->add_default_data();
		}
	}

	delete app;
	delete dbm;
	delete file_cache;
	delete settings;
	delete user_controller;
	delete user_model;
	delete session_manager;

	PlatformInitializer::free_all();

	return 0;
}