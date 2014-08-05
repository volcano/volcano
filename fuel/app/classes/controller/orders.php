<?php

/**
 * Orders controller
 */
 
 class Controller_Orders extends Controller
 {
    public function action_index()
    {
        $args = array(
            'seller' => Seller::active(),
        );
        
        $pagination = Pagination::forge('customer_pagination', array(
            'total_items' => Service_Customer_Order::count($args),
        ));
        
        $orders = Service_Customer_Order::find(array_merge($args, array(
            'offset' => $pagination->offset,
            'limit'  => $pagination->per_page,
            'order_by'  => array(
                'updated_at' => 'desc',
             ),
        )));
        
        $this->view->orders = $orders;
        $this->view->pagination = $pagination;
    }
 }
 