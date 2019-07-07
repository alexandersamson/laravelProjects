<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PermissionTableSeeder::class);
         $this->call(ObjectCategoriesTableSeeder::class); // after PermissionTable
         $this->call(UserTableSeeder::class);
         $this->call(ClientsTableSeeder::class);
         $this->call(SubjectsTableSeeder::class);
         $this->call(CasefileTableSeeder::class);
         $this->call(CaseStateTableSeeder::class);
         $this->call(AssignedInvestigatorTableSeeder::class);
         $this->call(AssignedClientTableSeeder::class);
         $this->call(AssignedSubjectTableSeeder::class);
         $this->call(OrganizationTableSeeder::class);
         $this->call(LicensesTableSeeder::class);
         $this->call(PostsTableSeeder::class);
    }
}
