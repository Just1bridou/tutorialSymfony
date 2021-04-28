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

                answersList.push(
                    {
                        "name": answerValue.name,
                        "value": answerValue.checked
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
        
        console.log(ajaxSend)


        $.ajax({
            method: "POST",
            url: '/tutorial/response/ajax',
            data: ajaxSend,
            success: function(reponse){
                location.href = redirectTo;
            }
        });
    })
})
