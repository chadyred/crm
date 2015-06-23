<?php

namespace Enigmatic\CRMBundle\Services;

class ListService
{
    protected $defaultLimit;

    /**
     * Constructor
     */
    public function __construct($defaultLimit = 25)
    {
        $this->defaultLimit = $defaultLimit;
    }

    /**
     * parseArray
     *
     * @param array $data
     * @return array
     */
    public function parseRequest($data) {

        $params = array();
        $params['page'] = 0;
        $params['limit'] = $this->defaultLimit;
        $params['order'] = array();
        $params['search'] = array();

        if (isset($data['page'])) {
            $params['page'] = $data['page'];
        }
        if (isset($data['limit'])) {
            $params['limit'] = $data['limit'];
        }
        if (isset($data['order'])) {
            if (is_array($data['order'])) {
                foreach($data['order'] as $field => $direction) {
                    $params['order'][$field] = $direction;
                }
            }
        }
        if (isset($data['search'])) {
            if (is_array($data['search'])) {
                foreach($data['search'] as $field => $value) {
                    $params['search'][$field] = $value;
                }
            }
        }

        return $params;
    }
}