var dropzone = document.getElementById("dropzone");
var nodes = document.getElementsByClassName("node");
var selectedNode = '';
var selectedNodePos = 0;
var numNodes = 0;
var parentNode = dropzone;
var siblings = [];
var updateId = 0;
var dragParentIdStart = 'dropzone';
var dragParentIdEnd = 'dropzone';

function updateMdlTitles(mdlTitle) {
    var mdlTitles = document.getElementsByClassName("mdl-title");
    for (var i = 0; i < mdlTitles.length; i++) {
        mdlTitles[i].innerHTML = mdlTitle;
    }
}

function extractCategoryTitle(elId) {
    var categoryTitle = document.getElementById(elId).innerHTML;
    var n = categoryTitle.indexOf("<div ");

    if (n>-1) {
        categoryTitle = categoryTitle.substring(0, n);
    }

    return categoryTitle;
}

function addNodeListeners(node) {
    //set up event listeners on each node
    node.addEventListener("dblclick", function(ev) {
        updateId = ev.target.id;
        updateMdlTitles('UPDATE CATEGORY');
        var categoryTitle = extractCategoryTitle(ev.target.id);
        document.getElementById("delete-category-btn").style.display = 'inline-block';
        document.getElementById("category-title").value = categoryTitle;
        openCategoryModal(ev.target.id);
    });

    node.addEventListener("dragstart", function(ev) {

        //what happens when the thing is dragged (at the start)

        resetNodes(); //make all the nodes go yellow (white) again
        ev.dataTransfer.setData('text/plain', ev.target.id);

        selectedNode = document.getElementById(ev.target.id);
        selectedNode.style.backgroundColor = 'tomato';
        selectedNode.style.transition = 'background 0s, margin 0.3s';
        parentNode.style.backgroundColor = 'powderblue';
        numNodes = nodes.length;
        dragParentIdStart = parentNode.id;

        setTimeout(function() {

            try {
                parentNode.removeChild(selectedNode);
            }
            catch(error) {
                return;
            }

        }, 0);


    });

    node.addEventListener("dragover", function(ev) {
        //what happens when the selectedDiv is dragged above 'this' node
        ev.preventDefault();
        resetNodes();
        dropzone.style.backgroundColor = 'powderblue';
        dropzone.style.paddingBottom = '1em';
        parentNode = document.getElementById(ev.target.id);
        whereAmI(ev.clientY);
    });

    node.addEventListener("dragleave", function(ev) {
        //what happens when the selectedDiv moves away
        parentNode.style.backgroundColor = '#fff';
        parentNode = dropzone;
        whereAmI(ev.clientY);
    });

    node.addEventListener("dragend", function(ev) {
        //what happens when the drag has finished
        if(nodes.length<numNodes) {
            console.log('lost a node, so adding it back onto the btm of the dropzone');
            resetNodes();
            dropzone.appendChild(selectedNode);
            dropzone.style.paddingBottom = '1em';
            dropzone.style.backgroundColor = '#eee';
        }

        dragParentIdEnd = parentNode.id;
        initUpdatePositions();
        deactivate();
    });
}

for (var i = 0; i < nodes.length; i++) {
    addNodeListeners(nodes[i]);
}

dropzone.addEventListener("dragover", function(ev) {
    ev.preventDefault();

    for (var i = 0; i < nodes.length; i++) {
        nodes[i].style.paddingBottom = '0.4em';
    }

    parentNode.style.backgroundColor = 'cornsilk';
    parentNode.style.paddingBottom = '3em';
    parentNode.style.transition = 'background 0.6s, margin 1.8s, padding 2.4s';
});

dropzone.addEventListener("drop", function(ev) {
    ev.preventDefault();
    console.log('the selectedNode was dropped');
    selectedNode.style.backgroundColor = 'tomato';
    parentNode.insertBefore(selectedNode, parentNode.children[selectedNodePos]);
    deactivate();
});

function deactivate() {

    dropzone.style.paddingBottom = '1em';
    dropzone.style.backgroundColor = '#eee';

    setTimeout(function() {

        for (var i = 0; i < nodes.length; i++) {
            nodes[i].style.marginTop = '0.5em';
            nodes[i].style.backgroundColor = 'white';
            nodes[i].style.paddingBottom = '0.4em';
            nodes[i].style.transition = 'background 2s, margin 0.3s';
        }

    }, 0);

}

function resetNodes() {
    for (var i = 0; i < nodes.length; i++) {
        nodes[i].style.marginTop = '0.5em';
        nodes[i].style.backgroundColor = 'white';
    }
}

function establishSiblingPositions() {

    //console.log('the parentNode is ' + parentNode.id);
    siblings = parentNode.children;

    for (var i = 0; i < siblings.length; i++) {
        //find out the yPos of the node
        var element = document.getElementById(siblings[i]['id']);
        var position = element.getBoundingClientRect();
        var yTop = position.top;
        var yBottom = position.bottom;
        siblings[i]['yPos'] = yTop + ((yBottom-yTop)/2);
    }
}

