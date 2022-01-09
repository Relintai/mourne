#ifndef ASSIGNMENT_CONTROLLER_H
#define ASSIGNMENT_CONTROLLER_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "modules/admin_panel/admin_node.h"

#include "assignment.h"

class Request;
class FormValidator;

class AssignmentController : public AdminNode {
	RCPP_OBJECT(AssignmentController, AdminNode);
	
public:
	void handle_request_default(Request *request);

	void admin_handle_request_main(Request *request);
	String admin_get_section_name();
	void admin_add_section_links(Vector<AdminSectionLinkInfo> *links);
	bool admin_full_render();

	void admin_render_assignment_list(Request *request);
	void admin_render_assignment(Request *request, Ref<Assignment> assignment);

	void migrate();
	virtual void add_default_data();

	static AssignmentController *get_singleton();

	AssignmentController();
	~AssignmentController();

protected:
	static AssignmentController *_self;
};

#endif