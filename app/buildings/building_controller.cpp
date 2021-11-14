#include "building_controller.h"

#include "core/html/form_validator.h"
#include "core/html/html_builder.h"
#include "core/http/cookie.h"
#include "core/http/http_session.h"
#include "core/http/request.h"
#include "core/http/session_manager.h"

#include "building_model.h"

void BuildingController::handle_request_default(Request *request) {
}

void BuildingController::migrate() {
	BuildingModel::get_singleton()->migrate();
}
void BuildingController::add_default_data() {
	BuildingModel::get_singleton()->add_default_data();
}

BuildingController *BuildingController::get_singleton() {
	return _self;
}

BuildingController::BuildingController() :
		Object() {

	if (_self) {
		printf("BuildingController::BuildingController(): Error! self is not null!/n");
	}

	_self = this;
}

BuildingController::~BuildingController() {
	if (_self == this) {
		_self = nullptr;
	}
}

BuildingController *BuildingController::_self = nullptr;
