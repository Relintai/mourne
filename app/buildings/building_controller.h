#ifndef BUILDING_CONTROLLER_H
#define BUILDING_CONTROLLER_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "core/object.h"

#include "building.h"

class Request;
class FormValidator;

class BuildingController : public Object {
	RCPP_OBJECT(BuildingController, Object);
	
public:
	void migrate();
	virtual void add_default_data();

	virtual void handle_request_default(Request *request);

	static BuildingController *get_singleton();

	BuildingController();
	~BuildingController();

protected:
	static BuildingController *_self;
};

#endif