<?php

namespace Album\Model;

use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class Album implements InputFilterAwareInterface
{
    public $id;
    public $artist;
    public $title;
    
    private $inputFilter;

    public function exchangeArray(array $array): void
    {
        $this->id = ! empty($array['id']) ? $array['id'] : null;
        $this->artist = ! empty($array['artist']) ? $array['artist'] : null;
        $this->title = ! empty($array['title']) ? $array['title'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id'=> $this->id,
            'artist'=> $this->artist,
            'title'=> $this->title,
        ];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            "%s does not allow injection of an alternative input filter",
            __CLASS__,
        ));
    }

    //we instantiate an InputFilter and then add the inputs that we require
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'artist',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name'=> StringLength::class,
                    'options' => [
                        'enconding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;

        /**
         * We now need to get the form to display and then process it 
         * on submission. This is done within the AlbumController::addAction():
         */
    }
}
// Our Album entity object is a PHP class. In order to work with 
// laminas-db's TableGateway class, we need to implement the exchangeArray() 
// method; this method copies the data from the provided array to our 
// entity's properties. We will add an input filter later to ensure the 
// values injected are valid.