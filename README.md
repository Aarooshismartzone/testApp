# Laravel 12 Arabic RTL Invoice Assessment

This repository contains a simple Laravel 12 invoice management module developed as a technical assessment.

The application demonstrates:

- Arabic RTL interface
- Customer selection
- Dynamic invoice item rows
- Quantity, price, discount, tax, and total calculations
- Server-side validation and calculations
- MySQL data storage
- Invoice preview
- PDF generation
- Clean Laravel MVC structure

---

## Features

### Invoice Creation

- Arabic RTL invoice form
- Customer selection from database
- Add/remove invoice item rows dynamically
- Quantity, unit price, discount percentage, and tax percentage fields
- Real-time total calculations

### Server-Side Processing

All invoice calculations are recalculated on the server before saving:

- Subtotal
- Discount total
- Tax total
- Grand total

This ensures that invoice values are not dependent solely on client-side JavaScript.

### Invoice Management

- Create invoice
- View all invoices
- Invoice preview page
- PDF generation

---

## Technology Stack

- Laravel 12
- PHP 8+
- MySQL
- Blade Templates
- Bootstrap 5
- jQuery
- DomPDF

---

## Database Structure

### Customers

```text
id
name
email
phone
created_at
updated_at
```
---

## Installation

### Clone Repository

```text
git clone https://github.com/Aarooshismartzone/testApp.git
cd testApp
```

### Install Dependencies

```text
composer install
```

## Database

The SQL structure is already included in the repository.

Please locate:

```text
testapplication.sql
