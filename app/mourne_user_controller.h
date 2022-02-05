#ifndef MOURNE_USER_CONTROLLER_H
#define MOURNE_USER_CONTROLLER_H

#include "web_modules/users/user_controller.h"

#include <string>
#include "web_modules/users/user.h"

class Request;
class FormValidator;

class MourneUserController : public UserController {
	RCPP_OBJECT(MourneUserController, UserController);
public:
	void render_login_request_default(Request *request, LoginRequestData *data);
	void render_register_request_default(Request *request, RegisterRequestData *data);
	void render_login_success(Request *request);
	void render_already_logged_in_error(Request *request);
	void render_settings_request(Ref<User> &user, Request *request, SettingsRequestData *data);

	void create_default_entries();

	MourneUserController();
	~MourneUserController();
};

#endif