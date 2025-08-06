<?php

namespace Blog\Form;

use Laminas\Form\Fieldset;

use Blog\Model\Post;
use Laminas\Hydrator\ReflectionHydrator;

//We can re-use this fieldset in as many forms as we want
class PostFieldset extends Fieldset
{
    public function init()
    {

        $this->setHydrator(new ReflectionHydrator());
        $this->setObject(new Post('', ''));

        $this->add([
            'type' => 'hidden',
            'name' => 'id',
        ]);

        $this->add([
            'type'=> 'text',
            'name' => 'title',
            'options' => [
                'label'=> 'Post Title',
            ],
        ]);

        $this->add([
            'type'=> 'textarea',
            'name'=> 'text',
            'options'=> [
                'label'=> 'Post Text',
            ],
        ]);
    }
}