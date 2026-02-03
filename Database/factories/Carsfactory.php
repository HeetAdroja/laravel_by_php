<?php

namespace Database\factories;

class Carsfactory
{

    public function fakeproduct($faker)
    {
        return [
            'name'    =>  $faker->unique->word(),
            'brand'   =>  $faker->unique->name(),
            'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s')
        ];
    }
}
