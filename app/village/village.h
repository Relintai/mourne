#ifndef VILLAGE_H
#define VILLAGE_H

#include "core/string.h"

#include "core/resource.h"

class Village : public Resource {
	RCPP_OBJECT(Village, Resource);

public:
	Village();
	~Village();
};

#endif