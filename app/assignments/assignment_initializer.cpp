#include "assignment_initializer.h"

void AssignmentInitializer::allocate_controller() {
	ERR_FAIL_COND(_controller);

	_controller = new AssignmentController();
}
void AssignmentInitializer::free_controller() {
	if (_controller) {
		delete _controller;
		_controller = nullptr;
	}
}

void AssignmentInitializer::allocate_model() {
	ERR_FAIL_COND(_model);

	_model = new AssignmentModel();
}
void AssignmentInitializer::free_model() {
	if (_model) {
		delete _model;
		_model = nullptr;
	}
}

void AssignmentInitializer::allocate_all() {
	allocate_model();
	allocate_controller();
}
void AssignmentInitializer::free_all() {
	free_controller();
	free_model();
}

AssignmentController *AssignmentInitializer::_controller = nullptr;
AssignmentModel *AssignmentInitializer::_model = nullptr;