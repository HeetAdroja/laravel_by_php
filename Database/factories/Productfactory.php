<?php

namespace Database\Factories;

class Productfactory
{

    public function fakeproduct($faker)
    {
        return [
            'name'    =>  $faker->unique->word(),
            'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s')
        ];
    }
}
