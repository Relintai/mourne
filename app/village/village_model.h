#ifndef VILLAGE_MODEL_H
#define VILLAGE_MODEL_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "core/object.h"

class VillageModel : public Object {
	RCPP_OBJECT(VillageModel, Object);
	
public:
	virtual void create_table();
	virtual void drop_table();
	virtual void migrate();
	virtual void add_default_data();

	static VillageModel *get_singleton();

	VillageModel();
	~VillageModel();

protected:
	static VillageModel *_self;
};

#endif