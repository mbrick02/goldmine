<?php
function _draw_node($parent_category_id, $all_categories) {

    $child_nodes = [];
    
    foreach ($all_categories as $key => $value) {

        if ($parent_category_id == $value->parent_category_id) {
            $row_data['id'] = $value->id;
            $row_data['category_title'] = $value->category_title;

            if (isset($child_nodes[$value->priority])) {
                $value->priority++;
            }

            $child_nodes[$value->priority] = $row_data;
        }

    }

    $num_child_nodes = count($child_nodes);
    if ($num_child_nodes>0) {
        ksort($child_nodes);
        foreach ($child_nodes as $key => $value) {
            $id = $value['id'];
            $category_title = $value['category_title'];
            echo '<div id="record-id-'.$id.'" class="node" draggable="true">'.$category_title;
            _draw_node($id, $all_categories); //attempt to draw sub nodes
            echo '</div>';
        }
    }

}

_draw_node(0, $all_categories);