<?php

namespace App\Validator;


use App\Entity\Booking;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;




class BookingValidator
{
    public function __construct (private ValidatorInterface $validator){

    }

    public function validate(Booking $booking){
        //$validator = Validation::createValidator();
        $errors = $this->validator->validate($booking);
        
        if (count($errors) > 0) {
            $errorsString = "";
            foreach ($errors as $error){
                $errorsString.= $error->getPropertyPath().":".$error->getMessage()." ";
            }

            return $errorsString;
    
            //return new Response($errorsString);
        }
        return true;

    }
}