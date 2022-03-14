<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <div id="dropzone">
        <div id="record-id-23" class="node" draggable="true">Watches</div>
        <div id="record-id-11" class="node" draggable="true">Gold</div>
        <div id="record-id-54" class="node" draggable="true">Rings</div>
        <div id="record-id-33" class="node" draggable="true">Necklaces</div>
        <div id="record-id-74" class="node" draggable="true">Offers</div>
        <div id="record-id-58" class="node" draggable="true">Designer Jewellery</div>
        <div id="record-id-32" class="node" draggable="true">Charms</div>
        <div id="record-id-87" class="node" draggable="true">Bracelets</div>
    </div>

    <script>
        var dropzone = document.getElementById("dropzone");
        var nodes = document.getElementsByClassName("node");
        var selectedNode = '';
        var selectedNodePos = 0;

        for (var i = 0; i < nodes.length; i++) {

            //set up event listeners on each node
            nodes[i].addEventListener("dragstart", function(ev) {

                //what happens when the thing is dragged (at the start)

                resetNodes(); //make all the nodes go yellow (cornsilk) again

                selectedNode = document.getElementById(ev.target.id); 
                selectedNode.style.backgroundColor = 'tomato';

                setTimeout(function() {
                    dropzone.removeChild(selectedNode);
                }, 0);
                

            });

            nodes[i].addEventListener("dragover", function(ev) {
                //what happens when the selectedDiv is dragged above 'this' node
                whereAmI(ev.clientY);
            });

        }

        dropzone.addEventListener("dragover", function(ev) {
            ev.preventDefault();
        });

        dropzone.addEventListener("drop", function(ev) {
            console.log('the selectedNode was dropped');
            dropzone.insertBefore(selectedNode, dropzone.children[selectedNodePos]);
            deactivate();
        });

        function deactivate() {

            setTimeout(function() {

                for (var i = 0; i < nodes.length; i++) {
                    nodes[i].style.marginTop = '0.5em';
                    nodes[i].style.backgroundColor = 'cornsilk';
                    nodes[i].style.transition = 'background 2s, margin 0.3s';
                }

            }, 0);

        }

        function resetNodes() {
            for (var i = 0; i < nodes.length; i++) {
                nodes[i].style.marginTop = '0.5em';
                nodes[i].style.backgroundColor = 'cornsilk';
            }
        }

        function establishNodePositions() {
            for (var i = 0; i < nodes.length; i++) {
                //find out the yPos of the node
                var element = document.getElementById(nodes[i]['id']);
                var position = element.getBoundingClientRect();
                var yTop = position.top;
                var yBottom = position.bottom;
                nodes[i]['yPos'] = yTop + ((yBottom-yTop)/2);
            }
        }

        function whereAmI(currentYPos) {
            //figure out where the selectedNode is in relation to the other nodes
            establishNodePositions();

            //identify the node that is directly above the selectedNode
            for (var i = 0; i < nodes.length; i++) {
                
                if (nodes[i]['yPos']<currentYPos) {
                    //this node MUST be higher up the page than the selectedNode
                    var nodeAbove = document.getElementById(nodes[i]['id']);
                    selectedNodePos = i+1;
                } else {
                    //this node MUST be lower down the page than the selectedNode
                    if (!nodeBelow) {
                        var nodeBelow = document.getElementById(nodes[i]['id']);
                    }
                    
                }
            }

            if (typeof nodeAbove == 'undefined') {
                selectedNodePos = 0; //must be at the top of the list
            }

            resetNodes();

            if (typeof nodeBelow == 'object') {
                nodeBelow.style.marginTop = '3em';
                nodeBelow.style.transition = '1.8s';
            }
        }
    </script>

    <style>
        #dropzone {
            background-color: powderblue;
            padding: 1em;
            font-size: 1.4em;
            min-height: 100vh;
        }

        .node {
            background-color: cornsilk;
            padding: 0.4em;
            margin: 0.5em;
            border: 3px skyblue solid;
        }
    </style>


</body>
</html>