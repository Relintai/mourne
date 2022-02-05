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

	void create_table();
	void drop_table();
	void create_default_entries();

	static WeatherModel *get_singleton();

	WeatherModel();
	~WeatherModel();

protected:
	static WeatherModel *_self;
};

#endif