#include "weather_initializer.h"

void WeatherInitializer::allocate_controller() {
	ERR_FAIL_COND(_controller);

	_controller = new WeatherController();
}
void WeatherInitializer::free_controller() {
	if (_controller) {
		delete _controller;
		_controller = nullptr;
	}
}

void WeatherInitializer::allocate_model() {
	ERR_FAIL_COND(_model);

	_model = new WeatherModel();
}
void WeatherInitializer::free_model() {
	if (_model) {
		delete _model;
		_model = nullptr;
	}
}

void WeatherInitializer::allocate_all() {
	allocate_model();
	allocate_controller();
}
void WeatherInitializer::free_all() {
	free_controller();
	free_model();
}

WeatherController *WeatherInitializer::_controller = nullptr;
WeatherModel *WeatherInitializer::_model = nullptr;