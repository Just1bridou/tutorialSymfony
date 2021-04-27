document.addEventListener('DOMContentLoaded',() => {

    var questionsCollectionHolder = document.querySelector('.questions')

    // Add New Question Button
    var addQuestionButton = _('button', questionsCollectionHolder, "Ajouter une question", null, "addQuestionButton")

    // Set Index to questionsCollectionHolder
    setNewIndex(questionsCollectionHolder)

    addQuestionButton.addEventListener('click', () => {
        
        var prototype = questionsCollectionHolder.getAttribute('data-prototype')
        prototype = setNewIndex(questionsCollectionHolder, prototype)

        questionsCollectionHolder.insertAdjacentHTML( 'beforeend', prototype );
        
        let divs = questionsCollectionHolder.querySelectorAll('div')
        let last = divs[divs.length-1]

        addNewAnswer(last, questionsCollectionHolder.getAttribute('data-index'))
    })
})

function addNewAnswer(elem, questionIndex) {

    let addAnswerButton = _('button', elem.parentNode, "Ajouter une réponse", null, "addAnswerButton")
    addAnswerButton.addEventListener('click', () => {

       setNewIndex(elem)
       createResponseForm(elem, questionIndex)
    })

   createResponseForm(elem, questionIndex)

}

function createResponseForm(elem, questionIndex) {

    let totalForm = _('div', elem, null, "tutorial_questions_" + questionIndex + "_answers_"+ elem.getAttribute('data-index'))
    totalForm.style.margin = "30px"
    totalForm.style.padding = "30px"
    totalForm.style.backgroundColor = "red"

    // ANSWER TYPE
    let formInput = _('div', totalForm)

    let labelInput = _('label', formInput, "Réponse", null, "required")
    labelInput.setAttribute('for', 'tutorial_questions_' + questionIndex + '_answers_'+ elem.getAttribute('data-index') +'_content')

    let inputAnswer = _('input', formInput, null, 'tutorial_questions_' + questionIndex + '_answers_'+ elem.getAttribute('data-index') +'_content', "form-control")
    inputAnswer.type = "text"
    inputAnswer.name = "tutorial[questions][" + questionIndex + "][answers]["+ elem.getAttribute('data-index') +"][content]"
    inputAnswer.required = true

    let formCheckbox = _('div', totalForm)

    // ANSWER CORRECT ?
    let labelCorrectAnswer = _('label', formCheckbox, "Réponse correcte ?", null, "required")

    let radioDiv = _('div', formCheckbox, null, "tutorial_questions_" + questionIndex + "_answers_" + elem.getAttribute('data-index') + "_isCorrect", "form-check")
    radioDiv.classList.add('form-control')

    // RADIO BUTTONS
    // YES
    let inputYes = _('input', radioDiv, null, 'tutorial_questions_' + questionIndex + '_answers_' + elem.getAttribute('data-index') + '_isCorrect_0', null)
    inputYes.type = "radio"
    inputYes.name = "tutorial[questions][" + questionIndex + "][answers][" + elem.getAttribute('data-index') + "][isCorrect]"
    inputYes.required = true
    inputYes.value = 1

    let labelYes = _('label', radioDiv, "Oui", null, "required")
    labelYes.for = "tutorial_questions_" + questionIndex + "_answers_" + elem.getAttribute('data-index') + "_isCorrect_0"

    // NO
    let inputNo = _('input', radioDiv, null, 'tutorial_questions_' + questionIndex + '_answers_' + elem.getAttribute('data-index') + '_isCorrect_1', null)
    inputNo.type = "radio"
    inputNo.name = "tutorial[questions][" + questionIndex + "][answers][" + elem.getAttribute('data-index') + "][isCorrect]"
    inputNo.required = true
    inputNo.value = 0

    let labelNo = _('label', radioDiv, "Non", null, "required")
    labelNo.for = "tutorial_questions_" + questionIndex + "_answers_" + elem.getAttribute('data-index') + "_isCorrect_1"
 

    let removeButton = _('button', totalForm, "Supprimer cette réponse", null, "removeAnswerButton")

    removeButton.addEventListener('click', () => {
        totalForm.remove()
    })
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