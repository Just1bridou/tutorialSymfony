document.addEventListener('DOMContentLoaded',() => {
    //var questionsCollectionHolder = document.querySelector('.questions')
    var questionsCollectionHolder = document.querySelector('.questionsHolder')
    // Add New Question Button
    var addQuestionButton = _('button', document.querySelector('.newQuestionHolder'), getId("add_question"), null, "addQuestionButton")
    
   // refreshIndex(questionsCollectionHolder)

    // Set Index to questionsCollectionHolder
    setNewIndex(questionsCollectionHolder)

    addQuestionButton.addEventListener('click', (e) => {
        var prototype = questionsCollectionHolder.getAttribute('data-prototype')
        prototype = setNewIndex(questionsCollectionHolder, prototype)

        questionsCollectionHolder.insertAdjacentHTML( 'beforeend', prototype );
        
        let divs = questionsCollectionHolder.querySelectorAll('div')
        let last = divs[divs.length-1]
        
        appendLine(divs[divs.length-4]) 

        addNewAnswer(last, questionsCollectionHolder.getAttribute('data-index'))
        e.preventDefault()
    })
})

function getId(name) {
    var traduction = document.querySelector('.displayNone')
    let e = traduction.querySelector('[data-id="' + name + '"]')
    return e.innerText
}

function editNewAnswer(e) {
    elem = e.parentNode

    setNewIndex(elem)
    createResponseForm(elem.querySelector('.newDivs'), e.parentNode.getAttribute('data-index'), elem)
}

function editRemoveAnswer(e) {
    let masterDiv = e.parentNode.parentNode.parentNode
    let allAnswers = masterDiv.querySelectorAll('.answerBlocQuestionForm')

    e.parentNode.remove()
    
    if(allAnswers.length == 1) {
        masterDiv.remove()        
    }
}

function editRemoveQuestion(e) {
    e.parentNode.parentNode.remove()
}

function addNewAnswer(elem, questionIndex) {
    
    let addAnswerButton = _('button', elem.parentNode, getId("add_answer"), null, "addAnswerButton")
    addAnswerButton.addEventListener('click', (e) => {
        setNewIndex(elem)
        createResponseForm(elem, questionIndex)
        
        e.preventDefault()
    })

    var addQuestionButton = _('button', elem.parentNode, getId("remove_question"), null, "removeAnswerButton")
    addQuestionButton.addEventListener('click', (e) => {
        elem.parentNode.parentNode.remove()
        e.preventDefault()
    })

   createResponseForm(elem, questionIndex)

}

function appendLine(e) {
    e.insertAdjacentHTML('afterbegin', '<hr/>')
}

function createResponseForm(elem, questionIndex, secondElem = null) {

    console.log(elem)

    if(secondElem == null) {
        secondElem = elem
    }

    let totalForm = _('div', elem, null, "tutorial_questions_" + questionIndex + "_answers_"+ secondElem.getAttribute('data-index'))
    totalForm.classList.add('answerBlocQuestionForm')

    // ANSWER TYPE
    let formInput = _('div', totalForm)

   // let labelInput = _('label', formInput, "R??ponse", null, "required")
   // labelInput.setAttribute('for', 'tutorial_questions_' + questionIndex + '_answers_'+ elem.getAttribute('data-index') +'_content')

    let inputAnswer = _('input', formInput, null, 'tutorial_questions_' + questionIndex + '_answers_'+ secondElem.getAttribute('data-index') +'_content', "form-control")
    inputAnswer.type = "text"
    inputAnswer.name = "tutorial[questions][" + questionIndex + "][answers]["+ secondElem.getAttribute('data-index') +"][content]"
    inputAnswer.required = true
    inputAnswer.placeholder = getId('answer')

    let formCheckbox = _('div', totalForm)

    // ANSWER CORRECT ?
    let labelCorrectAnswer = _('label', formCheckbox, getId("correct_answer"), null, "required")

    let radioDiv = _('div', formCheckbox, null, "tutorial_questions_" + questionIndex + "_answers_" + secondElem.getAttribute('data-index') + "_isCorrect", "form-check")
    radioDiv.classList.add('form-control')

    // RADIO BUTTONS
    let contentYes = _('div', radioDiv, null, null, 'radioDiv')
    // YES
    let inputYes = _('input', contentYes, null, 'tutorial_questions_' + questionIndex + '_answers_' + secondElem.getAttribute('data-index') + '_isCorrect_0', null)
    inputYes.type = "radio"
    inputYes.name = "tutorial[questions][" + questionIndex + "][answers][" + secondElem.getAttribute('data-index') + "][isCorrect]"
    inputYes.required = true
    inputYes.value = 1

    let labelYes = _('label', contentYes, getId("yes"), null, "required")
    labelYes.setAttribute('for',"tutorial_questions_" + questionIndex + "_answers_" + secondElem.getAttribute('data-index') + "_isCorrect_0")

    let contentNo = _('div', radioDiv, null, null, 'radioDiv')
    // NO
    let inputNo = _('input', contentNo, null, 'tutorial_questions_' + questionIndex + '_answers_' + secondElem.getAttribute('data-index') + '_isCorrect_1', null)
    inputNo.type = "radio"
    inputNo.name = "tutorial[questions][" + questionIndex + "][answers][" + secondElem.getAttribute('data-index') + "][isCorrect]"
    inputNo.required = true
    inputNo.value = 0

    let labelNo = _('label', contentNo, getId("no"), null, "required")
    labelNo.setAttribute("for","tutorial_questions_" + questionIndex + "_answers_" + secondElem.getAttribute('data-index') + "_isCorrect_1")
 

    let removeButton = _('button', totalForm, getId("remove_answer"), null, "removeAnswerButton")

    removeButton.addEventListener('click', () => {
        totalForm.remove()
        let masterDiv = elem.parentNode.parentNode
        let allAnswers = masterDiv.querySelectorAll('.answerBlocQuestionForm')
        if(allAnswers.length == 0) {
            masterDiv.remove()
        }
    })
}

function refreshIndex(elem) {
    let count = elem.querySelectorAll('.question-type').length
    if(count == null) count = 0;
    elem.setAttribute('data-index', count)

    let answers = elem.querySelectorAll('.answers')

    for(let i = 0; i<answers.length; i++) {
        answers[i].setAttribute('data-index', i)
    }
}

/**
 * Set / increment index (position of question for PHP)
 * @param {Element} elem 
 */
 function setNewIndex(elem, proto = null) {
    let index = elem.getAttribute('data-index')

    if(index == null) {
        elem.setAttribute('data-index', 0)
    } else {
        let newIndex = parseInt(index) + 1
        elem.setAttribute('data-index', newIndex)
    }

    if(proto != null) {
        let ni = elem.getAttribute('data-index')
        proto = proto.replace(/__name__label__/g, ni);
        proto = proto.replace(/__name__/g, ni);
        return proto
    }
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