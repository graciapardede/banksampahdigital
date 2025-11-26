# PHPUnit Testing Guide - Bank Sampah Digital

## 📦 **Setup Testing Environment**

### 1. Install Dependencies
```bash
# Laravel sudah include PHPUnit
composer install
```

### 2. Configure Testing Database
Edit `.env.testing` (create if not exists):
```env
APP_ENV=testing
APP_DEBUG=true
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

Or use separate MySQL database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=banksampah_test
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Tests
```bash
# Run all tests
php artisan test

# Or using PHPUnit directly
./vendor/bin/phpunit

# Run specific test file
php artisan test --filter=DepositTest

# With coverage
php artisan test --coverage
```

---

## 🧪 **Test Structure**

```
tests/
├── Feature/          # Integration tests (full app flow)
│   ├── Auth/
│   │   ├── LoginTest.php
│   │   └── RegistrationTest.php
│   ├── Deposit/
│   │   ├── CreateDepositTest.php
│   │   └── ViewDepositTest.php
│   ├── Redemption/
│   │   ├── CreateRedemptionTest.php
│   │   └── CancelRedemptionTest.php
│   └── Profile/
│       └── ProfilePhotoTest.php
└── Unit/             # Unit tests (individual functions)
    ├── Models/
    │   ├── UserTest.php
    │   ├── DepositTest.php
    │   └── RedemptionTest.php
    └── Helpers/
        └── HelpersTest.php
```

---

## 📝 **Sample Test Cases**

### **Feature Test: Login**

Create `tests/Feature/Auth/LoginTest.php`:

```php
<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_login_page()
    {
        $response = $this->get('/login');
        
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function user_can_login_with_correct_credentials()
    {
        // Create test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'warga'
        ]);

        // Attempt login
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Assert authenticated
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function user_cannot_login_with_incorrect_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function admin_redirected_to_admin_dashboard()
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect('/admin/dashboard');
    }
}
```

---

### **Feature Test: Create Redemption**

Create `tests/Feature/Redemption/CreateRedemptionTest.php`:

```php
<?php

namespace Tests\Feature\Redemption;

use App\Models\User;
use App\Models\RewardItem;
use App\Models\Branch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateRedemptionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $branch;
    protected $rewardItem;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->branch = Branch::factory()->create();
        
        $this->user = User::factory()->create([
            'role' => 'warga',
            'balance_points' => 5000,
            'branch_id' => $this->branch->id
        ]);

        $this->rewardItem = RewardItem::factory()->create([
            'name' => 'Beras 5kg',
            'points_cost' => 500,
            'stock' => 10,
            'branch_id' => $this->branch->id
        ]);
    }

    /** @test */
    public function user_can_create_redemption_with_sufficient_points()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/redemptions', [
                'branch_id' => $this->branch->id,
                'items' => [
                    [
                        'reward_item_id' => $this->rewardItem->id,
                        'quantity' => 2
                    ]
                ]
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Penukaran berhasil diajukan'
            ]);

        // Assert database has redemption
        $this->assertDatabaseHas('redemptions', [
            'user_id' => $this->user->id,
            'total_points' => 1000, // 500 * 2
            'status' => 'pending'
        ]);

        // Assert points deducted
        $this->assertEquals(4000, $this->user->fresh()->balance_points);
    }

    /** @test */
    public function user_cannot_create_redemption_with_insufficient_points()
    {
        $this->user->update(['balance_points' => 500]);

        $response = $this->actingAs($this->user)
            ->postJson('/api/redemptions', [
                'branch_id' => $this->branch->id,
                'items' => [
                    [
                        'reward_item_id' => $this->rewardItem->id,
                        'quantity' => 5 // Needs 2500 points
                    ]
                ]
            ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Poin Anda tidak mencukupi'
            ]);

        // Assert no redemption created
        $this->assertDatabaseCount('redemptions', 0);
    }

    /** @test */
    public function user_cannot_create_redemption_with_insufficient_stock()
    {
        $this->rewardItem->update(['stock' => 1]);

        $response = $this->actingAs($this->user)
            ->postJson('/api/redemptions', [
                'branch_id' => $this->branch->id,
                'items' => [
                    [
                        'reward_item_id' => $this->rewardItem->id,
                        'quantity' => 5
                    ]
                ]
            ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Stok barang tidak mencukupi'
            ]);
    }

    /** @test */
    public function guest_cannot_create_redemption()
    {
        $response = $this->postJson('/api/redemptions', [
            'branch_id' => $this->branch->id,
            'items' => [
                [
                    'reward_item_id' => $this->rewardItem->id,
                    'quantity' => 1
                ]
            ]
        ]);

        $response->assertStatus(401);
    }
}
```

---

### **Unit Test: User Model**

Create `tests/Unit/Models/UserTest.php`:

```php
<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Redemption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_deposits_relationship()
    {
        $user = User::factory()->create();
        $deposit = Deposit::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->deposits->contains($deposit));
        $this->assertEquals(1, $user->deposits->count());
    }

    /** @test */
    public function user_has_redemptions_relationship()
    {
        $user = User::factory()->create();
        $redemption = Redemption::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->redemptions->contains($redemption));
    }

    /** @test */
    public function user_can_check_if_is_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $warga = User::factory()->create(['role' => 'warga']);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($warga->isAdmin());
    }

    /** @test */
    public function user_balance_points_defaults_to_zero()
    {
        $user = User::factory()->create();

        $this->assertEquals(0, $user->balance_points);
    }

    /** @test */
    public function user_can_have_profile_photo()
    {
        $user = User::factory()->create([
            'profile_photo' => 'test_photo.jpg'
        ]);

        $this->assertNotNull($user->profile_photo);
        $this->assertEquals('test_photo.jpg', $user->profile_photo);
    }
}
```

---

### **Unit Test: Helper Functions**

Create `tests/Unit/Helpers/HelpersTest.php`:

```php
<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    public function format_rupiah_formats_number_correctly()
    {
        if (!function_exists('formatRupiah')) {
            $this->markTestSkipped('formatRupiah function not found');
        }

        $this->assertEquals('Rp 5.000', formatRupiah(5000));
        $this->assertEquals('Rp 1.000.000', formatRupiah(1000000));
        $this->assertEquals('Rp 0', formatRupiah(0));
    }

    /** @test */
    public function get_member_tier_returns_correct_tier()
    {
        if (!function_exists('getMemberTier')) {
            $this->markTestSkipped('getMemberTier function not found');
        }

        $this->assertEquals('Bronze', getMemberTier(0));
        $this->assertEquals('Silver', getMemberTier(5000));
        $this->assertEquals('Gold', getMemberTier(10000));
        $this->assertEquals('Platinum', getMemberTier(20000));
    }
}
```

---

## 🏭 **Database Factories**

Update `database/factories/UserFactory.php`:

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'phone' => fake()->phoneNumber(),
            'role' => 'warga',
            'balance_points' => 0,
            'branch_id' => null,
            'remember_token' => Str::random(10),
        ];
    }

    public function admin()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'branch_id' => 1,
        ]);
    }

    public function withPoints($points)
    {
        return $this->state(fn (array $attributes) => [
            'balance_points' => $points,
        ]);
    }
}
```

