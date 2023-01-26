<?php
class Template
{
    protected mixed $path = "";
    protected array $data = [];

    public function __construct($path = "../template") {
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
        echo $content;
    }

    public function assign(array $data) {
        $this->data = array_merge($this->data, $data);
    }
}
