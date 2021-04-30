function onKeyUp(input) {
    if(input.value != "" && input.value.length > 2) {
        $.ajax({
            method: "POST",
            url: '/tutorial/search',
            data: {"query": input.value},
            success: function(response){
                getTutorials(response, input)
            }
        });
    } else {
        cleanup()
    }

  /*  input.addEventListener('focusout', (e) => {
        if(e.target != document.querySelector('.searchModal')) {
            console.log(e)
            input.value = ""
            cleanup()
        }
    })*/
}

function getTutorials(result, input) {

    cleanup()

    _('div', document.body, null, null, "searchModal")
    let content = document.querySelector('.searchModal')

    let inputH = getOffset(input).top + input.offsetHeight
    content.style.top = (inputH + 70) + "px"

    let inputMid = getOffset(input).left + input.offsetWidth / 2
    let maxW = getOffset(content).left + console.offsetWidth

    let td = _('div', document.body, null, null, 'testDiv')

    var contentRect = content.getBoundingClientRect();

    if(inputMid >= maxW) {
        content.style.setProperty('--after-left', ((inputH + 70) + "px"));
    } else {
        content.style.setProperty('--after-left', (inputMid - contentRect.left - 25 + "px"));
    }

    if(result.length == 0 && input.value.length > 2) {
        noTutorial(content)
    } else if (input.value.length == 0){
        cleanup()
    }

    for(let tuto of result) {
        constructTutorial(tuto, content)
    }
}

function noTutorial(content) {
    _('h2', content, "Aucun tutoriel trouvé")
}

function constructTutorial(tutorial, content) {
    let a = _('a', content, tutorial["title"])
    _('hr', content)
    a.href = "/tutorial/" + tutorial["id"]
}

function cleanup() {
    if(document.querySelector('.searchModal')) {
        document.querySelector('.searchModal').remove()
    }
}

function getOffset(el) {
    var _x = 0;
    var _y = 0;
    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
        _x += el.offsetLeft - el.scrollLeft;
        _y += el.offsetTop - el.scrollTop;
        el = el.offsetParent;
    }
    return { top: _y, left: _x };
}

function _(tag, parent, text=null,  id=null, classs=null) {
	let element = document.createElement(tag)
	if (text)
		element.appendChild(document.createTextNode(text))
	parent.appendChild(element)
	if (id)
		element.id = id
	if (classs)
		element.classList.add(classs)
	return element
}