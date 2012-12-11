Prototype = {
    add: function($collectionHolder, $newLinkLi, prototypeName) {
        var prototype = $collectionHolder.attr('data-prototype');
        
        prototypeName = prototypeName || /__name__/g;
        
        var newForm = prototype.replace(prototypeName, $collectionHolder.children().length);
        
        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
    }
}