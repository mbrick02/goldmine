<?php
class Store_categories extends Trongate {
  function _draw_categories() {
    $data['all_categories'] = $this->model->get('priority', 'store_categories');
    $this->view('categories', $data);
  }

  function manage() {
      $this->module('security');
      $this->module('trongate_tokens');
      $this->security->_make_sure_allowed();
      $user_id = $this->security->_get_user_id();
      $data['token'] = $this->trongate_tokens->_fetch_token($user_id);
      $data['all_categories'] = $this->model->get('id');
      $data['headline'] = 'Manage Store Categories';
      $data['view_module'] = 'store_categories';
      $data['view_file'] = 'manage';
      $this->template('admin', $data);
  }

  function update_positions() {

      api_auth();

      //take in the posted variables
      $post = file_get_contents('php://input');
      $nodes_to_update = json_decode($post);

      $sql = '';
      foreach ($nodes_to_update as $key => $value) {
          $id = $value->id;
          $parent_category_id = $value->parent_category_id;
          $priority = $value->priority;

          if((!is_numeric($id)) || (!is_numeric($parent_category_id)) || (!is_numeric($priority))) {
              http_response_code(403);
              echo 'Not allowed: invalid parameters';
              die();
          }

          $sql.= 'update store_categories set priority='.$priority.', parent_category_id='.$parent_category_id.' where id='.$id.';';
      }

      $this->model->query($sql);
      http_response_code(200);
      echo 'true';

  }

  function _draw_dropzone_content($all_categories) {
      $data['all_categories'] = $all_categories;
      $this->view('dropzone_content', $data);
  }

  function _make_sure_delete_allowed($input) {

      $data['update_id'] = $input['params']['id'];

      //add validation rules
      $sql = 'select * from store_categories where parent_category_id = :update_id';
      $categories = $this->model->query_bind($sql, $data, 'array');
      $num_categories = count($categories);

      if ($num_categories>0) {
          //not allowed
          http_response_code(400);
          echo "At least one other category has this as a parent.";
          die();
      }

      return $input;
  }

  function _add_url_string($input) {

      $category_title = $input['params']['category_title'];
      $category_title = trim($category_title);

      if ($category_title == '') {
          http_response_code(400);
          echo "You did not enter a valid category title.";
          die();
      } else {
          $input['params']['url_string'] = strtolower(url_title($category_title));
      }

      return $input;
  }

  function show() {
      $this->module('security');
      $this->module('trongate_tokens');
      $this->security->_make_sure_allowed();

      $update_id = $this->url->segment(3);

      if ((!is_numeric($update_id)) && ($update_id != '')) {
          redirect('store_categories/manage');
      }

      $data = $this->_get_data_from_db($update_id);
      $user_id = $this->security->_get_user_id();
      $data['token'] = $this->trongate_tokens->_fetch_token($user_id);

      if ($data == false) {
          redirect('store_categories/manage');
      } else {
          $data['form_location'] = BASE_URL.'store_categories/submit/'.$update_id;
          $data['update_id'] = $update_id;
          $data['headline'] = 'Store Category Information';
          $data['view_file'] = 'show';
          $this->template('admin', $data);
      }
  }

  function create() {
      $this->module('security');
      $this->security->_make_sure_allowed();

      $update_id = $this->url->segment(3);
      $submit = $this->input('submit', true);

      if ((!is_numeric($update_id)) && ($update_id != '')) {
          redirect('store_categories/manage');
      }

      //fetch the form data
      if (($submit == '') && ($update_id>0)) {
          $data = $this->_get_data_from_db($update_id);
      } else {
          $data = $this->_get_data_from_post();
      }

      $data['headline'] = $this->_get_page_headline($update_id);

      if ($update_id>0) {
          $data['cancel_url'] = BASE_URL.'store_categories/show/'.$update_id;
          $data['btn_text'] = 'UPDATE STORE CATEGORY DETAILS';
      } else {
          $data['cancel_url'] = BASE_URL.'store_categories/manage';
          $data['btn_text'] = 'CREATE STORE CATEGORY RECORD';
      }


      $additional_includes_top[] = 'https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css';
      $additional_includes_top[] = 'https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.css';
      $additional_includes_top[] = 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"';
      $additional_includes_top[] = 'https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.js';
      $additional_includes_top[] = BASE_URL.'admin_files/js/i18n/jquery-ui-timepicker-addon-i18n.min.js';
      $additional_includes_top[] = BASE_URL.'admin_files/js/jquery-ui-sliderAccess.js';
      $data['additional_includes_top'] = $additional_includes_top;

      $data['form_location'] = BASE_URL.'store_categories/submit/'.$update_id;
      $data['update_id'] = $update_id;
      $data['view_file'] = 'create';
      $this->template('admin', $data);
  }

  function _get_page_headline($update_id) {
      //figure out what the page headline should be (on the store_categories/create page)
      if (!is_numeric($update_id)) {
          $headline = 'Create New Store Category Record';
      } else {
          $headline = 'Update Store Category Details';
      }

      return $headline;
  }

  function submit() {
      $this->module('security');
      $this->security->_make_sure_allowed();

      $submit = $this->input('submit', true);

      if ($submit == 'Submit') {

          $this->validation_helper->set_rules('category_title', 'Category Title', 'required|min_length[2]|max_length[255]');
          $this->validation_helper->set_rules('parent_category_id', 'Parent Category ID', 'required|max_length[11]|numeric|integer');
          $this->validation_helper->set_rules('priority', 'Priority', 'required|max_length[11]|numeric|integer');

          $result = $this->validation_helper->run();

          if ($result == true) {

              $update_id = $this->url->segment(3);
              $data = $this->_get_data_from_post();
              if (is_numeric($update_id)) {
                  //update an existing record
                  $this->model->update($update_id, $data, 'store_categories');
                  $flash_msg = 'The record was successfully updated';
              } else {
                  //insert the new record
                  $update_id = $this->model->insert($data, 'store_categories');
                  $flash_msg = 'The record was successfully created';
              }

              set_flashdata($flash_msg);
              redirect('store_categories/show/'.$update_id);

          } else {
              //form submission error
              $this->create();
          }

      }

  }

  function submit_delete() {
      $this->module('security');
      $this->security->_make_sure_allowed();

      $submit = $this->input('submit', true);

      if ($submit == 'Submit') {
          $update_id = $this->url->segment(3);

          if (!is_numeric($update_id)) {
              die();
          } else {
              $data['update_id'] = $update_id;

              //delete all of the comments associated with this record
              $sql = 'delete from comments where target_table = :module and update_id = :update_id';
              $data['module'] = $this->module;
              $this->model->query_bind($sql, $data);

              //delete the record
              $this->model->delete($update_id, $this->module);

              //set the flashdata
              $flash_msg = 'The record was successfully deleted';
              set_flashdata($flash_msg);

              //redirect to the manage page
              redirect('store_categories/manage');
          }
      }
  }

  function _get_data_from_db($update_id) {
      $store_categories = $this->model->get_where($update_id, 'store_categories');

      if ($store_categories == false) {
          $this->template('error_404');
          die();
      } else {
          $data['category_title'] = $store_categories->category_title;
          $data['parent_category_id'] = $store_categories->parent_category_id;
          $data['priority'] = $store_categories->priority;
          return $data;
      }
  }

  function _get_data_from_post() {
      $data['category_title'] = $this->input('category_title', true);
      $data['parent_category_id'] = $this->input('parent_category_id', true);
      $data['priority'] = $this->input('priority', true);
      $data['url_string'] = strtolower(url_title($data['category_title']));
      return $data;
  }

}
