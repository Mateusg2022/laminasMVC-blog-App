<?php 

namespace Album\Form;

use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;

class AlbumForm extends Form
{
    public function __construct($name = null)
    {
        //vamos ignorar o nome dado pelo construtor
        parent::__construct('album');

        $this->add([
            'name' => 'id',
            'tye' => Hidden::class,
        ]);

        $this->add([
            'name' => 'title',
            'type' => Text::class,
            'options' => [
                'label' => 'Title',
            ],
        ]);

        $this->add([
            'name' => 'artist',
            'type' => Text::class,
            'options' => [
                'label' => 'Artist',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'atributes' => [
                'value' => 'Go',
                'id' => 'submitbutton'
            ],
        ]);

    }
}