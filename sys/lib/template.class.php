<?php
class Template
{
    protected $config = [
        'path' => '../templates',
    ];
    protected $data = [];

    public function __construct(array $config) {
        $this->config = array_merge($this->config, $config);
    }

    public function render($tpl, array $data = []) {
        $output = $this->fetch($tpl, $data);
        echo $output;
    }

    private function fetch($tpl, array $data = []) {
        $this->assign($data);

        ob_start();
        extract($this->data);

        include $this->get_template($tpl);
        $content = ob_get_clean();
        ob_end_clean();
        return $content;
    }

    private function assign(array $data) {
        $this->data = array_merge($this->data, $data);
    }

    private function get_template($tpl) {
        return $this->config['path'].'/'.$tpl;
    }
}
