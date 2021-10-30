window.onload = init_timers;

//timer clallback variable
//this stores setInterval
var timerCallbackV;

function init_timers()
{
    timerCallbackV = setInterval(function(){timerTick()}, resTimerTick);
}

function timerTick()
{
    for (var i = 0; i < 5; i++)
    {
	resData[i] += resTickData[i];

	if (resData[i] > resMaxData[i])
	{
	    resData[i] = resMaxData[i];
	}

	var str = "res_" + i;

	document.getElementById(str).innerHTML = Math.floor(resData[i]);
    }

    if (resData[0] == resMaxData[0] && resData[1] == resMaxData[1] && resData[2] == resMaxData[2] &&
	resData[3] == resMaxData[3] && resData[4] == resMaxData[4])
    {
	clearInterval(timerCallbackV);
    }
}