Create `database/factories/RewardItemFactory.php`:

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RewardItemFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->word() . ' Item',
            'description' => fake()->sentence(),
            'points_cost' => fake()->numberBetween(100, 1000),
            'stock' => fake()->numberBetween(5, 50),
            'image' => 'default.jpg',
            'branch_id' => 1,
        ];
    }
}
```

---

## 🚀 **Running Tests**

### **Basic Commands:**
```bash
# Run all tests
php artisan test

# Run with verbose output
php artisan test --parallel

# Run specific test
php artisan test --filter=LoginTest

# Run tests in specific folder
php artisan test tests/Feature/Auth

# Stop on first failure
php artisan test --stop-on-failure
```

### **With Coverage:**
```bash
# Requires Xdebug or PCOV
php artisan test --coverage

# Minimum coverage threshold
php artisan test --coverage --min=80
```

### **Watch Mode (Auto-rerun):**
```bash
# Install Laravel Pint
composer require laravel/pint --dev

# Watch and auto-run tests
php artisan test --watch
```

---

## ✅ **Testing Checklist**

### **Authentication:**
- [ ] Login dengan credentials benar
- [ ] Login dengan credentials salah
- [ ] Logout
- [ ] Password reset flow
- [ ] Remember me functionality

### **Deposits:**
- [ ] View semua deposits user
- [ ] View detail deposit
- [ ] Create deposit (admin)
- [ ] Verify deposit (admin)
- [ ] Calculate points correctly

### **Redemptions:**
- [ ] View semua redemptions
- [ ] Create redemption dengan poin cukup
- [ ] Create redemption dengan poin tidak cukup
- [ ] Create redemption dengan stock habis
- [ ] Cancel redemption
- [ ] Admin approve/reject redemption

### **Profile:**
- [ ] View profile
- [ ] Update profile
- [ ] Upload foto profil
- [ ] Delete foto profil
- [ ] Update password

### **Admin:**
- [ ] Dashboard statistics correct
- [ ] Filter by branch
- [ ] Generate reports
- [ ] CRUD reward items
- [ ] CRUD waste types

---

## 🐛 **Debugging Tests**

### **View Test Output:**
```bash
# Run with debug mode
php artisan test --debug

# Print database queries
php artisan test --log-events
```

### **Common Issues:**

**1. Database not refreshing:**
```php
// Add to test class
use RefreshDatabase;
```

**2. CSRF Token issues:**
```php
// Disable CSRF for testing
$this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
```

**3. File upload tests:**
```php
use Illuminate\Http\UploadedFile;

$file = UploadedFile::fake()->image('photo.jpg', 600, 600);
```

---

## 📊 **Continuous Integration**

Create `.github/workflows/tests.yml`:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, pdo_mysql
        
    - name: Install Dependencies
      run: composer install
      
    - name: Copy .env
      run: php -r "file_exists('.env') || copy('.env.example', '.env');"
      
    - name: Generate key
      run: php artisan key:generate
      
    - name: Run Tests
      run: php artisan test
```

---

**Next Steps:**
1. Run `php artisan test` untuk cek apakah PHPUnit sudah configured
2. Buat test cases sesuai fitur prioritas Anda
3. Setup CI/CD untuk auto-run tests

**Last Updated:** November 24, 2025
