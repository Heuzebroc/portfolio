const toAnimate = document.querySelectorAll(".entrance");

const entrance = element => {
    let delay = 0;

    if (element.classList.contains("entrance-standalone")) {
        element.style.transform = "none";
        element.style.opacity = "1";
        element.style.transition = `0.8s ease-out`;
    } else element.querySelectorAll(".entrance > *, .entrance > .entrance-skip > *").forEach(child => {
        child.style.transform = "none";
        child.style.opacity = "1";
        child.style.transition = `0.8s ease-out ${delay}s`;
        delay += 0.2;
    });
}

let currentScroll = 0;

const scrollListener = e => {
    toAnimate.forEach((element, index) => {
        if (element.getBoundingClientRect().y < 500 && index === currentScroll) {
            entrance(element);
            currentScroll++;
        }
    });
};

//revealing elements on scroll
document.addEventListener("scroll", scrollListener);

//revealing the top of the page
scrollListener(0);