<?php

/** * ************************************************
 * Image CMS Template Engine (Mabilis TPL)
 *
 * Simple template engine for Image CMS based on regular expressions search and replace.
 *
 * @author <dev@imagecms.net>
 * @version 0.3 PHP5
 * ************************************************ */
class Mabilis
{

    /**
     * @var Mabilis_Compiler
     */
    private $compiler = NULL;

    /**
     * @var Mabilis_Config
     */
    private $config = NULL;

    /**
     * Mabilis constructor.
     * @param array $config
     */
    public function __construct(&$config = []) {
        $this->load_config($config);
    }

    /**
     * Display or fetch template file
     * @param string $file
     * @param array $data
     * @param bool $return
     * @return string
     */
    public function view($file, $data = [], $return = FALSE) {
        // Delete double .tpl.tpl
        //TODO remove this and find root of problem
        if(false !== strpos($file, '.tpl.tpl')) {
            $file = substr($file, 0, -4);
        }

        if (preg_match('/file:/', $file, $_Matches)) {
            $file_dir = preg_replace('/\/\//', '/', $file);
            $file_dir = preg_replace('/file\:/', '', $file_dir);
        } elseif (preg_match('/dir:/', $file, $_Matches)) {
            $file_dir = preg_replace('/\/\//', '/', $file);
            $file_dir = preg_replace('/dir\:/', '', $file_dir);
        } else {
            $file_dir = $this->config->tpl_path . $file;
        }
        $all_tpl_path = $this->config->tpl_path . 'shop/default/';
        //if (preg_match('/application\/modules/', $file_dir, $mm))
        if (strpos($file_dir, 'application\modules')) {
            $newFile = explode('application\modules', $file_dir);
            $new_file_dir = $all_tpl_path . 'modules' . $newFile[1];

            if (file_exists($new_file_dir)) {
                $file_dir = $new_file_dir;
            }
        }

        $compiled_file = $this->config->compile_path . md5($file_dir) . $this->config->compiled_ext;

        if (!file_exists($compiled_file) OR $this->config->force_compile == TRUE) {
            // Compile file
            $this->load_compiler();
            $this->compiler->compile($file_dir);
        }

        extract($data);

        ob_start();

        if (file_exists($compiled_file)) {

            //            if (!in_array($compiled_file, $this->arr)) {
            include $compiled_file;
            //                $this->arr[$compiled_file] = $compiled_file;
            //            }
            //            else
            //                include $this->arr[$compiled_file];
        } else {
            print '<p class="error">Error: ' . $compiled_file . ' does not exists!</p>';
        }

        // Time to live expried
        /* @var $mabilis_ttl integer */
        if ($mabilis_ttl <= time()) {
            @unlink($compiled_file);
        }

        if ($this->config->use_filemtime == TRUE AND $mabilis_last_modified != @filemtime($file_dir)) {
            @unlink($compiled_file);
        }

        if ($return == TRUE) {
            $buffer = ob_get_contents();
            ob_end_clean();
            return $buffer;
        }

        ob_end_flush();
    }

    /**
     * @param array $config
     * @return bool
     */
    public function load_config($config = []) {
        if (extension_loaded('zlib') AND $config['compress_output'] == TRUE) {
            if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) AND strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE) {
                ob_start('ob_gzhandler');
            }
        }

        if ($this->config == NULL) {
            include 'Config.class.php';
            $this->config = new Mabilis_Config($config);
        }

        return TRUE;
    }

    /**
     * @param string $param
     * @param string $value
     */
    public function set_config_value($param, $value) {
        $this->config->$param = $value;
    }

    /**
     * @param $param
     * @return mixed
     */
    public function get_config_value($param) {
        if (isset($this->config->$param)) {
            return $this->config->$param;
        }
    }

    /**
     * Load compiler class if not loaded yet
     */
    public function load_compiler() {
        if ($this->compiler == NULL) {
            include 'Mabilis.compiler.php';
            $this->compiler = new Mabilis_Compiler($this->config);
        }

        return TRUE;
    }

}

/* End of Mabilis.class.php */