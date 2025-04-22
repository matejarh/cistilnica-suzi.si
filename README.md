<p align="center"><a href="https://cistilnica-suzi.si" target="_blank"><img src="https://via.placeholder.com/400x150.png?text=Cistilnica+Suzi+Logo" width="400" alt="Cistilnica Suzi Logo"></a></p>

<p align="center">
<a href="https://github.com/cistilnica-suzi/cistilnica-suzi.si/actions"><img src="https://github.com/cistilnica-suzi/cistilnica-suzi.si/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://github.com/cistilnica-suzi/cistilnica-suzi.si"><img src="https://img.shields.io/github/stars/cistilnica-suzi/cistilnica-suzi.si" alt="GitHub Stars"></a>
<a href="https://github.com/cistilnica-suzi/cistilnica-suzi.si/blob/main/LICENSE"><img src="https://img.shields.io/github/license/cistilnica-suzi/cistilnica-suzi.si" alt="License"></a>
</p>

## About Cistilnica Suzi

Cistilnica Suzi is a Laravel-based web application designed to manage customer inquiries, promotions, and subscriptions for a cleaning service business. It provides an intuitive interface for administrators to handle customer interactions and streamline communication. Key features include:

- **Customer Inquiry Management**: View, respond to, and delete customer inquiries.
- **Promotions Management**: Create, edit, delete, and send promotions to subscribers.
- **Subscriber Management**: Add, delete, and send messages to subscribers.
- **Dynamic Content Management**: Manage and display active promotions and announcements.
- **Email Notifications**: Send automated and custom emails to subscribers.

Cistilnica Suzi is tailored to meet the needs of cleaning service businesses, ensuring efficient communication and customer satisfaction.

---

## Getting Started

To get started with Cistilnica Suzi, follow these steps:

### **1. Clone the repository**
```bash
git clone https://github.com/cistilnica-suzi/cistilnica-suzi.si.git
cd cistilnica-suzi.si
```

### **2. Install dependencies**
```bash
composer install
npm install
```

### **3. Set up the environment**
1. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```
2. Configure the `.env` file with your database, email, and other application settings.

### **4. Generate the application key**
```bash
php artisan key:generate
```

### **5. Run migrations and seed the database**
```bash
php artisan migrate --seed
```

### **6. Build front-end assets**
```bash
npm run dev
```

### **7. Start the development server**
```bash
php artisan serve
```

---

## Features

### **1. Customer Inquiry Management**
- View all customer inquiries in a centralized dashboard.
- Respond to inquiries directly from the admin panel.
- Delete inquiries that are no longer needed.

### **2. Promotions Management**
- Create and manage promotions with start and end dates.
- Send promotions to all subscribers via email.
- Display active promotions dynamically on the public website.

### **3. Subscriber Management**
- Add new subscribers with their email addresses.
- Delete subscribers who no longer wish to receive updates.
- Send custom messages to subscribers.

### **4. Email Notifications**
- Automated email notifications for promotions and updates.
- Custom email templates for personalized communication.

---

## Testing

To run the test suite, use the following command:

```bash
php artisan test
```

Ensure you have a testing database configured in your `.env` file.

---

## Contributing

We welcome contributions to improve Cistilnica Suzi! Please check out our [contribution guide](https://github.com/cistilnica-suzi/cistilnica-suzi.si/blob/main/CONTRIBUTING.md) for more information.

---

## Security Vulnerabilities

If you discover a security vulnerability, please report it by emailing us at [security@cistilnica-suzi.si](mailto:security@cistilnica-suzi.si). We will address all security issues promptly.

---

## License

Cistilnica Suzi is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
