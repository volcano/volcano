<?php

namespace Api;

/**
 * Seller contacts controller.
 */
class Controller_Sellers_Contacts extends Controller
{
    /**
     * Gets one or more seller contacts.
     *
     * @param int $seller_id Seller ID.
     * @param int $id        Contact ID.
     *
     * @return void
     */
    public function get_index($seller_id = null, $id = null)
    {
        if (!$id) {
            $contacts = \Seller::active()->contacts;
        } else {
            $contacts = $this->get_contact($id);
        }
        
        $this->response($contacts);
    }
    
    /**
     * Creates a seller contact.
     *
     * @param int $seller_id Seller ID.
     *
     * @return void
     */
    public function post_index($seller_id = null)
    {
        $validator = \Validation_Contact::create('seller');
        if (!$validator->run()) {
            throw new HttpBadRequestException($validator->errors());
        }
        
        $data = $validator->validated();
        
        $contact = \Service_Contact::create($data);
        if (!$contact) {
            throw new HttpServerErrorException;
        }
        
        if (!\Service_Contact::link($contact, \Seller::active(), \Arr::get($data, 'primary', false))) {
            throw new HttpServerErrorException;
        }
        
        $this->response($contact);
    }
    
    /**
     * Updates a seller contact.
     *
     * @param int $seller_id Seller ID.
     * @param int $id        Contact ID.
     *
     * @return void
     */
    public function put_index($seller_id = null, $id = null)
    {
        $contact = $this->get_contact($id);
        
        $validator = \Validation_Contact::update('seller');
        if (!$validator->run(\Input::put())) {
            throw new HttpBadRequestException($validator->errors());
        }
        
        $data = $validator->validated();
        
        $contact = \Service_Contact::update($contact, $data);
        if (!$contact) {
            throw new HttpServerErrorException;
        }
        
        $this->response($contact);
    }
    
    /**
     * Deletes a seller contact.
     *
     * @param int $seller_id Seller ID.
     * @param int $id        Contact ID.
     *
     * @return void
     */
    public function delete_index($seller_id = null, $id = null)
    {
        $contact = $this->get_contact($id);
        
        $deleted = \Service_Contact::delete($contact);
        if (!$deleted) {
            throw new HttpServerErrorException;
        }
    }
    
    /**
     * Attempts to get a contact from a given ID.
     *
     * @param int $id Contact ID.
     *
     * @return \Model_Contact
     */
    protected function get_contact($id)
    {
        if (!$id) {
            throw new HttpNotFoundException;
        }
        
        $contact = \Service_Contact::find_one($id);
        if (!$contact || !\Arr::key_exists(\Seller::active()->contacts, $contact->id)) {
            throw new HttpNotFoundException;
        }
        
        return $contact;
    }
}
