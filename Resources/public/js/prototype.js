Prototype = {
    add: function($collectionHolder, $newLinkLi) {
        var prototype = $collectionHolder.attr('data-prototype');
        
        var newForm = prototype.replace(/__name__/g, $collectionHolder.children().length);
        
        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
    }
}