//making hidden elements appear
document.querySelectorAll('.hide').forEach(e => {
    e.classList.remove('hide');
});

document.querySelectorAll('.slidein').forEach(e => {
    e.classList.remove('slidein');
});

//cardinal links
document.querySelectorAll('a.cardinal').forEach(link => {
    const img = document.getElementById(`${link.id}-img`);

    link.addEventListener('mouseenter', e => {
        img.classList.remove('folded');
    });

    link.addEventListener('mouseleave', e => {
        img.classList.add('folded');
    });

    link.addEventListener('click', e => {
        img.classList.add('deployed');
    });
});