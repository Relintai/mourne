#ifndef ASSIGNMENT_MODEL_H
#define ASSIGNMENT_MODEL_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "core/object.h"
#include "core/reference.h"

class Assignment;
class QueryResult;

class AssignmentModel : public Object {
	RCPP_OBJECT(AssignmentModel, Object);
	
public:
	virtual Ref<Assignment> get_assignment(const int id);
	virtual Vector<Ref<Assignment> > get_all();
	virtual void save_assignment(Ref<Assignment> &assignment);
	
	virtual void parse_row(Ref<QueryResult> &result, Ref<Assignment> &assignment);

	virtual void create_table();
	virtual void drop_table();
	virtual void migrate();
	virtual void add_default_data();

	static AssignmentModel *get_singleton();

	AssignmentModel();
	~AssignmentModel();

protected:
	static AssignmentModel *_self;
};

#endif