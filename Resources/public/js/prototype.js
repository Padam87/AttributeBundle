Prototype = {
    add: function($collectionHolder, prototypeName) {
        var prototype = $collectionHolder.attr('data-prototype');
        
        prototypeName = prototypeName || /__name__/g;
        
        var newItem = prototype.replace(prototypeName, $collectionHolder.children().length);
        
        $collectionHolder.append(newItem);
    }
}