<?php
    //index 和 admin 的 action  写法完全相同  只是位于不同的文件夹下、
    class IndexAction extends Action{
        public function index()
        {
            echo 'This is Admin';
            echo '<br>';
            say();
            echo '<br>';
            echo C('user');
            $this->display();
        }
    }

?>
