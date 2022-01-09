#ifndef HTML_MACROS_H
#define HTML_MACROS_H

#define ADMIN_EDIT_INPUT_TEXT(p_edit_name, p_var_name, p_show_post, p_var, p_request_var)                            \
	b.div("row_edit");                                                                                               \
	b.fdiv(p_edit_name, "edit_name");                                                                                \
	b.div("edit_input")->input_text(p_var_name, p_show_post ? p_request_var : p_var, "", "input")->cdiv(); \
	b.cdiv();

#define ADMIN_EDIT_INPUT_TEXTAREA(p_edit_name, p_var_name, p_show_post, p_var, p_request_var)                 \
	b.div("row_edit_textbox");                                                                                \
	b.fdiv(p_edit_name, "edit_name");                                                                         \
	b.div("edit_input")->ftextarea(p_var_name, p_show_post ? p_request_var : p_var, "textarea")->cdiv(); \
	b.cdiv();

#define ADMIN_EDIT_LINE_SPACER() \
	b.fdiv("", "edit_spacer");

#endif