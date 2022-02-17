#ifndef ASSIGNMENT_CONTROLLER_H
#define ASSIGNMENT_CONTROLLER_H

#include "core/containers/vector.h"
#include "core/string.h"

#include "web_modules/admin_panel/admin_node.h"

#include "assignment.h"

class Request;
class FormValidator;
class QueryResult;

class AssignmentNode : public AdminNode {
	RCPP_OBJECT(AssignmentNode, AdminNode);

public:
	void handle_request_default(Request *request);

	void admin_handle_request_main(Request *request);
	String admin_get_section_name();
	void admin_add_section_links(Vector<AdminSectionLinkInfo> *links);
	bool admin_full_render();

	void admin_render_assignment_list(Request *request);
	void admin_render_assignment(Request *request, Ref<Assignment> assignment);

	virtual Ref<Assignment> db_get_assignment(const int id);
	virtual Vector<Ref<Assignment> > db_get_all();
	virtual void db_save_assignment(Ref<Assignment> &assignment);

	virtual void db_parse_row(Ref<QueryResult> &result, Ref<Assignment> &assignment);

	void create_table();
	void drop_table();
	void create_default_entries();

	static AssignmentNode *get_singleton();

	AssignmentNode();
	~AssignmentNode();

protected:
	static AssignmentNode *_self;
};

#endif