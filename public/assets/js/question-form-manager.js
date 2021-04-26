jQuery(document).ready(function() {
    // Toutes les questions
    var $questionsCollectionHolder = $('div.questions');
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $questionsCollectionHolder.data('index', $questionsCollectionHolder.find('input').length);

    // Ajout un bouton "supprimer" pour chaque question
    $questionsCollectionHolder.find('.question-type').each(function() {
        addTagFormDeleteLink($(this));
    });

    //Ajoute un formuaire de Question lorsqu'on clique sur le bouton
    $('body').on('click', '.add_question_link', function(e) {
        var $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');
        addFormToCollection($collectionHolderClass);
    })

    /**
     * Ajout un formulaire de Question
     * @param {*} $collectionHolderClass 
     */
    function addFormToCollection($collectionHolderClass) {
        // Get the ul that holds the collection of tags
        var $collectionHolder = $('.' + $collectionHolderClass);
    
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');
    
        // get the new index
        var index = $collectionHolder.data('index');
    
        var newForm = prototype;
        // You need this only if you didn't set 'label' => false in your tags field in TaskType
        // Replace '__name__label__' in the prototype's HTML to
        // instead be a number based on how many items we have
        // newForm = newForm.replace(/__name__label__/g, index);
    
        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index);
    
        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);
    
        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('<li></li>').append(newForm);
        // Add the new form at the end of the list
        $collectionHolder.append($newFormLi)
    
        // add a delete link to the new form
        addTagFormDeleteLink($newFormLi);
    }
    
    function addTagFormDeleteLink($tagFormLi) {
        var $removeFormButton = $('<button type="button" class="btn btn-primary">Supprimer la question</button>');
        $tagFormLi.append($removeFormButton);
    
        $removeFormButton.on('click', function(e) {
            // remove the li for the tag form
            $tagFormLi.remove();
        });
    }
});
