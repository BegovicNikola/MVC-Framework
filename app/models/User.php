<?php
    class User {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        // Register user
        public function register($data){
            // Insert query
            $this->db->query('INSERT INTO users(name, email, password, role) VALUES(:name, :email, :password, 1)');

            // Bind params and values
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);

            // Execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function login($email, $password){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();
        }

        // Find user by email
        public function findUserByEmail($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            // Check row count
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }
    }    