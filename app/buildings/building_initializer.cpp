#include "building_initializer.h"

void BuildingInitializer::allocate_controller() {
	ERR_FAIL_COND(_controller);

	_controller = new BuildingController();
}
void BuildingInitializer::free_controller() {
	if (_controller) {
		delete _controller;
		_controller = nullptr;
	}
}

void BuildingInitializer::allocate_model() {
	ERR_FAIL_COND(_model);

	_model = new BuildingModel();
}
void BuildingInitializer::free_model() {
	if (_model) {
		delete _model;
		_model = nullptr;
	}
}

void BuildingInitializer::allocate_all() {
	allocate_model();
	allocate_controller();
}
void BuildingInitializer::free_all() {
	free_controller();
	free_model();
}

BuildingController *BuildingInitializer::_controller = nullptr;
BuildingModel *BuildingInitializer::_model = nullptr;