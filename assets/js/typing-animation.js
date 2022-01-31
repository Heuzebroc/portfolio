const title = document.querySelector("header h1");
const titleText = title.innerHTML;
const subtitle = document.querySelector("header h2");
const subtitleText = subtitle.innerHTML;

let element = title, text = titleText, currentFontSize = 1;

//emptying the titles for now. There has to be some text inside for them to keep the same height
title.innerHTML = "";
subtitle.innerHTML = "";
subtitle.style.fontSize = `${currentFontSize}rem`;

//typing one character
const typeOne = () => {
    //if(element.innerHTML === "&nbsp;") element.innerHTML = "";

    element.innerHTML += text.charAt(element.innerHTML.length);

    if(element.innerHTML != text) setTimeout(typeOne, 60);
    else if(element === title) {
        element = subtitle;
        text = subtitleText;

        setTimeout(typeOne, 400);
    }
    else {
        setTimeout(highlight, 500);
    }
};

//highlighting the subtitle
const highlight = () => {
    subtitle.classList.toggle("highlighted");

    if(subtitle.classList.contains("highlighted")) setTimeout(resizeOnce, 200);
};

//resizing
const resizeOnce = () => {
    currentFontSize += 0.25;
    subtitle.style.fontSize = `${currentFontSize}rem`;

    if(currentFontSize<2) setTimeout(resizeOnce, 200);
    else setTimeout(highlight, 200);
}

//pasting main text


setTimeout(typeOne, 800);