document.addEventListener('DOMContentLoaded',() => {

    //var questionsCollectionHolder = document.querySelector('.questions')
    var questionsCollectionHolder = document.querySelector('.questionsHolder')

    // Add New Question Button
    var addQuestionButton = _('button', document.querySelector('.newQuestionHolder'), "Ajouter une question", null, "addQuestionButton")
    
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

function addNewAnswer(elem, questionIndex) {
    
    let addAnswerButton = _('button', elem.parentNode, "Ajouter une réponse", null, "addAnswerButton")
    addAnswerButton.addEventListener('click', (e) => {
        setNewIndex(elem)
        createResponseForm(elem, questionIndex)
        
        e.preventDefault()
    })

    var addQuestionButton = _('button', elem.parentNode, "Supprimer la question", null, "removeAnswerButton")
    addQuestionButton.addEventListener('click', (e) => {
        elem.parentNode.parentNode.remove()
        e.preventDefault()
    })

   createResponseForm(elem, questionIndex)

}

function appendLine(e) {
    e.insertAdjacentHTML('afterbegin', '<hr/>')
}

function createResponseForm(elem, questionIndex) {

    let totalForm = _('div', elem, null, "tutorial_questions_" + questionIndex + "_answers_"+ elem.getAttribute('data-index'))
    totalForm.classList.add('answerBlocQuestionForm')

    // ANSWER TYPE
    let formInput = _('div', totalForm)

   // let labelInput = _('label', formInput, "Réponse", null, "required")
   // labelInput.setAttribute('for', 'tutorial_questions_' + questionIndex + '_answers_'+ elem.getAttribute('data-index') +'_content')

    let inputAnswer = _('input', formInput, null, 'tutorial_questions_' + questionIndex + '_answers_'+ elem.getAttribute('data-index') +'_content', "form-control")
    inputAnswer.type = "text"
    inputAnswer.name = "tutorial[questions][" + questionIndex + "][answers]["+ elem.getAttribute('data-index') +"][content]"
    inputAnswer.required = true
    inputAnswer.placeholder = "Réponse"

    let formCheckbox = _('div', totalForm)

    // ANSWER CORRECT ?
    let labelCorrectAnswer = _('label', formCheckbox, "Réponse correcte ?", null, "required")

    let radioDiv = _('div', formCheckbox, null, "tutorial_questions_" + questionIndex + "_answers_" + elem.getAttribute('data-index') + "_isCorrect", "form-check")
    radioDiv.classList.add('form-control')

    // RADIO BUTTONS
    let contentYes = _('div', radioDiv, null, null, 'radioDiv')
    // YES
    let inputYes = _('input', contentYes, null, 'tutorial_questions_' + questionIndex + '_answers_' + elem.getAttribute('data-index') + '_isCorrect_0', null)
    inputYes.type = "radio"
    inputYes.name = "tutorial[questions][" + questionIndex + "][answers][" + elem.getAttribute('data-index') + "][isCorrect]"
    inputYes.required = true
    inputYes.value = 1

    let labelYes = _('label', contentYes, "Oui", null, "required")
    labelYes.setAttribute('for',"tutorial_questions_" + questionIndex + "_answers_" + elem.getAttribute('data-index') + "_isCorrect_0")

    let contentNo = _('div', radioDiv, null, null, 'radioDiv')
    // NO
    let inputNo = _('input', contentNo, null, 'tutorial_questions_' + questionIndex + '_answers_' + elem.getAttribute('data-index') + '_isCorrect_1', null)
    inputNo.type = "radio"
    inputNo.name = "tutorial[questions][" + questionIndex + "][answers][" + elem.getAttribute('data-index') + "][isCorrect]"
    inputNo.required = true
    inputNo.value = 0

    let labelNo = _('label', contentNo, "Non", null, "required")
    labelNo.setAttribute("for","tutorial_questions_" + questionIndex + "_answers_" + elem.getAttribute('data-index') + "_isCorrect_1")
 

    let removeButton = _('button', totalForm, "Supprimer cette réponse", null, "removeAnswerButton")

    removeButton.addEventListener('click', () => {
        totalForm.remove()
        let masterDiv = elem.parentNode.parentNode
        let allAnswers = masterDiv.querySelectorAll('.answerBlocQuestionForm')
        if(allAnswers.length == 0) {
            masterDiv.remove()
        }
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