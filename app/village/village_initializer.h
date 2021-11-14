#ifndef VILLAGE_INITIALIZER_H
#define VILLAGE_INITIALIZER_H

#include "village_model.h"
#include "village_controller.h"

class VillageInitializer {
public:
	static void allocate_controller();
	static void free_controller();

	static void allocate_model();
	static void free_model();

	static void allocate_all();
	static void free_all();

protected:
	static VillageController *_controller;
	static VillageModel *_model;
};

#endif