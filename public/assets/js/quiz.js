document.addEventListener('DOMContentLoaded', () => {

    var submit = document.querySelector('.submitQuiz')
    
    submit.addEventListener('click', () => {
        var questionsContent = document.querySelectorAll('.question-type')
        
        var responseQuiz = []

        for(let question of questionsContent) {

            let answers = question.querySelectorAll('.answer')

            var answersList = []

            for(let answer of answers) {
                let answerValue = answer.querySelector('.answerValue')

                let valueBool = (answerValue.checked?1:0)

                answersList.push(
                    {
                        "name": answerValue.name,
                        "value": valueBool
                    }
                )
            }

            responseQuiz.push({
                "question": question.querySelector('.questionName').id,
                "answers": answersList
            })
        }

        let idTuto = document.querySelector('.quizForm').getAttribute('tuto-id')
        let redirectTo = '/tutorial/' + idTuto
        let ajaxSend = {
            "id_tuto": idTuto,
            "quiz": responseQuiz
        }

        $.ajax({
            method: "POST",
            url: '/tutorial/response/ajax',
            data: ajaxSend,
            success: function(response){
                location.href = redirectTo;
            }
        });
    })

    var quizForm = document.querySelector('.quizForm')
    var answersBloc = quizForm.querySelectorAll('.answerBloc')

    for(let bloc of answersBloc) {
        let name = bloc.querySelector('.answerName')
        let input = bloc.querySelector('.answerValue')

        name.addEventListener('click', () => {
            name.classList.toggle('selectAnswer')
            input.checked = !input.checked
        })
    }

})
