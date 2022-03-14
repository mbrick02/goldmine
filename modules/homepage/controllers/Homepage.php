<?php
class Homepage extends Trongate {
  function index () {
    $data['view_module'] = 'homepage'; // where the module is containing view file
    $data['view_file'] = 'homepage_content';
    // $this->template('homepage_design', $data);
    $this->template('public_defiant', $data);
  }
}
