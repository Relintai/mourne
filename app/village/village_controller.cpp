#include "village_controller.h"

#include "web/html/form_validator.h"
#include "web/html/html_builder.h"
#include "web/http/cookie.h"
#include "web/http/http_session.h"
#include "web/http/request.h"
#include "web/http/session_manager.h"

#include "village_model.h"

void VillageController::handle_request_default(Request *request) {
}

void VillageController::create_table() {
	VillageModel::get_singleton()->create_table();
}
void VillageController::drop_table() {
	VillageModel::get_singleton()->drop_table();
}
void VillageController::create_default_entries() {
	VillageModel::get_singleton()->create_default_entries();
}

VillageController *VillageController::get_singleton() {
	return _self;
}

VillageController::VillageController() :
		Object() {

	if (_self) {
		printf("VillageController::VillageController(): Error! self is not null!/n");
	}

	_self = this;
}

VillageController::~VillageController() {
	if (_self == this) {
		_self = nullptr;
	}
}

VillageController *VillageController::_self = nullptr;
