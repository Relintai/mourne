#include "mourne_user_model.h"

void MourneUserModel::create_test_users() {
	Ref<User> user;
	user = UserModel::get_singleton()->create_user();

	user->rank = 6;
	user->name_user_input = "admin";
	user->email_user_input = "admin@admin.com";

	create_password(user, "Password");
	save_user(user);


	user = UserModel::get_singleton()->create_user();

	user->rank = 1;
	user->name_user_input = "user";
	user->email_user_input = "user@user.com";

	create_password(user, "Password");
	save_user(user);
}

MourneUserModel::MourneUserModel() :
		UserModel() {
}

MourneUserModel::~MourneUserModel() {
}
