<?php
/**
 * This library is based on Clubhouse API wrapper by Mikkelson:
 * https://github.com/mikkelson/clubhouse-php
 *
 * It uses API V3 and have some improvements.
 *
 * @author: Cortela
 */

namespace App\Libraries;

class ClubhouseApi {

    /** @var string users Clubhouse API token */
    protected $token;

    /** @var string Clubhouse API endpoint */
    protected $endpoint = 'https://api.clubhouse.io/api/v3/';

    /*
     * Constructor
     * @param string API token
     */
    public function __construct($token) {
        $this->token = $token;
    }

    /*
     * Clubhouse HTTP GET operations
     * @param string $uri api method
     * @return array
     */
    public function get($uri = null, $id = null) {
    
        if (!empty($id)) {
            $uri = $uri . '/' . $id;
        }
    
        return $this->request($uri, 'get');
    }

    /*
     * Clubhouse Update operations
     * @param string $uri api method
     * @param string $id of resource to update
     * @return array $data for update
     */
    public function update($uri = null, $id, $data) {

        if (empty($id) || empty($data)) {
            return array('message' => 'You must provide an id and data to update');
        }

        return $this->request($uri . '/' . $id, 'put', $data);
    }

    /*
     * Clubhouse HTTP DELETE operations
     * @param string $uri api method
     * @param string $id resource id
     * @return array
     */
    public function delete($uri = null, $id = null) {

        if (empty($id)) {
            //return clubhouse style error
            return array('message' => 'You must provide an id to delete');
        }

        return $this->request($uri . '/' . $id, 'delete');
    }
    
    /*
     * Clubhouse Create operations
     * @param string $uri api method
     * @return array $data to create
     */
    public function create($uri = null, $data) {

        if (is_null($uri) || empty($data)) {
            return array('message' => 'You must specify a resource to create, and provide data');
        }

        return $this->request($uri, 'post', $data);
    }

    /*
     * Wraps and preforms curl request
     * @param string $uri api method
     * @param string $type http request test
     * @parma array $fields data to post
     * @return array
     */
    private function request($uri, $type = 'get', $fields = null) {

        $ch = curl_init($this->endpoint . $uri . '?token=' . $this->token);
        
        if (!empty($fields)) {
            $fields = json_encode($fields);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }

        $type = strtoupper($type);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($fields))
        );

        $result = curl_exec($ch);

        if (curl_error($ch)) {
            //upon failure, return a clubstyle style error message
            $output = array('message' => curl_error($ch));
        } else {
            $output = json_decode($result, true);
        }

        curl_close($ch);
        return $output;
    }
}
