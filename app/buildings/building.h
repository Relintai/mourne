#ifndef BUILDING_H
#define BUILDING_H

#include "core/string.h"

#include "core/resource.h"

class Building : public Resource {
	RCPP_OBJECT(Building, Resource);

public:
	Building();
	~Building();
};

#endif