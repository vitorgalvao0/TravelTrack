<?php
class BaseController
{
    protected function view($file, $data = [])
    {
        extract($data);
        include VIEW_PATH . '/' . $file;
    }
}
