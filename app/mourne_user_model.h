#ifndef MOURNE_USER_MODEL_H
#define MOURNE_USER_MODEL_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "modules/users/user_model.h"

#include "modules/users/user.h"

class MourneUserModel : public UserModel {
	RCPP_OBJECT(MourneUserModel, UserModel);
	
public:
	virtual void create_test_users();

	MourneUserModel();
	~MourneUserModel();

protected:
};

#endif