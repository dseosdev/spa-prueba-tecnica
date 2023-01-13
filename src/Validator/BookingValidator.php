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
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;

            return $errorsString;
    
            //return new Response($errorsString);
        }
        return true;

    }
}