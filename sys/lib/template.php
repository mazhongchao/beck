<?php
class Template
{
    protected $path = "";
    protected $data = [];

    public function __construct($path = "./") {
        $this->path = $path;
    }

    public function display($tpl_file) {
        ob_start();
        extract($this->data);
        if (!file_exists($this->path.DIRECTORY_SEPARATOR.$tpl_file)) {
            return;
        }
        include $this->path.DIRECTORY_SEPARATOR.$tpl_file;
        $content = ob_get_clean();
        ob_end_clean();
        return $content;
    }

    public function assign(array $data) {
        $this->data = array_merge($this->data, $data);
    }
}
