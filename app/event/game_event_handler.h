#ifndef GAME_EVENT_HANDLER_H
#define GAME_EVENT_HANDLER_H

#include "core/containers/vector.h"
#include "core/string.h"

#include "web_modules/admin_panel/admin_node.h"

class Request;
class FormValidator;
class QueryResult;

class GameEventHandler : public Reference {
	RCPP_OBJECT(GameEventHandler, Reference);

public:
	GameEventHandler();
	~GameEventHandler();
};

#endif