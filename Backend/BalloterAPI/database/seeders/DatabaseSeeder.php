<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');

        //Roles
        DB::table('roles')->insert([
            'name' => 'Rozhodčí',
        ]);
        DB::table('roles')->insert([
            'name' => 'Kouč',
        ]);
        DB::table('roles')->insert([
            'name' => 'Debatér',
        ]);
        DB::table('roles')->insert([
            'name' => 'Doprovod',
        ]);

        //User Account
        DB::table('persons')->insert([
            'name' => 'Test',
            'surname' => 'Testovič',
            'birthdate' => '1999-01-01',
            'id_number'  => '123456789',
        ]);
        DB::table('users')->insert([
            'username'  => 'test@test.cz',
            'password' => '$2y$10$wx.hRIG7tKB9RZxJ3kNk.erAjTtEW6HNw2aouPW9lkQxNpXpCW03.',
            'person' => '1',
            'admin'=> '1',
            'role'=> '2',
            'preferred_locale'=> 'cs',
        ]);

        //Speakers
        DB::table('persons')->insert([
            'name' => 'Person_A1',
            'surname' => 'Testovič',
            'birthdate' => '1999-01-01',
            'id_number'  => '987654321',
        ]);
        DB::table('persons')->insert([
            'name' => 'Person_A2',
            'surname' => 'Testovič',
            'birthdate' => '1999-01-01',
            'id_number'  => '987654321',
        ]);
        DB::table('persons')->insert([
            'name' => 'Person_A3',
            'surname' => 'Testovič',
            'birthdate' => '1999-01-01',
            'id_number'  => '987654321',
        ]);
        DB::table('persons')->insert([
            'name' => 'Person_N1',
            'surname' => 'Testovič',
            'birthdate' => '1999-01-01',
            'id_number'  => '987654321',
        ]);
        DB::table('persons')->insert([
            'name' => 'Person_N2',
            'surname' => 'Testovič',
            'birthdate' => '1999-01-01',
            'id_number'  => '987654321',
        ]);
        DB::table('persons')->insert([
            'name' => 'Person_N3',
            'surname' => 'Testovič',
            'birthdate' => '1999-01-01',
            'id_number'  => '987654321',
        ]);

        //Addresses
        DB::table('addresses')->insert([
            'state' => 'Česká Republika',
            'city' => 'Praha',
            'street' => 'Sněmovní',
            'house_nmr' => '4',
            'zip' => '118 26',
        ]);

        //Institutions
        DB::table('institutions')->insert([
            'name' => 'Parlament ČR',
            'short_name' => 'Par',
            'address' => '1',
        ]);

        //Teams
        DB::table('teams')->insert([
            'name' => 'Test_A',
            'institution' => '1',
            'registered_by' => '1',
        ]);
        DB::table('teams')->insert([
            'name' => 'Test_N',
            'institution' => '1',
            'registered_by' => '1',
        ]);
        //Team members
        DB::table('person_team')->insert([
            'person_id' => '2',
            'team_id' => '1',
        ]);
        DB::table('person_team')->insert([
            'person_id' => '3',
            'team_id' => '1',
        ]);
        DB::table('person_team')->insert([
            'person_id' => '4',
            'team_id' => '1',
        ]);
        DB::table('person_team')->insert([
            'person_id' => '5',
            'team_id' => '2',
        ]);
        DB::table('person_team')->insert([
            'person_id' => '6',
            'team_id' => '2',
        ]);
        DB::table('person_team')->insert([
            'person_id' => '7',
            'team_id' => '2',
        ]);

        //Events
        DB::table('events')->insert([
            'name' => 'Finále Debatní Ligy',
            'beginning' => '2023-11-15',
            'end' => '2023-11-17',
            'institution' => '1',
        ]);
        DB::table('event_team')->insert([
            'event_id' => '1',
            'team_id' => '1',
        ]);
        DB::table('event_team')->insert([
            'event_id' => '1',
            'team_id' => '2',
        ]);

        //Motions
        DB::table('motions')->insert([
            'name' => 'Měli bychom zavést trest smrti',
            'added_by' => '1',
        ]);

        //Ballots
        DB::table('ballots')->insert([
            'tournament' => '1',
            'date' => '2023-11-15',
            'motion' => '1',
            'team_AFF' => '1',
            'team_NEG' => '2',
            'decision' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Fusce aliquam vestibulum ipsum. Nam quis nulla. In dapibus augue non sapien. Integer imperdiet lectus quis justo. Etiam dictum tincidunt diam. In sem justo, commodo ut, suscipit at, pharetra vitae, orci. Nulla non lectus sed nisl molestie malesuada. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Phasellus rhoncus. Praesent dapibus. Nunc tincidunt ante vitae massa. Mauris dictum facilisis augue. Aliquam erat volutpat. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam at arcu a est sollicitudin euismod. Etiam dui sem, fermentum vitae, sagittis id, malesuada in, quam. Proin in tellus sit amet nibh dignissim sagittis. ',
            'adj_winning_team' => '1',
            'winning_team' => '1',
            'adjucations' => '3:0',
        ]);
        //Debate Participants
        DB::table('ballot_person')->insert([
            'ballot_id' => '1',
            'person_id' => '1',
            'role' => 'Adjudicator',
            'best_speaker' => '0',
            'author' => '1',
        ]);
        DB::table('ballot_person')->insert([
            'ballot_id' => '1',
            'person_id' => '2',
            'role' => 'A1',
            'comment' => 'Lorem ipsum dolor sit amet',
            'cont_points' => '24',
            'str_points' => '19',
            'style_points' => '21',
            'cq_points' => '1',
            'best_speaker' => '1',
            'author' => '0',
        ]);
        DB::table('ballot_person')->insert([
            'ballot_id' => '1',
            'person_id' => '3',
            'role' => 'A2',
            'comment' => 'Consectetuer adipiscing elit.',
            'cont_points' => '23',
            'str_points' => '18',
            'style_points' => '18',
            'cq_points' => '2',
            'best_speaker' => '0',
            'author' => '0',
        ]);
        DB::table('ballot_person')->insert([
            'ballot_id' => '1',
            'person_id' => '4',
            'role' => 'A3',
            'comment' => 'Fusce aliquam vestibulum ipsum.',
            'cont_points' => '24',
            'str_points' => '19',
            'style_points' => '16',
            'cq_points' => '-2',
            'best_speaker' => '0',
            'author' => '0',
        ]);
        DB::table('ballot_person')->insert([
            'ballot_id' => '1',
            'person_id' => '5',
            'role' => 'N1',
            'comment' => 'Nam quis nulla.',
            'cont_points' => '20',
            'str_points' => '18',
            'style_points' => '19',
            'cq_points' => '0',
            'best_speaker' => '0',
            'author' => '0',
        ]);
        DB::table('ballot_person')->insert([
            'ballot_id' => '1',
            'person_id' => '6',
            'role' => 'N2',
            'comment' => 'In dapibus augue non sapien.',
            'cont_points' => '22',
            'str_points' => '17',
            'style_points' => '18',
            'cq_points' => '1',
            'best_speaker' => '0',
            'author' => '0',
        ]);
        DB::table('ballot_person')->insert([
            'ballot_id' => '1',
            'person_id' => '7',
            'role' => 'N3',
            'comment' => 'Integer imperdiet lectus quis justo.',
            'cont_points' => '23',
            'str_points' => '15',
            'style_points' => '17',
            'cq_points' => '2',
            'best_speaker' => '0',
            'author' => '0',
        ]);
    }
}
