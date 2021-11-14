#ifndef BUILDING_INITIALIZER_H
#define BUILDING_INITIALIZER_H

#include "building_model.h"
#include "building_controller.h"

class BuildingInitializer {
public:
	static void allocate_controller();
	static void free_controller();

	static void allocate_model();
	static void free_model();

	static void allocate_all();
	static void free_all();

protected:
	static BuildingController *_controller;
	static BuildingModel *_model;
};

#endif