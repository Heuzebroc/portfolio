const toAnimate = document.querySelectorAll(".entrance");
const toAnimateImmediately = document.querySelectorAll(".entrance-immediate");

const entrance = element => {
    let delay = 0;

    if(element.classList.contains("entrance-standalone")) {
        element.style.transform = "none";
        element.style.transition = `transform 0.8s ease-out`;
    }

    else element.querySelectorAll(".entrance > *, .entrance > .entrance-skip > *").forEach(child => {
        child.style.transform = "none";
        child.style.transition = `transform 0.8s ease-out ${delay}s`;
        delay += 0.2;
    });
}

//for entrances that need to be animated without scrolling first
setTimeout(() => toAnimateImmediately.forEach(element => {
    entrance(element);
}), 100);

let currentScroll = toAnimateImmediately.length;

document.addEventListener("scroll", e => {
    toAnimate.forEach((element, index) => {
        if(element.getBoundingClientRect().y < 500 && index === currentScroll) {
            entrance(element);
            currentScroll++;
        }
    });
});