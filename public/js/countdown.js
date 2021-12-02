const getTime = dateTo => {
    let now = new Date(),
        time = (new Date(dateTo) - now + 1000) / 1000,
        seconds = ('0' + Math.floor(time % 60)).slice(-2),
        minutes = ('0' + Math.floor(time / 60 % 60)).slice(-2),
        hours = ('0' + Math.floor(time / 3600 % 24)).slice(-2),
        days = Math.floor(time / (3600 * 24));
 
    return {
        seconds,
        minutes,
        hours,
        days,
        time
    }
};

const countdown = (dateTo, element) => {
    const item = document.getElementById(element);
	band = false; 
    const timerUpdate = setInterval( () => {
        let currenTime = getTime(dateTo);
        item.innerHTML = `${currenTime.days} días, ${currenTime.hours} horas para cierre de la membresia!`;

        if (currenTime.time <= 1) {
            clearInterval(timerUpdate);
            item.innerHTML = finalMessage;
        }

        if(!band){
			alert(item.innerHTML)
			band = true
      	}

    }, 1000);

};


const miVariableEnJavaScript = 'Dec 30 2021 5:42:20';
 
countdown(miVariableEnJavaScript, 'countdown1');



