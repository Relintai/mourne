#ifndef WEATHER_MODEL_H
#define WEATHER_MODEL_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "core/object.h"
#include "core/reference.h"

class Weather;
class QueryResult;

class WeatherModel : public Object {
	RCPP_OBJECT(WeatherModel, Object);
	
public:
	virtual Ref<Weather> get_weather(const int id);
	virtual Vector<Ref<Weather> > get_all();
	virtual void save_weather(Ref<Weather> &weather);
	
	virtual void parse_row(Ref<QueryResult> &result, Ref<Weather> &weather);

	virtual void create_table();
	virtual void drop_table();
	virtual void migrate();
	virtual void add_default_data();

	static WeatherModel *get_singleton();

	WeatherModel();
	~WeatherModel();

protected:
	static WeatherModel *_self;
};

#endif