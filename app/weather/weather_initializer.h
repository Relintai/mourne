#ifndef WEATHER_INITIALIZER_H
#define WEATHER_INITIALIZER_H

#include "weather_model.h"
#include "weather_controller.h"

class WeatherInitializer {
public:
	static void allocate_controller();
	static void free_controller();

	static void allocate_model();
	static void free_model();

	static void allocate_all();
	static void free_all();

protected:
	static WeatherController *_controller;
	static WeatherModel *_model;
};

#endif