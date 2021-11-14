#ifndef VILLAGE_CONTROLLER_H
#define VILLAGE_CONTROLLER_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "core/object.h"

#include "village.h"

class Request;
class FormValidator;

class VillageController : public Object {
	RCPP_OBJECT(VillageController, Object);
	
public:
	void migrate();
	virtual void add_default_data();

	virtual void handle_request_default(Request *request);

	static VillageController *get_singleton();

	VillageController();
	~VillageController();

protected:
	static VillageController *_self;
};

#endif