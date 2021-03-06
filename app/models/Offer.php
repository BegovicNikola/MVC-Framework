<?php
    class Offer {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getOffers(){
            $this->db->query('SELECT *,
                            offers.id as o_id,
                            users.id as u_id,
                            offers.created as o_created,
                            users.created as u_created 
                            FROM offers
                            INNER JOIN users
                            ON offers.user_id = users.id
                            ORDER BY offers.created DESC');

            $results = $this->db->resultSet();

            return $results;
        }

        public function getSingleOffer($id){
            $this->db->query('SELECT * FROM offers WHERE id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public function getOffersByUser($user_id){
            $this->db->query('SELECT * FROM offers WHERE user_id = :user_id');
            
            $this->db->bind(':user_id', $user_id);

            $results = $this->db->resultSet();

            return $results;
        }

        public function addOffer($data){
            $this->db->query('INSERT INTO offers (user_id, title, description, company) VALUES(:user_id, :title, :description, :company)');

            $this->db->bind(':user_id', $_SESSION['user_id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':company', $data['company']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function updateOffer($data){
            $this->db->query('UPDATE offers SET title = :title, description = :description, company = :company WHERE id = :id');

            $this->db->bind(':id', $data['id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':company', $data['company']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function deleteOffer($id){
            $this->db->query('DELETE FROM offers WHERE id = :id');

            $this->db->bind(':id', $id);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

    }