function whereAmI(currentYPos) {
    //figure out where the selectedNode is in relation to the other nodes
    establishSiblingPositions();

    //identify the node that is directly above the selectedNode
    for (var i = 0; i < siblings.length; i++) {

        if (siblings[i]['yPos']<currentYPos) {
            //this node MUST be higher up the page than the selectedNode
            var nodeAbove = document.getElementById(siblings[i]['id']);
            selectedNodePos = i+1;
        } else {
            //this node MUST be lower down the page than the selectedNode
            if (!nodeBelow) {
                var nodeBelow = document.getElementById(siblings[i]['id']);
            }

        }
    }

    if (typeof nodeAbove == 'undefined') {
        selectedNodePos = 0; //must be at the top of the list
    }

    if (typeof nodeBelow == 'object') {
        nodeBelow.style.marginTop = '3em';
        nodeBelow.style.transition = '1.8s';
    }

    //console.log('selectedNodePos is ' + selectedNodePos);

}

function openCategoryModal(categoryId) {

    if (categoryId == 0) {
        updateId = 0;
        updateMdlTitles('ADD NEW CATEGORY');
        document.getElementById("delete-category-btn").style.display = 'none';
        document.getElementById("category-title").value = '';
    }

    document.getElementById("errorMsg").innerHTML = '';
    document.getElementById("category-modal").style.display='block';
}

function deleteCategory() {
    var categoryTitle = document.getElementById("category-title").value;

    //send a request to the API
    var recordId = updateId.replace('record-id-', '');
    var apiUrl = '../api/delete/store_categories/' + recordId;

    var http = new XMLHttpRequest();
    http.open('POST', apiUrl);
    http.setRequestHeader('trongatetoken', token);
    http.send();

    http.onload = function() {

        if (http.status == 200) {
            //IF everything is good then,
            //(1) clear the value in the textfield and (2) close the modal
            //(3) remove the node
            document.getElementById("category-title").value = '';
            document.getElementById('category-modal').style.display='none';

            var nodeToRemove = document.getElementById(updateId);
            nodeToRemove.parentNode.removeChild(nodeToRemove);

            dragParentIdStart = nodeToRemove.parentNode.id;
            dragParentIdEnd = nodeToRemove.parentNode.id;
            initUpdatePositions();

        } else {
            //IF there is an error then display it
            document.getElementById("category-title").value = '';
            document.getElementById("errorMsg").innerHTML = http.responseText;
        }

    }

}

function submitCategory() {
    var categoryTitle = document.getElementById("category-title").value;

    //send a POST request to the API
    if (updateId == 0) {

        var params = {
            category_title: categoryTitle,
            parent_category_id: 0,
            priority: 0
        }

        var apiUrl = '../api/create/store_categories';

    } else {

        var params = {
            category_title: categoryTitle
        }

        var recordId = updateId.replace('record-id-', '');
        var apiUrl = '../api/update/store_categories/' + recordId;
    }

    var http = new XMLHttpRequest();
    http.open('POST', apiUrl);
    http.setRequestHeader('trongatetoken', token);
    http.send(JSON.stringify(params));

    http.onload = function() {

        if (http.status == 200) {
            //IF everything is good then, (1) clear the value in the textfield and (2) close the modal
            document.getElementById("category-title").value = '';
            document.getElementById('category-modal').style.display='none';
            var nodeObj = JSON.parse(http.responseText);

            if (updateId == 0) {
                //add the newNode onto the page
                var newNode = document.createElement("div");
                var newContent = document.createTextNode(nodeObj.category_title);
                newNode.appendChild(newContent);  //  <div>Gold</div>
                newNode.setAttribute("id", "record-id-" + nodeObj.id);
                newNode.setAttribute("class", "node");
                newNode.setAttribute("draggable", "true");
                dropzone.appendChild(newNode);
                addNodeListeners(newNode);
                dragParentIdStart = 'dropzone';
                dragParentIdEnd = 'dropzone';
                initUpdatePositions();
            } else {
                updateNodeCategoryTitle(updateId, nodeObj.category_title);
            }


        } else {
            //IF there is an error then display it
            document.getElementById("category-title").value = '';
            document.getElementById("errorMsg").innerHTML = http.responseText;
        }

    }

}

function updateNodeCategoryTitle(elId, categoryTitleNew) {
    var nodeInnerHtml = document.getElementById(elId).innerHTML;
    var categoryTitleOld = extractCategoryTitle(elId);
    nodeInnerHtml = nodeInnerHtml.replace(categoryTitleOld, categoryTitleNew);
    document.getElementById(elId).innerHTML = nodeInnerHtml;
}

function initUpdatePositions() {
    setTimeout(() => {

        processPositions(dragParentIdEnd);

        if (dragParentIdStart !== dragParentIdEnd) {
            processPositions(dragParentIdStart);
        }

    }, 500);
}

function processPositions(dragParentId) {
    //send an update request to the API, so that positions are remembered

    //make sure the dragParentId is numeric
    if (dragParentId == 'dropzone') {
        var parent_category_id = 0;
    } else {
        var parent_category_id = dragParentId.replace('record-id-', '');
    }

    var dragChildren = document.getElementById(dragParentId).children;
    var nodesToUpdate = [];
    for (var i = 0; i < dragChildren.length; i++) {

        var thisNodeId = dragChildren[i]['id'].replace('record-id-', '');

        var thisNode = {
            id: thisNodeId,
            parent_category_id,
            priority: i+1
        }

        nodesToUpdate.push(thisNode);
    }

    if(nodesToUpdate.length>0) {
        //send a request to the API to have the positions updated
        var apiUrl = '../store_categories/update_positions';
        var http = new XMLHttpRequest();
        http.open('POST', apiUrl);
        http.setRequestHeader('trongatetoken', token);
        http.send(JSON.stringify(nodesToUpdate));
    }

}
