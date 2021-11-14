#ifndef BUILDING_MODEL_H
#define BUILDING_MODEL_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "core/object.h"
#include "core/reference.h"

class Building;
class QueryResult;

class BuildingModel : public Object {
	RCPP_OBJECT(BuildingModel, Object);
	
public:
	virtual Ref<Building> get_building(const int id);
	virtual Vector<Ref<Building> > get_all();
	virtual void save_building(Ref<Building> &building);

	virtual void parse_row(Ref<QueryResult> &result, Ref<Building> &building);

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