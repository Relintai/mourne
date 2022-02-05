#include "mourne_user_controller.h"

#include "web/html/form_validator.h"
#include "web/html/html_builder.h"
#include "web/http/cookie.h"
#include "web/http/http_session.h"
#include "web/http/request.h"
#include "web/http/session_manager.h"

void MourneUserController::render_login_request_default(Request *request, LoginRequestData *data) {
	HTMLBuilder b;

	b.w("Login");
	b.br();

	{
		if (data->error_str.size() != 0) {
			b.div()->cls("error");

			b.w(data->error_str);

			b.cdiv();
		}
	}

	b.div()->cls("login");
	{
		// todo href path helper
		b.form()->method("POST")->href("/user/login");
		{
			b.w("Username");
			b.br();
			b.input()->type("text")->name("username")->value(data->uname_val);
			b.cinput();
			b.br();

			b.w("Password");
			b.br();
			b.input()->type("password")->name("password");
			b.cinput();
			b.br();

			b.input()->type("submit")->value("Send");
			b.cinput();
		}
		b.cform();

		b.a()->href("/user/register");
		b.w("Register");
		b.ca();
	}
	b.cdiv();

	request->body += b.result;

	request->compile_and_send_body();
}

void MourneUserController::render_register_request_default(Request *request, RegisterRequestData *data) {
	HTMLBuilder b;

	b.w("Registration");
	b.br();

	{
		if (data->error_str.size() != 0) {
			b.div()->cls("error");

			b.w(data->error_str);

			b.cdiv();
		}
	}

	b.div()->cls("register");
	{
		// todo href path helper
		b.form()->method("POST")->href("/user/register");
		{
			b.w("Username");
			b.br();
			b.input()->type("text")->name("username")->value(data->uname_val);
			b.cinput();
			b.br();

			b.w("Email");
			b.br();
			b.input()->type("email")->name("email")->value(data->email_val);
			b.cinput();
			b.br();

			b.w("Password");
			b.br();
			b.input()->type("password")->name("password");
			b.cinput();
			b.br();

			b.w("Password again");
			b.br();
			b.input()->type("password")->name("password_check");
			b.cinput();
			b.br();

			b.input()->type("submit")->value("Register");
			b.cinput();
		}
		b.cform();
	}
	b.cdiv();

	request->body += b.result;

	request->compile_and_send_body();
}

void MourneUserController::render_login_success(Request *request) {
	request->body = "Login Success!<br>";

	request->send_redirect("/");
}

void MourneUserController::render_already_logged_in_error(Request *request) {
	request->body += "You are already logged in.";

	request->compile_and_send_body();
}

void MourneUserController::render_settings_request(Ref<User> &user, Request *request, SettingsRequestData *data) {
	HTMLBuilder b;

	b.w("Settings");
	b.br();

	{
		if (data->error_str.size() != 0) {
			b.div()->cls("error");

			b.w(data->error_str);

			b.cdiv();
		}
	}

	b.div()->cls("settings");
	{
		// todo href path helper
		b.form()->method("POST")->href("/user/settings");
		{
			b.w("Username");
			b.br();
			b.input()->type("text")->name("username")->placeholder(user->name_user_input)->value(data->uname_val);
			b.cinput();
			b.br();

			b.w("Email");
			b.br();
			b.input()->type("email")->name("email")->placeholder(user->email_user_input)->value(data->email_val);
			b.cinput();
			b.br();

			b.w("Password");
			b.br();
			b.input()->type("password")->placeholder("*******")->name("password");
			b.cinput();
			b.br();

			b.w("Password again");
			b.br();
			b.input()->type("password")->placeholder("*******")->name("password_check");
			b.cinput();
			b.br();

			b.input()->type("submit")->value("Save");
			b.cinput();
		}
		b.cform();
	}
	b.cdiv();

	request->body += b.result;

	request->compile_and_send_body();
}

void MourneUserController::create_default_entries() {
	Ref<User> user;
	user = create_user();

	user->rank = 6;
	user->name_user_input = "admin";
	user->email_user_input = "admin@admin.com";

	create_password(user, "Password");
	db_save_user(user);

	user = create_user();

	user->rank = 1;
	user->name_user_input = "user";
	user->email_user_input = "user@user.com";

	create_password(user, "Password");
	db_save_user(user);
}

MourneUserController::MourneUserController() :
		UserController() {
}

MourneUserController::~MourneUserController() {
}
