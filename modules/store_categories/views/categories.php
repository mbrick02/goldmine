<?php
  function get_sub_categories($parent_category_id, $all_categories) {
    $sub_categories = [];

    foreach ($all_categories as $category) {
      if ($category->parent_category_id == $parent_category_id) {
        $sub_categories[] = $category; // append $category
      }
    }

    return $sub_categories;
  }

  function get_category_url($url_str) {
    $category_url = BASE_URL . 'store_categories/show_items/'.$url_str;
    return $category_url;
  }
 ?>

<!-- Navbar -->
<nav class="navbar">
    <?php
    foreach($all_categories as $category) {
      if ($category->parent_category_id == 0) {
        $category_title = $category->category_title;
        $sub_categories = get_sub_categories($category->id, $all_categories);
        if (count($sub_categories)>0) {
        ?>
          <div class="dropdown">
              <button class="navbar-link dropdown-toggle"><?= $category_title ?></button>
              <div class="dropdown-menu">
                <?php
                foreach ($sub_categories as $sub_category) {
                  $sub_category_title = $sub_category->category_title;
                  $category_url = get_category_url($sub_category->url_string);
                  echo '<a href="'.$category_url.'" class="dropdown-menu-link">'.$sub_category_title.'</a>';
                }
                ?>
              </div>
      </div>
      <?php
        } else {
          $category_url = get_category_url($category->url_string);
          echo '<a href="'.$category_url.'" class="navbar-link">'.$category_title.'</a>';
        }
      }

    }
    ?>
</nav>
