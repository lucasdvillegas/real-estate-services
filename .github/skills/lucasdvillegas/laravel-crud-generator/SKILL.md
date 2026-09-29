# Laravel CRUD Generator Skill

## Description

This is a Composer package for Laravel that automates the complete generation of CRUD (Create, Read, Update, Delete) operations. It automatically generates models, controllers, validations, migrations, factories, seeders, routes, and Vue views in a single command.

**Ideal for**: Laravel projects with Inertia.js and Vue 3 that need to reduce repetitive work in creating CRUDs.

---

## When to use this package

Use the Laravel CRUD Generator when:

- You need to create multiple CRUD modules in a Laravel project
- You're working with Laravel + Inertia.js + Vue 3
- You want to maintain consistency in code structure
- You need to save time on repetitive scaffolding tasks
- You need to automatically generate migrations, factories, seeders, and routes

**Do not use** if:

- You don't have Inertia.js + Vue 3 configured (although the backend will work)
- You need highly customized CRUD logic that cannot be automatically generated
- Your project does not use Laravel

---

## Prerequisites

### Package Installation

```bash
composer require lucasdvillegas/laravel-crud-generator:@dev
```

Or for local development:

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "../laravel-crud-generator"
    }
  ],
  "require-dev": {
    "lucasdvillegas/laravel-crud-generator": "dev-main"
  }
}
```

### Required Dependencies

The package requires:

- **PHP** ^8.3
- **Laravel** 10, 11, 12, or 13
- **Inertia.js** + **Vue 3** (for frontend)

### Frontend Dependencies (if you generate Vue views)

```bash
npm install vee-validate yup vue-sonner
npx shadcn-vue@latest add alert-dialog
npx shadcn-vue@latest add table
```

---

## How to Use

### Step 1: Generate Generic Components (only once)

Before creating any CRUD, generate the shared components:

```bash
php artisan crud:components
```

Or with alias:

```bash
php artisan components
```

This generates:

- `resources/js/Components/DataTablePagination.vue`
- `resources/js/Components/DeleteActionButton.vue`

### Step 2: Generate a Complete CRUD

```bash
php artisan crud ModelName field1:type field2:type field3:type
```

**Example:**

```bash
php artisan crud Product name:string price:decimal stock:integer active:boolean
```

**Supported field types:**

- `string` → `string(255)`
- `text` → `text`
- `longText` → `longText`
- `integer` → `integer`
- `boolean` → `boolean`
- `date` → `date`
- `datetime` → `datetime`
- `decimal` → `decimal`

### Step 3: Complete Post-Generation Steps

After running the command, a message will appear in the terminal with the following steps:

#### 3.1 Run the Migration

```bash
php artisan migrate
```

This creates the table in the database.

#### 3.2 Run the Seeder (optional)

```bash
php artisan db:seed --class=ProductSeeder
```

This inserts test data.

#### 3.3 Update Wayfinder

```bash
php artisan wayfinder:generate
```

This indexes the new Artisan commands.

#### 3.4 Add Route in AppSidebar.vue

Edit `resources/js/Components/AppSidebar.vue` and add:

```vue
<SidebarMenuButton href="/products" icon="Package" label="Products" />
```

---

## Generated Files

When you run `php artisan crud Product name:string price:decimal`, the following are generated:

### Backend

```
app/Models/Product.php
app/Http/Controllers/ProductController.php
app/Http/Requests/ProductRequest.php
database/migrations/YYYY_MM_DD_HHMMSS_create_products_table.php
database/factories/ProductFactory.php
database/seeders/ProductSeeder.php
routes/web.php (updated with resource routes)
```

### Frontend (Vue)

```
resources/js/Pages/Product/Index.vue
resources/js/Pages/Product/Create.vue
resources/js/Pages/Product/Update.vue
resources/js/types/product.ts
```

---

## Practical Examples

### Example 1: Generate Article CRUD

```bash
php artisan crud Article title:string content:longText author:string published:boolean publication_date:date
php artisan migrate
php artisan db:seed --class=ArticleSeeder
php artisan wayfinder:generate
```

Then add in AppSidebar.vue:

```bash
import crudModel from '@/routes/crudModel';

const mainNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: dashboard(),
    icon: LayoutGrid,
  },
  {
    title: 'crudModel',
    href: crudModel.index(),
    icon: FileText,
  },
];
```

### Example 2: Generate User CRUD

```bash
php artisan crud User name:string email:string phone:string active:boolean registration_date:datetime
php artisan migrate
php artisan db:seed --class=UserSeeder
```

### Example 3: Generate Multiple CRUDs

```bash
php artisan crud:components

php artisan crud Category name:string description:text
php artisan migrate

php artisan crud Product name:string price:decimal stock:integer category_id:integer
php artisan migrate

php artisan wayfinder:generate
```

---

## Limitations and Considerations

1. **No automatic relationship generation**: If you need relationships between models (hasMany, belongsTo), you must add them manually in the model.

2. **Basic validations**: Generated validations are generic. You can customize them in `app/Http/Requests/{Model}Request.php`.

3. **Business logic**: The generator creates the base structure. Business-specific logic must be added manually in controllers and models.

4. **Default routes**: Generates standard RESTful routes. Custom routes must be added manually.

5. **Styles and UI**: Vue components use shadcn-vue. Customize styles in generated `.vue` files.

---

## Available Commands

| Command                              | Description                        |
| ------------------------------------ | ---------------------------------- |
| `php artisan crud {model} {fields*}` | Generate a complete CRUD           |
| `php artisan crud:components`        | Generate shared generic components |
| `php artisan components`             | Alias for `crud:components`        |

---

## AI Agent Integration

### For agents modifying code

If you modify or extend this package:

1. **Respect the generator structure**: Each file type (Model, Controller, Migration, etc.) has its own generator in `src/generators/`.

2. **Update stubs if you change the output**: Templates are in `src/stubs/`. If you want to change the generated output, modify the stubs, not the generator code.

3. **Maintain compatibility**: Don't break existing commands. Add new functionality as new commands.

4. **Document changes**: Update this SKILL.md and README.md with new features.

### For agents using this package

If you need to use this package from an agent:

1. **Verify requirements**: Confirm that Laravel, Inertia.js, and Vue 3 are installed.

2. **Install frontend dependencies**: Run the necessary `npm install` commands.

3. **Generate components first**: Always call `crud:components` before generating CRUDs.

4. **Complete post-generation steps**: Don't forget to migrate, seed, and update Wayfinder.

5. **Update the sidebar**: Any generated CRUD needs an entry in AppSidebar.vue to be accessible.

---

## Troubleshooting

### Error: "Argument #1 ($model) must be of type string, null given"

**Cause**: Attempted to call `VueGenerator::generate()` without passing a model.

**Solution**: Use `VueGenerator::generateGenericComponents()` to generate only components without a model.

### Routes don't appear after generation

**Cause**: Routes are added to `routes/web.php`, but `php artisan route:cache` may not have been run.

**Solution**: Run `php artisan route:clear` to clear the route cache.

### Vue components don't render correctly

**Cause**: Frontend dependencies are not installed.

**Solution**: Install `vee-validate`, `yup`, `vue-sonner`, and shadcn-vue components.

### Database has no data

**Cause**: Migration or seeder was not executed.

**Solution**: Run:

```bash
php artisan migrate
php artisan db:seed --class=MyModelSeeder
```

---

## Additional Resources

- [README.md](README.md) - Complete package documentation
- [CHANGELOG.md](CHANGELOG.md) - Change history
- [Laravel Documentation](https://laravel.com/docs)
- [Inertia.js Documentation](https://inertiajs.com/)
- [Vue 3 Documentation](https://vuejs.org/)
- [shadcn-vue](https://www.shadcn-vue.com/)

---

## Final Notes

This package is designed to accelerate the development of standard CRUDs. For more complex logic, customize the generated files. Generated code is fully editable and does not depend on the package after generation.