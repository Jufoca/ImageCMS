<?php

/**
 * class TMenuColumn for component template_manager
 */
class TMenuColumn extends \template_manager\classes\TComponent {

    /**
     * Columns names array
     * @var type 
     */
    private $columns = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

    /**
     * Prepare param from xml to save in db
     * @param \SimpleXMLElement $nodes
     */
    public function select_column_menu($id) {
        $params = $this->getParam('columns');

        $select = '<select name="categoriesColumns[' . $id . ']" class="input-mini">';

        foreach ($this->columns as $i) {
            $selected = '';
            if ($params['columns'][$id] && $params['columns'][$id] == $i)
                $selected = 'selected="selected"';
            $select .= "<option value='" . $i . "'" . $selected . ">" . $i . "</option>";
        }
        $select.='</select>';
        return $select;
    }

    public function setParamsXml(\SimpleXMLElement $component) {
        $data = array();
        foreach ($component as $item) {
            switch ($item->getName()) {
                case 'params':
                    $params_attributes = $item->attributes();
                    foreach ($item as $param) {
                        $param_attributes = $param->attributes();
                        $data[(string) $params_attributes->name][] = array(
                            'column' => (string) $param_attributes->key,
                            'values' => (string) $param_attributes->value
                        );
                    }
                    $data[(string) $params_attributes->name] = serialize($data[(string) $params_attributes->name]);
                    break;
            }
        }

        if (count($data) > 0)
            $this->setParams($data);
    }

    /**
     * Prepare param from form to save in db
     * @param type $data - data array
     */
    public function setParams($data = array()) {
        if (count($data) > 0)
            parent::setParams($data);
        else {
            if ($_POST['column']) {
                $data = array();
                foreach ($_POST['column'] as $col => $value) {
                    $value = serialize($value);
                    $key = str_replace('col', '', $col);
                    $data[$key] = $value;
                }
                if (count($data) > 0)
                    parent::setParams($data);
            }
        }
    }

    /**
     * Get param
     * @param string $key - param key
     * @return array
     */
    public function getParam($key = null) {
        $params = parent::getParam($key);
        $params = unserialize($params);

        $data = array();
        if ($key) {
            $data[$key] = $params;
        } else {
            foreach ($params as $param) {
                $data[$key] = $param;
            }
        }

        return $data;
    }

    /**
     * Render admin template
     */
    public function renderAdmin() {
        $this->cAssetManager->registerScript('scripts', 'after');
        $this->cAssetManager->display('admin/main', array(
            'handler' => $this->name,
            'openLevels' => $this->getOpenLevels()
            )
        );
    }

    /**
     * Update component params
     */
    public function updateParams() {
        if ($_POST['categoriesColumns']) {
            $data = \CI::$APP->input->post();

            $dataToUpdate['columns'] = serialize($data['categoriesColumns']);
            $dataToUpdate['openLevels'] = serialize($data['openLevels']);
            if (count($dataToUpdate) > 0)
                return parent::updateParams($dataToUpdate);
        }
    }

    /**
     * Get component label
     * @return string
     */
    public function getLabel() {
        return lang('Menu Column', 'newLevel_TM');
    }

    /**
     * Get component type
     * @return system
     */
    public function getType() {
        return __CLASS__;
    }

    public function getCategoryColumns($category_id = NULL) {
        $component_data = $this->getParam('columns');

        if (!isset($component_data['columns'])) {
            return '0';
        }

        if ($category_id !== NULL) {
            return $component_data['columns'][$category_id] ? $component_data['columns'][$category_id] : '0';
        }
        return '0';
    }

    public function getOpenLevels() {
        $component_data = $this->getParam('openLevels');

        if (!isset($component_data['openLevels'])) {
            return 'all';
        } else {
            return $component_data['openLevels'];
        }
    }

}

?>