#include "village_controller.h"

#include "core/html/form_validator.h"
#include "core/html/html_builder.h"
#include "core/http/cookie.h"
#include "core/http/http_session.h"
#include "core/http/request.h"
#include "core/http/session_manager.h"

#include "village_model.h"

void VillageController::handle_request_default(Request *request) {
}

void VillageController::migrate() {
	VillageModel::get_singleton()->migrate();
}
void VillageController::add_default_data() {
	VillageModel::get_singleton()->add_default_data();
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
