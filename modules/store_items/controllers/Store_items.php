<?php
class Store_items extends Trongate {
  /* ***below was in L12 vvvvv vvv
  function display() {
    $data['view_module'] = 'store_items';
    $data['view_file'] = 'display';
    $this->template('public_defiant', $data);
  }
  *** above was in L12 ^^***/

    function _init_picture_uploader_multi_settings() {
        $data['targetModule'] = 'store_items';
        $data['destination'] = 'store_items_pictures';
        $data['max_file_size'] = 1200;
        $data['max_width'] = 2500;
        $data['max_height'] = 1400;
        return $data;
    }

    function _init_picture_settings() {
        $picture_settings['targetModule'] = 'store_items';
        $picture_settings['maxFileSize'] = 2000;
        $picture_settings['maxWidth'] = 1200;
        $picture_settings['maxHeight'] = 1200;
        $picture_settings['resizedMaxWidth'] = 450;
        $picture_settings['resizedMaxHeight'] = 450;
        $picture_settings['destination'] = 'store_items_pics';
        $picture_settings['targetColumnName'] = 'picture';
        $picture_settings['thumbnailDir'] = 'store_items_pics_thumbnails';
        $picture_settings['thumbnailMaxWidth'] = 120;
        $picture_settings['thumbnailMaxHeight'] = 120;
        return $picture_settings;
    }

    function manage() {
        $this->module('security');
        $data['token'] = $this->security->_make_sure_allowed();
        $data['order_by'] = 'id';

        //format the pagination
        $data['total_rows'] = $this->model->count('store_items');
        $data['record_name_plural'] = 'store_items';

        $data['headline'] = 'Manage Store_items';
        $data['view_module'] = 'store_items';
        $data['view_file'] = 'manage';

        $this->template('admin', $data);
    }

    function show() {
        $this->module('security');
        $token = $this->security->_make_sure_allowed();

        $update_id = $this->url->segment(3);

        if ((!is_numeric($update_id)) && ($update_id != '')) {
            redirect('store_items/manage');
        }

        $data = $this->_get_data_from_db($update_id);
        $data['token'] = $token;

        if ($data == false) {
            redirect('store_items/manage');
        } else {
            $data['form_location'] = BASE_URL.'store_items/submit/'.$update_id;
            $data['update_id'] = $update_id;
            $data['headline'] = 'Store_item Information';
            $data['in_stock'] = $this->_boolean_to_words($data['in_stock']);
            $data['picture_uploader_multi_settings'] = $this->_init_picture_uploader_multi_settings();
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
            redirect('store_items/manage');
        }

        //fetch the form data
        if (($submit == '') && ($update_id>0)) {
            $data = $this->_get_data_from_db($update_id);
        } else {
            $data = $this->_get_data_from_post();
        }

        $data['headline'] = $this->_get_page_headline($update_id);

        if ($update_id>0) {
            $data['cancel_url'] = BASE_URL.'store_items/show/'.$update_id;
            $data['btn_text'] = 'UPDATE STORE_ITEM DETAILS';
        } else {
            $data['cancel_url'] = BASE_URL.'store_items/manage';
            $data['btn_text'] = 'CREATE STORE_ITEM RECORD';
        }

        $additional_includes_top[] = 'https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css';
        $additional_includes_top[] = 'https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.css';
        $additional_includes_top[] = 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"';
        $additional_includes_top[] = 'https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.js';
        $additional_includes_top[] = BASE_URL.'admin_files/js/i18n/jquery-ui-timepicker-addon-i18n.min.js';
        $additional_includes_top[] = BASE_URL.'admin_files/js/jquery-ui-sliderAccess.js';
        $data['additional_includes_top'] = $additional_includes_top;

        $data['form_location'] = BASE_URL.'store_items/submit/'.$update_id;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'create';
        $this->template('admin', $data);
    }

    function _get_page_headline($update_id) {
        //figure out what the page headline should be (on the store_items/create page)
        if (!is_numeric($update_id)) {
            $headline = 'Create New Store_item Record';
        } else {
            $headline = 'Update Store_item Details';
        }

        return $headline;
    }

    function submit() {
        $this->module('security');
        $this->security->_make_sure_allowed();

        $submit = $this->input('submit', true);

        if ($submit == 'Submit') {

            $this->validation_helper->set_rules('item_title', 'Item Title', 'required|min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('in_stock', 'In Stock', '');
            $this->validation_helper->set_rules('item_price', 'Item Price', 'required|max_length|numeric|greater_than[0]|numeric');
            $this->validation_helper->set_rules('description', 'Description', 'required|min_length[2]');

            $result = $this->validation_helper->run();

            if ($result == true) {

                $update_id = $this->url->segment(3);
                $data = $this->_get_data_from_post();
                if (is_numeric($update_id)) {
                    //update an existing record
                    $this->model->update($update_id, $data, 'store_items');
                    $flash_msg = 'The record was successfully updated';
                } else {
                    //insert the new record
                    $data['item_code'] = make_rand_str(6, true);
                    $update_id = $this->model->insert($data, 'store_items');
                    $flash_msg = 'The record was successfully created';
                }

                set_flashdata($flash_msg);
                redirect('store_items/show/'.$update_id);

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
                redirect('store_items/manage');
            }
        }
    }

    function _get_data_from_db($update_id) {
        $store_items = $this->model->get_where($update_id, 'store_items');

        if ($store_items == false) {
            $this->template('error_404');
            die();
        } else {
            $data['item_title'] = $store_items->item_title;
            $data['in_stock'] = $store_items->in_stock;
            $data['item_code'] = $store_items->item_code;
            $data['item_price'] = $store_items->item_price;
            $data['description'] = $store_items->description;
            return $data;
        }
    }

    function _get_data_from_post() {
        $data['item_title'] = $this->input('item_title', true);
        $data['in_stock'] = $this->input('in_stock', true);
        $data['item_price'] = $this->input('item_price', true);
        $data['description'] = $this->input('description', true);
        $data['url_string'] = strtolower(url_title($data['item_title']));
        return $data;
    }

    function _boolean_to_words($value) {
        if ($value == 1) {
            $value = 'yes';
        } else {
            $value = 'no';
        }
        return $value;
    }

    function _prep_output($output) {
        $output['body'] = json_decode($output['body']);
        foreach ($output['body'] as $key => $value) {
            $output['body'][$key]->in_stock = $this->_boolean_to_words($value->in_stock);
        }

        $output['body'] = json_encode($output['body']);

        return $output;
    }

}
