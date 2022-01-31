//elements needed
const title = document.querySelector("header h1"),
    titleText = title.innerHTML;
const subtitle = document.querySelector("header h2"),
    subtitleText = subtitle.innerHTML;
const mainSection = document.querySelector('#main');

//preparing the document
title.innerHTML = "";
subtitle.innerHTML = "";
subtitle.style.fontSize = "50%";
mainSection.style.display = "none";

//typing one character
const typeOne = (element, text, delay) => {
    element.innerHTML += text.charAt(element.innerHTML.length);

    if(element.innerHTML !== text) setTimeout(() => typeOne(element, text, delay), delay);
    else nextStep();
};

//highlighting an element
const highlight = (element, doHighlight) => {
    //inline element
    if(element.style.display !== "block" && element.style.display !== "none") {
        if(doHighlight) element.innerHTML = `<mark>${element.innerHTML}</mark>`
        else element.innerHTML = element.innerHTML.substr(6, element.innerHTML.length-13);
    }

    //block element
    else {
        if(doHighlight) {
            element.innerHTML = element.innerHTML
                .replaceAll("<p>", "<p><mark>")
                .replaceAll("</p>", "</mark></p>");
        }
        else {
            element.innerHTML = element.innerHTML
                .replaceAll("<p><mark>", "<p>")
                .replaceAll("</mark></p>", "</p>");
        }
    }

    nextStep();
};

//changing a CSS property
const css = (element, property, value) => {
    element.style[property] = value;
    nextStep();
}

//MAIN SEQUENCE
const steps = [
    {step: () => typeOne(title, titleText, 70), delay: 500},
    {step: () => typeOne(subtitle, subtitleText, 50), delay: 150},
    {step: () => highlight(subtitle, true), delay: 150},
    {step: () => css(subtitle, "font-size", "75%"), delay: 150},
    {step: () => css(subtitle, "font-size", "100%"), delay: 150},
    {step: () => highlight(subtitle, false), delay: 150},
    {step: () => highlight(mainSection, true), delay: 0},
    {step: () => css(mainSection, "display", "block"), delay: 150},
    {step: () => highlight(mainSection, false), delay: 250},
];
let currentStep = 0;

const nextStep = () => {
    if(currentStep < steps.length) setTimeout(steps[currentStep].step, steps[currentStep].delay);

    currentStep++;
}

nextStep();