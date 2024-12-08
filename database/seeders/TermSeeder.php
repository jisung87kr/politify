<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $terms = [
            ['term_code' => "100021", 'start_date' => "20200530",  'end_date' => "20240529", 'name' => '제21대'],
            ['term_code' => "100020", 'start_date' => "20160530",  'end_date' => "20200529", 'name' => '제20대'],
            ['term_code' => "100019", 'start_date' => "20120530",  'end_date' => "20160529", 'name' => '제19대'],
            ['term_code' => "100018", 'start_date' => "20080530",  'end_date' => "20120529", 'name' => '제18대'],
            ['term_code' => "100017", 'start_date' => "20040530",  'end_date' => "20080529", 'name' => '제17대'],
            ['term_code' => "100016", 'start_date' => "20000530",  'end_date' => "20040529", 'name' => '제16대'],
            ['term_code' => "100015", 'start_date' => "19960530",  'end_date' => "20000529", 'name' => '제15대'],
            ['term_code' => "100014", 'start_date' => "19920530",  'end_date' => "19960529", 'name' => '제14대'],
            ['term_code' => "100013", 'start_date' => "19880530",  'end_date' => "19920529", 'name' => '제13대'],
            ['term_code' => "100012", 'start_date' => "19850411",  'end_date' => "19880529", 'name' => '제12대'],
            ['term_code' => "100011", 'start_date' => "19810411",  'end_date' => "19850410", 'name' => '제11대'],
            ['term_code' => "100010", 'start_date' => "19790312",  'end_date' => "19801027", 'name' => '제10대'],
            ['term_code' => "100009", 'start_date' => "19730312",  'end_date' => "19790311", 'name' => '제9대'],
            ['term_code' => "100008", 'start_date' => "19710701",  'end_date' => "19721017", 'name' => '제8대'],
            ['term_code' => "100007", 'start_date' => "19670701",  'end_date' => "19710630", 'name' => '제7대'],
            ['term_code' => "100006", 'start_date' => "19631217",  'end_date' => "19670630", 'name' => '제6대'],
            ['term_code' => "100005", 'start_date' => "19600729",  'end_date' => "19610516", 'name' => '제5대'],
            ['term_code' => "100004", 'start_date' => "19580531",  'end_date' => "19600728", 'name' => '제4대'],
            ['term_code' => "100003", 'start_date' => "19540531",  'end_date' => "19580530", 'name' => '제3대'],
            ['term_code' => "100002", 'start_date' => "19500531",  'end_date' => "19540530", 'name' => '제2대'],
            ['term_code' => "100001", 'start_date' => "19480531",  'end_date' => "19500530", 'name' => '제헌'],
        ];

        foreach ($terms as $index => $term) {
            Term::create($term);
        }
    }
}
