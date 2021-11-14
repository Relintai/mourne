#include "village_initializer.h"

void VillageInitializer::allocate_controller() {
	ERR_FAIL_COND(_controller);

	_controller = new VillageController();
}
void VillageInitializer::free_controller() {
	if (_controller) {
		delete _controller;
		_controller = nullptr;
	}
}

void VillageInitializer::allocate_model() {
	ERR_FAIL_COND(_model);

	_model = new VillageModel();
}
void VillageInitializer::free_model() {
	if (_model) {
		delete _model;
		_model = nullptr;
	}
}

void VillageInitializer::allocate_all() {
	allocate_model();
	allocate_controller();
}
void VillageInitializer::free_all() {
	free_controller();
	free_model();
}

VillageController *VillageInitializer::_controller = nullptr;
VillageModel *VillageInitializer::_model = nullptr;