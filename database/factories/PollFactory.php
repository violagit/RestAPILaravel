<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Poll;
use App\Answer;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Question\Question;

$factory->define(App\Poll::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(50),
    ];
});

$factory->define(App\Question::class, function (Faker $faker) {
    $poll_ids = DB::table('polls')->pluck('id')->all();

    return [
        'title' => $faker->realText(50),
        'question' => $faker->realText(500),
        'poll_id' => $faker->randomElement($poll_ids),
    ];
});

$factory->define(App\Answer::class, function (Faker $faker) {
    $question_ids = DB::table('questions')->pluck('id')->all();

    return [
        'answer' => $faker->realText(500),
        'question_id' => $faker->randomElement($question_ids),
    ];
});