#ifndef ASSIGNMENT_INITIALIZER_H
#define ASSIGNMENT_INITIALIZER_H

#include "assignment_model.h"
#include "assignment_controller.h"

class AssignmentInitializer {
public:
	static void allocate_controller();
	static void free_controller();

	static void allocate_model();
	static void free_model();

	static void allocate_all();
	static void free_all();

protected:
	static AssignmentController *_controller;
	static AssignmentModel *_model;
};

#endif