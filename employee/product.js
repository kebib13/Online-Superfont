function handle(){
    // Find the element with the id 'topicend'
    var topicEnd = document.getElementById('top');

    // Check if the element exists
    if (topicEnd) {
        // Get the parent container of the element
        var parentDiv = topicEnd.parentNode;

        // Get all the siblings of the element
        var siblings = Array.from(parentDiv.children);

        // Find the index of the 'topicend' element
        var topicEndIndex = siblings.indexOf(topicEnd);

        // Remove all siblings after 'topicend'
        for (var i = topicEndIndex + 1; i < siblings.length; i++) {
            parentDiv.removeChild(siblings[i]);
        }
    }

}