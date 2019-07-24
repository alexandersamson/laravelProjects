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
         $this->call(LinkCasefileUserTableSeeder::class);
         $this->call(LinkCasefileClientsTableSeeder::class);
         $this->call(LinkCasefileSubjectTableSeeder::class);
         $this->call(OrganizationTableSeeder::class);
         $this->call(LicensesTableSeeder::class);
         $this->call(PostsTableSeeder::class);
         $this->call(MessagesTableSeeder::class);
         $this->call(LinkMessageUsersTableSeeder::class);
         $this->call(RegistrationKeysTableSeeder::class);
         $this->call(CasenotesTableSeeder::class);
         $this->call(LinkCasefileCasenotesTableSeeder::class);
    }
}
