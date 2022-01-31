const initClock = clock => {
    const hourHand = clock.querySelector('.hour'), minuteHand = clock.querySelector('.minute');
    let angle = 0;

    const refreshClock = e => {
        // ALL ANGLES ARE IN RADIANS
        angle = Math.atan(
            (hourHand.getBoundingClientRect().left - e.pageX) / (e.pageY - hourHand.getBoundingClientRect().top)
        );

        if (e.pageY - hourHand.getBoundingClientRect().top < 0) angle += Math.PI;

        hourHand.style.transform = `rotate(${angle}rad)`;
        minuteHand.style.transform = `rotate(${angle*2}rad)`;
    };

    document.body.addEventListener("mousemove", refreshClock);
    document.body.addEventListener("scroll", refreshClock);
}

const clock = document.querySelector('.clock');
clock && initClock(clock);