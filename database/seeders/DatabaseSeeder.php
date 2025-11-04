public function run(): void
{
    $this->call([
        BranchSeeder::class,
        WasteTypeSeeder::class,
        AdminSeeder::class,
    ]);
}
