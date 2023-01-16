const initClock = clock => {
    const hourHand = clock.querySelector('.hour'), minuteHand = clock.querySelector('.minute');
    let counter = 30;

    const refreshClock = () => {
        counter++;

        hourHand.style.transform = `rotate(${counter*0.5}deg)`;
        minuteHand.style.transform = `rotate(${counter*6}deg)`;
    };

    setInterval(refreshClock, 1000);
};

const clock = document.querySelector('.clock');
clock && initClock(clock);