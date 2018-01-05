<?php

use Illuminate\Database\Seeder;

class UsersModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create Permissions
         */
        DB::table('permissions')->insert([
          ['name' => 'Contatos [read]', 'slug' => 'painel.contacts.read', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Páginas [read]', 'slug' => 'painel.pages.read', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Páginas [write]', 'slug' => 'painel.pages.write', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Analytics [read]', 'slug' => 'painel.analytics.read', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Logs [read]', 'slug' => 'painel.logs.read', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Logs [write]', 'slug' => 'painel.logs.write', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Usuários [read]', 'slug' => 'painel.users.read', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Usuários [write]', 'slug' => 'painel.users.write', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Grupos [read]', 'slug' => 'painel.roles.read', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Grupos [write]', 'slug' => 'painel.roles.write', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Posts [read]', 'slug' => 'painel.posts.read', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Posts [write]', 'slug' => 'painel.posts.write', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Categorias [read]', 'slug' => 'painel.categories.read', 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['name' => 'Categorias [write]', 'slug' => 'painel.categories.write', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ]);

        /**
         * Create Roles
         */
        $root = Sentinel::getRoleRepository()->create(
          [
            'name' => 'Root',
            'slug' => 'root',
            'permissions' => [
              'root' => true
            ]
          ]
        );

        $admin = Sentinel::getRoleRepository()->create(
          [
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => [
              'painel.posts.read' => true,
              'painel.posts.write' => true,
              'painel.categories.read' => true,
              'painel.categories.write' => true,
              'painel.contacts.read' => true,
              'painel.analytics.read' => true,
              'painel.logs.read' => true,
              'painel.logs.write' => true,
              'painel.users.read' => true,
              'painel.users.write' => true,
              'painel.roles.read' => true,
              'painel.roles.write' => true
            ]
          ]
        );

        /**
         * Create Users
         */
        $rootRole = Sentinel::findRoleBySlug('root');
        $hugo = Sentinel::registerAndActivate(
          [
            'first_name'            => 'Hugo',
            'last_name'             => 'Fabricio',
            'email'                 => 'hugo@brzdigital.com.br',
            'password'              => 'mrt17dsp',
            'slug'                  => 'hugo-fabricio'
          ]
        );
        $hugo->roles()->attach($rootRole);

        $jonathan = Sentinel::registerAndActivate(
          [
            'first_name'            => 'Jonathan',
            'last_name'             => 'Veras',
            'email'                 => 'jonatham@brzdigital.com.br',
            'password'              => 'brzsala310',
            'slug'                  => 'jonathan-veras'
          ]
        );
        $jonathan->roles()->attach($rootRole);
    }
}
