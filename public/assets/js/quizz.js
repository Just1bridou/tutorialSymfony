document.addEventListener('DOMContentLoaded', () => {

    var submit = document.querySelector('.submitQuizz')
    
    submit.addEventListener('click', () => {
        var questionsContent = document.querySelectorAll('.question-type')
        
        var responseQuizz = []

        for(let question of questionsContent) {

            let answers = question.querySelectorAll('.answer')

            var answersList = []

            for(let answer of answers) {
                let answerValue = answer.querySelector('.answerValue')

                answersList.push(
                    {
                        "name": answerValue.name,
                        "value": answerValue.checked
                    }
                )
            }

            responseQuizz.push({
                "question": question.querySelector('.questionName').id,
                "answers": answersList
            })
        }

        let ajaxSend = {
            "id_tuto": document.querySelector('.quizzForm').getAttribute('tuto-id'),
            "quizz": responseQuizz
        }
        
        console.log(responseQuizz)


        $.ajax({
            method: "POST",
            url: '/tutorial/quizz/response',
            data: ajaxSend,
            success: function(reponse){}
     });

    })

})