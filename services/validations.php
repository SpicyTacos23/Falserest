<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of validations
 *
 * @author msi
 */
class validations {
   
        //Valida el nombre antes de comparar en la base de datos
    public function validateName($name){
        if(strlen($name) > 35 || strlen($name) < 1 
                || ctype_space($name) || ctype_digit($name)){
            return false;
        }else{
            return true;
        }
    }
        //Valida la pass antes de comparar en la base de datos
    public function validatePasswd($pass){
        if(strlen($pass)>60 || strlen($pass) < 1){
            return false;
        }else{
            return true;
        }
    }
}
