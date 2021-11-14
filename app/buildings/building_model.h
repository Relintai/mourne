#ifndef BUILDING_MODEL_H
#define BUILDING_MODEL_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "core/object.h"

class BuildingModel : public Object {
	RCPP_OBJECT(BuildingModel, Object);
	
public:
	virtual void create_table();
	virtual void drop_table();
	virtual void migrate();
	virtual void add_default_data();

	static BuildingModel *get_singleton();

	BuildingModel();
	~BuildingModel();

protected:
	static BuildingModel *_self;
};

#endif