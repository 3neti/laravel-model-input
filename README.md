# 3neti/laravel-model-input

A Laravel package that enables **dynamic, validated inputs attached to Eloquent models**.

Features:
- attach arbitrary named inputs to any model (polymorphic)
- enforce validation rules per input type (via enum-driven rules)
- normalize mobile numbers (via laravel-phone)
- dynamic getters/setters via magic accessors
- query models by input (e.g., find by mobile)
- DTO support for structured responses

This package serves as a **flexible input layer** within the x-change ecosystem.

---

## ✨ Core Concept

Instead of adding many columns to a model, you can attach **typed inputs**:

- mobile
- email
- signature
- address
- bank_account
- etc.

Each input:
- is stored in a separate `inputs` table
- is validated using rules defined per input type
- can be accessed like a normal attribute

---

## 📦 Installation

```bash
composer require 3neti/laravel-model-input
```

---

## ⚙️ Configuration

Publish config (optional):

```bash
php artisan vendor:publish --tag=config
```

---

## 🧱 Database Migrations

This package uses:

```php
loadMigrationsFrom()
```

Run:

```bash
php artisan migrate
```

---

## 🧠 Usage

### Add trait to your model

```php
use LBHurtado\ModelInput\Traits\HasInputs;

class User extends Model
{
    use HasInputs;
}
```

---

### Set input

```php
$user->setInput('mobile', '09171234567');
```

or using enum:

```php
use LBHurtado\ModelInput\Enums\InputType;

$user->setInput(InputType::MOBILE, '09171234567');
```

---

### Force set (skip validation)

```php
$user->forceSetInput('mobile', '09171234567');
```

---

### Access input like attribute

```php
$user->mobile;
$user->signature;
```

---

### Validate input

```php
$user->isValidInput('email', 'test@example.com');
```

---

### Query by input

```php
User::findByMobile('09171234567');
User::findByInput('mobile', '09171234567');
```

Supports:
- normalized matching
- partial matching
- flexible formats

---

### Direct access

```php
$user->input('mobile');
```

---

## 📱 Mobile Normalization

Mobile inputs are automatically normalized to:

```text
E.164 format (without "+")
```

Examples:
- 0917xxxxxxx
- +63917xxxxxxx
- 63917xxxxxxx

All resolve to the same stored value.

---

## 🧩 Input Types

Defined via enum:

```php
InputType::MOBILE
InputType::EMAIL
InputType::SIGNATURE
InputType::OTP
...
```

Each input type has validation rules defined in config:

```php
model-input.rules.mobile
```

---

## 🧾 Schema

```text
inputs
- id
- model_type
- model_id
- name
- value
- timestamps
```

---

## 🧱 Traits

- `HasInputs` → core functionality
- dynamic getters/setters
- validation and normalization

---

## 🧪 Testing

- Testbench
- SQLite in-memory
- test-only migrations under `tests/database/migrations`

---

## 🧭 Architecture Role

In x-change ecosystem:

- contact → identity
- model-input → dynamic attributes layer
- cash → value
- voucher → instruction
- wallet → ledger

---

## 🔒 Design Principles

- avoid schema explosion
- strongly typed inputs via enum
- validation-first design
- flexible querying
- normalization of sensitive fields (e.g., mobile)

---

## 🚀 Future Enhancements

- input history versioning
- encryption support
- indexing optimizations
- event hooks

---

## 🧾 License

Proprietary
